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
          <li>
            <a href="{{action('ChannelController@show',['id'=> $c->id])}}">
              {{$c->name}}チャンネル
              <?php $m = $c->messages()->orderBy('id', 'desc')->first() ?>
              @if($m && session($c->name) && $m->user->id != Auth::user()->id && $m->id > session($c->name))
                <strong>!</strong>
              @endif
            </a>
          </li>
        @endforeach
        
      </ul>
      <div class="channel-add">
        <a href="#" id="channels-popup-btn">チャンネルを追加</a>
        <ul class="channel-add-list" id="channel-add-list">
          <li><a href="#" id="channel-add-btn">チャンネルを追加</a></li>
          <li><a href="#" id="channel-create-btn">チャンネルを作成</a></li>
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
      <a href="#" class="user-add" id="user-add-btn">ユーザーを追加</a>
      
    </div>

    <a class="sign-out" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">サインアウト</a>
    <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
        {{csrf_field()}}
    </form>

    <a href="" class="channel-search" id="channel-search-btn">チャンネルを検索</a>
  </nav>

  <!-- メッセージ表示部分 -->
    <!-- チャンネル名とユーザー招待ボタン -->
    <div class="messages" id="scroll" data-scroll="" style="height: calc(100vh - 76px); margin-bottom:0px;">
      <div class="channel-name">
        <p>検索結果</p>
        <a href="" id="user-channel-add-btn">ユーザーを追加</a>
        
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
<div class="popup-background2" id="popupBackground2"></div>
@include('form1',['id'=>'popup','action'=>action('ChannelController@serch'),'create'=>''])

<!-- ポップアップ要素2 -->
@include('form2',['id'=>'popup2','action'=>action('ChannelController@create')])

@include('form1',['id'=>'popup3','action'=>action('DirectController@serch'),'create'=>action('DirectController@create')])

@include('form1',['id'=>'popup4','action'=>action('ChannelController@serch'),'create'=>''])

@include('form1',['id'=>'popup5','action'=>action('ChannelController@serch'),'create'=>action('ChannelController@add')])



<script>
  $(document).ready(function(){
    // $("#scroll").scrollTop($(".message-13").position().top)
    $("#scroll").scroll(function(){
      if($(this).scrollTop() == 0){
        
        page = $(this).data('scroll');
        id = {{$id}};
        
        $.ajax("{{action('ChannelController@scroll')}}",
          
          {
            type: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {page: page, id:id},
          }
        ).done(function(data){
          
          $.each(data,function(index,element){
            if(index == 'data'){
              m = element;
              $.each(m,function(index,element){
                id = element['id'];
                
                $edit = `{{action('MessageController@edit')}}`;
                $delete = `{{action('MessageController@delete')}}`;
                $update = `{{action('MessageController@update')}}`;
                console.log(element);
                
                $p = 
                `<div class="message message-${element['id']}">
                <form action="${$update}?=${element['id']}" method="post">
                  <div class="message-header">
                    <p>日付とユーザー名が取得できない</p>
                    <button><a class="message-edit" href="${$edit}?=${element['id']}" data-id="${element['id']}">編集</a></button>
                    <button class="message-delete"><a href="${$delete}?=${element['id']}">削除</a></button>
                  </div>
                  <div class="message-main">
                    <p>${element['message']}</p>
                  </div>
                  <input type="hidden" name="id" value="${element['id']}">
                  {{csrf_field()}}
                </form>
                </div>`;
                
                $("#messageContainer").prepend($p);
              });
            }
          });
          page = page == 0 ? 2 : page + 1;
          $("#scroll").data('scroll',page);
        });
      }
    });
  });
</script>

@endsection
