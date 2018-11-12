@extends('site/index')

@push('css')

@endpush 

@push('scripts')

<!-- products -->
<script src="/js/site/products.js"></script>

<!-- filter -->
<script src="/js/site/filter.js"></script>
@endpush

@section('title', 'Отзывы о товаре')

@section('content')
<nav class="box box-control">
    {!! Breadcrumbs::render('reviews.product', $product) !!}
</nav>

<section class="">
    <div class="row custom-row">
        <div class="col-sm-8 m-r-sm">
            <div class="box m-l p-l p-r">
                <h3>Отзывы о товаре</h3>
                @if(count($reviews) > 0)
                    @foreach($reviews as $i => $review)
                        <div class="review">
                            <div class="row">
                                <div class="col-xs-3">
                                    <select class="rating-readonly rating small" name="rating">
                                        <option @if($review->rating == 1) selected @endif value="1">1</option>
                                        <option @if($review->rating == 2) selected @endif value="2">2</option>
                                        <option @if($review->rating == 3) selected @endif value="3">3</option>
                                        <option @if($review->rating == 4) selected @endif value="4">4</option>
                                        <option @if($review->rating == 5) selected @endif value="5">5</option>
                                    </select>
                                </div>
                                <div class="col-xs-6">
                                    @if($review->user_name)
                                        <!-- если есть имя -->
                                        <b>{{$review->user_name}}</b>
                                    @else
                                        <!-- если нет имени -->
                                        <b>Пользователь № {{$review->user_id}}</b>
                                    @endif
                                </div>
                                <div class="col-xs-3">
                                    <div class="text-grey text-right">{{date('Y-m-d', time( $review->created_at))}}</div>
                                </div>
                            </div>
                            <hr>
                            <div>
                                <p>
                                    {{$review->text}}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else    
                    <p>Отзывы отсутствуют</p>
                @endif
            </div>
            
            @if($reviews->total() > $reviews->perPage())
                <nav class="m-lg-b m-sm-t text-center">
                    {{ $reviews->links() }}
                </nav>
            @endif
        </div>
        <div class="col-sm-4 m-l-sm">
            <div class="box m-r p-l p-r p-b">
                <div class="h3">
                    <a href="{{Route('product', ['product_id' => $product->id])}}">{{$product->title}}</a>
                </div>
                <div class="img">
                    @if(Helper::getImg($product->images, 'products', 'middle'))
                        <img class="img-responsive w-100" src="{{Helper::getImg($product->images, 'products', 'middle')}}" alt=""/>
                    @else
                        <img class="img-responsive w-100" src="/img/no-image-1x1.jpg" alt=""/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@stop