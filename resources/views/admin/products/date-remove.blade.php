<div class="x_panel">
    <div class="x_title">
        <h2>Дата удаления товара</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="form-group">
            <label class="control-label">Дата:</label>
            <input type="text" class="form-control daterange" name="date_remove" @if(isset($product->date_remove)) value="{{$product->date_remove}}" @else value="{{date("Y-m-d H:i", strtotime("+3 month", time()))}}" @endif/>
        </div>
    </div>
</div>