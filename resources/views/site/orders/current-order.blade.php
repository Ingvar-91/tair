@extends('site/index')

@push('css')
@endpush

@section('title', 'Заказ № '.str_pad($order->id, 6, '0', STR_PAD_LEFT))

@section('content')
<nav class="box box-control m-b-0" id="breadcrumb">
    {!! Breadcrumbs::render('current-order', $order) !!}
</nav>

<section id="current-order" class="m">
    <div class="row custom-row">
        <div class="col-sm-8 order-detail">
            <div class="">
                <div class="panel panel-default box">
                    <div class="panel-heading">Заказ № {{str_pad($order->id, 6, '0', STR_PAD_LEFT)}} от {{$order->created_at}}, {{Helper::wordForms(count($order->products), ['товар', 'товара', 'товаров'])}} на сумму <b>{{number_format($order->total, 0, '', ' ')}} ₸</b></div>
                    <hr class="hr-print"/>
                    <div class="panel-body">
                        
                        <div class="row row-print-1">
                            <div class="col-sm-6">
                                <div class="logo-print">
                                    <img src="/img/logo/logo-dark.png" class="w-100" style="max-width: 310px;" alt=""/>
                                </div>
                                <div class="text-center m-sm-t logo-site">
                                    <img src="/img/logo/logo.png" class="w-100" style="max-width: 310px;" alt=""/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-grey">
                                    Служба пожддержки:
                                </div>
                                <div class="display-table">
                                    <div class="icon table-cell"><i class="fa fa-phone" aria-hidden="true"></i></div>
                                    <div class="phone table-cell">
                                        <a href="tel:+77212502524">+7 7212 50 25 24</a>
                                    </div>
                                </div>
                                <div class="display-table">
                                    <div class="icon table-cell"><i style="font-size: 1.4rem;" class="fa fa-mobile" aria-hidden="true"></i></div>
                                    <div class="phone table-cell">
                                        <a href="tel:+77004343002">+7 700 43 43 002</a>
                                    </div>
                                </div>
                                <span id="printPage" onclick="print()" role="button" title="Распечатать">
                                    <i class="fa fa-print" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row row-print-1">
                            <div class="col-sm-6">
                                <h3 class="m-sm-t print-title">Содержимое заказа</h3>
                                <div class="table-product">

                                    @if(count($order->products))
                                        @foreach($order->products as $product)
                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="{{Route('product', ['id' => $product->product_id])}}">
                                                        @if(Helper::getImg($product->product_images, 'products', 'middle'))
                                                            <img class="media-object" style="max-width: 130px;" src="{{Helper::getImg($product->product_images, 'products', 'middle')}}" alt=""/>
                                                        @else
                                                            <img class="media-object" style="max-width: 130px;" src="/img/no-image-1x1.jpg" alt=""/>
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <a href="{{Route('product', ['id' => $product->product_id])}}" class="media-heading h4">{{$product->product_title}}</a>
                                                    <div class="text-grey">
                                                        Количество: {{$product->count}} шт
                                                    </div>
                                                    <div class="text-grey">
                                                        Цена за еденицу: 
                                                        <br/>
                                                        {{number_format($product->price, 0, '', ' ')}} ₸
                                                    </div>
                                                    <div class="text-grey">
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
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <h3 class="m-sm-t print-title">Информация о заказе</h3>
                                <div class="m-sm-b">
                                    <div class="text-grey">Сумма заказа:</div>
                                    <div class="text-bold display-table">
                                        <div class="icon table-cell"><i class="fa fa-money" aria-hidden="true"></i></div>
                                        <div class="table-cell">
                                            {{number_format($order->total, 0, '', ' ')}} ₸
                                        </div>
                                    </div>
                                </div>

                                <div class="m-sm-b status-order">
                                    <div class="text-grey">Текущий статус:</div>
                                    @if($order->status == 3)
                                        <div class="text-bold text-green display-table">
                                            <div class="icon table-cell"><i class="fa fa-check" aria-hidden="true"></i></div>
                                            <div class="table-cell">
                                                {{config('orders.status')[$order->status]}}
                                            </div>
                                        </div>
                                    @elseif(($order->status == 1) or ($order->status == 2))
                                        <div class="text-bold text-yellow display-table">
                                            <div class="icon table-cell"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
                                            <div class="table-cell">
                                                {{config('orders.status')[$order->status]}}
                                            </div>
                                        </div>
                                    @elseif($order->status == 4)
                                        <div class="text-bold text-red display-table">
                                            <div class="icon table-cell"><i class="fa fa-close" aria-hidden="true"></i></div>
                                            <div class="table-cell">
                                                {{config('orders.status')[$order->status]}}
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="m-sm-b">
                                    <div class="text-grey">Контактное лицо (ФИО):</div>
                                    <div class="text-bold display-table">
                                        <div class="icon table-cell"><i class="fa fa-user-o" aria-hidden="true"></i></div>
                                        <div class="table-cell">
                                            {{$order->fio}}
                                        </div>
                                    </div>
                                </div>

                                <div class="m-sm-b">
                                    <div class="text-grey">Основной мобильный номер:</div>
                                    <div class="text-bold display-table">
                                        <div class="icon table-cell"><i style="font-size: 1.4rem;" class="fa fa-mobile" aria-hidden="true"></i></div>
                                        <div class="table-cell">
                                            {{$order->phone}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="m-sm-t print-title">Доставка</h3>
                                <div>
                                    @if($order->delivery_id == 2)
                                    <p>
                                        <b>Стоимость доставки {{ number_format($order->delivery_price, 0, '', ' ') }} ₸</b>
                                    </p>
                                    @endif
                                    <p>
                                        Служба доставки: {{$order->delivery_title}}
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="icon-svg">
                                    <img src="/fonts/fast-delivery.svg" alt="">
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="form-group">
                            <div class="row row-print">
                                <div class="col-md-5 col-sm-12">
                                    <div>
                                        Предварительная стоимость:
                                    </div>
                                    @if($order->delivery_id == 2)
                                        <div>
                                            Стоимость доставки:
                                        </div>
                                    @endif
                                    <div>
                                        Итого:
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div>
                                        <b>{{number_format($order->total, 0, '', ' ')}} ₸</b>
                                    </div>
                                    @if($order->delivery_id == 2)
                                        <div>
                                            <b>{{ number_format($order->delivery_price, 0, '', ' ') }} ₸</b>
                                        </div>
                                    @endif
                                    <div>
                                        <b>{{ number_format($order->total + $order->delivery_price, 0, '', ' ') }} ₸</b>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-4 order-sidebar m-t-sm">
            
            @include('site.profile-menu')
            
        </div>
    </div>
</section>

@stop