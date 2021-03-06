<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

function checkhost(){
    $host = str_after($_SERVER['HTTP_HOST'],'.');
    $dbyuming =  \Illuminate\Support\Facades\DB::table('yuming')->select('host')->get()->toArray();
    foreach ($dbyuming as $item){
        if ($host == $item->host){
            return $yuming = $item->host;
        }
    }
}

function deletespace($url)
{
    return  str_replace(array("\r\n", "\r", "\n" ,"\t"), "", $url);
}

Route::get('sitemap.xml','HomeController@sitemap'); //网站sitemap
Route::get('silian.xml','HomeController@silian'); //网站死链
Route::get('home','NovelController@index'); //队列工具
Route::get('getnginxcon1f','HomeController@getnginxconf'); //队列工具

Route::domain('www.'.checkhost())->group(function () {
    Route::middleware(['cacheResponse:5'])->get('/','HomeController@index');
});

Route::domain('zhannei.'.checkhost())->group(function () {
    Route::middleware(['cacheResponse:5'])->get('/search','HomeController@search');
});

Route::domain('{account}.'.checkhost())->group(function ($account) {
    Route::middleware(['cacheResponse:5'])->get('/','HomeController@fan');
});

Route::get('/book/{bookname}','HomeController@chapterlist');
Route::get('/book/{bookid}/{chapterid}','HomeController@show');

Route::get('hentai','AdminController@login');
Route::get('{nav}','HomeController@nav');
Route::get('spider/getwebname','SpiderController@getwebname');
Route::get('spider/getbookname','SpiderController@getbookname');
Route::get('spider/getnoveldesc','SpiderController@getnoveldesc');
Route::get('spider/chapterlist','SpiderController@chapterlist');
Route::get('spider/chaptercontent','SpiderController@chaptercontent');