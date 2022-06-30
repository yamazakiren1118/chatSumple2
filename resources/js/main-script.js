$(document).ready(function(){
  // console.log(10000);
  var messageContainer = $("#messageContainer")
  // var margin = $("#post-form").offsetHeight + 'px';

  // メッセージ一覧
  var messageContainer = $("#messageContainer")
  // 入力フォームの高さ
  var postFormHeight = $("#post-form").height();
  // 入力フォームのテキストエリア
  var textarea = $("#post-form textarea");
  // 入力フォームのテキストエリアの高さ
  var textareaHeight = textarea[0].offsetHeight;
  

  $("#popupBackground").on('click', function(){
    $("*").removeClass("on");

    // 検索フォームをクリアする
    $(".popup-container input").val('');
    $(".popup-container .popup-body").html('');
    $(".popup-container2 input").val('');

    // ポップアップボタンを消す
    $("#channel-add-list").attr('data-popup',"0");
  });


  p_back = $("#popupBackground");
  nav_btn = $("#menu-btn");
  $(document).on('click', function(e){
    if($(e.target).closest("#menu-btn").length && !(Number($("#nav").attr('data-popup')))){//navを開く
      console.log('1');
      $("#nav").attr('data-popup',"1");
      // Number($("#nav").attr('data-popup')) && !($(e.target).closest("#nav").length)&&!($(e.target).closest("#popupBackground").length)
      // 以前の条件式
      // 下のelseifの条件式はcssのプロパティを取得してスマホ時とpc時で処理を分けてる
    }else if($("#nav").css('position') == "fixed" && $("#nav").css('left') == '0px' && !($(e.target).closest("#nav").length)&&!($(e.target).closest("#popupBackground").length)){//navが開いているときどこかがクリックされたら navを閉じる form展開時は閉じない
      // navを消しボタンも消す
      console.log('2');
      $("#nav").attr('data-popup',"0");
      $("#channel-add-list").attr('data-popup',"0");
      return false;
    }else if($(e.target).closest("#channels-popup-btn").length){//ボタンを表示する
      console.log('3');
      $("#channel-add-list").attr('data-popup',"1");
      return false;
    }else if($(e.target).closest("#nav a").length && Number($("#channel-add-list").attr('data-popup'))){//navのaがクリックされてボタンが表示されていた時
      $("#channel-add-list").attr('data-popup',"0");
      
      return false;
    }else if($(e.target).closest("#nav").length){//navをクリックしたときボタンを消す
      console.log('4');
      $("#channel-add-list").attr('data-popup',"0");
      // return false;
    }

  });
  $("#channel-create-btn").on('click',function(){
    $("#popup2").attr('data-popup',"1");
    $("#channel-add-list").attr('data-popup',"0");
    console.log('55');
    p_back.attr('data-popup', "1");
    return false;
  });
  $("#channel-add-btn").on('click',function(){
    $("#popup").attr('data-popup',"1");
    $("#channel-add-list").attr('data-popup',"0");
    p_back.attr('data-popup', "1");
    return false;
  });
  p_back.on('click',function(){//backgroundがクリックされたときフォームを消してbackgroundも消す
    $(".popup-container").attr('data-popup',"0");
    $(".popup-container2").attr('data-popup',"0");
    $(this).attr('data-popup',"0");
  });
  // $("#popupBackground2").on('click', function(){
  //   $("*").not("#nav,#popupBackground").removeClass("on");
  // });
  // $("#nav").on('click', function(){
  //   $("*").not("#nav,#popupBackground").removeClass("on");
  // });





  $("#user-add-btn").on('click', function(){
    $("#popup3").attr('data-popup','1');
    p_back.attr('data-popup', "1");
    return false;
  });

  // 以前の名残　現状使用していない
  $("#channel-search-btn").on('click', function(){
    $("#popup4").attr('data-popup','1');
    p_back.attr('data-popup', "1");
    return false;
  });

  // チャンネルにユーザーを追加するためのフォームをポップアップする
  $("#user-channel-add-btn").on('click', function(){
    // ポップアップボタンがポップアップしていたらボタンを消す
    // そうでないならフォームを表示する
    if(Number($("#channel-add-list").attr('data-popup'))){
      $("#nav").attr('data-popup',"0");
      $("#channel-add-list").attr('data-popup',"0");
    }else{
      $("#popup5").attr('data-popup','1');
      p_back.attr('data-popup', "1");
    }
    return false;
  });



  


  $('body').on('input', 'textarea' ,function(){
    if($(this)[0].offsetHeight <= $(this)[0].scrollHeight){
      console.log($(this)[0].scrollHeight);
      $(this)[0].style.height = $(this)[0].scrollHeight + 'px';
    }
  })

  // MessageController@editアクション メッセージの編集
  $("body").on('click', '.message-edit', function(){
    button = $(this).parent('button');
    id = $(this).data('id');
    url = $(this).attr('href');
    main = $(this).parents('.message').find(".message-main");
    p = $(this).parents('.message').find(".message-main").find('p').innerHeight();
    console.log(main);
    console.log(p);
    $.ajax(url,
      {
        type: 'post',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {id: id}
      }
    ).done(function(data){
      main.html(`<textarea style="height:${p}px;" name="message">${data}</textarea>`);
      button.replaceWith(`<button class="message-update">更新</button>`);
    });
    return false;
  });


  // $('body').on('click', '#popup-btn', function(){
  //   url = $(this).data('action');
  //   text = $(this).parents('.popup-form').find('.text').val();
  //   console.log(1000000000);
  //   console.log(url);
  //   console.log(text);
  //   $.ajax(url,
  //     {
  //       type: 'post',
  //       headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
  //       data: {text: text},
  //     }
  //   ).done(function(data){
  //     console.log(data);
  //   });
  //   return false;
  // });





  // ユーザーを検索して検索結果を表示する
  $('#popup3-btn').on('click', function(){
    text = $("#popup3-text").val();
    url = $(this).data('action');
    $.ajax(url,
      {
        type: 'post',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {text: text},
        context: this,
      }
    ).done(function(data){
      $(".popup-container .popup-body").html('');
      if(data.length > 0){//検索結果が0ならば何も表示しない
        
        $.each(data, function(index, val){

          $("#popup3-body").append(`<div class='popup-content'><p>${val['name']}</p><button class='add-btn' data-id='${val['id']}'>追加</button></div>`);
        });
      }
    });
  });


  // チャンネルを検索して結果を表示する
  $('#popup-btn').on('click', function(){
    text = $("#popup-text").val();
    url = $(this).data('action');
    $.ajax(url,
      {
        type: 'post',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {text: text},
        context: this,
      }
    ).done(function(data){//結果がなければ検索結果を消す
      if(data.length > 0){
        $.each(data, function(index, val){
          $("#popup-body").append(`<div class='popup-content'><p>${val['name']}</p><button class='add-btn' data-id='${val['id']}'>追加</button></div>`);
        })
      }else{
        $(".popup-container .popup-body").html('');
      }
    });
  });

  // チャンネルに加入するための処理
  $('body').on('click', '#popup button', function(){
    url = $("#popup-btn").data('create');
    id = $(this).data('id');
    user_id = "my";
    $.ajax(url,
      {
        type: 'post',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {id: id, user_id: user_id},
        context: this,
      }
    ).done(function(data){
      var parent = $(this).parents('.popup-content');
      console.log($(this));
      $(".channels > ul").append(`<li><a href="${data['url']}">${data['name']}チャンネル</a></li>`);
      parent.remove();
    })
  });
  


  

  // DMにユーザーを追加するための処理
  $('body').on('click', '#popup3 button', function(){
    url = $("#popup3-btn").data('create');
    id = $(this).data('id');
    
    $.ajax(url,
      {
        type: 'post',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {id: id},
        context: this,
      }).done(function(data){
        // console.log(data);
        // ユーザー部分にリンクを追加する
        console.log(data);
        $(".users ul").append(`<li><a href="${data['url']}">${data['user']}</a></li>`);

        // クリックされた要素は消す
        var parent = $(this).parents('.popup-content');
        console.log('ajax after')
        console.log(parent);
        
        parent.remove();
      });
  });

  // チャンネルにユーザーを追加するために検索する
  $("#popup5-btn").on('click', function(){
    text = $("#popup5-text").val();
    url = $(this).data('action');
    url_id = $(this).data('url_id');
    $(".popup-container .popup-body").html('');
    $.ajax(url,
      {
        type: 'post',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {text: text, url_id: url_id},
        context: this,
      }
    ).done(function(data){
      if(data.length > 0){
        $.each(data, function(index, val){
          $("#popup5-body").append(`<div class='popup-content'><p>${val['name']}</p><button class='add-btn' data-id='${val['id']}'>追加</button></div>`)
        });
      }else{
        $(".popup-container .popup-body").html('');
      }
    })
  });



  // ユーザーをチャンネルに追加する際の処理
  $('body').on('click', '#popup5 button', function(){
    url = $("#popup5-btn").data('create');
    id = $('body').data('id');
    user_id = $(this).data('id');
    $.ajax(url,
      {
        type: 'post',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {id: id, user_id: user_id},
        context: this,
      }
    ).done(function(data){
      var parent = $(this).parents('.popup-content');
      console.log($(this));
      parent.remove();
    })
  });
  
  textarea.on('input', function(){
    $(this)[0].style.height = textareaHeight + "px";

    $(this)[0].style.height = $(this)[0].scrollHeight + 'px';

    if(textareaHeight < $(this)[0].scrollHeight){
      margin = ($("#post-form").height() - postFormHeight) + "px";
      messageContainer.css({'margin-bottom': margin});
    }else{
      messageContainer.css({'margin-bottom': 0});
    }
  });
});