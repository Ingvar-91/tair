<div class="x_panel">
    <div class="x_title">
        <h2>Опубликовать</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="form-group">
            <label class="control-label">Статус:</label>
            <select class="form-control" name="status">
                @if(Auth::user()->role > 4)
                <option @if(isset($shop->status) and ($shop->status == 2)) selected="selected" @endif value="2">Опубликовано</option>
                @endif
                <option @if(isset($shop->status) and ($shop->status == 1)) selected="selected" @endif value="1">На утверждении</option>
                <option @if(isset($shop->status) and ($shop->status == 3)) selected="selected" @endif value="3">Черновик</option>
            </select>
        </div>

        <div class="ln_solid"></div>
        
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="to_top" @if(isset($shop->to_top) and ($shop->to_top == 1)) checked @endif value="1"> Вывести на главную
                </label>
            </div>
        </div>
        
        <div class="ln_solid"></div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-success btn-control">{{$actionName}}</button>
        </div>

    </div>
</div>

