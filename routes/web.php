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

Route::get('/', function () {
    return redirect('/blog');
});

Route::get('/blog','BlogController@index')->name('blog.home');
Route::get('/blog/{slug}','BlogController@detail')->name('blog.detail');


//后台路由
Route::get('/admin',function(){
   return redirect('/admin/article');
});

Route::middleware('auth')->namespace('admin')->group(function(){
   Route::resource('admin/article','articleController@index');
   Route::resource('admin/tag','tagController@index');
   Route::get('admin/upload','uploadController@index');
});

Route::get('login','Auth.LoginController@loginForm')->name('login');
Route::post('login','Auth.LoginController@login');
Route::get('logout','Auth,LoginController@loginout')->name('logout');
