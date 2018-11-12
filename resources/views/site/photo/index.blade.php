@extends('site/index')

@push('css')

@endpush 

@push('scripts')
<!-- ejs -->
<script src="/vendors/ejs/ejs.min.js"></script>

<!-- photogallery -->
<script src="/js/site/photogallery.js"></script>
@endpush

@section('title', 'Фотогалерея')

@section('content')
<nav class="box box-control">
    {!! Breadcrumbs::render('photo') !!}
</nav>

<section class="box-control" id="photo">
    @if(empty($albums) == false)
    <div class="row custom-row">
        @foreach($albums as $i => $album)
        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="{{Route('get.photo', ['id' => $album['id']])}}">
                <figure class="box">
                    <img src="{{$album['thumb']['photo_604']}}" alt="{{$album['thumb']['text']}}">
                    <div class="overlay">
                        <figcaption class="text p">{{$album['title']}}</figcaption>
                    </div>
                </figure>
            </a>
        </div>
        @endforeach
    </div>
    @endif
    
    <div class="text-center m-lg-t">
        <button id="more-albums" class="btn btn-blue btn-lg">Ещё</button>
    </div>
</section>

<script id="albums-list" type="text/template">
    <% $.each(albums, function(i, album){%>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="/photo/getPhotosAlbum/<%=album.id%>">
                <figure class="box">
                    <img src="<%=album.thumb.photo_604%>" alt="<%=album.thumb.text%>">
                    <div class="overlay">
                        <figcaption class="text p"><%=album.title%></figcaption>
                    </div>
                </figure>
            </a>
        </div>
    <% }); %>
</script>

@stop