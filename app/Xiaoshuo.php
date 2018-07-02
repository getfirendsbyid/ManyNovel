<?php

namespace App;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Xiaoshuo extends Model
{
    protected $table ='xiaoshuo';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }


    public static function newxiao($count)
    {
       if (empty($count)){
           return response()->json('没有填写数量');
       }
       return DB::table('xiaoshuo')
             ->join('chapter','chapter.bookid','=','xiaoshuo.bookid')
             ->take($count)
             ->orderby('xiaoshuo.created_at','desc')
             ->select(
                'xiaoshuo.bookid',
                'xiaoshuo.nav',
                'xiaoshuo.name',
                'xiaoshuo.author',
                'chapter.name as chaptername',
                'chapter.id as chapterid'
             )
            ->get();
    }

    public static function getname($bookid)
    {
        return Xiaoshuo::where(['bookid'=>$bookid])->first()->name;
    }

    public static function author($bookid)
    {
        return Xiaoshuo::where(['bookid'=>$bookid])->first()->author;
    }

    public static function description($bookid)
    {
        return Xiaoshuo::where(['bookid'=>$bookid])->first()->description;
    }

    public static function  getconverimg($bookid)
    {
        return Xiaoshuo::where(['bookid'=>$bookid])->first()->cover_img_url;
    }

    public static function getrecomend($count)
    {
        return $data = Xiaoshuo::where([])->orderBy(DB::raw('RAND()'))->take($count)->get();
    }

    public static function getnewbook($count)
    {
        return $data = Xiaoshuo::where([])->orderBy('created_at','desc')->take($count)->get();
    }

}
