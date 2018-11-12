<div>
    <div class="x_content">

        <div class="form-group">
            <label class="control-label">Статус:</label>
            <select class="form-control" name="status">
                <option @if(isset($product->status) and ($product->status == 1)) selected="selected" @endif value="1">На утверждении</option>
                
                <option @if(isset($product->status) and ($product->status == 3)) selected="selected" @endif value="3">Черновик</option>
            </select>
        </div>

        <div class="ln_solid"></div>

        <div class="form-group text-right">
            <button type="button" class="btn btn-blue btn-control w-100 btn-medium" id="{{$idName}}">{{$actionName}}</button>
        </div>

    </div>
</div>

