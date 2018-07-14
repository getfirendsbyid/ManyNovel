<?php

namespace App\Http\Controllers;

use App\Novel\Jobs\ContentPodcast;
use App\Novel;
use Illuminate\Http\Request;

class NovelController extends Controller
{

    public function index(Request $request) //创建所有小说章节爬内容取任务
    {
        $novel = Novel::all();
        foreach ($novel as $key => $item){
            dispatch(new ContentPodcast($item , $key));
        }

    }

}
