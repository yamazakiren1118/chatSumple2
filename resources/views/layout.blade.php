<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="{{asset('js/main-script.js')}}"></script>
  
  <title>@yield('title')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body data-id="{{$id}}">
  @yield('content')
</body>
</html>