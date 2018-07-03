<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Nav;
use App\Novel;
use App\Yuming;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(Request $request,$account)
    {
        $host =  str_before(str_after($_SERVER['HTTP_HOST'],'.'),':');
        if ($account=='www'){
            $yuming =  Yuming::where(['host'=>$host])->first();
            $nav = Nav::where(['hostid'=>$yuming->id])->get();
            foreach ($nav as $key=>$item){
                $nav[$key]['novel'] = Novel::where(['navid'=>$item->id])->take(20)->orderby('created_at','desc')->get();
            }
            return view($yuming->templet_name.'.index',compact('yuming','host','nav'));
        }else{
            $yuming =  Yuming::where(['host'=>$host])->first();
            $novel =  Novel::where(['enname'=>$account])->first();
            if (empty($novel->toArray())){
                return view($yuming->templet_name.'.nonovel');
            }else{
                $nav = Nav::where(['hostid'=>$yuming->id])->get();
                $chapter = Chapter::find($novel->id);
                $othernovel = Novel::where(['nav'=>$novel->navid])->take(40)->get();
                return view($yuming->templet_name.'.sonlist',compact('othernovel','host','yuming','nav','novel','novel','chapter'));
            }
        }
    }

    public function sonsite($account)
    {
        $host = $_SERVER['HTTP_HOST'];
        $domain =  str_before(str_after($host,'.'),':');

    }

    public function lista(Request $request,$bookname)
    {
        $host = $_SERVER['HTTP_HOST'];
        $domain =  str_after($host,'.');
        $yuming =  Yuming::where(['host'=>$domain])->first();
        $nav = Nav::where(['host'=>$yuming->id])->get();
        $novel = Novel::where(['enname'=>$bookname])->get();
        return view($yuming->templet_name.'.list',compact('yuming','nav','host','novel'));
    }

    public function show(){
        $host = $_SERVER['HTTP_HOST'];
        $yuming =  Yuming::where(['host'=>$host])->first();
        $nav = Nav::where(['host'=>$host])->get();
        return view($yuming->templet_name.'.index',compact('yuming'));
    }

}
