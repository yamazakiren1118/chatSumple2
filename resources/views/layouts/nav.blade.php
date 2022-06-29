
  <!-- サイドバー部分 -->
  <nav id="nav" data-popup="0">
    <div class="nav-wrap">
      <div class="channels">
        <span>チャンネル</span>
        <ul>
          @foreach($channels as $c)
            <li class="c-{{$c->id}}">
              <a href="{{action('ChannelController@show',['id'=> $c->id])}}">
                {{$c->name}}チャンネル
                <!-- 未読通知の判断 -->
                <!-- 最新のメッセージを取得 -->
                
                <?php $m = $c->messages()->orderBy('id', 'desc')->first() ?>
                
                @if(isset($m) && $m->user->id != Auth::user()->id && $c->pivot->message_id < $m->id)
                  <strong>!</strong>
                @endif
              </a>
            </li>
          @endforeach
          
        </ul>
        <div class="channel-add">
          <a href="#" id="channels-popup-btn">チャンネルを追加</a>
          <ul class="channel-add-list" id="channel-add-list" data-popup=0>
            <li><a href="" id="channel-add-btn">チャンネルを追加</a></li>
            <li><a href="" id="channel-create-btn">チャンネルを作成</a></li>
          </ul>
        </div>
      </div>
  
      <div class="users">
        <span>ユーザー</span>
        <ul>
          @foreach($directs as $d)
            <li class="d-{{$d->id}}">
              @foreach($d->users as $u)
                @if($u->id != Auth::id())
                  <a href="{{action('DirectController@show',['id'=>$d->id])}}">
                    {{$u->name}}


                    <!-- 未読通知の判断 -->
                    <!-- 最新のメッセージを取得 -->
                    <?php $dm = $d->direct_messages()->orderBy('id', 'desc')->first() ?>
                    
                    @if(isset($dm) && $dm->user->id != Auth::user()->id && $d->pivot->message_id < $dm->id)
                      <strong>!</strong>
                    @endif
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
  

      <a href="{{action('Auth\DeleteController@delete',['id'=>Auth::User()->id])}}" class="user-delete">ユーザーを削除</a>
    </div>
    <div class="nav-background" id="navBackground"></div>
  </nav>