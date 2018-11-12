@extends('site/index')

@push('css')
<!-- lightGallery -->
<link href="/vendors/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet"/> 
@endpush

@push('scripts')
<!-- lightgallery -->
<script src="/vendors/lightgallery/dist/js/lightgallery-all.min.js"></script>

<!-- shop-gallery -->
<script src="/js/site/shop-gallery.js"></script>
@endpush

@section('title', $shop->title)

@section('content')
<nav class="box box-control m-b-0">
    {!! Breadcrumbs::render('shop', $shop) !!}
</nav>

<section id="pano" class="border-bottom box box-control">
    <div class="preview-container">
        <div>
            @if(Helper::getImg($shop->images, 'shops', 'large'))
            <img src="{{Helper::getImg($shop->images, 'shops', 'large')}}" class="img-responsive" alt=""/>
            @endif
        </div>

        <div class="btn-pano-container">
            <div class="btn-pano-group">

                @if($shop->pano)
                <button type="button" class="btn btn-blue show-pano" title="Показать панораму">
                    <i class="fa fa-camera" aria-hidden="true"></i>
                </button>
                @endif

                @if($shop->site_link)
                <a href="{{$shop->site_link}}" target="_blank" class="btn btn-blue link-site" title="Перейти на сайт">
                    <i class="fa fa-globe" aria-hidden="true"></i>
                </a>
                @endif

                @if($shop->instagram)
                <a href="{{$shop->instagram}}" target="_blank" class="btn btn-blue link-instagram" title="Перейти на Instagramm">
                    <i class="fa fa-instagram" aria-hidden="true"></i>
                </a>
                @endif

            </div>
        </div>

    </div>

    <div class="w-100 pano-container hide">
        <iframe src="#" data-pano="{{$shop->pano}}" class="w-100" scrolling="no" frameborder="0" marginwidth="0" marginheight="0"></iframe>
    </div>
</section>

<section id="nav-shop" class="box m">
    <nav>
        <ul class="list-unstyled">
            <li class="border-right">
                <a href="#about-mfp" class="open-popup-mfp" data-effect="mfp-zoom-in"><i class="fa fa-info-circle" aria-hidden="true"></i> О нас</a>
                <div id="about-mfp" class="white-popup popup-mfp mfp-with-anim mfp-large mfp-hide">
                    <h3 class="m-0">{{$shop->title}}</h3>
                    <hr>
                    <div>
                        {!!$shop->about!!}
                    </div>
                </div>
            </li>
            <li class="border-right">   
                <a href="#vacancy-mfp" class="open-popup-mfp" data-effect="mfp-zoom-in"><i class="fa fa-id-card-o" aria-hidden="true"></i> Вакансии</a>
                <div id="vacancy-mfp" class="white-popup popup-mfp mfp-with-anim mfp-large mfp-hide">
                    <h3 class="m-0">Вакансии</h3>
                    <hr>
                    <div>
                        {!!$shop->vacancy!!}
                    </div>
                </div>
            </li>
            <li>
                <a href="#contacts-mfp" class="open-popup-mfp" data-effect="mfp-zoom-in"><i class="fa fa-phone-square" aria-hidden="true"></i> Контакты</a>
                <div id="contacts-mfp" class="white-popup popup-mfp mfp-with-anim mfp-large mfp-hide">
                    <h3 class="m-0">Контакты</h3>
                    <hr>
                    <div>
                        {!!$shop->contacts!!}
                    </div>
                </div>
            </li>
        </ul>
    </nav>
</section>

@if($shop->shop_type_id == 1)
@include('site/shops/type-products')
@elseif($shop->shop_type_id == 4)
@include('site/shops/type-gallery')
@elseif($shop->shop_type_id == 5)
@include('site/shops/type-slider')
@endif    

@stop