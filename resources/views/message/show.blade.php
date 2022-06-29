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
    <div class="messages" id="scroll" data-scroll="" style="height: calc(100vh - 103px); margin-bottom:0px;">
      <div class="channel-name">
        <p>検索結果</p>
        
        
      </div>
      <div class="message-container" id="messageContainer">
      
      @foreach($messages as $m)
        <div class="message message-{{$m->id}}">
          
          <form action="{{action('MessageController@update',['id'=>$m->id])}}" method="post">
            <div class="message-header">
              <p>{{$m->created_at->format('Y/m/d')}} {{$m->user->name}}</p>
              
              @if($m instanceof App\Message)
                
                <button><a class="" href="{{action('ChannelController@jump',['id'=>$m->id,'dm'=>false])}}" data-id="{{$m->id}}">ジャンプ</a></button>
              @else
              
                <button><a class="" href="{{action('ChannelController@jump',['id'=>$m->id,'dm'=>true])}}" data-id="{{$m->id}}">ジャンプ</a></button>
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





<!-- jsの読み込み -->
@include('script/js')

@endsection
