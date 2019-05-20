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
   Route::resource('admin/article','ArticleController');
   Route::resource('admin/tag','TagController',['except'=>'show']);
   Route::get('admin/uploads','UploadsController@index');
   Route::post('admin/uploads/file', 'UploadsController@uploadFile');
   Route::delete('admin/uploads/file', 'UploadsController@deleteFile');
   Route::post('admin/uploads/folder', 'UploadsController@createFolder');
   Route::delete('admin/uploads/folder', 'UploadsController@deleteFolder');
});

Route::get('login','Auth\LoginController@showLoginForm')->name('login');
Route::post('login','Auth\LoginController@login');
Route::get('logout','Auth\LoginController@logout')->name('logout');



// 添加如下路由
Route::get('contact', 'ContactController@showForm');
Route::post('contact', 'ContactController@sendContactInfo');