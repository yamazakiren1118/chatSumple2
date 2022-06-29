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

// トップページに飛ぶと/channel/1に飛ばされる
Route::get('/', function () {
    return redirect()->action('ChannelController@show',['id'=>1]);
});

Route::get('User/delete','Auth\DeleteController@delete');

Route::group(['prefix'=>'channel'], function(){
    Route::post('create', 'ChannelController@create');

    // テスト用
    Route::get('create', 'ChannelController@create');
    // Route::get('add', 'ChannelController@add');
    Route::get('serch', 'ChannelController@serch');

    Route::post('serch', 'ChannelController@serch');
    Route::post('user_serch', 'ChannelController@user_serch');
    
    Route::post('add', 'ChannelController@add');
    Route::get('delete', 'ChannelController@delete')->middleware('auth');
    Route::get('jump', 'ChannelController@jump');
    Route::get('detach', 'ChannelController@detach')->middleware('auth');

    Route::get('scroll_u', 'ChannelController@scroll_u');
    Route::get('{id}', 'ChannelController@show')->middleware('auth');
    Route::post('scroll_u', 'ChannelController@scroll_u');
    Route::post('scroll_d', 'ChannelController@scroll_d');

    
    
});

Route::group(['prefix' => 'direct'], function(){
    Route::post('create', 'DirectController@create');
    Route::get('delete', 'DirectController@delete');

    // テスト用
    Route::get('create', 'DirectController@create');
    Route::get('serch', 'DirectController@serch');
    Route::get('scroll_u', 'DirectController@scroll_u');
    Route::get('scroll_d', 'DirectController@scroll_d');

    Route::post('serch', 'DirectController@serch');
    Route::post('scroll_u', 'DirectController@scroll_u');
    Route::post('scroll_d', 'DirectController@scroll_d');
    Route::get('{id}', 'DirectController@show')->middleware('auth');

});

Route::group(['prefix' => 'direct_message'], function(){
    // テスト
    Route::get('create', 'DirectMessageController@create');


    Route::post('edit', 'DirectMessageController@edit');
    Route::get('delete', 'DirectMessageController@delete');
    Route::post('create', 'DirectMessageController@create');
    Route::post('update', 'DirectMessageController@update');
    Route::post('socket_serch', 'DirectMessageController@socket_serch');
});

Route::group(['prefix'=>'message'], function(){
    // テスト用
    Route::get('create', 'MessageController@create');

    Route::post('create', 'MessageController@create');
    Route::get('delete', 'MessageController@delete');
    Route::post('edit', 'MessageController@edit');
    Route::post('update', 'MessageController@update');
    Route::post('serch', 'MessageController@serch');
    Route::post('socket_serch', 'MessageController@socket_serch');
    Route::get('socket_serch', 'MessageController@socket_serch');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
