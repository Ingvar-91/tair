<div id="products-wrap" class="m-t">
    <div class="m-l m-r">
        <div class="block-left">
            <aside id="filter">
                <div class="container-filter">
                    <h2 class="m-lg-b title">Категории</h2>
                    <div class="box p">
                        @if(request()->price)
                        <form action="" autocomplete="off">
                            <div class="filter-block"> 
                                <a role="button" class="margin-small-bottom display-block" data-toggle="collapse" href="#price-filter">
                                    Цена
                                </a>
                                <div class="collapse in" id="price-filter">
                                    <div class="text-center">
                                        <div class="price form-group">
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control price-min" name="price-min" value="@if(request()->price){{explode(',', request()->price)[0]}}@else{{$priceMin}}@endif" min="{{$priceMin}}"/>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control price-max" name="price-max" value="@if(request()->price){{explode(',', request()->price)[1]}}@else{{$priceMax}}@endif" max="{{$priceMax}}"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="">
                                                <input id="slider-price" type="text" class="hide" data-slider-min="{{$priceMin}}" data-slider-max="{{$priceMax}}" data-slider-step="5" data-slider-value="@if(request()->price){{'['.request()->price.']'}}@else{{'['.$priceMin.','.$priceMax.']'}}@endif"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @endif

                        <form action="" method="POST">    
                            @if(empty($categoriesShop) == false)
                            <div class="categories">
                                <ul class="nav-items">
                                    @foreach($categoriesShop as $categoryVal)
                                    <li> 
                                        @if(isset($categoryVal->child)) 
                                        <a href="#" class="toggle-cat">{{$categoryVal->title}} <small>({{$categoryVal->count}})</small> <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                        @include('/site/shops/categories', ['child' => $categoryVal->child])
                                        @else
                                        <a href="{{Route('shop', ['subdomain' => $shop->placeholder, 'category_id' => $categoryVal->id])}}">{{$categoryVal->title}} @if(isset($categoryVal->count)) <small>({{$categoryVal->count}})</small> @endif</a>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </form>

                        <div class="form-group text-center m-t">
                            <a href="{{Route('shop', ['subdomain' => $shop->placeholder, 'id' => request()->id, 'sort' => request()->sort])}}" class="btn btn-info btn-sm display-block">Сбросить</a>
                        </div>
                    </div>

                    <div id="filter-sticker" class="hide">
                        <span class="label loader-text hide">
                            <i class="fa fa-spinner fa-pulse fa-fw"></i> Загрузка...</span> 
                        <span class="label count-text">
                            <span class="count-products-flter-sticker">0 товаров</span>
                        </span> 
                        <a href="#" class="btn btn-orange btn-xs">Показать</a> 
                    </div>

                </div>
                <div class="switch-filter-button" id="switch-filter-button"> <i class="fa fa-filter fa-2x"></i> </div>
            </aside>
        </div>
        <div class="block-right">
            <section id="products">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h2 class="m-lg-b products-count-title">Товары <small>{{Helper::wordForms($countProducts, ['товар', 'товара', 'товаров'])}}</small></h2>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="sort-title">
                            <span class="h3">Сортировать по:</span>
                            <span class="dropdown">
                                <span role="button" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span id="sort-name" class="border-bottom">
                                        @if(request()->sort == 'rating')
                                        По популярности
                                        @elseif(request()->sort == 'price')
                                        По возрастанию цены
                                        @elseif(request()->sort == '-price')
                                        По убыванию цены
                                        @elseif(request()->sort == 'new')
                                        По новинкам
                                        @elseif(request()->sort == 'discount')
                                        По скидкам
                                        @else
                                        По новинкам
                                        @endif
                                    </span>
                                    <span class="caret"></span>
                                </span>
                                <ul class="dropdown-menu" id="sort-by">
                                    <li>
                                        <a href="{{Route('shop', ['subdomain' => $shop->placeholder, 'sort' => 'rating', 'filterChar' => request()->filterChar, 'price' => request()->price])}}">По популярности</a>
                                        <a href="{{Route('shop', ['subdomain' => $shop->placeholder, 'sort' => 'price', 'filterChar' => request()->filterChar, 'price' => request()->price])}}">По возрастанию цены</a>
                                        <a href="{{Route('shop', ['subdomain' => $shop->placeholder, 'sort' => '-price', 'filterChar' => request()->filterChar, 'price' => request()->price])}}">По убыванию цены</a>
                                        <a href="{{Route('shop', ['subdomain' => $shop->placeholder, 'sort' => 'new', 'filterChar' => request()->filterChar, 'price' => request()->price])}}">По новинкам</a>
                                        <a href="{{Route('shop', ['subdomain' => $shop->placeholder, 'sort' => 'discount', 'filterChar' => request()->filterChar, 'price' => request()->price])}}">По скидкам</a>
                                    </li>
                                </ul>
                            </span>
                        </div>
                    </div>
                </div>

                @if(count($products) > 0)
                <div class="row product-list">
                    @foreach($products as $i => $val)
                    <div class="col-sm-6 col-md-4 col-xs-6">

                        @include('site/products/item-product')

                    </div>
                    @endforeach
                </div>
                @if($products->total() > $products->perPage())
                <nav class="m-lg-b m-sm-t text-center">
                    {{ $products->appends(['filterChar' => request()->filterChar, 'category_id' => request()->category_id, 'price' => request()->price, 'sort' => request()->sort])->links() }}
                </nav>
                @endif

                @else
                <div class="box">
                    <p class="p m-sm-t">Товары не найдены</p>
                </div>
                @endif

            </section>
        </div>
    </div>
</div>