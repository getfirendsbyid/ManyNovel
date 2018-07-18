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
        $where = ['hostid'=>$this->yuming->id,'enname'=>$navname];
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
        return view($this->yuming->templet_name.'.search')->with(['novel'=>$res,'nav'=>$this->nav,'host'=>$this->domain]);
    }

    public function sitemap()
    {
        $novel = Novel::where([])->orderBy('updated_at', 'desc')->get();

        return response()->view($this->yuming->templet_name.'.sitemap', [
            'data' => $novel,
        ])->header('Content-Type', 'text/xml');
    }

    public function page404()
    {
        return view($this->yuming->templet_name.'.nopage')->with(['nav'=>$this->nav,'host'=>$this->domain]);
    }

    public function tt()
    {
        $yuming =  Yuming::all();
        foreach ($yuming as $item){
            $item->keywords = '下载小说,免费全本小说下载,txt全本下载,好看的小说,txt小说下载';
            $item->description = '（163novel.cn）收录最新好看的小说，提供海量最新txt小说下载、txt全本下载、免费全本小说下载，是一个最新最全的下载小说网站。';
            $item->webname = ' - 下载小说,免费全本小说下载,txt全本下载,好看的小说,txt小说下载';
            $item->description = ' - 下载小说,免费全本小说下载,txt全本下载,好看的小说,txt小说下载';
            $a =$item->save();
            if ($a){
                echo '成功:'.$item->id;
                echo '<br>';
            }
        }
    }

}
