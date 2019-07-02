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

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace'=>'Home','prefix'=>'home'],function (){
    Route::get('/','IndexController@index');
    Route::get('memberInfo','IndexController@memberInfo');
    Route::get('sendSms','IndexController@sendSms');
    Route::get('getFirstChar','IndexController@getFirstChar');
});
