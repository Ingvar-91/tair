@extends('site/index')

@push('css')
<!-- lightGallery -->
<link href="/vendors/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet"/> 
@endpush 

@push('scripts')
<!-- photogallery -->
<script src="/js/site/photogallery.js"></script>

<!-- lightgallery -->
<script src="/vendors/lightgallery/dist/js/lightgallery-all.min.js"></script>
@endpush

@section('title', 'Фотогалерея | '.$album_title)

@section('content')
<section class="box box-control">
    {!! Breadcrumbs::render('photoAlbum', ['title' => $album_title, 'album_id' => $album_id]) !!}
</section>

<section class="box-control" id="photo-album">
    @if(empty($photo) == false)
    <div class="row custom-row">
        @foreach($photo as $i => $val)
        <div class="col-sm-2 col-xs-4">
            <figure class="box">
                <img src="{{$val['photo_130']}}" class="image show-gallery-img" alt="" data-large-img="@if(isset($val['photo_1280'])) {{$val['photo_1280']}} @elseif(isset($val['photo_807'])) {{$val['photo_807']}} @elseif(isset($val['photo_604'])) {{$val['photo_604']}} @endif" data-num="{{$i}}"/>
            </figure>
        </div>
        @endforeach
    </div>
    @endif
</section>

@stop