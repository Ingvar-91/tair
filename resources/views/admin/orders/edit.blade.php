@extends('admin/index')

@push('css')
<!-- DataTables -->
<link href="/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<!-- DataTables END -->
@endpush 

@push('scripts')
<!-- DataTables -->
<script src="/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="/js/admin/data-tables.js"></script>
<!-- DataTables END -->
@endpush 

@section('content')

<div class="clearfix"></div>
{!! Breadcrumbs::render('admin.orders.form') !!}

<section>
    <form action="{{Route('admin.orders.edit', ['id' => $order->id])}}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        @include('alerts')

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Детали заказа</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Контактное лицо (ФИО)</th>
                                    <th>Телефон</th>
                                    <th>Адрес доставки</th>
                                    <th>Способ доставки</th>
                                    <th>Оплата</th>
                                    <th>Дата создания</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$order->fio}}</td>
                                    <td>{{$order->phone}}</td>
                                    <td>{{$order->street}}</td>
                                    <td>{{$order->delivery_title}}</td>
                                    <td>{{$order->payment_title}}</td>
                                    <td>{{$order->created_at}}</td>
                                </tr>
                            </tbody>
                        </table>

                        <br/>

                        <table class="table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Товар</th>
                                    <th>Свойства товара</th>
                                    <th>Кол-во</th>
                                    <th>Цена за ед.</th>
                                    <th>Всего</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(empty($products) == false)
                                    @foreach($products as $product)
                                    <tr>
                                        <td><a target="_blank" href="{{Route('product', ['product_id' => $product->product_id])}}">{{$product->product_title}}</a></td>
                                        <td>
                                            @if(empty($product->props) == false)
                                                @foreach($product->props as $prop)
                                                    {{$prop->title}}
                                                    @if(count($prop->child))
                                                        @foreach($prop->child as $propChild)
                                                            - {{$propChild->title}}
                                                        @endforeach
                                                    @endif
                                                    @if(!$loop->last)
                                                        /
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{$product->count}}</td>
                                        <td>{{number_format($product->price, 0, '', ' ')}} ₸</td>
                                        <td>{{ number_format($product->count * $product->price, 0, '', ' ') }} ₸</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">Предварительная стоимость</th>
                                    <th>{{ number_format($total, 0, '', ' ') }} ₸</th>
                                </tr>
                                @if($order->delivery_id == 2)
                                    <tr>
                                        <th colspan="4">Стоимость доставки</th>
                                        <th>{{$order->delivery_price}} ₸</th>
                                    </tr>
                                @endif
                                
                                <!--<tr>
                                    <th colspan="3">НДС (18%)</th>
                                    <th>{{ number_format(round($total * (18/100)), 0, '', ' ') }} тг.</th>
                                </tr>-->
                                
                                @if($order->delivery_id == 2)
                                <tr>
                                    <th colspan="4">{{$order->delivery_title}}</th>
                                    <th>{{ number_format($order->delivery_price, 0, '', ' ') }} ₸</th>
                                </tr>
                                @endif
                                
                                <tr>
                                    <th colspan="4">Итого</th>
                                    <th>{{ number_format($total + $order->delivery_price, 0, '', ' ') }} ₸</th>
                                </tr>
                                <tr>
                                    <th colspan="4">Нужна сдача с</th>
                                    <th colspan="4">{{ number_format($order->deal, 0, '', ' ') }} ₸</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Дополнительная информация</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                       <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Квартира</th>
                                    <th>Дом</th>
                                    <th>Этаж</th>
                                    <th>Код домофона</th>
                                    <th>Корпус, строение</th>
                                    <th>Подъезд</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$order->apartment}}</td>
                                    <td>{{$order->home}}</td>
                                    <td>{{$order->floor}}</td>
                                    <td>{{$order->intercom}}</td>
                                    <td>{{$order->building}}</td>
                                    <td>{{$order->entrance}}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        @if($order->note)
                            <div class="alert alert-warning">
                                {{$order->note}}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Управление историей заказа</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group ">
                            <label class="control-label">Статус заказа</label>
                            <select required autocomplete="off" name="status" class="form-control" title="Статус заказа">
                                <option value="1" @if($order->status == 1) selected @endif>Ожидание</option>
                                <option value="2" @if($order->status == 2) selected @endif>В обработке</option>
                                <option value="3" @if($order->status == 3) selected @endif>Доставлено</option>
                                <option value="4" @if($order->status == 4) selected @endif>Отменено</option>
                            </select>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<script>
var columnsName = [
    {data: 'nickname'},
    {data: 'email'},
    {data: 'title'},
    {data: 'actions', searchable: false, orderable: false}
];
</script>

@stop