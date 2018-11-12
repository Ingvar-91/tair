@extends('site/index')

@push('css')
<!-- lightGallery -->
<link href="/vendors/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet"/> 
@endpush 

@push('scripts')

<!-- lightgallery -->
<script src="/vendors/lightgallery/dist/js/lightgallery-all.min.js"></script>
@endpush

@section('title', $product->title)

@section('content')

<nav class="box box-control">
    {!! Breadcrumbs::render('product', $product, $breadcrumb) !!}
</nav>

<section id="product">
    <div class="p-l p-r" id="product-info">
        <div class="product-info-left">
            <div class="box p-sm overflow-hidden">
                @if(Helper::isDiscount($product->start_discount, $product->end_discount, $product->discount))
                    @if($product->price && $product->discount)
                        <span class="ribbon sale">
                            <strong>-{{Helper::getDiscountPercent($product->price, $product->discount)}}%</strong>
                        </span>
                    @endif
                @endif

                @if(Helper::isNew($product->created_at)) 
                    <span class="ribbon new">
                        <strong>Новинка!</strong>
                    </span>
                @endif
                
                <div id="swiper-container">
                    <!-- Swiper -->
                    <div class="swiper-container gallery-top" id="gallery-top">
                        <div class="swiper-wrapper">
                            @if($product->images)
                                @foreach($product->images as $i => $imageSlide)
                                    <div class="swiper-slide">
                                        <span class="show-gallery-img" data-num="{{$i}}">
                                            <i class="fa fa-search-plus" aria-hidden="true"></i>
                                        </span>
                                        @if(Helper::getImg($imageSlide, 'products', 'middle'))
                                            <img class="img-responsive w-100" data-image-name="{{$imageSlide}}" data-large-img="{{Helper::getImg($imageSlide, 'products', 'large')}}" src="{{Helper::getImg($imageSlide, 'products', 'middle')}}" alt="" data-num="{{$i}}"/>
                                        @else
                                            <img class="img-responsive w-100" data-large-img="/img/no-image-1x1.jpg" src="/img/no-image-1x1.jpg" alt="" data-num="0"/>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="swiper-slide">
                                    <img class="img-responsive w-100" data-large-img="/img/no-image-1x1.jpg" src="/img/no-image-1x1.jpg" alt="" data-num="0"/>
                                </div>
                            @endif
                            
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-fa-button-next">
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </div>
                        <div class="swiper-fa-button-prev">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="swiper-container gallery-thumbs" id="gallery-thumbs">
                        <div class="swiper-wrapper">
                            @if($product->images)
                                @foreach($product->images as $i => $imageSlide)
                                    <div class="swiper-slide">
                                        @if(Helper::getImg($imageSlide, 'products', 'small'))
                                            <img class="img-responsive w-100" src="{{Helper::getImg($imageSlide, 'products', 'small')}}" alt=""/>
                                        @else
                                            <img class="img-responsive w-100" src="/img/no-image-1x1.jpg" alt=""/>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="swiper-slide">
                                    <img class="img-responsive w-100" src="/img/no-image-1x1.jpg" alt=""/>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-info-right m-t-sm">
            <div class="box p-sm-l p-sm-r">
                <div class="row custom-row">
                    <div class="col-md-8 p-sm-t border-right">
                        <div class="row custom-row">
                            <div class="col-md-10">
                                <h3 class="m-t-0 m-b-0 title">
                                    {{$product->title}}
                                </h3>
                            </div>
                            <div class="col-md-2 text-right">
                                @if(Helper::isWishlist($product->id))
                                    <a href="#" role="button" class="remove-wishlist icon-wishlist" title="Убрать из списка избранное" data-id="{{$product->id}}">
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                    </a>
                                @else
                                    <a href="#" role="button" class="add-wishlist icon-wishlist" title="Добавить в избранное" data-id="{{$product->id}}">
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <span class="text-grey m-r">
                            код: {{str_pad($product->id, 6, '0', STR_PAD_LEFT)}}
                        </span>
                        
                        <span class="text-yellow">
                            <i class="fa fa-users" aria-hidden="true" style="padding-right: 5px;"></i> <b>просмотров: {{$product->views}}</b>
                        </span>

                        <hr class="m-sm-b m-sm-t"/>

                        <div id="product-control" class="product-add-container">
                            @if(!$product->price)
                            <div class="h3 text-center m-t-0">
                               Цену данного товара уточняйте у <br/> <a class="custom-link open-popup-mfp" href="#all-phone-shop" data-effect="mfp-zoom-in">продавца</a>
                            </div>
                            @elseif($product->date_remove > date('Y-m-d H:i:s'))
                                <div class="row custom-row">
                                    <div class="col-md-3 col-xs-5">
                                        <div class="count">
                                            <div class="input-group">
                                                <div>
                                                    <input type="text" name="quant[1]" class="form-control count input-number" value="1" min="1" max="999999"/>
                                                    <span class="text-grey count-label">шт.</span>
                                                </div>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default btn-number btn-1" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                        <span class="glyphicon glyphicon-minus"></span>
                                                    </button>
                                                </span>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default btn-number btn-2" data-type="plus" data-field="quant[1]">
                                                        <span class="glyphicon glyphicon-plus"></span>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-xs-7">
                                        @if(Helper::isDiscount($product->start_discount, $product->end_discount, $product->discount))
                                            @if($product->discount)
                                                <div class="h1 text-bold text-center m-0">{{number_format($product->discount, 0, '', ' ')}} ₸</div>
                                                <div class="h4 text-bold text-center text-strike m-0">{{number_format($product->price, 0, '', ' ')}} ₸</div>
                                            @endif
                                        @else
                                            @if($product->price)
                                                <div class="h1 text-bold m-sm-t text-center">{{number_format($product->price, 0, '', ' ')}} ₸</div>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <button class="btn btn-orange btn-lg w-100 buy p-0 m-t-md @if(Helper::isCart($product->id)) open-cart @else add-cart @endif" type="button" data-id="{{$product->id}}" data-shop_id="{{$product->shop_id}}">
                                            @if(Helper::isCart($product->id))
                                                В корзине
                                            @else
                                                Купить
                                            @endif
                                        </button>
                                    </div>
                                </div>
                            @elseif(!$product->date_remove > date('Y-m-d H:i:s'))
                                <h3 class="m-t m-b text-center text-red">Данный товар больше не продается</h3>
                            @endif
                        </div>
                        
                        @if(count($charsOrder))
                            <hr class="m-sm-t m-sm-b"/>
                        
                            <div id="chars-order">
                                <div class="row custom-row m-sm-b">
                                    @foreach($charsOrder as $charOrder)
                                        <div class="col-md-{{12/count($charsOrder)}}">
                                            <label>{{$charOrder->title}}</label>
                                            <select class="form-control">
                                                @if($charOrder->values)
                                                    @foreach($charOrder->values as $charValues)
                                                        <option value="{{$charValues->id}}">{{$charValues->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(isset($tradeOffersProduct))
                            <hr class="m-sm-t m-sm-b"/>
                            
                            <div id="productTradeOffers">
                                <div class="items">
                                    @foreach($tradeOffersProduct as $i => $tradeOfferProduct)
                                        <div class="item-group row custom-row" data-id="{{$tradeOfferProduct->parent->id}}">
                                            <label class="col-md-2 h4 m-0 label-title" style="padding-top: 6px;">{{$tradeOfferProduct->parent->title}}</label>
                                            @if(isset($tradeOfferProduct->child))
                                                <div class="col-md-9 items-radio-container" data-toggle="tooltip-product" data-placement="top" title="Выберите {{$tradeOfferProduct->parent->title}}">
                                                    @foreach($tradeOfferProduct->child as $value)
                                                        <div class="item-radio">
                                                            <label class="item-label">
                                                                <input type="radio" class="" name="product_trade_offers[{{$i}}]" value="{{$value->id}}" data-trade_offers_id="{{$value->trade_offers_id}}" data-image="{{$value->image}}" data-collect_id="{{json_encode($value->trade_offers_collect_id)}}" autocomplete="off"/>
                                                                @if($value->hash)
                                                                    <div class="hash" style="background: {{$value->hash}}"></div>
                                                                @else
                                                                    <div class="title">{{$value->title}}</div>
                                                                @endif
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        <hr class="m-sm-t m-sm-b"/>
                        
                        <div class="row custom-row">
                            <div class="col-xs-6">
                                <div>
                                    <div class="h4 m-t-0" style="margin-bottom: 6px;">
                                        Мин. сумма заказа
                                    </div>
                                    <div class="h4 m-t-0" style="margin-bottom: 6px;">
                                        {{number_format($product->min_price, 0, '', ' ')}} ₸
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div>
                                    <div class="h4 m-t-0" style="margin-bottom: 6px;">
                                        Стоимость доставки
                                    </div>
                                    <div class="h4 m-t-0" style="margin-bottom: 6px;">
                                        от {{number_format($product->cost_delivery, 0, '', ' ')}} ₸
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row custom-row m-t-sm">
                            <div class="col-xs-6">
                                <div>
                                    <div>
                                        <span>Поделиться</span>
                                    </div>
                                    <ul class="social list-unstyled">
                                        <li>
                                            <a class="nav-link bg-facebook" href="https://www.facebook.com/groups/1486136335012115/" target="_blank" title="Поделиться в Facebook" onclick="window.open('http://www.facebook.com/sharer.php?m2w&s=100&p[url]={{Route('product', ['id' => $product->id])}}& p[title]={{urlencode($product->title)}}& p[summary]={{urlencode($product->title)}}', '_blank', 'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0'); return false"> <i class="fa fa-facebook fa-lg"></i> </a>
                                        </li>
                                        <li>
                                            <a class="nav-link bg-instagram" href="https://www.instagram.com/tair.karaganda/" target="_blank" title="Поделиться в Google+" onclick="window.open('https://plus.google.com/share?url={{Route('product', ['id' => $product->id])}}', '_blank', 'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0');return false"> <i class="fa fa-google-plus fa-lg"></i> </a>
                                        </li>
                                        <li>
                                            <a class="nav-link bg-odnoklassniki" href="http://ok.ru/tairkaraganda" target="_blank" title="Добавить в Одноклассники" onclick="window.open('http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl={{Route('product', ['id' => $product->id])}}& title={{urlencode($product->title)}}& st.comments={{urlencode($product->title)}}', '_blank', 'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0'); return false"> <i class="fa fa-odnoklassniki fa-lg"></i> </a>
                                        </li>
                                        <li>
                                            <a class="nav-link bg-vk" href="https://vk.com/tair3dkz" target="_blank" title="Поделиться В Контакте" onclick="window.open('http://vk.com/share.php?url={{Route('product', ['id' => $product->id])}}& title={{urlencode($product->title)}}& description={{urlencode($product->title)}}', '_blank', 'scrollbars=0, resizable=1, menubar=0, left=100, top=100, width=550, height=440, toolbar=0, status=0'); return false"> <i class="fa fa-vk fa-lg"></i> </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="text-blue" id="phone-info">
                                    <i class="fa fa-phone fa-custom" aria-hidden="true"></i> 
                                    <a class="custom-link open-popup-mfp" href="#all-phone-shop" data-effect="mfp-zoom-in">Показать номер</a>
                                    <div id="all-phone-shop" class="white-popup popup-mfp mfp-with-anim mfp-middle mfp-hide">
                                        <h3 class="m-0"><i class="fa fa-phone fa-custom p-lg-r" aria-hidden="true"></i> Телефон продавца</h3>
                                        <hr>
                                        <a href="tel:{{$product->main_phone}}" class="h3" >{{Helper::phoneMobileFormat($product->main_phone)}}</a>
                                    </div>
                                </div>
                                <div class="text-blue m-sm-t" id="whats-app-info">
                                    <i class="fa fa-whatsapp fa-custom" aria-hidden="true"></i>
                                    <a href="{{$product->link_whatsapp}}" class="custom-link">WhatsApp</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 p-sm-t">
                        <div class="p-sm-l">
                            <div class="logo">
                                @if(Helper::getImg($product->shop_logo, 'logo'))
                                    <img src="{{Helper::getImg($product->shop_logo, 'logo')}}" alt=""/>
                                @endif
                            </div>

                            <div class="m-sm-t">
                                <a href="{{Route('shop', ['subdomain' => $product->placeholder])}}" class="text-bold">{{$product->shop_title}}</a>
                            </div>

                            <div class="m-sm-t">
                                <i class="fa fa-clock-o fa-custom text-blue" aria-hidden="true"></i> 
                                <a class="custom-link open-popup-mfp" href="#schedule-shop" data-effect="mfp-zoom-in">График работы</a>

                                <div id="schedule-shop" class="white-popup popup-mfp mfp-with-anim mfp-middle mfp-hide">
                                    <h3 class="m-0"><i class="fa fa-clock-o fa-custom p-lg-r" aria-hidden="true"></i> График работы</h3>
                                    <hr>
                                    <div>
                                        {!!$product->schedule!!}
                                    </div>
                                </div>
                            </div>

                            <div class="m-t">
                                <a href="{{Route('shop', ['subdomain' => $product->placeholder])}}">Все предложения продавца</a>
                            </div>

                            <div class="m-t">
                                <a href="{{Route('reviews.shop', ['id' => $product->shop_id])}}">{{$percentRating}}% положительных из {{Helper::wordForms($countReviewsShop, ['отзыв', 'отзыва', 'отзывов'])}}</a>
                            </div>

                            <div class="m-t" style="height: 60px;">
                                <select class="rating-readonly rating large" data-rating="{{$ratingShop}}">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-top @if(!count($charsOrder)) height @endif" id="delivery-info-container">
                    <div class="row custom-row p-sm-t p-sm-b" id="delivery-info">
                        <div class="col-sm-4 col-xs-12">
                            <div class="product-payment">
                                <div class="icons">
                                    <i class="fa fa-usd" aria-hidden="true"></i>
                                </div>
                                <div class="text">
                                    <div class="text-bold">Способы оплаты</div>
                                    @if($payment_methods)
                                        @foreach($payment_methods as $payment_method)
                                            @if(is_numeric($product->payment_methods->search($payment_method->id)))
                                                <span>{{$payment_method->title}}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="product-delivery">
                                <div class="icons">
                                    <i class="fa fa-truck" aria-hidden="true"></i>
                                </div>
                                <div class="text">
                                    <div class="text-bold">Способы доставки</div>
                                    @if($delivery_methods)
                                        @foreach($delivery_methods as $delivery_method)
                                            @if(is_numeric($product->delivery_methods->search($delivery_method->id)))
                                                <span>{{$delivery_method->title}}</span>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12 text-center">
                            <div class="m-t-sm">
                                <i class="fa fa-check-square-o fa-custom text-blue" aria-hidden="true"></i>
                                <a href="#rules-shop" class="custom-link open-popup-mfp" data-effect="mfp-zoom-in">Условия возврата</a>

                                <div id="rules-shop" class="white-popup popup-mfp mfp-with-anim mfp-large mfp-hide">
                                    <h3 class="m-0"><i class="fa fa-check-square-o fa-custom p-lg-r" aria-hidden="true"></i> Условия возврата</h3>
                                    <hr>
                                    <div>
                                        <div class="h4">
                                            Компания осуществляет возврат согласно Закону <a target="_blank" href="http://adilet.zan.kz/rus/docs/Z100000274_" style="text-decoration: underline;">«О защите прав потребителей»</a>.
                                        </div>
                                        <div>
                                            <span>Срок возврата:</span>
                                            <span class="h4">14 дней</span>
                                        </div>
                                        <div class="margin-small-top">
                                            <span>Стоимость возврата:</span>
                                            <span class="h4">по договоренности</span>
                                        </div>
                                        <hr>
                                        <div>
                                            <b>Условия возврата и обмена</b>
                                            <p>
                                                Согласно ст.14 действующего Закона Республики Казахстан «О защите прав потребителей» потребитель вправе в течение четырнадцати дней с момента передачи ему непродовольственного товара, если более длительный срок не объявлен продавцом (изготовителем), обменять купленный товар на аналогичный товар другого размера, формы, габарита, фасона, расцветки, комплектации, произведя, в случае разницы в цене, необходимый перерасчет с продавцом (изготовителем).
                                            </p>
                                            <p>
                                                При отсутствии необходимого для обмена товара у продавца (изготовителя) покупатель вправе возвратить приобретенный товар продавцу (изготовителю) и получить уплаченную за него денежную сумму.
                                            </p>
                                            <b>Исключения</b>
                                            <p>
                                                Согласно ст. 30 Закона, продавец имеет право отказать потребителю в обмене и возврате:
                                                лекарственных средств, изделий медицинского назначения;
                                                нательного белья;
                                                чулочно-носочных изделий;
                                                животных и растений;
                                                метражных товаров, а именно тканей из волокон всех видов, трикотажного и гардинного полотна, меха искусственного, ковровых изделий, нетканых материалов, лент, кружева, тесьмы, проводов, шнуров, кабелей, линолеума, багета, пленки, клеенки.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-sm-t">
                                <i class="fa fa-map-marker fa-custom text-blue" aria-hidden="true"></i>
                                <a href="#regions-shop" class="custom-link open-popup-mfp" data-effect="mfp-zoom-in">Регионы доставки</a>
                                <div id="regions-shop" class="white-popup popup-mfp mfp-with-anim mfp-middle mfp-hide">
                                    <h3 class="m-0"><i class="fa fa-map-marker fa-custom" aria-hidden="true"></i> Регионы доставки</h3>
                                    <hr>

                                    @if(empty($cities) == false)
                                        @foreach($cities as $city)
                                            @if(empty($city->child) == false)
                                                <div class="m-sm-t">
                                                    <div>
                                                        <span class="text-bold">{{$city->title}}:</span> 
                                                    </div>
                                                    <div>
                                                        @foreach($city->child as $district)
                                                            @if(!$loop->last)
                                                                <span>{{$district->districts_title}}</span>,
                                                            @else
                                                                <span>{{$district->districts_title}}</span>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <div id="product-details" class="m-t">
        <div class="">
            <div id="anchor"></div>
            <div class="box box-control p-l p-r p-lg-b" style="margin-top: 0;">
                @if(count($chars))
                    <section>
                        <h3>Характеристики</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    @foreach($chars as $char)
                                        <tr>
                                            <td>{{$char->title}}</td>
                                            <td>{{implode(', ', $char->values->pluck('title')->toArray())}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>
                @endif
                
                <section class="desc">
                    <h3>Описание</h3>
                    @if($product->text)
                        {!! $product->text !!}
                    @else
                        <p class="m-b-0">Описание отсутствует</p>
                    @endif
                </section>
                
            </div>

            <div class="box-control">
                <div id="tabs-reviews" class="m-b">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#reviews-product-one" aria-controls="reviews-product" role="tab" data-toggle="tab">
                                <div class="icon">
                                    <i class="fa fa-inbox" aria-hidden="true"></i>
                                </div>
                                <div class="text">
                                    Отзывы о товаре
                                </div>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#reviews-product-two" aria-controls="reviews-product-two" role="tab" data-toggle="tab">
                                <div class="icon">
                                    <i class="fa fa-building-o" aria-hidden="true"></i>
                                </div>
                                <div class="text">
                                    <span>Отзывы о компании</span>
                                </div>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane p active" id="reviews-product-one">
                            <div class="m-lg-b">
                                @if(Auth::check())
                                    <a href="#review-product-mfp" class="open-popup-mfp btn btn-blue btn-medium" type="button" data-effect="mfp-zoom-in">Добавить отзыв о товаре</a>
                                @else
                                    <span>Чтобы оставить отзыв, необходимо авторизоваться</span>
                                @endif
                                <div id="review-product-mfp" class="white-popup popup-mfp mfp-with-anim mfp-large mfp-hide" style="max-width: 745px;">
                                    <form id="review-product-form" method="post" action="{{Route('review.product.add')}}">
                                        {{ csrf_field() }}
                                        {{ method_field('POST') }}
                                        <input name="product_id" id="product_id" type="hidden" value="{{$product->id}}"/>
                                        
                                        <h3 class="m-0">Оставьте отзыв о товаре</h3>
                                        <hr>
                                        <div> 
                                            <div class="row">
                                                <div class="col-md-7 col-xs-12">
                                                    <div class="form-group">
                                                        <label>Дайте общую оценку товара</label>
                                                        <select class="rating-write rating large" name="rating">
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5" selected>5</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group" style="margin-top: 30px;">
                                                        <label>Отзыв</label>
                                                        <textarea style="height: 157px;" name="text" class="form-control input-white" placeholder="Расскажите, чем именно вам понравился или не понравился этот товар: 
                                                                  - как долго вы пользуетесь товаром; 
                                                                  - довольны ли качеством товара; 
                                                                  - посоветовали бы вы купить его другим."></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-blue btn-medium submit">Добавить отзыв</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-xs-12">
                                                    <div>
                                                        @if($product->images and Helper::getImg(implode('|', $product->images), 'products', 'middle'))
                                                            <img class="w-100" src="{{Helper::getImg(implode('|', $product->images), 'products', 'middle')}}" alt=""/>
                                                        @else
                                                            <img class="img-responsive w-100" src="/img/no-image-1x1.jpg" alt=""/>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div id="reviews-product">
                                @if(count($reviewsProduct) > 0)
                                    @foreach($reviewsProduct as $i => $reviewProduct)
                                        <div class="review">
                                            <div class="row">
                                                <div class="col-xs-12 col-md-3">
                                                    <select class="rating-readonly rating small" name="rating">
                                                        <option @if($reviewProduct->rating == 1) selected @endif value="1">1</option>
                                                        <option @if($reviewProduct->rating == 2) selected @endif value="2">2</option>
                                                        <option @if($reviewProduct->rating == 3) selected @endif value="3">3</option>
                                                        <option @if($reviewProduct->rating == 4) selected @endif value="4">4</option>
                                                        <option @if($reviewProduct->rating == 5) selected @endif value="5">5</option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-6 col-md-3">
                                                    @if($reviewProduct->user_name)
                                                        <!-- если есть имя -->
                                                        <b>{{$reviewProduct->user_name}}</b>
                                                    @else
                                                        <!-- если нет имени -->
                                                        <b>Пользователь № {{$reviewProduct->user_id}}</b>
                                                    @endif
                                                </div>
                                                <div class="col-xs-6 col-md-3 col-md-offset-3">
                                                    <div class="text-grey text-right">{{date('Y-m-d', time( $reviewProduct->created_at))}}</div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div>
                                                <p>
                                                    {{$reviewProduct->text}}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else    
                                    <p>Отзывы отсутствуют</p>
                                @endif

                                <div>
                                    <a href="{{Route('reviews.product', ['id' => $product->id])}}" class="link">Все отзывы товара</a>
                                </div>
                            </div>

                        </div>
                        <div role="tabpanel" class="tab-pane p" id="reviews-product-two">
                            <div class="row">
                                <div class="col-md-8 col-xs-6">
                                    @if(Auth::check())
                                        <a href="#review-shop-mfp" class="btn btn-blue btn-medium open-popup-mfp" type="button" data-effect="mfp-zoom-in">Добавить отзыв</a>
                                    @else
                                        <span>Чтобы оставить отзыв, необходимо авторизоваться</span>
                                    @endif
                                </div>
                                <div class="col-md-4 col-xs-6 text-right">
                                    <a href="{{Route('shop', ['id' => $product->shop_id])}}" class="link" style="font-size: 1.5rem;">{{$product->shop_title}}</a>
                                </div>
                            </div>

                            <div class="m-lg-b">
                                <div id="review-shop-mfp" class="white-popup popup-mfp mfp-with-anim mfp-middle mfp-hide">
                                    <form id="review-shop-form" method="post" action="{{Route('review.shop.add')}}">
                                        {{ csrf_field() }}
                                        {{ method_field('POST') }}
                                        <input name="shop_id" type="hidden" value="{{$product->shop_id}}"/>
                                        
                                        <h3 class="m-0">Оставьте отзыв о магазине</h3>
                                        <hr>
                                        <div>
                                            <div class="form-group">
                                                <label>Дайте общую оценку магазина</label>
                                                <select class="rating-write rating large" name="rating">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5" selected>5</option>
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin-top: 30px;">
                                                <label>Отзыв</label>
                                                <textarea style="height: 157px;" name="text" class="form-control input-white" placeholder="Расскажите, почему вам понравилось или не понравилось заказывать у этой компании: 
                                                          - качественно ли вас обслужили; 
                                                          - посоветовали бы вы эту компанию другим."></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-blue btn-medium">Добавить отзыв</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div id="reviews-shop"> 
                                @if(count($reviewsShop) > 0)
                                    @foreach($reviewsShop as $i => $reviewShop)
                                        <div class="review">
                                            <div class="row">
                                                <div class="col-xs-12 col-md-3">
                                                    <select class="rating-readonly rating small" name="rating">
                                                        <option @if($reviewShop->rating == 1) selected @endif value="1">1</option>
                                                        <option @if($reviewShop->rating == 2) selected @endif value="2">2</option>
                                                        <option @if($reviewShop->rating == 3) selected @endif value="3">3</option>
                                                        <option @if($reviewShop->rating == 4) selected @endif value="4">4</option>
                                                        <option @if($reviewShop->rating == 5) selected @endif value="5">5</option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-6 col-md-3">
                                                    @if($reviewShop->user_name)
                                                        <!-- если есть имя -->
                                                        <b>{{$reviewShop->user_name}}</b>
                                                    @else
                                                        <!-- если нет имени -->
                                                        <b>Пользователь № {{$reviewShop->user_id}}</b>
                                                    @endif
                                                </div>
                                                <div class="col-xs-6 col-md-3 col-md-offset-3">
                                                    <div class="text-grey text-right">{{date('Y-m-d', time( $reviewShop->created_at))}}</div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div>
                                                <p>
                                                    {{$reviewShop->text}}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else    
                                    <p>Отзывы отсутствуют</p>
                                @endif

                                <div>
                                    <a href="{{Route('reviews.shop', ['id' => $product->shop_id])}}" class="link">Все отзывы магазина</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div id="sticky-product-wrap">
                <div id="sticky-product" class="box box-control hide">
                    <div class="row custom-row">
                        <div class="col-md-6">
                            <div class="img">
                                @if($product->images and Helper::getImg(implode('|', $product->images), 'products', 'middle'))
                                    <img class="w-100" src="{{Helper::getImg(implode('|', $product->images), 'products', 'middle')}}" alt=""/>
                                @else
                                    <img class="img-responsive w-100" src="/img/no-image-1x1.jpg" alt=""/>
                                @endif
                            </div>
                            <div class="m-sm-t">
                                <a href="{{Route('shop', ['subdomain' => $product->placeholder])}}" class="text-bold">
                                    {{$product->shop_title}}
                                </a>
                            </div>
                            <div class="m-sm-t">
                                <i class="fa fa-heart-o fa-custom" aria-hidden="true"></i> 
                                <a href="#">Добавить в избранное</a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div>
                                <p class="text-bold h4 m-t-0">
                                    {{$product->title}}
                                </p>
                            </div>
                            @if(Helper::isDiscount($product->start_discount, $product->end_discount, $product->discount))
                                @if($product->discount)
                                    <h3 class="text-bold m-b-0">{{number_format($product->discount, 0, '', ' ')}} ₸</h3>
                                    <h4 class="text-bold text-strike m-t-0 m-lg-b">{{number_format($product->price, 0, '', ' ')}} ₸</h4>
                                @endif
                            @else
                                @if($product->price)
                                    <h4 class="text-bold h3 m-lg-b">{{number_format($product->price, 0, '', ' ')}} ₸</h4>
                                @endif
                            @endif
                            <div class="form-group">
                                @if(!$product->price)
                                    <div class="h4 m-t-0">
                                       Цену данного товара уточняйте у <a class="custom-link open-popup-mfp" href="#all-phone-shop" data-effect="mfp-zoom-in">продавца</a>
                                    </div>
                                @elseif($product->date_remove > date('Y-m-d H:i:s'))
                                    <button class="btn btn-orange btn-lg w-100 buy @if(Helper::isCart($product->id)) open-cart @else add-cart @endif" type="button" data-id="{{$product->id}}" data-shop_id="{{$product->shop_id}}">
                                        @if(Helper::isCart($product->id))
                                            В корзине
                                        @else
                                            Купить
                                        @endif
                                    </button>
                                @elseif(!$product->date_remove > date('Y-m-d H:i:s'))
                                    <h4 class="m-t m-b text-center text-red">Данный товар больше не продается</h4>
                                @endif
                                
                            </div>
                            <div>
                                <i class="fa fa-phone fa-custom text-blue" aria-hidden="true"></i> 
                                <a class="custom-link open-popup-mfp" href="#all-phone-shop" data-effect="mfp-zoom-in">Показать номер</a>
                            </div>
                            <div class="m-sm-t">
                                <i class="fa fa-whatsapp fa-custom text-blue" aria-hidden="true"></i>
                                <a href="{{$product->link_whatsapp}}" class="custom-link">WhatsApp</a>
                            </div>
                            <div class="m-sm-t">
                                <i class="fa fa-clock-o fa-custom text-blue" aria-hidden="true"></i> 
                                <a class="custom-link open-popup-mfp" href="#schedule-shop" data-effect="mfp-zoom-in">График работы</a>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row custom-row">
                        <div class="col-md-4">
                            <select class="rating-readonly rating" data-rating="{{$ratingShop}}">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <div>
                                <a href="{{Route('reviews.shop', ['id' => $product->shop_id])}}">{{$percentRating}}% положительных из {{Helper::wordForms($countReviewsShop, ['отзыв', 'отзыва', 'отзывов'])}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    @if(count($similarProducts) > 0)
        <section class="m-lg-t m-sm-b" style="height: 571px;">
            <div id="other-options" class="box-control">
                <h3 style="padding-left: 100px;" class="m-lg-b">Похожие товары из других магазинов</h3>
                <div class="owl-carousel owl-theme owl-loaded" >

                    @foreach($similarProducts as $i => $similarProduct)
                        @include('site/products/item-product', ['val' => $similarProduct])
                    @endforeach

                </div>
            </div>
        </section>
    @endif
@stop