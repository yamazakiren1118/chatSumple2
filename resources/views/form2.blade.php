<div class="popup-container2" id="{{$id}}">
  <form action="{{$action}}" method="post" class="popup-form">
    <input type="text" name="name">
    <input type="submit" value="送信">
    {{csrf_field()}}
  </form>
</div>