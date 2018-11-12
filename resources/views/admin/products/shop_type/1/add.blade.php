@extends('admin/index') 

@push('css')
<!-- daterangepicker -->
<link href="/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
@endpush 

@push('scripts')
<!-- ckeditor -->
<script src="/vendors/ckeditor/ckeditor.js"></script>

<!-- moment -->
<script src="/vendors/moment/moment.js"></script>
<!-- daterangepicker -->
<script src="/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- products -->
<script src="/js/admin/products.js"></script>
<!-- categories -->
<script src="/js/admin/categories.js"></script>
<!-- charactiristics -->
<script src="/js/admin/charactiristics.js"></script>
@endpush 

@section('content')

<div class="clearfix"></div>
{!! Breadcrumbs::render('admin.products.add.form') !!}

<section>
    <form autocomplete="off" method="post" enctype="multipart/form-data" action="{{Route('admin.products.add')}}">
        {{ csrf_field() }}
        {{ method_field('POST') }}

        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="x_panel">
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
                                <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Доп. Данные</a>
                                </li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                    <div class="form-group">
                                        <label class="control-label" for="title">Заголовок</label>
                                        <input required="required" name="title" class="form-control" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="text">Текст</label>
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
                                    @include('admin/characteristics-name')
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
                                    
                                    <!--<div class="form-group">
                                        <label for="images">Выбрать изображения</label>
                                        <input type="file" name="images[]" id="images" multiple accept="image/png, image/jpeg, image/gif">
                                    </div>-->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                
                @include('admin/products/publish', ['actionName' => 'Добавить'])
                
                @include('admin/products/price')

            </div>
        </div>

    </form>
</section>

@include('admin/categories-action')

<script id="product-images-ejs" type="text/template">
<div class="col-sm-12 col-md-4">
    <div class="thumbnail">
      <div class="image view view-first">
        <img style="width: 100%; display: block;" src="<%= src %>" alt="image">
        <div class="mask">
          <p><%= title %></p>
        </div>
      </div>
    </div>
</div>
</script>

@stop