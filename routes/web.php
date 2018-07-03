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
//$yuming =  \App\Yuming::all();
//$host = $_SERVER['HTTP_HOST'];
//$domain =  str_before(str_after($host,'.'),':');
//foreach ($yuming as $item){

Route::domain('{account}.app.com')->group(function ($account) {

    Route::get('/','HomeController@index');
    Route::get('/book/{bookid}/{chapterid}','HomeController@show');

});



Route::get('/book/{bookname}','HomeController@list');
Route::get('/md','HomeController@web');

Route::get('spider/getwebname','SpiderController@getwebname');
Route::get('spider/getbookname','SpiderController@getbookname');
Route::get('spider/getnoveldesc','SpiderController@getnoveldesc');
