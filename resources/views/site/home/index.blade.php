@extends('site/index')

@push('css')

@endpush 

@push('scripts')

@endpush

@section('content')
<div id="home">
    <section>
        @if(count($slider))
        <div class="swiper-container" id="slider">
            <div class="swiper-wrapper">
                @foreach($slider as $key => $image)
                @if(Helper::getImg($image, 'slider', 'large'))
                <div class="swiper-slide" data-swiper-autoplay="3000"> 
                    <img src="{{Helper::getImg($image, 'slider', 'large')}}" alt=""/> 
                </div>
                @endif
                @endforeach
            </div>

            <div class="swiper-pagination"></div>
            <div class="swiper-fa-button-next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </div>
            <div class="swiper-fa-button-prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </div>

        </div>
        @endif
    </section>

    @if($brands)
    <section>
        <h3>Бренды</h3>
        <div class="swiper-container swiper-section" id="swiper-brands">
            <div class="fa-button-prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </div>
            <div class="fa-button-next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </div>
            
            <div class="swiper-wrapper">

                @foreach($brands as $imageBrands)
                @if(Helper::getImg($imageBrands, 'logo_brands', 'large'))
                <div class="swiper-slide" data-swiper-autoplay="3000"> 
                    <figure class="img"> 
                        <img class="img-responsive w-100" src="{{Helper::getImg($imageBrands, 'logo_brands', 'large')}}" alt=""/> 
                    </figure>
                </div>
                @endif
                @endforeach

            </div>
            <div class="swiper-pagination"></div>

            <div class="swiper-fa-button-next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </div>
            <div class="swiper-fa-button-prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </div>
        </div>

    </section>
    @endif

    <section> 
        @if(count($productsDay))
        <h3>Новинки</h3>
        <div class="swiper-container swiper-section" id="swiper-product-day">
            <div class="fa-button-prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </div>
            <div class="fa-button-next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </div>

            <div class="swiper-wrapper">

                @foreach($productsDay as $productDay)

                <div class="swiper-slide swiper-slide-case">
                    <div class="overflow-hidden position-relative">
                        <figure class="img"> 
                            @if(Helper::isDiscount($productDay->start_discount, $productDay->end_discount, $productDay->discount))
                            @if($productDay->price && $productDay->discount)
                            <span class="ribbon sale">
                                <strong style="right: -100px;">-{{Helper::getDiscountPercent($productDay->price, $productDay->discount)}}%</strong>
                            </span>
                            @endif
                            @endif

                            @if(Helper::isNew($productDay->created_at)) 
                            <span class="ribbon new">
                                <strong style="left: -105px;">Новинка!</strong>
                            </span>
                            @endif

                            @if(Helper::getImg($productDay->images, 'products', 'middle'))
                            <img src="{{Helper::getImg($productDay->images, 'products', 'middle')}}" class="img-responsive w-100" alt=""/>
                            @else
                            <img class="img-responsive w-100" src="/img/no-image-1x1.jpg" alt=""/>
                            @endif
                        </figure>
                        <div class="p-l p-r m-t">
                            <div class="price-block"> 
                                @if(Helper::isDiscount($productDay->start_discount, $productDay->end_discount, $productDay->discount))
                                @if($productDay->discount)
                                <span class="text-bold price text-red h3">{{number_format($productDay->discount, 0, '', ' ')}} ₸</span>
                                <span class="text-bold price float-right text-dark text-strike h3 m-0">{{number_format($productDay->price, 0, '', ' ')}} ₸</span>
                                @endif
                                @else
                                @if($productDay->price)
                                <span class="text-bold price text-dark h3">{{number_format($productDay->price, 0, '', ' ')}} ₸</span>
                                @endif
                                @endif
                            </div>

                            <div class="title"> 
                                <a class="h3 link m-s-t m-s-b display-block m-sm-t" href="{{Route('product', ['id' => $productDay->id])}}">{{$productDay->title}}</a> 
                            </div>
                            <p class="text"> 
                                {{$productDay->text}}
                            </p>
                        </div>
                        <div class="form-group p-l p-r m-t">
                            <a class="btn btn-outline-blue btn-outline w-100" href="{{Route('product', ['id' => $productDay->id])}}">Подробнее <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>

                @endforeach

            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-fa-button-next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </div>
            <div class="swiper-fa-button-prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </div>
        </div>
        @endif
    </section>

    <section> 
        @if(count($shopsTop))
        <h3>Топ магазинов</h3>
        <div class="swiper-container swiper-section" id="swiper-top-shop">
            <div class="fa-button-prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </div>
            <div class="fa-button-next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </div>

            <div class="swiper-wrapper">

                @foreach($shopsTop as $shopTop)

                <div class="swiper-slide swiper-slide-case">
                    <figure class="img"> 
                        @if(Helper::getImg($shopTop->preview_frontpage, 'preview_frontpage'))
                        <img src="{{Helper::getImg($shopTop->preview_frontpage, 'preview_frontpage')}}" class="img-responsive" alt=""/>
                        @else
                        <img class="img-responsive w-100" src="/img/no-image-1x1.jpg" alt=""/>
                        @endif
                    </figure>
                    <div class="p-l p-r m-t">
                        <div class="title"> 
                            <a class="h3 link m-s-t m-s-b display-block" href="{{Route('shop', ['subdomain' => $shopTop->placeholder])}}">{{$shopTop->title}}</a> 
                        </div>
                        <p class="text"> 
                            {{$shopTop->short_description}}
                        </p>
                    </div>
                    <div class="form-group p-l p-r m-t">
                        <a class="btn btn-outline-blue btn-outline w-100" href="{{Route('shop', ['subdomain' => $shopTop->placeholder])}}">Подробнее <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                    </div>
                </div>

                @endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-fa-button-next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </div>
            <div class="swiper-fa-button-prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </div>
        </div>
        @endif
    </section>

    <section> 
        @if(count($entertainmentPlaces))
        <h3>Популярные места</h3>
        <div class="swiper-container swiper-section" id="swiper-ent-places">
            <div class="swiper-wrapper">

                @foreach($entertainmentPlaces as $entertainmentPlace)

                <div class="swiper-slide swiper-slide-case">
                    <figure class="img"> 
                        @if(Helper::getImg($entertainmentPlace->preview_frontpage, 'preview_frontpage'))
                        <img src="{{Helper::getImg($entertainmentPlace->preview_frontpage, 'preview_frontpage')}}" class="img-responsive" alt=""/>
                        @else
                        <img class="img-responsive w-100" src="/img/no-image-1x1.jpg" alt=""/>
                        @endif
                    </figure>
                    <div class="p-l p-r m-t">
                        <div class="title"> 
                            <a class="h3 link m-s-t m-s-b display-block" href="{{Route('shop', ['subdomain' => $entertainmentPlace->placeholder])}}">{{$entertainmentPlace->title}}</a> 
                        </div>
                        <p class="text"> 
                            {{$entertainmentPlace->short_description}}
                        </p>
                    </div>
                    <div class="form-group p-l p-r m-t">
                        <a class="btn btn-outline-blue btn-outline w-100" href="{{Route('shop', ['subdomain' => $entertainmentPlace->placeholder])}}">Подробнее <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                    </div>
                </div>

                @endforeach

            </div>
            <div class="swiper-pagination"></div>

            <div class="swiper-fa-button-next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </div>
            <div class="swiper-fa-button-prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </div>
            <div class="fa-button-prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </div>
            <div class="fa-button-next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </div>
        </div>
        @endif
    </section>

</div>
@stop