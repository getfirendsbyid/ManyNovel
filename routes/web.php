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

Route::domain('{account}.navicat.com')->group(function ($account) {
    dd($account);
   if (empty($account)){
       Route::get('/','HomeController@index');
   }else{
       Route::get('/','HomeController@sonsite');
   }
   Route::get('/book/{bookid}/{chapterid}','HomeController@show');
});

Route::get('/book/{bookname}','HomeController@list');


Route::get('spider/getwebname','SpiderController@getwebname');
Route::get('spider/getbookname','SpiderController@getbookname');
Route::get('spider/getnoveldesc','SpiderController@getnoveldesc');






