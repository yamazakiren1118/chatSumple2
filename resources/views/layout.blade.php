<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <script src="{{asset('js/app.js')}}" defer></script>
  <script src="{{asset('js/main-script.js')}}"></script>
  <title>@yield('title')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body data-id="{{$id}}">
<div id="app"></div>
  @yield('content')
</body>

</html>