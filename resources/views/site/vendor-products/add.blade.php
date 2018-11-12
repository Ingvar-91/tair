@extends('site/index')

@push('css')
<!-- daterangepicker -->
<link href="/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

<!-- typeahead 
<link href="/vendors/sliptree-bootstrap-tokenfield-9c06df4/dist/css/tokenfield-typeahead.min.css" rel="stylesheet">

<!-- bootstrap-tokenfield 
<link href="/vendors/sliptree-bootstrap-tokenfield-9c06df4/dist/css/bootstrap-tokenfield.min.css" rel="stylesheet">

<!-- dropzone -->
<link href="/vendors/dropzone/min/dropzone.min.css" rel="stylesheet">

<!-- sweetalert -->
<link rel="stylesheet" href="/vendors/sweetalert/dist/sweetalert.css">

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
<script src="/vendors/sliptree-bootstrap-tokenfield-9c06df4/dist/bootstrap-tokenfield.js"></script>

<!-- typeahead.js 
<script src="/vendors/sliptree-bootstrap-tokenfield-9c06df4/docs-assets/js/typeahead.bundle.min.js"></script>

<!-- sortable.min.js -->
<script src="/vendors/sortable/sortable.min.js"></script>

<!-- dropzone -->
<script src="/vendors/dropzone/min/dropzone.min.js"></script>

<!-- sweetalert -->
<script src="/vendors/sweetalert/dist/sweetalert.min.js"></script>

<!-- bootstrap-select-1.12.4 -->
<script src="/vendors/bootstrap-select-1.12.4/dist/js/bootstrap-select.min.js"></script>

<!-- bootstrap-select-1.12.4 rus -->
<script src="/vendors/bootstrap-select-1.12.4/dist/js/i18n/defaults-ru_RU.min.js"></script>

<!-- products -->
<script src="/js/site/vendor-products.js?v={{time()}}"></script>

<!-- categories -->
<script src="/js/site/categories.js?v={{time()}}"></script>

<!-- chars -->
<script src="/js/site/chars.js?v={{time()}}"></script>

<!-- vendor -->
<script src="/js/site/vendor.js"></script>
@endpush

@section('title', 'Добавить товар')

@section('content')
<section class="box box-control m-b-0">
    {!! Breadcrumbs::render('vendor.products.add.form') !!}
</section>

<section id="products-vendor-add" class="m">
    <form id="product-form" autocomplete="off" method="post" enctype="multipart/form-data" action="{{Route('vendor.products.add', ['shop_id' => $shop->id])}}">
        <div class="row custom-row">
            <div class="col-sm-8">
                <div class="box p">

                    <div>
                        @include('alerts')
                    </div>

                    <section>
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <input name="shop_id" type="hidden" value="{{request()->shop_id}}"/>

                        @include('alerts')

                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">1. Товар <i class="fa fa-arrow-down p-sm-l" aria-hidden="true"></i></a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">2. Категории <i class="fa fa-arrow-down p-sm-l" aria-hidden="true"></i></a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">3. Характеристики <i class="fa fa-arrow-down p-sm-l" aria-hidden="true"></i></a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">4. Изображения <i class="fa fa-arrow-down p-sm-l" aria-hidden="true"></i></a>
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
                                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                    @include('site/vendor-products/categories')
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                    @include('site/vendor-products/chars')
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                                    <div id="product-images" class="dropzone dropzone-product" data-images="" data-path="/{{config('filesystems.products.path').'small/'}}">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="col-sm-4 m-t-sm">

                <div class="box p-l p-r">
                    
                    @include('site/vendor-products/date-remove')
                    
                    <hr/>

                    @include('site/vendor-products/price')
                    
                    <hr/>
                    
                    @include('site/vendor-products/publish', ['actionName' => 'Добавить', 'idName' => 'add-submit'])
                    
                </div>

                <div class="m-t">
                    @include('site.profile-menu')
                </div>

            </div>
        </div>
    </form>
</section>

@stop