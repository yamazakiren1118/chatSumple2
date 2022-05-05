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
  <!-- サイドバー部分 -->
  
  <nav id="nav">
    <div class="channels">
      <span>チャンネル</span>
      <ul>
        @foreach($channels as $c)
          <li><a href="{{action('ChannelController@show',['id'=> $c->id])}}">{{$c->name}}チャンネル</a></li>
        @endforeach
      </ul>
      <div class="channel-add">
        <a href="" id="channels-popup-btn">チャンネルを追加</a>
        <ul class="channel-add-list" id="channel-add-list">
          <li><a href="" id="channel-add-btn">チャンネルを追加</a></li>
          <li><a href="" id="channel-create-btn">チャンネルを作成</a></li>
        </ul>
      </div>
    </div>
    

    <div class="users">
      <span>ユーザー</span>
      <ul>
        @foreach($directs as $d)
          <li>
            @foreach($d->users as $u)
              @if($u->id != Auth::id())
                <a href="{{action('DirectController@show',['id'=>$d->id])}}">
                  {{$u->name}}
                </a>
              @endif
            @endforeach
          </li>
        @endforeach
      </ul>
      <a href="" class="user-add" id="user-add-btn">ユーザーを追加</a>
      
    </div>

    <a class="sign-out" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">サインアウト</a>
    <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
        {{csrf_field()}}
    </form>

    <a href="" class="channel-search" id="channel-search-btn">チャンネルを検索</a>
  </nav>

  <!-- メッセージ表示部分 -->
    <!-- チャンネル名とユーザー招待ボタン -->
    <div class="messages">
      <div class="channel-name">
        <p>{{$channel->name}}チャンネル</p>
        <a href="" id="user-channel-add-btn">ユーザーを追加</a>
        <a href="{{action('DirectController@delete',['id'=> $id])}}">チャンネルを削除</a>
      </div>
      <div class="message-container" id="messageContainer">

      @foreach($messages as $m)
        <div class="message message-{{$m->id}}">
          <form action="{{action('DirectMessageController@update',['id'=>$m->id])}}" method="post">
            <div class="message-header">
              <p>{{$m->created_at->format('Y/m/d')}} {{$m->user->name}}</p>
              <button><a class="message-edit" href="{{action('DirectMessageController@edit',['id'=>$m->id])}}" data-id="{{$m->id}}">編集</a></button>
              <button class="message-delete"><a href="{{action('DirectMessageController@delete',['id'=>$m->id])}}">削除</a></button>
            </div>
            <div class="message-main">
              <p>{!! nl2br($m->message) !!}</p>
            </div>
            <input type="hidden" name="id" value="{{$m->id}}">
            {{csrf_field()}}
          </form>
        </div>
      @endforeach

        <div class="message">
          <div class="message-header">
            <p>2021/12/09 14:23 田中 タロウ</p>
            <button class="message-edit">編集</button>
            <button class="message-delete">削除</button>
          </div>
          <div class="message-main">
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
          </div>
        </div>
    
        <div class="message">
          <div class="message-header">
            <p>2021/12/09 14:23 田中 タロウ</p>
            <button class="message-edit">編集</button>
            <button class="message-delete">削除</button>
          </div>
          <div class="message-main">
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
          </div>
        </div>
    
        <div class="message">
          <div class="message-header">
            <p>2021/12/09 14:23 田中 タロウ</p>
            <button class="message-edit">編集</button>
            <button class="message-delete">削除</button>
          </div>
          <div class="message-main">
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
          </div>
        </div>
    
        <div class="message">
          <div class="message-header">
            <p>2021/12/09 14:23 田中 タロウ</p>
            <button class="message-edit">編集</button>
            <button class="message-delete">削除</button>
          </div>
          <div class="message-main">
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
          </div>
        </div>
    
        <div class="message">
          <div class="message-header">
            <p>2021/12/09 14:23 田中 タロウ</p>
            <button class="message-edit">編集</button>
            <button class="message-delete">削除</button>
          </div>
          <div class="message-main">
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
          </div>
        </div>
    
        <div class="message">
          <div class="message-header">
            <p>2021/12/09 14:23 田中 タロウ</p>
            <button class="message-edit">編集</button>
            <button class="message-delete">削除</button>
          </div>
          <div class="message-main">
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
            <p>投稿内容はこのように表示されます。</p>
          </div>
        </div>
      </div>
    </div>
</main>
<!-- ポップアップ要素 -->
<div class="popup-background" id="popupBackground"></div>
<div class="popup-background2" id="popupBackground2"></div>
@include('form1',['id'=>'popup','action'=>action('ChannelController@serch'),'create'=>''])

<!-- ポップアップ要素2 -->
@include('form2',['id'=>'popup2','action'=>action('ChannelController@create')])

@include('form1',['id'=>'popup3','action'=>action('DirectController@serch'),'create'=>action('DirectController@create')])

@include('form1',['id'=>'popup4','action'=>action('ChannelController@serch'),'create'=>''])

@include('form1',['id'=>'popup5','action'=>action('ChannelController@serch'),'create'=>''])

@include('form3',['action'=>action('DirectMessageController@create'),'name'=>'direct_id'])

@endsection
