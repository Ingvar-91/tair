@extends('site/index')

@push('css')

@endpush 

@push('scripts')

@endpush

@section('title', 'Результаты поиска')

@section('content')
<nav class="box box-control m-b-0">
    {!! Breadcrumbs::render('search') !!}
</nav>

<section id="search" class="box box-control p">
    <div class="row m-lg-t">
        <div class="col-md-8 col-md-offset-2">
            <form action="{{Route('search')}}" method="GET">
                <div class="input-group">
                    <input class="form-control" type="search" name="search" placeholder="Найти..." value="{{trim(request()->search)}}"/>
                    <span class="input-group-btn">
                        <button class="btn btn-blue btn-search" type="submit">Поиск</button>
                    </span>
                </div>
                <!--<div class="row text-center m-t">
                    <div class="col-md-6">
                        <div class="radio">
                            <label>
                                <input type="radio" name="searchType" @if(request()->searchType == 'google') checked @endif value="google"/> Google поиск
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="radio">
                            <label>
                                <input type="radio" name="searchType" @if(request()->searchType == 'inner' or (!request()->searchType)) checked @endif value="inner"/> Внутренний поиск
                            </label>
                        </div>
                    </div>
                </div>-->
            </form>
        </div>
    </div>
    
    @if(isset($resultsGoogle))
        <hr>
        @foreach($resultsGoogle as $result)
            <article class="media">
                @if(isset($result->pagemap->cse_thumbnail[0]->src))
                    <div class="media-left">
                        <a href="{{$result->link}}">
                            <img class="media-object" src="{{$result->pagemap->cse_thumbnail[0]->src}}" alt="{{$result->title}}">
                        </a>
                    </div>
                @endif
                <div class="media-body">
                  <h3 class="media-heading">
                      <a href="{{$result->link}}" class="link">{{$result->title}}</a>
                  </h3>
                  <div class="link-page">{{$result->link}}</div>
                  <div class="text">
                      {{$result->snippet}}
                  </div>
                </div>
            </article>
        @if(!$loop->last)
            <hr>
        @endif
        @endforeach
    @endif
    
    @if(isset($resultsInner))
    <hr>
        @foreach($resultsInner as $resultInner)
            <article class="media">
                <div class="media-left">
                    <a href="{{Route('product', ['product_id' => $resultInner->id])}}">
                        @if(Helper::getImg($resultInner->images, 'products', 'middle'))
                            <img class="media-object" src="{{Helper::getImg($resultInner->images, 'products', 'middle')}}" alt="{{$resultInner->title}}">
                        @else
                            <img class="media-object" src="/img/no-image-1x1.jpg" alt="{{$resultInner->title}}"/>
                        @endif  
                    </a>
                </div>
                <div class="media-body">
                    <h3 class="media-heading">
                        <a href="{{Route('product', ['product_id' => $resultInner->id])}}" class="link">{{$resultInner->title}}</a>
                    </h3>
                    <div class="link-page">{{Route('product', ['product_id' => $resultInner->id])}}</div>
                    <div class="text">
                        {{$resultInner->text}}
                    </div>
                </div>
            </article>
        @if(!$loop->last)
            <hr>
        @endif
        @endforeach
    @endif
</section>

@if(isset($resultsInner))
    @if($resultsInner->total() > $resultsInner->perPage())
        <nav class="m-lg-b m-sm-t text-center">
            {{ $resultsInner->appends(['search' => request()->search, 'searchType' => request()->searchType])->links() }}
        </nav>
    @endif
@endif

@stop