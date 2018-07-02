<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected  $table ='chapter';

    public static function getbooklist($bookid)
    {
       return Chapter::where(['bookid'=>$bookid])->get();
    }

    public static function lasttime($bookid)
    {
        return Chapter::where(['bookid'=>$bookid])->orderby('bookid','desc')->first()->created_at;
    }

    public static function getbody($chapterid)
    {
        return Chapter::find($chapterid)->chapter_content;
    }

    public static function getcname($chapterid)
    {
        return Chapter::find($chapterid)->name;
    }

}
