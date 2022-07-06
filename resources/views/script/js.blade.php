<script>
  // スクロールが重複して起こらないようにするためのフラグ
  // trueでスクロールイベントが起こらない
  let scrFlg = false;

  // メッセージを作成する関数
  function create_message(element, edit_url, delete_url, update_url){
    // メッセージのidが自分のidと同じならボタンを表示する
    edit_btn = '';
    delete_btn = '';
    if(element['user_id'] == {{Auth::user()->id}}){
        edit_btn = $("<button>").html($('<a>', {
          href: edit_url,
          'data-id': element['id'],
          text: '編集',
          class: "message-edit",
        }));

        delete_btn = $("<button>").html($('<a>', {
          href: delete_url,
          'data-id': element['id'],
          text: '削除',
          class: "message-delete",
        }));
    }


    message_header = $("<div>",{class:`message-header`}).html($('<p>', {
      text: `${element['data']} ${element['name']}`,
    }).add(edit_btn).add(delete_btn));
    message_main = $("<div>",{class:`message-main`}).html($('<p>', {
      style: 'white-space:prewrap',
      text: `${element['message']}`,
    }));
    input_hidden = $("<input>",{
      type: 'hidden',
      name: 'id',
      value: `${element['id']}`,
    });

    form = $('<form>', {
      action: update_url,
      method: 'post',
    }).html(message_header.add(message_main).add(input_hidden).add(`{{csrf_field()}}`));


    // 実際に追加するメッセージ
    message = $("<div>", {
      class:`message message-${element['id']}`,
      id: `m-${element['id']}`,
      'data-id': `${element['id']}`,
    }).html(form);
    
    return message;
    
  }



  window.addEventListener('DOMContentLoaded', function(){
    // 無限スクロール
    $("#scroll").scroll(function(){
      
      // 一番下までスクロールしたかどうかの判断基準
      // -1は小数点基準の値の誤差に対応するため
      bottom = ($("#messageContainer").height() - $(this).height() - 1);

      // 一番上までスクロール
      if($(this).scrollTop() == 0){
          console.log('scroll up');
          page = $(this).data('scroll');
          id = {{$id}};
          // スクロール要素を足した後この要素の位置までスクロールを戻す
          point = $("#messageContainer")[0].firstElementChild;

          url = "{{$scroll_u}}";
          
          $.ajax(url,
            {
              type: 'post',
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              data: {page: page, id:id, point_id: point.dataset.id},
            }
          ).done(function(data){
            $.each(data,function(index,element){
              id = element['id'];
              
              edit_url = `{{$message_edit}}`;
              delete_url = `{{$message_delete}}`;
              update_url = `{{$message_update}}`;

              message = create_message(element, edit_url, delete_url, update_url);
              $("#messageContainer").prepend(message);
              console.log('prepend');
            });
            
            // スクロールを最後の要素の位置まで戻す
            if(data.length > 0){
              $("#scroll").scrollTop(point.offsetTop - 100);
            }
          });
        }else if($(this).scrollTop() >= bottom){//下までスクロールしたか判断
          if(scrFlg){
            return false;
          }
          scrFlg = true;
          console.log('scroll down start');
          page = $(this).data('scroll');
          id = {{$id}};
          
          point = $("#messageContainer")[0].lastElementChild;
          
          // scrollTopは指定した要素を基準に考える
          // offset().topは画面の上から考えるためそのズレを下でなくしている
          back = Math.abs($("#messageContainer").offset().top) + 100;

          url = "{{$scroll_d}}";
          $.ajax(url,
            {
              type: 'post',
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              data: {page: page, id:id, point_id: point.dataset.id},
            }
          ).done(function(data){
            console.log(data);
            $.each(data,function(index,element){
              id = element['id'];
              
              edit_url = `{{$message_edit}}`;
              delete_url = `{{$message_delete}}`;
              update_url = `{{$message_update}}`;

              message = create_message(element, edit_url, delete_url, update_url);
              $("#messageContainer").append(message);
              console.log(`append ${element['id']}`);

            });
            console.log('scroll down end');    

            if(data.length > 0){
              $("#scroll").scrollTop(back);
            }
            scrFlg = false;
          });
          
        }
    });


    @if (!$scroll)
      // スクロールを下にする
      $("#messageContainer")[0].scrollIntoView(false);
    @endif

    // チャンネル作成時の処理
    $("#popup2 .submit").on('click', function(){
      url = $(this).data('action');
      name = $("#popup2 input[type='text']").val();
      $.ajax(url,{
        type: 'post',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {name: name},
      }).done(function(data){
        $(".channels > ul").append(`<li><a href="${data['url']}">${data['name']}チャンネル</a></li>`);
        $("#popup2 input[type='text']").val('');
      });
      return false;
    });


    // メッセージ作成時の処理
    $("#post-form input[type='submit']").on('click', function(){
      url = $("#post-form").attr('action');
      message = $("#post-form textarea").val();
      room_id = {{$id}};
      $.ajax(url, {
        type: 'post',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {message: message,room_id: room_id}
      }).done(function(data){
        console.log('create message ok');
        socket.emit('create',{room_id:room_id,id:data['id'],last_message_id:data['last_message_id']});
        socket.emit('push', {id: data['id'], room_id: room_id, users: data['users'], user_id: data['user_id']});
      });
      $("#post-form textarea").val('');
      return false;
    });

    // メッセージ削除時の処理
    $("body").on("click", ".message .message-delete", function(){
      if(!(window.confirm('削除しますか'))){
        return false;
      }
      url = $(this).children('a').attr("href");
      id = $(this).parents('.message').attr('data-id');
      $.ajax(url, {
        type: 'get',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {id: id}
      }).done(function(data){
        socket.emit('delete', {id: id});
      })
      return false;
    });


    // メッセージ編集時の処理
    $("body").on("click", ".message .message-update", function(){
      url = $(this).parents('form').attr('action');
      id = $(this).parents('.message').attr('data-id');
      message = $(this).parents('.message').find('textarea').val();
      room_id = {{$id}};
      $.ajax(url, {
        type: 'post',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {id: id, room_id: room_id, message: message}
      }).done(function(data){
        
        socket.emit('update', {id: id});
      });
      return false;
    });



    // 下記3つは削除などの際の確認メッセージ
    $("#room-delete,#user-delete").on('click', function(){
      if(!(window.confirm('削除しますか'))){
        return false;
      }
    });

    $("#detach").on('click', function(){
      if(!(window.confirm('脱退しますか'))){
        return false;
      }
    });

    $("#logout-link").on('click', function(){
      if(!(window.confirm('ログアウトしますか'))){
        return false;
      }
      document.getElementById('logout-form').submit();
    });

  });
</script>