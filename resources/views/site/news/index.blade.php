@extends('site/index')

@push('css')

@endpush 

@push('scripts')

@endpush

@section('content')

<nav class="box box-control">
    {!! Breadcrumbs::render('news') !!}
</nav>

<section id="news" class="margin-large-bottom">
    <h4 class="title-section">Новости и статьи</h4>
    <div class="row">
        
        @if(empty($posts) == false)
            @foreach($posts as $val)
                <div class="col-sm-12 col-md-6">
                    <article class="bg-white margin-large-bottom">
                        <figure>
                            <div class="preview-news">
                                <a href="{{Route('news.post', ['id' => $val->id])}}">
                                    @if($val->preview)
                                        <img src="/{{config('filesystems.news').$val->preview}}" alt="" class="img-responsive"/>
                                    @else
                                        <img src="/img/no-image-16x9.jpg" alt="" class="img-responsive"/>
                                    @endif
                                </a>
                            </div>
                            <div class="padding">
                                <figcaption>
                                    <div class="margin-small-bottom">
                                        <a href="{{Route('news.post', ['id' => $val->id])}}" class="title h3">
                                            {{$val->title}}
                                        </a>
                                    </div>
                                    <div class="margin-small-bottom">
                                        <span class="date">
                                            <i class="fa fa-clock-o"></i> {{Date::parse($val->created_at)->format('l, j F Y - H:i')}}
                                        </span>
                                        <span class="count-views float-right">
                                            <i class="fa fa-eye"></i>Просмотров <b> {{$val->count_view}}</b>					
                                        </span>
                                    </div>
                                    <div class="desc">
                                        {!!str_limit(strip_tags($val->text), 365)!!}
                                    </div>
                                </figcaption>
                                <div>
                                    <a href="{{Route('news.post', ['id' => $val->id])}}">Читать далее</a>
                                </div>
                            </div>
                        </figure>
                    </article>
                </div>
            @endforeach
        @endif
            
    </div>
    
    @if(empty($posts) == false)
        <div class="bg-white padding text-center">
            {{ $posts->links() }}
        </div>
    @endif
</section>

@stop