<!-- env関数で環境変数があればそれをなければlocalhostのアドレスを出力する -->
<script src="{{env('SOCKET_URL', 'http://localhost:3000')}}/socket.io/socket.io.js"></script>
<script>
  var socket = io("{{env('SOCKET_URL', 'http://localhost:3000')}}");
  console.log(socket);
  socket.on("connect", function(data){
    // 接続時ユーザー情報を送信する
    var user_id = {{Auth::user()->id}};
    socket.emit('user_set', {id: user_id});

    var room_id = {{$id}};
    
    // ChannelかDirectかの識別
    var room_type = "{{$room_type}}";
    socket.room = room_id;
    socket.room_type = room_type;
    socket.emit('room_in', {id: room_id, room_type: room_type});
  });

  socket.on("room_in", function(data){
    
  });

  socket.on('create', function(data){
    
    url = '{{$socket_serch}}';

    last_message_id = $("#messageContainer")[0].lastElementChild.dataset.id;

    // 送られてきたメッセージのidの順序が正しいかチェックしている
    if(last_message_id != data.last_message_id){
      return false;
    }
    $.ajax(url, {
      type: "post",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {id: data.id, last_message_id: last_message_id}
    }).done(function(data){
      

      // 各HTML要素を生成する
      message = $("<div>",{
        class: "message message-20",
        id: `m-${data.id}`,
        'data-id': data.id
      });
      // フォーム
      form = $("<form>",{
        action: data.update_url,
        method: "post"
      });


      // --- メッセージヘッダー系部分 ---
      // 編集ボタン
      edit_btn = $("<button>").html($("<a>", {
        href: data.edit_url,
        class: "message-edit",
        "data-id": data.id,
        text: "編集" 
      }));
      // 削除ボタン
      delete_btn = $("<button>",{class:"message-delete"}).html($("<a>", {
        href: data.delete_url,
        text: "削除" 
      }));

      // ユーザーidが違ったらボタンは表示しない
      if({{Auth::user()->id}} != data.user_id){
        edit_btn = '';
        delete_btn = '';
      }
      // メッセージヘッダー
      message_header = $("<div>",{
        class: "message-header"
      }).html($(`<p>${data.updated_at} ${data.user_name}</p>`).add(edit_btn).add(delete_btn));
      


      // メッセージ内容
      message_main = $("<div>",{class:"message-main"}).html(`<p style="white-space:pre-wrap">${data.message}</p>`);
      // hidden
      hidden = $("<input>",{
        type: "hidden",
        name: "id",
        value: data.id
      });


      // 実際に追加するhtml
      message.html(
        form.html(
          message_header.add(message_main).add(hidden)
      ));

      

      $("#messageContainer").append(message);
    });
  });


  // メッセージが編集されたときの処理
  socket.on('update', function(data){
    url = '{{$socket_serch}}';
    
    $.ajax(url, {
      type: "post",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {id: data.id}
    }).done(function(data){


      // ユーザーidが同じならmessage-headerを修正
      if({{Auth::user()->id}} == data.user_id){
          // 編集ボタン
          edit_btn = $("<button>").html($("<a>", {
            href: data.edit_url,
            class: "message-edit",
            "data-id": data.id,
            text: "編集" 
          }));
          // 削除ボタン
          delete_btn = $("<button>",{class:"message-delete"}).html($("<a>", {
            href: data.delete_url,
            text: "削除" 
          }));
          $(`#m-${data.id} .message-header`).html($(`<p>${data.updated_at} ${data.user_name}</p>`).add(edit_btn).add(delete_btn));
      }

      // メッセージ内容を反映
      console.log(data.message);
      $(`#m-${data.id} .message-main`).html(`<p style="white-space:pre-wrap">${data.message}</p>`);
    });
  });

  socket.on('delete', function(data){
    // ブロードキャストが来たらメッセージを削除する
    message = $(`#m-${data.id}`);
    message.remove();
  });


  // 通知を表示するための処理
  socket.on('push', function(data){
    if({{Auth::user()->id}} != data.user_id && {{$id}} != data.room_id){
      $(`.${data.room_type}-${data.room_id} a`).append("<strong>!</strong>");
    }
  });
</script>