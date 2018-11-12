<div style="min-width: 90px;">
    <a href="{{Route('vendor.products.edit.form', ['id' => $id, 'shop_id' => $shop_id])}}" class="btn btn-edit" title="Редактировать запись"><i class="fa fa-edit"></i></a>
    <button class="btn btn-danger remove-entry" title="Удалить запись" data-id="{{$id}}"><i class="fa fa-close"></i></button>
</div>