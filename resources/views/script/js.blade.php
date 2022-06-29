<script>
  $(document).ready(function(){
    // 各ポップアップ要素
    // p_form1;
    // p_form2;
    // p_btns;
    
// {id: '20', updated_at: '2022/06/23', message: 'aaa', edit_url: 'http://127.0.0.1:8000/message/edit', delete_url: 'http://127.0.0.1:8000/message/delete'}delete_url: "http://127.0.0.1:8000/message/delete"edit_url: "http://127.0.0.1:8000/message/edit"id: "20"message: "aaa"updated_at: "2022/06/23"[[Prototype]]: Object

    // 無限スクロール
    $("#scroll").scroll(function(){
      
      
      // 上にスクロール
      @if (!(isset($direct)))
        if($(this).scrollTop() == 0){
          
          page = $(this).data('scroll');
          id = {{$id}};
          
          point = $("#messageContainer")[0].firstElementChild;
          $.ajax("{{action('ChannelController@scroll_u')}}",
            
            {
              type: 'post',
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              data: {page: page, id:id, point_id: point.dataset.id},
            }
          ).done(function(data){
                $.each(data,function(index,element){
                  id = element['id'];
                  
                  $edit = `{{action('MessageController@edit')}}`;
                  $delete = `{{action('MessageController@delete')}}`;
                  $update = `{{action('MessageController@update')}}`;
                  
                  if(!(point.dataset.id <= element['id'])){
                    $x = '';
                    if(element['user_id'] == {{Auth::user()->id}}){
                      $x = 
                      `<button><a class="message-edit" href="${$edit}?=${element['id']}" data-id="${element['id']}">編集</a></button>
                        <button class="message-delete"><a href="${$delete}?=${element['id']}">削除</a></button>`
                    }
                    $p = 
                    `<div class="message message-${element['id']}" id="m-${element['id']}" data-id="${element['id']}">
                    <form action="${$update}?=${element['id']}" method="post">
                      <div class="message-header">
                        <p>${element['data']} ${element['name']}</p>
                        ${$x}
                      </div>
                      <div class="message-main">
                        <p style="white-space:pre-wrap">${element['message']}</p>
                      </div>
                      <input type="hidden" name="id" value="${element['id']}">
                      {{csrf_field()}}
                    </form>
                    </div>`;
                    $("#messageContainer").prepend($p);
                  }
                });
              
            

            
            if(data.length > 0){
              $("#scroll").scrollTop(point.offsetTop - 100);
            }
          });
        }else if($(this).scrollTop() >= ($("#messageContainer").height() - $(this).height() - 1)){
          
          page = $(this).data('scroll');
          id = {{$id}};
          
          point = $("#messageContainer")[0].lastElementChild;

          // scrollTopは指定した要素を基準に考える
          // offset().topは画面の上から考えるためそのズレを下でなくしている
          back = Math.abs($("#messageContainer").offset().top) + 100;
          $.ajax("{{action('ChannelController@scroll_d')}}",
            
            {
              type: 'post',
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              data: {page: page, id:id, point_id: point.dataset.id},
            }
          ).done(function(data){
            console.log(data);
                $.each(data,function(index,element){
                  id = element['id'];
                  
                  $edit = `{{action('MessageController@edit')}}`;
                  $delete = `{{action('MessageController@delete')}}`;
                  $update = `{{action('MessageController@update')}}`;
                  
                  if(!(point.dataset.id >= element['id'])){
                    $p = 
                    `<div class="message message-${element['id']}" id="m-${element['id']}" data-id="${element['id']}">
                    <form action="${$update}?=${element['id']}" method="post">
                      <div class="message-header">
                        <p>${element['data']} ${element['name']}</p>
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
                    $("#messageContainer").append($p);
                  }
                  
                });
              
            

            
            if(data.length > 0){
              $("#scroll").scrollTop(back);
            }
          });
        }
      @else
        // DM用の無限スクロール
        if($(this).scrollTop() == 0){
          page = $(this).data('scroll');
          id = {{$id}};
          
          point = $("#messageContainer")[0].firstElementChild;
          console.log(point.dataset.id);
          $.ajax("{{action('DirectController@scroll_u')}}",
            {
              type: 'post',
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              data: {page: page, id:id, point_id: point.dataset.id},
            }
          ).done(function(data){
                $.each(data,function(index,element){
                  id = element['id'];
                  
                  $edit = `{{action('DirectMessageController@edit')}}`;
                  $delete = `{{action('DirectMessageController@delete')}}`;
                  $update = `{{action('DirectMessageController@update')}}`;
                  
                  if(!(point.dataset.id <= element['id'])){
                    $x = '';
                    if(element['user_id'] == {{Auth::user()->id}}){
                      $x = 
                      `<button><a class="message-edit" href="${$edit}?=${element['id']}" data-id="${element['id']}">編集</a></button>
                        <button class="message-delete"><a href="${$delete}?=${element['id']}">削除</a></button>`
                    }
                    $p = 
                    `<div class="message message-${element['id']}" id="m-${element['id']}" data-id="${element['id']}">
                    <form action="${$update}?=${element['id']}" method="post">
                      <div class="message-header">
                        <p>${element['data']} ${element['name']}</p>
                        ${$x}
                      </div>
                      <div class="message-main">
                        <p style="white-space:pre-wrap">${element['message']}</p>
                      </div>
                      <input type="hidden" name="id" value="${element['id']}">
                      {{csrf_field()}}
                    </form>
                    </div>`;
                    $("#messageContainer").prepend($p);
                  }
                });
              
            
            // page = page == 0 ? 2 : page + 1;
            // $("#scroll").data('scroll',page);
            
            if(data.length > 0){
              $("#scroll").scrollTop(point.offsetTop - 100);
            }
          });
        }else if($(this).scrollTop() >= ($("#messageContainer").height() - $(this).height() - 1)){
          console.log('dm scroll bottom');
          page = $(this).data('scroll');
          id = {{$id}};
          
          point = $("#messageContainer")[0].lastElementChild;

          // scrollTopは指定した要素を基準に考える
          // offset().topは画面の上から考えるためそのズレを下でなくしている
          back = Math.abs($("#messageContainer").offset().top) + 100;
          $.ajax("{{action('DirectController@scroll_d')}}",
            {
              type: 'post',
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              data: {page: page, id:id, point_id: point.dataset.id},
            }
          ).done(function(data){
            console.log(data);
                $.each(data,function(index,element){
                  id = element['id'];
                  
                  $edit = `{{action('DirectMessageController@edit')}}`;
                  $delete = `{{action('DirectMessageController@delete')}}`;
                  $update = `{{action('DirectMessageController@update')}}`;
                  
                  if(!(point.dataset.id >= element['id'])){
                    $p = 
                    `<div class="message message-${element['id']}" id="m-${element['id']}" data-id="${element['id']}">
                    <form action="${$update}?=${element['id']}" method="post">
                      <div class="message-header">
                        <p>${element['data']} ${element['name']}</p>
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
                    $("#messageContainer").append($p);
                  }
                  
                });
              
            
            // page = page == 0 ? 2 : page + 1;
            // $("#scroll").data('scroll',page);
            
            if(data.length > 0){
              $("#scroll").scrollTop(back);
            }
          });
        }
      @endif
      
    });


    @if (!(isset($scroll)))
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
        socket.emit('create',{room_id:room_id,id:data['id']});
        socket.emit('push', {room_id: room_id, users: data['users'], user_id: data['user_id']});
      });
      $("#post-form textarea").val('');
      return false;
    });

    // メッセージ削除時の処理
    $("body").on("click", ".message .message-delete", function(){
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
  });
</script>