@extends('site/index')

@section('title', 'Мои отзывы о товаре')

@section('content')
<nav class="box box-control m-b-0">
    {!! Breadcrumbs::render('reviews-product') !!}
</nav>

<section id="reviews-product" class="m">
    <div class="row custom-row">
        <div class="col-sm-8">
            <div>
                <div class="box p">
                    <h3 class="m-t-0">Мои отзывы о товарах</h3>
                    @if(count($reviews) > 0)
                        @foreach($reviews as $i => $review)
                            <div class="review">
                                <div class="row">
                                    <div class="col-xs-12 col-md-3">
                                        <select class="rating-readonly rating small" name="rating">
                                            <option @if($review->rating == 1) selected @endif value="1">1</option>
                                            <option @if($review->rating == 2) selected @endif value="2">2</option>
                                            <option @if($review->rating == 3) selected @endif value="3">3</option>
                                            <option @if($review->rating == 4) selected @endif value="4">4</option>
                                            <option @if($review->rating == 5) selected @endif value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        @if($review->user_name)
                                            <!-- если есть имя -->
                                            <b>{{$review->user_name}}</b>
                                        @else
                                            <!-- если нет имени -->
                                            <b>Пользователь № {{$review->user_id}}</b>
                                        @endif
                                    </div>
                                    <div class="col-xs-6 col-md-3 col-md-offset-3">
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
        </div>
        <div class="col-sm-4 m-t-sm">
            
            @include('site.profile-menu')
            
        </div>
    </div>
</section>
@stop