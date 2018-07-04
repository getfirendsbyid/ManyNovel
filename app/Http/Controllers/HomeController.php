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


}
