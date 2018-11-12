<section class="box-control" id="shop-slider">
    <h2 class="m-lg-b">{{$shop->slider_title}}</h2>
    @if(count($shop->gallery))
        <div class="overflow-hidden box preview-container">
            <a href="{{$shop->site_link}}" target="_blank" class="btn btn-blue link-site">Перейти на сайт</a>
            
            <div class="swiper-container" id="slider">
                <div class="swiper-wrapper">
                    @foreach($shop->gallery as $key => $image)
                        @if(Helper::getImg($image, 'shops_gallery', 'large'))
                        <div class="swiper-slide" data-swiper-autoplay="3000">
                            <img src="{{Helper::getImg($image, 'shops_gallery', 'large')}}" alt=""/>
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
        </div>
    @endif
</section>