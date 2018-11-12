@foreach($shops as $key => $val)
<div class="radio">
    <label>
        <input type="radio" name="shop_id" value="{{$val->id}}" @if(isset($val->check)) checked @endif />
        {{$val->title}}
    </label>
</div>
@endforeach