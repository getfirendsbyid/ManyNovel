<?php
namespace App\Http\Controllers;

use App\Chapter;
use App\Host;
use App\Nav;
use App\Novel;
use App\SpiderNav;
use GuzzleHttp\Client;
use App\Xiaoshuo;
use App\Yuming;
use GuzzleHttp\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Overtrue\Pinyin\Pinyin;
use Symfony\Component\DomCrawler\Crawler;

class SpiderController extends Controller
{

    private $totalPageCount;
    private $counter        = 1;
    private $concurrency    = 1;  // 同时并发抓取
    private $xiaoshuo = [];
    private $bookurl = [];

    protected $signature = 'test:multithreading-request';
    protected $description = 'Command description';

    protected $url = 'http://www.janpn.com/book/zuowubusheng.html';

    protected $hostid = 2;


    public function  getwebname()
    {
        $host =  Host::find($this->hostid);
        echo '开始爬取网页栏目:'.$host->host;
        echo '<br>';
        $this->getnav($host);
    }

    public function getnav($host)
    {
        $client = new Client();  // 实例化
        $http = $client->request('GET', $host->host);  // 执行
        $nav =[];
        if ($http->getStatusCode() == 200) {
            // 判断 http 状态码为 200 的时候，执行成功
            // echo $http->getBody();
            $htmldata = mb_convert_encoding($http->getBody()->getContents(), 'utf-8', 'GBK,UTF-8,ASCII'); //强行转码
            $crawler = new Crawler();
            $crawler->addHtmlContent($htmldata);
            $nav = $crawler->filter('#nav-header > ul > li')->each(function (Crawler $node, $i) {
                $data['url'] =  $node->filter('li > a')->attr('href');
                $data['nav'] =  $node->filter('li > a')->text();
                return $data;
            });

            foreach ($nav as $key=>$item){
                $data[$key]['name']=$item['nav'];
                $data[$key]['hostid']=$host->id;
                $data[$key]['url']= $item['url'];
                $data[$key]['created_at']=date('Y-m-d h:i:s');
                $data[$key]['updated_at']=date('Y-m-d h:i:s');
                echo '抓取到栏目'.json_encode($data[$key]);
                echo '<br>';
                ob_flush();
                flush();
            }
            $bool = SpiderNav::insert($data);
            if ($bool){
                echo '目录插入数据库成功';
            }
        }
    }



    public function getbookname()
    {
        $this->url = SpiderNav::where(['hostid'=>$this->hostid])->select('name','url','id','hostid')->get()->toArray();
        $this->totalPageCount = count($this->url);
        $client = new Client();
        $requests = function ($total) use ($client) {
            foreach ($this->url as $key => $uri) {
                yield function() use ($client, $uri) {
                    return $client->getAsync($uri['url']);
                };
            }
        };
        $pool = new Pool($client, $requests($this->totalPageCount), [
            'concurrency' => $this->concurrency,
            'fulfilled'   => function ($response, $index){
                $xiaoshuodata =   mb_convert_encoding($response->getBody()->getContents(), 'utf-8', 'GBK,UTF-8,ASCII');

                echo "请求第 $index 个请求，栏目" . $this->url[$index]['url'] . "的小说名称正在爬取";
                echo '<br>';
                $crawler = new Crawler();
                $crawler->addHtmlContent($xiaoshuodata);
                $chapter =[];
                $list = $crawler->filter('body > div.list > a')->each(function (Crawler $node, $i) {
                    $data['name'] =  $node->filter('a > div:nth-child(1) > b')->text();
                    $data['temp_url'] =  $node->filter('a')->attr('href');
                    $data['author'] = str_before( $node->filter('a > div:nth-child(2)')->text(),'[著]');
                    $data['new_chapter_name'] =  $node->filter('a > div:nth-child(3) > span ')->text();
                    return $list = $data;
                });
                $pinyin = new Pinyin();
                foreach ($list as $key=>$item){
                    $list[$key]['navid'] = $this->url[$index]['id'];
                    $list[$key]['hostid'] = $this->url[$index]['hostid'];
                    $list[$key]['enname'] = implode("",$pinyin->convert($item['name']));
                    $list[$key]['created_at'] = date('Y-m-d h:i:s');
                    $list[$key]['updated_at'] = date('Y-m-d h:i:s');
                }
                ob_flush();
                flush();
                $a =  Novel::insert($list);
                if ($a){
                    echo '所有小说名称爬取完成';
                }
                $this->countedAndCheckEnded();
            },
            'rejected' => function ($reason, $index){
//                    log('test',"rejected" );
//                    log('test',"rejected reason: " . $reason );
                $this->countedAndCheckEnded();
            },
        ]);

        $promise = $pool->promise();
        $promise->wait();
    }

    public function getnoveldesc()
    {
        ini_set('max_execution_time', '0');
        ini_set('memory_limit','1024M');
        $this->novel = Novel::where(['hostid'=>$this->hostid])->get()->toArray();
        $this->totalPageCount = count($this->novel);
        $client = new Client();
        $requests = function ($total) use ($client) {
            foreach ($this->novel as $key => $uri) {
                yield function() use ($client, $uri) {
                    return $client->getAsync( $uri['temp_url']);
                };
            }
        };

        $pool = new Pool($client, $requests($this->totalPageCount), [
            'concurrency' => $this->concurrency,
            'fulfilled'   => function ($response, $index){
                $chapterdata =   mb_convert_encoding($response->getBody()->getContents(), 'utf-8', 'GBK,UTF-8,ASCII');
                echo "请求第 $index 个请求，小说" .  $this->novel[$index]['temp_url']. "的章节正在爬取";
                echo '<br>';
                $crawler = new Crawler();
                $crawler->addHtmlContent($chapterdata);
                $chapter =[];
                dd($chapterdata);
                //补充小说描述 封面 作者 热点 连载状态
                $novel['description'] = $crawler = $crawler->filter('body > div:nth-child(6) > div ')->html();


//                $list = $crawler->filter('body > div:nth-child(7) > div > div > div')->each(function (Crawler $node, $i) {
//                    $novel['url'] = $node->filter('div:nth-child(3) > a')->html();
//                    return $list = $novel;
//                });



                dd($novel);

                $novelbool =  Novel::where(['id'=>$this->novel[$index]['id']])->update($novel);

                if ($novelbool){
                    echo '小说作者信息补全完整';
                    echo '<br>';
                }
                ob_flush();
                flush();
                $this->countedAndCheckEnded();
            },
            'rejected' => function ($reason, $index){
//                    log('test',"rejected" );
//                    log('test',"rejected reason: " . $reason );
                $this->countedAndCheckEnded();
            },
        ]);
        $promise = $pool->promise();
        $promise->wait();
    }





    public function chapterlist()
    {
        ini_set('max_execution_time', '0');
        ini_set('memory_limit','1024M');
        $this->novel = Novel::all()->toArray();
        $this->totalPageCount = count($this->novel);
        $client = new Client();
        $requests = function ($total) use ($client) {
            foreach ($this->novel as $key => $uri) {
                yield function() use ($client, $uri) {
                    return $client->getAsync($uri['url']);
                };
            }
        };

        $pool = new Pool($client, $requests($this->totalPageCount), [
            'concurrency' => $this->concurrency,
            'fulfilled'   => function ($response, $index){
                $chapterdata =   mb_convert_encoding($response->getBody()->getContents(), 'utf-8', 'GBK,UTF-8,ASCII');
                echo "请求第 $index 个请求，小说" . $this->novel[$index]['url'] . "的章节正在爬取";
                echo '<br>';
                $crawler = new Crawler();
                $crawler->addHtmlContent($chapterdata);
                $chapter =[];
                //补充小说描述 封面 作者 热点 连载状态
                $novel['cover_img_url'] = $crawler->filterXPath('//*[@id="fmimg"]/img')->attr('src');
                $novel['description'] = $crawler->filterXPath('//*[@id="intro"]/p/text()')->text();
                $novel['author'] = str_after($crawler->filterXPath('//*[@id="info"]/p[1]')->text(),'：') ;
                $novel['hot'] = rand(10000,999999);
                $novel['lasttime'] = str_after($crawler->filterXPath('//*[@id="info"]/p[3]')->text(),'：');
                $novelbool =  Novel::where(['id'=>$this->novel[$index]['id']])->update($novel);

                if ($novelbool){
                    echo '小说作者信息补全完整';
                    echo '<br>';
                    echo '开始采集章节标题';
                }

                $list = $crawler->filter('#list > dl > dd')->each(function (Crawler $node, $i) {
                    $chapter['name'] =  $node->filter('dd > a')->text();
                    $chapter['url'] =  $this->url.$node->filter('dd > a')->attr('href');
                    $chapter['created_at'] = date('Y-m-d');
                    $chapter['updated_at'] = date('Y-m-d');
                    $chapter['number'] = $i;
                    return $list = $chapter;
                });
                $chapter['novelid'] = $this->novel[$index]['id'];
                foreach ($list as $key=> $item){
                    $list[$key]['novelid'] = $this->novel[$index]['id'];
                }
                $bool =  Chapter::insert($list);
                if ($bool){
                    echo $this->novel[$index]['name'].'章节抓取完成插入';
                    echo '<br>';
                }
                ob_flush();
                flush();
                $this->countedAndCheckEnded();
            },
            'rejected' => function ($reason, $index){
//                    log('test',"rejected" );
//                    log('test',"rejected reason: " . $reason );
                $this->countedAndCheckEnded();
            },
        ]);
        $promise = $pool->promise();
        $promise->wait();
    }


    public function getchaptercontent()
    {
            ini_set('max_execution_time', '0');
            ini_set('memory_limit','3072M');
            $client = new Client();
            $this->chapter = Chapter::all()->toArray();
            $this->totalPageCount = count($this->chapter);
            $requests = function ($total) use ($client) {
                foreach ($this->chapter as $key => $uri) {
                    yield function() use ($client, $uri) {
                        return $client->getAsync($uri['url']);
                    };
                }
            };

            $pool = new Pool($client, $requests($this->totalPageCount), [
                'concurrency' => $this->concurrency,
                'fulfilled'   => function ($response, $index){
                    $chapterdata =   mb_convert_encoding($response->getBody()->getContents(), 'utf-8', 'GBK,UTF-8,ASCII');
                    echo "请求第 .$index. 个请求，章节" . $this->chapter[$index]['url'] . "的内容正在爬取";
                    echo '<br>';
                    $crawler = new Crawler();
                    $crawler->addHtmlContent($chapterdata);
                    $chapter =[];
                    //补充小说描述 封面 作者 热点 连载状态
                    $novel['content'] = $crawler->filterXPath('//*[@id="content"]')->text();

                    $novelbool =  Chapter::where(['id'=>$this->chapter[$index]['id']])->update($novel);
                    if ($novelbool){
                        echo "章节" . $this->chapter[$index]['url'] . "的内容存储完成";
                    }
                    ob_flush();
                    flush();
                    $this->countedAndCheckEnded();
                },
                'rejected' => function ($reason, $index){
//                    log('test',"rejected" );
//                    log('test',"rejected reason: " . $reason );
                    $this->countedAndCheckEnded();
                },
            ]);
        $promise = $pool->promise();
        $promise->wait();
    }

    public function countedAndCheckEnded()
    {
        if ($this->counter < $this->totalPageCount){
            $this->counter++;
            return;
        }
       echo("请求结束！");
    }

    public function deletechapter()
    {
        $a =  Chapter::truncate();
        dd($a);
    }

}