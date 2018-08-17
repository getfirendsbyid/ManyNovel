<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Content;
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
        if (empty($this->yuming)){
          dd('该域名还没有绑定');
        }
        $this->nav = Nav::all();
    }

    public function index()
    {
        foreach ($this->nav as $key=>$item){
            $this->nav[$key]['novel'] = Novel::where(['navid'=>$item->id])->orderBy(\DB::raw('RAND()'))->take(20)->orderby('created_at','desc')->get();
        }
        return view($this->yuming->templet_name.'.index')->with(['tdk'=>$this->yuming,'nav'=>$this->nav,'host'=>$this->domain]);
    }

    public function fan($account)
    {
        $novel =  Novel::where(['enname'=>$account])->first();
        if (empty($novel)){
            return view($this->yuming->templet_name.'.nopage')->with(['nav'=>$this->nav,'host'=>$this->domain]);
        }else{
            $chapter = Chapter::where(['novelid'=>$novel->id])->get();
            $nav = Nav::find($novel->navid);
            $othernovel = Novel::where(['navid'=>$novel->navid])->orderBy(\DB::raw('RAND()'))->take(40)->get();
            $befor_novel = Novel::where('id','<',$novel->id)->orderBy('id','desc')->first();
            $last_novel = Novel::where('id','>',$novel->id)->orderBy('id','asc')->first();
            return view($this->yuming->templet_name.'.sonlist')->with([
                'tdk'=>$this->yuming,
                'nav'=>$this->nav,
                'chapter'=>$chapter,
                'befor_novel'=>$befor_novel,
                'last_novel'=>$last_novel,
                'othernovel'=>$othernovel,
                'host'=>$this->domain,
                'novel'=>$novel,
                'navname'=>$nav->name
            ]);
        }
    }

    public function nav($navname)
    {
        $where = ['hostid'=>4,'enname'=>$navname];
        $nav = Nav::where($where)->first();
        if (empty($nav)){
            return view($this->yuming->templet_name.'.nopage')->with(['nav'=>$this->nav,'host'=>$this->domain]);
        }
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
            $chapter = Chapter::where(['novelid'=>$novel->id])->get();
            $nav = Nav::find($novel->navid);
            $othernovel = Novel::where(['navid'=>$novel->navid])->take(40)->get();
            $befor_novel = Novel::where('id','<',$novel->id)->orderBy('id','desc')->first();
            $last_novel = Novel::where('id','>',$novel->id)->orderBy('id','asc')->first();
            return view($this->yuming->templet_name.'.list')->with([
                'tdk'=>$this->yuming,
                'nav'=>$this->nav,
                'chapter'=>$chapter,
                'othernovel'=>$othernovel,
                'host'=>$this->domain,
                'novel'=>$novel,
                'befor_novel'=>$befor_novel,
                'last_novel'=>$last_novel,
                'navname'=>$nav->name
            ]);
        }
    }

    public function show($bookid,$chapterid){
        $chapterid = str_before($chapterid,'.html');
        $chapter =  \DB::table('content')
            ->where(['chapterid'=>$chapterid])
            ->join('chapter','chapter.id','=','content.chapterid')
            ->first();
        $novel =  Novel::find($bookid);
        $nav = Nav::find($novel->navid);
        $befor_chapter = Chapter::where('id','<',$chapterid)->where(['novelid'=>$bookid])->orderBy('id','desc')->first();
        $last_chapter = Chapter::where('id','>',$chapterid)->where(['novelid'=>$bookid])->orderBy('id','asc')->first();
        return view($this->yuming->templet_name.'.show')->with([
            'tdk'=>$this->yuming,
            'nav'=>$this->nav,
            'chapter'=>$chapter,
            'host'=>$this->domain,
            'novel'=>$novel,
            'navname'=>$nav->name,
            'befor_chapter'=>$befor_chapter,
            'last_chapter'=>$last_chapter,
        ]);
    }

    public function search(Request $request)
    {
        $data = $request->input('data');
        $res =   Novel::where('name','like','%'.$data.'%')->get();
        return view($this->yuming->templet_name.'.search')->with(['tdk'=>$this->tdk,'novel'=>$res,'nav'=>$this->nav,'host'=>$this->domain]);
    }

    public function sitemap()
    {
        $novel = Novel::where([])->orderBy('updated_at', 'desc')->get();
        return response()->view($this->yuming->templet_name.'.sitemap', [
            'data' => $novel,
            'host' => $this->yuming
        ])->header('Content-Type', 'text/xml');
    }

    public function page404()
    {
        return view($this->yuming->templet_name.'.nopage')->with(['nav'=>$this->nav,'host'=>$this->domain]);
    }

    public function getnginxconf()
    {
        $yuming =  Yuming::all();
        foreach ($yuming as $item){
            $host = fopen('host/'.$item->host.'.conf','w');
            fwrite($host, 'server'."\r\n");
            fwrite($host, '{'."\r\n");
            fwrite($host, 'listen '.$item->ipbelongto.';'."\r\n");
            fwrite($host, 'server_name _;'."\r\n");
            fwrite($host, 'index index.html index.htm index.php;'."\r\n");
            fwrite($host, 'root  /home/wwwroot/ManyNovel/public;'."\r\n");
            fwrite($host, 'include enable-php.conf;'."\r\n");
            fwrite($host, 'if ($http_host ~ "^'.$item->host.'$") {'."\r\n");
            fwrite($host, 'rewrite  ^(.*)    http://www.'.$item->host.'$1 permanent;'."\r\n");
            fwrite($host, '}'."\r\n");
            fwrite($host, 'location / {'."\r\n");
            fwrite($host, 'try_files $uri $uri/ /index.php?$query_string;'."\r\n");
            fwrite($host, '}'."\r\n");
            fwrite($host, '}'."\r\n");
            fclose($host);
            echo 'success file';
            echo '<br>';
        }
    }

    public function silian()
    {
        $data = file('silian.txt');
        return response()->view($this->yuming->templet_name.'.silian',compact('data'))->header('Content-Type', 'text/xml');
    }


}
