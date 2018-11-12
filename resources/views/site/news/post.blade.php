@extends('site/index')

@push('css')
@endpush 

@push('scripts')
@endpush

@section('content')

{!! Breadcrumbs::render('news.post', $post) !!}

<section id="post" class="margin-large-bottom">
    <h4 class="title-section">{{$post->title}}</h4>
    <article class="bg-white">
        <div class="padding">
            <div class="desc margin-bottom">
                {!!$post->text!!}
            </div>
            <div>
                <span class="date">
                    <i class="fa fa-clock-o"></i>{{Date::parse($post->created_at)->format('l, j F Y - H:i')}}
                </span>
                <span class="count-views float-right">
                    <i class="fa fa-eye"></i>Просмотров <b>{{$post->count_view}}</b>					
                </span>
            </div>
        </div>
    </article>
</section>

@stop