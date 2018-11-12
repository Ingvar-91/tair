<div>{{$nameSite}}</div>
<p>
    Заказ под номером № {{str_pad($id, 6, '0', STR_PAD_LEFT)}} был успешно сформирован.
</p>
@if($email)
<p>
    Просмотерть данные о заказе можно по ссылке - <a href="{{Route('current-order', ['id' => $id])}}">перейти</a>
</p>
@endif