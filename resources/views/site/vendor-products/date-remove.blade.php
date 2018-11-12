<div class="form-group m-sm-t">
    <label class="control-label">Дата удаления товара:</label>
    <input type="text" class="form-control daterange" name="date_remove" @if(isset($product->date_remove)) value="{{$product->date_remove}}" @else value="{{date("Y-m-d H:i", strtotime("+3 month", time()))}}" @endif/>
</div>
