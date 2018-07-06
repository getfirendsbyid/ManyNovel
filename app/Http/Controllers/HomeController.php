<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Nav;
use App\Novel;
use App\Yuming;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->host = $_SERVER['HTTP_HOST'];
        $this->domain =  str_after($this->host,'.');
        $this->yuming =  Yuming::where(['host'=>$this->domain])->first();
        $this->nav = Nav::where(['hostid'=>$this->yuming->id])->get();
    }

    public function index()
    {
        foreach ($this->nav as $key=>$item){
            $this->nav[$key]['novel'] = Novel::where(['navid'=>$item->id])->take(20)->orderby('created_at','desc')->get();
        }
        return view($this->yuming->templet_name.'.index')->with(['tdk'=>$this->yuming,'nav'=>$this->nav,'host'=>$this->domain]);
    }

    public function fan($account)
    {

        $novel =  Novel::where(['enname'=>$account])->first();
        if (empty($novel->toArray())){
            return view($this->yuming->templet_name.'.nonovel');
        }else{
            $chapter = Chapter::find($novel->id);
            $nav = Nav::find($novel->navid);
            $othernovel = Novel::where(['nav'=>$novel->navid])->take(40)->get();
            return view($this->yuming->templet_name.'.sonlist')->with([
                'tdk'=>$this->yuming,
                'nav'=>$this->nav,
                'chapter'=>$chapter,
                'othernovel'=>$othernovel,
                'host'=>$this->domain,
                'novel'=>$novel,
                'navname'=>$nav->name
            ]);
        }
    }


    public function nav($navname)
    {
        $where = ['hostid'=>$this->yuming->id,'enname'=>$navname];
        $nav = Nav::where($where)->first();
        $novel =Novel::where(['navid'=>$nav->id])->paginate(80);
        return view($this->yuming->templet_name.'.nav')->with(['tdk'=>$this->yuming,'nav'=>$this->nav,'host'=>$this->domain,'novel'=>$novel,'navname'=>$nav->name]);
    }

    public function chapterlist($bookname)
    {
        $bookname = str_before($bookname,'.');
        $novel =  Novel::where(['enname'=>$bookname])->first();
        if (empty($novel->toArray())){
            return view($this->yuming->templet_name.'.nonovel');
        }else{
            $chapter = Chapter::find($novel->id);
            $nav = Nav::find($novel->navid);
            $othernovel = Novel::where(['nav'=>$novel->navid])->take(40)->get();
            return view($this->yuming->templet_name.'.sonlist')->with([
                'tdk'=>$this->yuming,
                'nav'=>$this->nav,
                'chapter'=>$chapter,
                'othernovel'=>$othernovel,
                'host'=>$this->domain,
                'novel'=>$novel,
                'navname'=>$nav->name
            ]);
        }
    }

    public function show(){
        $host = $_SERVER['HTTP_HOST'];
        $yuming =  Yuming::where(['host'=>$host])->first();
        $nav = Nav::where(['host'=>$host])->get();
        return view($yuming->templet_name.'.index',compact('yuming'));
    }


    public function search(Request $request)
    {
        $data = $request->input('data');
        $res =   Novel::where('name','like','%'.$data.'%')->get();
        return view($this->yuming->templet_name.'.search')->with(['data'=>$res]);
    }

    public function test()
    {
            $str = '111.206.221.106 - - [05/Jul/2018:12:02:59 +0800] "GET /janpa/logo1.png HTTP/1.1" 200 5735 "http://weiduzhiyongheng.zbtorch.cn/" "Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1 (compatible; Baiduspider-render/2.0; +http://www.baidu.com/search/spider.html)"';
//          $useragent = addslashes(strtolower($str));


            $useragent = strtolower($str);
           dd(strpos($useragent, 'baiduspider'));
            if (strpos($useragent, 'googlebot') !== false){
                return 'Google';
            }
            if (strpos($useragent, 'baiduspider') !== false){
                return 'Baidu';
            }
            if (strpos($useragent, 'msnbot') !== false){
                return 'Bing';
            }
            if (strpos($useragent, 'slurp') !== false){
                return 'Yahoo';
            }
            if (strpos($useragent, 'sosospider') !== false){
                return 'Soso';
            }
            if (strpos($useragent, 'sogou spider') !== false){
                return 'Sogou';
            }
            if (strpos($useragent, 'yodaobot') !== false){
                return 'Yodao';
            }
            return false;
        exit();
        if (strpos($useragent, 'googlebot')!== false){$bot = 'Google';}
        elseif (strpos($useragent,'mediapartners-google') !== false){$bot = 'Google Adsense';}
        elseif (strpos($useragent,'baiduspider') !== false){$bot = 'Baidu';}
        elseif (strpos($useragent,'sogou spider') !== false){$bot = 'Sogou';}
        elseif (strpos($useragent,'sogou web') !== false){$bot = 'Sogou web';}
        elseif (strpos($useragent,'sosospider') !== false){$bot = 'SOSO';}
        elseif (strpos($useragent,'360spider') !== false){$bot = '360Spider';}
        elseif (strpos($useragent,'yahoo') !== false){$bot = 'Yahoo';}
        elseif (strpos($useragent,'msn') !== false){$bot = 'MSN';}
        elseif (strpos($useragent,'msnbot') !== false){$bot = 'msnbot';}
        elseif (strpos($useragent,'sohu') !== false){$bot = 'Sohu';}
        elseif (strpos($useragent,'yodaoBot') !== false){$bot = 'Yodao';}
        elseif (strpos($useragent,'twiceler') !== false){$bot = 'Twiceler';}
        elseif (strpos($useragent,'ia_archiver') !== false){$bot = 'Alexa_';}
        elseif (strpos($useragent,'iaarchiver') !== false){$bot = 'Alexa';}
        elseif (strpos($useragent,'slurp') !== false){$bot = '雅虎';}
        elseif (strpos($useragent,'bot') !== false){$bot = '其它蜘蛛';}
        elseif (strpos($useragent,'Yisouspider') !== false){$bot = '神马';}
        if(isset($bot)){
            echo 1;
            $fp = @fopen(date("Y-m-d").'.txt','a');
            fwrite($fp,date('Y-m-d H:i:s')."\t".$_SERVER[" "]."\t".$bot."\t".'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]."\r\n");
            fclose($fp);
        }
    }


}
