<div>{{$nameSite}}</div>
<p>
    Заказ под номером № {{str_pad($id, 6, '0', STR_PAD_LEFT)}} был успешно сформирован.
</p>

<p>
    Просмотерть данные о заказе можно по ссылке - <a href="{{Route('admin.orders.edit.form', ['id' => $id])}}">перейти в админ панель</a>
</p>
