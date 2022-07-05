@extends('layout')

@section('title','チャンネル')

@section('content')
<header>
  <!-- 検索フォーム -->
  <form action="{{action('MessageController@serch')}}" method="post" class="search-form">
    <input type="text" name="text">
    <input type="submit" value="送信">
    {{csrf_field()}}
  </form>
  
  <!-- ハンバーガーボタン -->
  <div class="popup-btn" id="menu-btn">
    <span></span>
    <span></span>
    <span></span>
  </div>
</header>

<main>
<!-- navの読み込み -->
@include('layouts/nav',['channels'=>$channels, 'directs'=>$directs])

  <!-- メッセージ表示部分 -->
    <!-- チャンネル名とユーザー招待ボタン -->
    <div class="messages" id="scroll" data-scroll="{{(int)$page}}">
      <div class="channel-name">
        <p>{{$channel->name}}チャンネル</p>
        <a href="" id="user-channel-add-btn">ユーザーを追加</a>
        <a href="{{action('ChannelController@delete',['id'=> $id])}}">チャンネルを削除</a>
      </div>
      <div class="message-container" id="messageContainer">
      @foreach($messages->reverse() as $m)
        <div class="message message-{{$m->id}}" id="m-{{$m->id}}" data-id="{{$m->id}}">
          <form action="{{action('MessageController@update',['id'=>$m->id])}}" method="post">
            <div class="message-header">
              <p>{{$m->created_at->format('Y/m/d')}} {{$m->user->name}}</p>
              @if($m->user->id == Auth::user()->id)
                <button><a class="message-edit" href="{{action('MessageController@edit',['id'=>$m->id])}}" data-id="{{$m->id}}">編集</a></button>
                <button class="message-delete"><a href="{{action('MessageController@delete',['id'=>$m->id])}}">削除</a></button>
              @endif
              </div>
            <div class="message-main">
              <p>{!! nl2br($m->message) !!}</p>
            </div>
            <input type="hidden" name="id" value="{{$m->id}}">
            {{csrf_field()}}
          </form>
        </div>
      @endforeach
      </div>
    </div>
</main>
<!-- ポップアップ要素 -->
<div class="popup-background" id="popupBackground"></div>
@include('form1',['id'=>'popup','action'=>action('ChannelController@serch'),'create'=>action('ChannelController@add'),'url_id'=>$id])

<!-- ポップアップ要素2 -->
@include('form2',['id'=>'popup2','action'=>action('ChannelController@create')])

@include('form1',['id'=>'popup3','action'=>action('DirectController@serch'),'create'=>action('DirectController@create'),'url_id'=>$id])

@include('form1',['id'=>'popup4','action'=>action('ChannelController@serch'),'create'=>'','url_id'=>$id])

@include('form1',['id'=>'popup5','action'=>action('ChannelController@user_serch'),'create'=>action('ChannelController@add'),'url_id'=>$id])

@include('form3',['action'=>action('MessageController@create'),'name'=>'room_id'])

<!-- jsの読み込み -->

@if(!(isset($direct)))
  @include('script/js',['scroll'=>0])
@else
  @include('script/js',['scroll'=>0,'direct'=>'direct_scroll'])
@endif

@endsection
