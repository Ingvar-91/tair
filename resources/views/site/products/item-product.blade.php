<article class="item-product">
    <div class="main">
        <figure class="img">
            @if(Helper::isDiscount($val->start_discount, $val->end_discount, $val->discount))
                @if($val->price && $val->discount)
                    <span class="ribbon sale">
                        <strong>-{{Helper::getDiscountPercent($val->price, $val->discount)}}%</strong>
                    </span>
                @endif
            @endif

            @if(Helper::isNew($val->created_at)) 
                <span class="ribbon new">
                    <strong>Новинка!</strong>
                </span>
            @endif

            <a href="{{Route('product', ['product_id' => $val->id])}}">
                @if(Helper::getImg($val->images, 'products', 'middle'))
                    <img class="img-responsive w-100" src="{{Helper::getImg($val->images, 'products', 'middle')}}" alt=""/>
                @else
                    <img class="img-responsive w-100" src="/img/no-image-1x1.jpg" alt=""/>
                @endif
            </a>
        </figure>
        <div class="text">
            <div class="price-block">
                @if(Helper::isDiscount($val->start_discount, $val->end_discount, $val->discount))
                    @if($val->discount)
                    <span class="text-bold price">{{number_format($val->discount, 0, '', ' ')}} ₸</span>
                    <strike class="text-bold price text-red float-right">{{number_format($val->price, 0, '', ' ')}} ₸</strike>
                    @endif
                @else
                    @if($val->price)
                    <span class="text-bold price">{{number_format($val->price, 0, '', ' ')}} ₸</span>
                    @endif
                @endif
            </div>
            <div class="title"> 
                <a href="{{Route('product', ['product_id' => $val->id])}}">
                    {{$val->title}}
                </a> 
            </div>
        </div>
    </div>
    <div class="extra">
        <div class="p-b">
            @if($val->shop_type_id == 2)
                <!--<button class="btn btn-orange btn-medium w-100 m-sm-b @if(Helper::isCart($val->id)) remove-cart @else add-cart @endif" type="button" data-shop_id="{{$val->shop_id}}" data-id="{{$val->id}}">
                    @if(Helper::isCart($val->id))
                    В корзине
                    @else
                    Купить
                    @endif
                </button>-->
            @endif
            
            <a href="{{Route('product', ['product_id' => $val->id])}}" class="btn btn-blue btn-medium w-100" type="button">Подробнее</a>
        </div>

        <div>
            <a href="http://{{$val->placeholder.'.'.config('app.domain')}}">{{$val->shop_title}}</a>
        </div>

        <div class="m-sm-b">
            <div class="row custom-row">
                <div class="col-xs-9">
                    <a class="custom-link open-popup-mfp" href="#all-phone-shop-{{$i}}" data-effect="mfp-zoom-in">Показать номер</a>
                </div>
                <div class="col-xs-3 text-right">
                    @if(Helper::isWishlist($val->id))
                    <a href="#" role="button" class="remove-wishlist" title="Убрать из списка избранное" style="font-size: 1.3rem;" data-id="{{$val->id}}">
                        <i class="fa fa-heart" aria-hidden="true"></i>
                    </a>
                    @else
                    <a href="#" role="button" class="add-wishlist" title="Добавить в избранное" style="font-size: 1.3rem;" data-id="{{$val->id}}">
                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                    </a>
                    @endif
                </div>
            </div>

            <div id="all-phone-shop-{{$i}}" class="white-popup popup-mfp mfp-with-anim mfp-middle mfp-hide">
                <h3 class="m-0"><i class="fa fa-phone fa-custom p-lg-r" aria-hidden="true"></i> Телефон продавца</h3>
                <hr>
                <a href="tel:{{$val->main_phone}}" class="h3" >{{Helper::phoneMobileFormat($val->main_phone)}}</a>
            </div>
        </div>

        <div class="">
            <div class="row">
                <div class="col-xs-6">
                    <select class="rating-readonly rating small" data-rating="{{$val->rating}}">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="col-xs-6 text-right">
                    <a href="{{Route('reviews.product', ['id' => $val->id])}}" class="link">{{Helper::wordForms($val->countReviews, ['отзыв', 'отзыва', 'отзывов'])}}</a>
                </div>
            </div>
        </div>
    </div>
</article>