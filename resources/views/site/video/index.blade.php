@extends('site/index')

@push('css')
@endpush 

@push('scripts')
<!-- videogallery -->
<script src="/js/site/videogallery.js"></script>

<!-- ejs -->
<script src="/vendors/ejs/ejs.min.js"></script>
@endpush

@section('title', 'Видеогалерея')

@section('content')
<nav class="box box-control">
    {!! Breadcrumbs::render('video') !!}
</nav>

<section class="box-control" id="video">
    @if(empty($listChannelVideos['results']) == false)
    <div class="row custom-row">
        @foreach($listChannelVideos['results'] as $i => $video)
        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="#show-video-{{$video->id->videoId}}" class="open-popup-mfp" data-effect="mfp-zoom-in">
                <figure class="box">
                    <img src="{{$video->snippet->thumbnails->medium->url}}" alt="">
                </figure>
            </a>
           
            <div id="show-video-{{$video->id->videoId}}" class="white-popup youtube-popup-mfp popup-mfp mfp-with-anim mfp-large mfp-hide">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$video->id->videoId}}" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    
    <div class="text-center m-lg-t">
        <button id="more-video-youtube" class="btn btn-blue btn-lg" data-next_page_token="{{$listChannelVideos['info']['nextPageToken']}}">Ещё</button>
    </div>
</section>

<script id="youtube-list" type="text/template">
    <% $.each(listVideo, function(i, video){%>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <a href="#show-video-<%= video.id.videoId %>" class="open-popup-mfp" data-effect="mfp-zoom-in">
                <figure class="box">
                    <img src="<%= video.snippet.thumbnails.medium.url %>" alt="">
                </figure>
            </a>
           
            <div id="show-video-<%=video.id.videoId%>" class="white-popup youtube-popup-mfp popup-mfp mfp-with-anim mfp-large mfp-hide">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/<%= video.id.videoId %>" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
            </div>
        </div>
    <% }); %>
</script>

@stop