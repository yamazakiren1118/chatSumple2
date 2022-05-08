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
    return redirect()->action('ChannelController@show',['id'=>1]);
});

Route::group(['prefix'=>'channel'], function(){
    Route::post('create', 'ChannelController@create');
    Route::post('serch', 'ChannelController@serch');
    Route::post('add', 'ChannelController@add');
    Route::get('delete', 'ChannelController@delete')->middleware('auth');
    Route::get('jump', 'ChannelController@jump');

    Route::get('scroll_u', 'ChannelController@scroll_u');
    Route::get('{id}', 'ChannelController@show')->middleware('auth');
    Route::post('scroll_u', 'ChannelController@scroll_u');
    Route::post('scroll_d', 'ChannelController@scroll_d');
    
});

Route::group(['prefix' => 'direct'], function(){
    Route::post('create', 'DirectController@create');
    Route::post('delete', 'DirectController@delete');
    Route::post('serch', 'DirectController@serch');
    Route::get('{id}', 'DirectController@show')->middleware('auth');
});

Route::group(['prefix' => 'direct_message'], function(){
    Route::post('edit', 'DirectMessageController@edit');
    Route::get('delete', 'DirectMessageController@delete');
    Route::post('create', 'DirectMessageController@create');
    Route::post('update', 'DirectMessageController@update');
});

Route::group(['prefix'=>'message'], function(){
    Route::post('create', 'MessageController@create');
    Route::get('delete', 'MessageController@delete');
    Route::post('edit', 'MessageController@edit');
    Route::post('update', 'MessageController@update');
    Route::post('serch', 'MessageController@serch');
    
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
