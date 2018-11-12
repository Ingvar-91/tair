@extends('admin/index') 

@push('css')
<!-- daterangepicker -->
<link href="/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

<!-- typeahead 
<link href="/vendors/sliptree-bootstrap-tokenfield-9c06df4/dist/css/tokenfield-typeahead.min.css" rel="stylesheet">-->

<!-- bootstrap-tokenfield 
<link href="/vendors/sliptree-bootstrap-tokenfield-9c06df4/dist/css/bootstrap-tokenfield.min.css" rel="stylesheet">-->

<!-- dropzone -->
<link href="/vendors/dropzone/min/dropzone.min.css" rel="stylesheet">

<!-- bootstrap-select-1.12.4 -->
<link rel="stylesheet" href="/vendors/bootstrap-select-1.12.4/dist/css/bootstrap-select.min.css">
@endpush 

@push('scripts')
<!-- ckeditor -->
<script src="/vendors/ckeditor/ckeditor.js"></script>

<!-- moment -->
<script src="/vendors/moment/moment.js"></script>
<!-- daterangepicker -->
<script src="/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- bootstrap-tokenfield 
<script src="/vendors/sliptree-bootstrap-tokenfield-9c06df4/dist/bootstrap-tokenfield.js"></script>-->

<!-- typeahead.js 
<script src="/vendors/sliptree-bootstrap-tokenfield-9c06df4/docs-assets/js/typeahead.bundle.min.js"></script>-->

<!-- sortable.min.js -->
<script src="/vendors/sortable/sortable.min.js"></script>

<!-- dropzone -->
<script src="/vendors/dropzone/min/dropzone.min.js"></script>

<!-- bootstrap-select-1.12.4 -->
<script src="/vendors/bootstrap-select-1.12.4/dist/js/bootstrap-select.min.js"></script>

<!-- bootstrap-select-1.12.4 rus -->
<script src="/vendors/bootstrap-select-1.12.4/dist/js/i18n/defaults-ru_RU.min.js"></script>

<!-- products -->
<script src="/js/admin/products.js"></script>

<!-- categories -->
<script src="/js/admin/categories.js"></script>

<!-- chars -->
<script src="/js/admin/chars.js"></script>
@endpush 

@section('content')

<div class="clearfix"></div>

<section>
    <form id="product-form" autocomplete="off" method="post" enctype="multipart/form-data" action="{{Route('admin.products.add')}}">
        {{ csrf_field() }}
        {{ method_field('POST') }}
        <input name="shop_type_id" id="shop_type_id" type="hidden" value="{{request()->shop_type}}"/>

        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Добавить товар </h2>
                        <button type="button" id="insert-last-record" data-id="1" style="float: right;">Вставить последний товар</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        @include('alerts')

                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Товар</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Магазины</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Категории</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Характеристики</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Изображения</a>
                                </li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                    <div class="form-group">
                                        <label class="control-label" for="title">Заголовок</label>
                                        <input required="required" name="title" class="form-control" type="text"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="text">Описание товара</label>
                                        <textarea class="form-control" rows="6" name="text" id="text"></textarea>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">
                                    @include('admin/products/shops')
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                    @include('admin/categories')
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                    @include('admin/products/chars')
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                                    <div id="product-images" class="dropzone dropzone-product" data-images="" data-path="/{{config('filesystems.products.path').'small/'}}">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">

                @include('admin/products/publish', ['actionName' => 'Добавить товар', 'idName' => 'add-submit'])
                
                @include('admin/products/date-remove')

                @include('admin/products/price')

            </div>
        </div>

    </form>
</section>

@include('admin/categories-action')

@stop