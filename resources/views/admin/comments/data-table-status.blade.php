<select class="form-control comment-status" data-id="{{$id}}">
    <option value="2" @if($status == 2) selected @endif>Проверено</option>
    <option value="1" @if($status == 1) selected @endif>Не проверено</option>
    <option value="3" @if($status == 3) selected @endif>Удалено</option>
</select>