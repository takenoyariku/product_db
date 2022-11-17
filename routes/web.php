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
    return view('welcome');
});

Auth::routes();
// 商品一覧画面を表示
Route::get('/home', 'ProductController@showList')->middleware('auth')->name('product');

//登録画面を表示
Route::get('/create','ProductController@showCreate')->middleware('auth')->name('create');

//商品登録
Route::post('/store','ProductController@exeStore')->middleware('auth')->name('store');

// 商品詳細画面を表示
Route::get('/product/{id}','ProductController@showDetail')->middleware('auth')->name('detail');

// 商品編集画面を表示
Route::get('/edit/{id}','ProductController@showEdit')->middleware('auth')->name('edit');

//商品編集
Route::post('/update','ProductController@exeUpdate')->middleware('auth')->name('update');

//商品削除
Route::post('/delete/{id}','ProductController@exeDelete')->middleware('auth')->name('delete');

