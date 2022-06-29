<div class="popup-container2" id="{{$id}}" data-popup="0">
  <form action="{{$action}}" method="post" class="popup-form">
    <input type="text" name="name">
    <input type="submit" value="送信" class="submit" data-action="{{$action}}">
    {{csrf_field()}}
  </form>
</div>