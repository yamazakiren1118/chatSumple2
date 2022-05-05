/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/main-script.js":
/*!*************************************!*\
  !*** ./resources/js/main-script.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  // console.log(10000);
  var messageContainer = $("#messageContainer");
  var margin = $("#post-form").offsetHeight + 'px';
  var textarea = $("#post-form textarea");
  $("#popupBackground").on('click', function () {
    $("*").removeClass("on");
  });
  $("#popupBackground2").on('click', function () {
    $("*").not("#nav,#popupBackground").removeClass("on");
  });
  $("#nav").on('click', function () {
    $("*").not("#nav,#popupBackground").removeClass("on");
  }); // チャンネルを追加 ボタンが2つポップアップ

  $("#channels-popup-btn").on('click', function () {
    if ($("#channel-add-list").hasClass("on")) {
      $("#channel-add-list").removeClass("on");
    } else {
      $("#popupBackground").addClass("on");
      $("#channel-add-list").addClass("on");
    }

    return false;
  }); // チャンネルを作成

  $("#channel-create-btn").on('click', function () {
    if ($("#popup2").hasClass("on")) {
      $("#popup2").removeClass("on");
    } else {
      // $("#popupBackground2").addClass("on");
      $("#popupBackground").addClass("on");
      $("#popup2").addClass("on");
    }

    return false;
  }); // チャンネルを追加

  $("#channel-add-btn").on('click', function () {
    if ($("#popup").hasClass("on")) {
      $("#popup").removeClass("on");
    } else {
      // $("#popupBackground2").addClass("on");
      $("#popupBackground").addClass("on");
      $("#popup").addClass("on");
    }

    return false;
  });
  $("#user-add-btn").on('click', function () {
    if ($("#popup3").hasClass("on")) {
      $("#popup3").removeClass("on");
    } else {
      // $("#popupBackground2").addClass("on");
      $("#popupBackground").addClass("on");
      $("#popup3").addClass("on");
    }

    return false;
  });
  $("#channel-search-btn").on('click', function () {
    if ($("#popup4").hasClass("on")) {
      $("#popup4").removeClass("on");
    } else {
      // $("#popupBackground2").addClass("on");
      $("#popupBackground").addClass("on");
      $("#popup4").addClass("on");
    }

    return false;
  });
  $("#user-channel-add-btn").on('click', function () {
    if ($("#popup5").hasClass("on")) {
      $("#popup5").removeClass("on");
    } else {
      // $("#popupBackground2").addClass("on");
      $("#popupBackground").addClass("on");
      $("#popup5").addClass("on");
    }

    return false;
  }); // ハンバーガー

  $("#menu-btn").on('click', function () {
    if ($("#nav").hasClass("on")) {
      $("#nav").removeClass("on");
    } else {
      $("#popupBackground").addClass("on");
      $("#nav").addClass("on");
    }

    return false;
  });
  $('body').on('input', 'textarea', function () {
    if ($(this)[0].offsetHeight <= $(this)[0].scrollHeight) {
      console.log($(this)[0].scrollHeight);
      $(this)[0].style.height = $(this)[0].scrollHeight + 'px';
    }
  }); // MessageController@editアクション

  $("body").on('click', '.message-edit', function () {
    button = $(this).parent('button');
    id = $(this).data('id');
    url = $(this).attr('href');
    main = $(this).parents('.message').find(".message-main");
    p = $(this).parents('.message').find(".message-main").find('p').innerHeight();
    console.log(main);
    console.log(p);
    $.ajax(url, {
      type: 'post',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        id: id
      }
    }).done(function (data) {
      main.html("<textarea style=\"height:".concat(p, "px;\" name=\"message\">").concat(data, "</textarea>"));
      button.replaceWith("<button>\u66F4\u65B0</button>");
    });
    return false;
  });
  $('body').on('click', '#popup-btn', function () {
    url = $(this).data('action');
    text = $(this).parents('.popup-form').find('.text').val();
    console.log(1000000000);
    console.log(url);
    console.log(text);
    $.ajax(url, {
      type: 'post',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        text: text
      }
    }).done(function (data) {
      console.log(data);
    });
    return false;
  });
  $('#popup3-btn').on('click', function () {
    text = $("#popup3-text").val();
    url = $(this).data('action');
    $.ajax(url, {
      type: 'post',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        text: text
      }
    }).done(function (data) {
      $.each(data, function (index, val) {
        console.log(index);
        console.log(val);
        console.log("<div class='popup-content'><p>".concat(val['name'], "</p><button class='add-btn' data-id='").concat(val['id'], "'>\u8FFD\u52A0</button></div>"));
        console.log('----------------');
        $("#popup3-body").append("<div class='popup-content'><p>".concat(val['name'], "</p><button class='add-btn' data-id='").concat(val['id'], "'>\u8FFD\u52A0</button></div>"));
      });
    });
  });
  $('#popup-btn').on('click', function () {
    text = $("#popup-text").val();
    url = $(this).data('action');
    $.ajax(url, {
      type: 'post',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        text: text
      }
    }).done(function (data) {
      $.each(data, function (index, val) {
        console.log(index);
        console.log(val);
        console.log("<div class='popup-content'><p>".concat(val['name'], "</p><button class='add-btn' data-id='").concat(val['id'], "'>\u8FFD\u52A0</button></div>"));
        console.log('----------------');
        $("#popup-body").append("<div class='popup-content'><p>".concat(val['name'], "</p><button class='add-btn' data-id='").concat(val['id'], "'>\u8FFD\u52A0</button></div>"));
      });
    });
  });
  $('body').on('click', '#popup3 button', function () {
    url = $("#popup3-btn").data('create');
    id = $(this).data('id');
    $.ajax(url, {
      type: 'post',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        id: id
      }
    }).done(function (data) {
      console.log(data);
    });
  });
  $("#popup5-btn").on('click', function () {
    text = $("#popup5-text").val();
    url = $(this).data('action');
    $.ajax(url, {
      type: 'post',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        text: text
      }
    }).done(function (data) {
      $.each(data, function (index, val) {
        $("#popup5-body").append("<div class='popup-content'><p>".concat(val['name'], "</p><button class='add-btn' data-id='").concat(val['id'], "'>\u8FFD\u52A0</button></div>"));
      });
    });
  });
  $('body').on('click', '#popup5 button', function () {
    url = $("#popup5-btn").data('create');
    id = $('body').data('id');
    user_id = $(this).data('id');
    $.ajax(url, {
      type: 'post',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        id: id,
        user_id: user_id
      }
    }).done(function (data) {
      console.log(data);
    });
  });
  var textareaHeight = textarea[0].offsetHeight;
  textarea.on('input', function () {
    if (textareaHeight < $(this)[0].scrollHeight) {
      $(this)[0].style.height = $(this)[0].scrollHeight + 'px';
      margin = $("#post-form")[0].offsetHeight + 'px';
      messageContainer.css({
        'margin-bottom': margin
      });
    }
  });
});

/***/ }),

/***/ 1:
/*!*******************************************!*\
  !*** multi ./resources/js/main-script.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /mnt/c/workspace/chatSumple2/resources/js/main-script.js */"./resources/js/main-script.js");


/***/ })

/******/ });