<?php

namespace App\Novel\Jobs;

use App\Chapter;
use App\Content;
use App\Novel;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Symfony\Component\DomCrawler\Crawler;

class ContentPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $totalPageCount;
    private $counter        = 1;
    private $concurrency    = 300;  // 同时并发抓取

    protected  $podcast;
    /**
     * Create a new job instance.
     *
     * @return void
     */


    public function __construct($novel)
    {
        $this->novel = $novel;
        $this->chapter = Chapter::where(['novelid'=> $this->novel->id])->get();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('max_execution_time', '0');
        ini_set('memory_limit','1024M');

        $this->totalPageCount = count($this->chapter);
        $client = new Client();
        $requests = function ($total) use ($client) {
            foreach ($this->chapter as $uri) {
                yield function() use ($client, $uri) {
                    return $client->getAsync($uri->chapter_url);
                };
            }
        };

        $pool = new Pool($client, $requests($this->totalPageCount), [
            'concurrency' => $this->concurrency,
            'fulfilled'   => function ($response, $index){
                $chapterdata =   mb_convert_encoding($response->getBody()->getContents(), 'utf-8', 'GBK,UTF-8,ASCII');
                echo "爬取《".$this->novel->name."》小说" . $this->chapter[$index]->chapter_url . "的章节正在爬取".'id'.$this->chapter[$index]->id;
                echo '<br>';
                $crawler = new Crawler();
                $crawler->addHtmlContent($chapterdata);
                $content =[];
                $content['chapterid'] = $this->chapter[$index]->id;
                $content['content'] = $crawler->filterXPath('//*[@id="htmlContent"]')->text();

                $this->countedAndCheckEnded($content);
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

    public function countedAndCheckEnded($data ='')
    {
        if ($this->counter < $this->totalPageCount){
            echo $this->counter;
            $this->con[$this->counter-1] =$data;
            $this->counter++;
            return;
        }

       $bool =   Content::insert($this->con);
        if ($bool){
            echo 'success';
            echo '<br>';
        }

        echo("请求结束！");
    }

}
