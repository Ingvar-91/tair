@extends('site/index')

@section('title', 'История заказов')

@section('content')
<nav class="box box-control m-b-0">
    {!! Breadcrumbs::render('orders') !!}
</nav>

<section id="orders" class="m">
    <div class="row custom-row">
        <div class="col-sm-8">
            <div>
                <div class="">
                    @if(count($orders))
                        @foreach($orders as $order)
                            <div class="panel panel-default box">
                                <div class="panel-heading">Заказ № {{str_pad($order->id, 6, '0', STR_PAD_LEFT)}} от {{$order->created_at}}, {{Helper::wordForms(count($order->products), ['товар', 'товара', 'товаров'])}} на сумму <b>{{number_format($order->total, 0, '', ' ')}} ₸</b></div>
                                <div class="panel-body">
                                    @if(count($order->products))
                                        <div class="table-responsive">
                                            <table class="w-100 table">
                                                <thead>
                                                    <tr>
                                                        <td>Наименование</td>
                                                        <td>Количество</td>
                                                        <td>Цена</td>
                                                        <td>Сумма</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order->products as $product)
                                                        <tr>
                                                            <td>
                                                                <a href="{{Route('product', ['id' => $product->product_id])}}" target="_blank" class="link">{{$product->product_title}}</a>
                                                            </td>
                                                            <td>{{$product->count}} шт</td>
                                                            <td>{{number_format($product->price, 0, '', ' ')}} ₸</td>
                                                            <td>{{number_format(($product->price * $product->count), 0, '', ' ')}} ₸</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <a href="{{Route('current-order', ['id' => $order->id])}}" class="btn btn-orange btn-medium">Детали заказа</a>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="text-right m-sm-t">
                                                @if($order->status == 3)
                                                    <span class="text-green">{{config('orders.status')[$order->status]}}</span>
                                                @elseif($order->status == 4)
                                                    <span class="text-red">{{config('orders.status')[$order->status]}}</span>
                                                @endif
                                                - {{$order->status_at}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                    <div class="box p">
                        Заказы отсутствуют
                    </div>
                    @endif
                </div>
                
                @if($orders->total() > $orders->perPage())
                    <nav class="m-lg-b m-sm-t text-center">
                        {{ $orders->links() }}
                    </nav>
                @endif
            </div>
        </div>
        <div class="col-sm-4 m-t-sm">

            @include('site.profile-menu')

        </div>
    </div>
</section>

@stop