<form action="{{$action}}" method="post" class="post-form" id="post-form">
  <input type="submit" value="送信">
  <textarea name="message"></textarea>
  <input type="hidden" name="{{$name}}" value="{{$id}}">
  {{csrf_field()}}
</form>