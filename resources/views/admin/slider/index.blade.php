@extends('admin/index')

@push('css')
<!-- dropzone -->
<link href="/vendors/dropzone/min/dropzone.min.css" rel="stylesheet">
@endpush 

@push('scripts')
<!-- sortable.min.js -->
<script src="/vendors/sortable/sortable.min.js"></script>

<!-- dropzone -->
<script src="/vendors/dropzone/min/dropzone.min.js"></script>

<!-- slider -->
<script src="/js/admin/slider.js"></script>
@endpush 

@section('content')
<div class="clearfix"></div>

<section id="slider">

    <div class="row">
        <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Слайдер</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <div id="images" class="dropzone dropzone-product" data-id="{{$slider->id}}" data-images="{{$slider->images}}" data-path="/{{config('filesystems.slider.path').'small/'}}">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12">

            <div class="x_panel">
                <div class="x_title">
                    <h2>Действие</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-success btn-control" id="update-slider">Обновить</button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
</section>

@stop