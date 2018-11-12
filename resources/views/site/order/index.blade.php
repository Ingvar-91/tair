@extends('site/index')

@push('css')

@endpush 

@push('scripts')
<!-- order -->
<script src="/js/site/order.js"></script>

<!-- maskedinput -->
<script src="/vendors/jquery.maskedinput/dist/jquery.maskedinput.min.js"></script>

<!-- api.2gis -->
<script charset="utf-8" src="https://floors-widget.api.2gis.ru/loader.js" id="dg-floors-widget-loader"></script>

<script>
    $(function($){
        $('#phone').mask('+7(999) 999-9999');
    });
</script>
@endpush

@section('title', 'Оформление заказа')

@section('content')
<nav class="box box-control m-b-0">
    {!! Breadcrumbs::render('order', $shop) !!}
</nav>

<section id="order" class="overflow-hidden">
    <div class="row custom-row">
        <div class="col-sm-7 m-r-sm">
            <div class="box box-control p-l p-r p-b m-r-0">
                <h2 class="margin-small-top">Оформление заказа</h2>
                
                @include('alerts')
                
                <form method="POST" autocomplete="off" id="order-form" action="{{Route('order.add', ['id' => request()->id])}}">
                    
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    
                    <input type="hidden" name="firm" value="{{$shop->firm2gis}}"/>
                    <input type="hidden" name="floors" value="{{$shop->floors2gis}}"/>
                    
                    <div class="section m-sm-b" id="delivery-order">
                        <div class="title"><span class="step">1.</span>Способ доставки</div>
                        <div class="item-content">
                            <div class="section-field">
                                <div class="messages"></div>
                                
                                <div class="form-group">
                                    @if($delivery_methods)
                                        @foreach($delivery_methods as $delivery_method)
                                            @if(is_numeric($shop->delivery_methods->search($delivery_method->id)))
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="delivery_id" value="{{$delivery_method->id}}" title="{{$delivery_method->title}}" required=""/> {{$delivery_method->title}}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                                <div class="form-group margin-large-top btn-control">
                                    <button type="button" class="btn btn-blue btn-medium back">Назад</button>
                                    <button type="button" class="btn btn-blue btn-medium float-right onwards">Продолжить</button>
                                </div>
                            </div>  
                            <div class="section-preiew hide">
                                <b></b>
                            </div>
                        </div>
                    </div>
                    
                    <div class="section m-sm-b hide" id="delivery-address">
                        <div class="title"><span class="step">2.</span>Самовывоз</div>
                        <div class="item-content hide">
                            <div class="section-field">
                                <div class="messages"></div>
                                
                                <div class="form-group map-group" id="map-delivery"></div>
                                
                                <div class="text form-group contacts-group">
                                    {!!$shop->contacts!!}
                                </div>

                                <div class="form-group margin-large-top btn-control">
                                    <button type="button" class="btn btn-blue btn-medium back">Назад</button>
                                    <button type="button" class="btn btn-blue btn-medium float-right onwards">Продолжить</button>
                                </div>
                            </div>  
                            <div class="section-preiew hide">
                                <b></b>
                            </div>
                        </div>
                    </div>

                    <div class="section m-sm-b" id="address-order">
                        <div class="title"><span class="step">2.</span>Местоположение получателя</div>
                        <div class="item-content hide">
                            <div class="section-field">

                                <div class="messages"></div>

                                <div class="m-sm-b text-bold">Основная информация</div>
                                <div class="form-group">
                                    <label>Выберите город <span class="color-red">*</span></label>
                                    <select class="form-control" name="city_id" required="">  
                                        @if(count($cities) > 0)
                                            <option></option>
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}">{{$city->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group hide" id="district">
                                    <label>Район <span class="color-red">*</span></label>
                                    <select class="form-control" name="district_id" required="">
                                    </select>
                                    <div class="district-message"></div>
                                </div>

                                <div class="form-group m-b">
                                    <label>Улица <span class="color-red">*</span></label>
                                    <input type="text" id="street" required="" class="form-control" name="street" value="@if(Auth::check()){{Auth::user()->street}}@endif"/>
                                </div>

                                <hr/>

                                <div class="m-sm-b text-bold">Дополнительная информация</div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Квартира / офис</label>
                                            <input type="text" class="form-control" name="apartment" value="@if(Auth::check()){{Auth::user()->apartment}}@endif"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Дом</label>
                                            <input type="text" class="form-control" name="home" value="@if(Auth::check()){{Auth::user()->home}}@endif"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Этаж</label>
                                            <input type="text" class="form-control" name="floor" value="@if(Auth::check()){{Auth::user()->floor}}@endif"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Код домофона</label>
                                            <input type="text" class="form-control" name="intercom" value="@if(Auth::check()){{Auth::user()->intercom}}@endif"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Корпус, строение</label>
                                            <input type="text" class="form-control" name="building" value="@if(Auth::check()){{Auth::user()->building}}@endif"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label>Подъезд</label>
                                            <input type="text" class="form-control" name="entrance" value="@if(Auth::check()){{Auth::user()->entrance}}@endif"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group btn-control">
                                    <button type="button" class="btn btn-blue btn-medium back">Назад</button>
                                    <button type="button" class="btn btn-blue btn-medium float-right onwards">Продолжить</button>
                                </div>
                            </div>  
                            <div class="section-preiew hide">
                                <b></b>
                            </div>
                        </div>
                    </div>

                    <div class="section m-sm-b" id="payment-order">
                        <div class="title"><span class="step">3.</span>Оплата</div>
                        <div class="item-content hide">
                            <div class="section-field">
                                <div class="messages"></div>

                                <div class="form-group">
                                    @if($payment_methods)
                                        @foreach($payment_methods as $payment_method)
                                            @if(is_numeric($shop->payment_methods->search($payment_method->id)))
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="payment_id" value="{{$payment_method->id}}" title="{{$payment_method->title}}" required=""/> {{$payment_method->title}} <span class="popover-item-product" data-toggle="popover" title="Popover title" data-content=""><i class="fa fa-info-circle" aria-hidden="true" style="padding-left: 4px;"></i></span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                
                                <div class="form-group">
                                    <div class="row">
                                        <label class="label-control col-md-3 col-sm-12" style="padding-top: 6px;">Нужна сдача с</label>
                                        <input type="number" id="deal" min="0" class="form-control col-md-6 m-l-sm" name="deal" style="max-width: 110px;"/>
                                    </div>
                                </div>
                                
                                <div class="form-group btn-control">
                                    <button type="button" class="btn btn-blue btn-medium back">Назад</button>
                                    <button type="button" class="btn btn-blue btn-medium float-right onwards">Продолжить</button>
                                </div>
                            </div>  
                            <div class="section-preiew hide">
                                <b></b>
                            </div>
                        </div>
                    </div>

                    <div class="section m-sm-b" id="buyer-order">
                        <div class="title">
                            <span class="step">4.</span>Покупатель
                        </div>
                        <div class="item-content padding-left padding-right hide">

                            <div class="messages"></div>

                            <div class="form-group">
                                <label>Контактное лицо (ФИО) <span class="color-red">*</span></label>
                                <input type="text" class="form-control" required="" required name="fio" placeholder="Контактное лицо (ФИО)" value=""/>
                            </div>
                            <div class="form-group">
                                <label>Основной мобильный номер <span class="color-red">*</span></label>
                                <input type="text" class="form-control" id="phone" required="" required name="phone" placeholder="Основной мобильный номер" value=""/>
                            </div>
                            <div class="form-group">
                                <label>Примечание</label>
                                <textarea name="note" class="form-control" required="" placeholder="Примечание"></textarea>
                            </div>
                            <div class="form-group margin-large-top btn-control">
                                <button type="button" class="btn btn-blue btn-medium back">Назад</button>
                                <button type="submit" class="btn btn-blue btn-medium float-right onwards">Оформить заказ</button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
        <div class="col-sm-5 m-l-sm">
            <div class="box box-control p-l p-r p-b m-l-0">
                <h2 class="m-sm-t">В заказе <small class="text-grey">{{Helper::wordForms(count($shop->products), ['товар', 'товара', 'товаров'])}}</small></h2>
                <hr>
                <div>
                    
                    @if(empty($shop->products) == false)
                        @foreach($shop->products as $product)
                            <div class="media">
                                <div class="media-left">
                                    <a href="{{Route('product', ['product_id' => $product->id])}}">
                                        <img style="max-width: 120px;" class="media-object" src="{{$product->preview}}" alt="">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <div>
                                        <a href="{{Route('product', ['product_id' => $product->id])}}" class="media-heading h4">{{$product->title}}</a>
                                    </div>
                                    
                                    @if($product->del == 1)
                                        <div class="text-grey">
                                            Количество: {{$cookieCart[$product->id]->count}} шт
                                        </div>
                                        <div class="text-grey">
                                            @if(Helper::isDiscount($product->start_discount, $product->end_discount, $product->discount)) 
                                                Цена за еденицу: <small class="text-strike">{{number_format($product->price, 0, '', ' ')}} ₸</small> <span>{{number_format($product->discount, 0, '', ' ')}}</span> ₸
                                            @else
                                                @if($product->price)
                                                    Цена за еденицу: {{number_format($product->price, 0, '', ' ')}} ₸
                                                @endif
                                            @endif
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
                                    @elseif($product->del == 2)
                                        <div class="text-yellow">
                                            Данный товар отсутствует, для более подробной информации обратитесь к <a class="link" href="{{Route('shop', ['id' => $shop->shop_id])}}">продавцу</a>.
                                        </div>
                                    @endif
                                    
                                    
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <hr>

                    <div>
                        <input type="hidden" id="order-price-val" value="{{$shop->total}}"/>
                        <input type="hidden" id="rate-shipping-val" value="{{$shop->cost_delivery}}"/>
                        <div>Сумма заказа: <span>{{number_format($shop->total, 0, '', ' ')}}</span> ₸</div>
                        <div id="rate-shipping-h" class="hide">Стоимость доставки: <span id="rate_shipping">0</span> ₸</div>
                    </div>
                    <hr>
                    <div>
                        <span class="h3">Всего: <span id="total-price">{{number_format($shop->total, 0, '', ' ')}}</span> ₸</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@stop