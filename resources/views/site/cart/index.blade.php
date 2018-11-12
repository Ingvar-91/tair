@extends('site/index')

@push('css')

@endpush 

@push('scripts')
<!-- products -->
<script src="/js/site/products.js"></script>
@endpush

@section('title', 'Корзина товаров')

<script id="message-min-price-ejs" type="text/template">

</script>

@section('content')
<section id="cart-page" class="bg-white margin-large-bottom">
    <h4 class="title-section">Корзина товаров</h4>
    <div class="cart-body">
        @if(count($productsShops) > 0)
            @foreach($productsShops as $shop)
            <div class="shop">
                <h4>{{$shop->title}}</h4>
                
                <input type="hidden" name="min_price" value="{{$shop->min_price}}"/>
                <input type="hidden" name="total" value="{{$shop->total}}"/>
                
                <div class="alert alert-danger alert-dismissible fade show message-min-price @if($shop->min_price <= $shop->total) hide @endif" role="alert">
                    <noindex>
                        Минимальная сумма заказа для магазина <strong>{{$shop->title}}</strong> составляет <strong class="min_price">{{$shop->min_price}}</strong> тг.
                        <br/>
                        У вас <strong class="total">{{$shop->total}}</strong> тг. Закажите ещё что-нибудь.
                    </noindex>
                </div>

                <div class="table-responsive">
                    <table class="table-cart table-striped w-100">
                        <thead>
                            <tr>
                                <td>Товар</td>
                                <td>Количество</td>
                                <td>Стоимость</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @if(empty($shop->products) == false)
                                @foreach($shop->products as $product)
                                    <tr>
                                        <td>
                                            <span class="img-product">
                                                @if(Helper::getImg($product->images, 'products', 'small'))
                                                    <img style="max-width: 150px;" src="{{Helper::getImg($product->images, 'products', 'small')}}" alt="" class="img-fluid"/>
                                                @else
                                                    <img style="max-width: 150px;" src="/img/no-image-1x1.jpg" alt="" class="img-fluid"/>
                                                @endif
                                            </span>
                                            <span class="title">
                                                <a href="{{Route('product', ['product_id' => $product->id])}}">{{$product->title}}</a>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="count">
                                                @if(Helper::isDiscount($product->start_discount, $product->end_discount, $product->discount)) 
                                                    <input type="number" min="1" step="1" size="4" maxlength="4" data-id="{{$product->id}}" data-price="{{$product->discount}}" class="count-in-cart form-control display-inline-block" value="{{$cookieCart[$product->id]->count}}"/>
                                                @else
                                                    @if($product->price)
                                                        <input type="number" min="1" step="1" size="4" maxlength="4" data-id="{{$product->id}}" data-price="{{$product->price}}" class="count-in-cart form-control display-inline-block" value="{{$cookieCart[$product->id]->count}}"/>
                                                    @endif
                                                @endif
                                                
                                            </span>
                                        </td>
                                        <td>
                                            <span class="price">
                                                @if(Helper::isDiscount($product->start_discount, $product->end_discount, $product->discount)) 
                                                    <div><span>{{number_format($cookieCart[$product->id]->count * $product->discount, 0, '', ' ')}}</span> тг.</div>
                                                @else
                                                    @if($product->price)
                                                        <div><span>{{number_format($cookieCart[$product->id]->count * $product->price, 0, '', ' ')}}</span> тг.</div>
                                                    @endif
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <span class="icon-close remove-cart" data-id="{{$product->id}}" data-shop_id="{{$product->shop_id}}" role="button" title="Удалить из корзины">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="form-group margin-top text-right">
                    <a href="{{Route('order', ['id' => $shop->shop_id])}}" class="btn @if($shop->min_price <= $shop->total) btn-primary @else btn-secondary disable-link @endif">Оформить заказ</a>
                </div>
            </div>
            @endforeach
            
        <div class="total">
            <b>Общая стоимость</b>
            <span class="price padding-left" id="total-price">{{number_format($totalCost, 0, '', ' ')}} тг.</span>
        </div>  
    @else
        <div class="no-products text-center @if(count($productsShops)) hide @endif">
            <noindex>
                <h4>В корзине нет товаров</h4>
                <p>Вернитесь на <a href="{{Route('home')}}">главную</a>, чтобы начать покупки</p>
                <a href="{{Route('home')}}" class="btn btn-primary">Главная</a>
            </noindex>
        </div>
    @endif
    </div>
    
</section>
@stop