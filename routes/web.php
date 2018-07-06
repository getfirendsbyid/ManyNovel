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

Route::get('test','HomeController@test');
Route::domain('www.app.com')->group(function () {
    Route::middleware('CountSpider')->get('/','HomeController@index');
});

Route::domain('zhannei.app.com')->group(function () {
    Route::middleware('CountSpider')->get('/search','HomeController@search');
});

Route::domain('{account}.app.com')->group(function ($account) {
    Route::middleware('CountSpider')->get('/','HomeController@fan');
});

Route::get('/book/{bookname}','HomeController@chapterlist');
Route::get('/book/{bookid}/{chapterid}','HomeController@show');
//Route::get('test','HomeController@test');

Route::get('hentai','AdminController@login');
Route::get('/{nav}','HomeController@nav');
Route::get('spider/getwebname','SpiderController@getwebname');
Route::get('spider/getbookname','SpiderController@getbookname');
Route::get('spider/getnoveldesc','SpiderController@getnoveldesc');

