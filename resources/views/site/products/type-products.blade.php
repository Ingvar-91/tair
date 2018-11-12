@extends('site/index')

@push('css')

@endpush 

@push('scripts')

@endpush

@section('title', $currentCategory->title)

@section('content')
<nav class="box box-control m-b-0">
    {!! Breadcrumbs::render('products', $breadcrumb) !!}
</nav>

<input type="hidden" name="category_id" id="category_id" value="{{request()->category_id}}"/>

<div id="products-wrap">
    <div class="m-l m-r">
        <div class="block-left">
            <aside id="filter">
                <div class="container-filter">
                <h2 class="m-lg-b title">Фильтр</h2>   
                    <form action="" class="box p m-b">
                        @if(request()->price)
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
                        @endif

                        @if(empty($chars) == false)
                            @foreach($chars as $charName)
                                <div class="filter-block">
                                    <a role="button" data-toggle="collapse" href="#char-{{$charName->id}}">
                                        {{$charName->title}}
                                    </a>
                                    @if(isset($charName->child))
                                    <div class="collapse in" id="char-{{$charName->id}}">
                                        @foreach($charName->child as $charNameChild)
                                            <div class="checkbox" data-char-id="{{$charNameChild->id}}">
                                                <label>
                                                    <input type="checkbox" @if(!$charNameChild->productsCount) disabled @endif @if($charNameChild->check) checked @endif value="{{$charNameChild->id}}"> {{$charNameChild->title}} <span class="count-products"> @if(empty(!$charNameChild->productsCount)) ({{$charNameChild->productsCount}}) @else &#40;0&#41; @endif</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                        <div class="form-group text-center">
                            <a href="{{Route('products', ['category_id' => request()->category_id, 'sort' => request()->sort])}}" class="btn btn-info btn-sm display-block">Сбросить</a>
                        </div>
                    </form>

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
                                    <a href="{{Route('products', ['id' => request()->category_id, 'sort' => 'rating', 'filterChar' => request()->filterChar, 'price' => request()->price])}}">По популярности</a>
                                    <a href="{{Route('products', ['id' => request()->category_id, 'sort' => 'price', 'filterChar' => request()->filterChar, 'price' => request()->price])}}">По возрастанию цены</a>
                                    <a href="{{Route('products', ['id' => request()->category_id, 'sort' => '-price', 'filterChar' => request()->filterChar, 'price' => request()->price])}}">По убыванию цены</a>
                                    <a href="{{Route('products', ['id' => request()->category_id, 'sort' => 'new', 'filterChar' => request()->filterChar, 'price' => request()->price])}}">По новинкам</a>
                                    <a href="{{Route('products', ['id' => request()->category_id, 'sort' => 'discount', 'filterChar' => request()->filterChar, 'price' => request()->price])}}">По скидкам</a>
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
                            {{ $products->appends(['filterChar' => request()->filterChar, 'price' => request()->price, 'sort' => request()->sort])->links() }}
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

@stop