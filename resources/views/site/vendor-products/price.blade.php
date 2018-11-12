<div class="x_panel">
    <div class="x_content">
        <div class="form-group">
            <label class="control-label" for="title">Цена</label>
            <input name="price" class="form-control" min="0" type="number" @if(isset($product->price)) value="{{$product->price}}" @endif/>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">Цена со скидкой</label>
            <input name="discount" class="form-control" min="0" type="number" @if(isset($product->discount)) value="{{$product->discount}}" @endif/>
        </div>
        
        <div class="form-group {{ empty($product->discount) ? ' hide' : '' }}">
            <label class="control-label">Дата начала скидки:</label>
            <input type="text" class="form-control daterange" name="start_discount" @if(isset($product->start_discount)) value="{{$product->start_discount}}" @else value="{{date("Y-m-d H:i")}}" @endif/>
        </div>
        
        <div class="form-group {{ empty($product->discount) ? ' hide' : '' }}">
            <label class="control-label">Дата окончания скидки:</label>
            <input type="text" class="form-control daterange" name="end_discount" @if(isset($product->end_discount)) value="{{$product->end_discount}}" @else value="{{date("Y-m-d H:i")}}" @endif/>
        </div>
    </div>
</div>