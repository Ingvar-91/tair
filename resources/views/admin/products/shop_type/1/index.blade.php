@extends('admin/index')

@push('css')
<!-- DataTables -->
<link href="/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<!-- DataTables END -->

<!-- lightGallery -->
<link href="/vendors/lightgallery/dist/css/lightgallery.min.css" rel="stylesheet"/> 
@endpush 

@push('scripts')
<!-- DataTables -->
<script src="/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="/js/admin/data-tables.js"></script>
<!-- DataTables END -->

<!-- dropzone -->
<script src="/vendors/dropzone/min/dropzone.min.js"></script>

<!-- lightgallery -->
<script src="/vendors/lightgallery/dist/js/lightgallery-all.min.js"></script>

<!-- products -->
<script src="/js/admin/products.js"></script>
@endpush 

@section('content')

<div class="clearfix"></div>
{!! Breadcrumbs::render('admin.products.form') !!}

<section id="products">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Товары</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <a href="{{Route('admin.products.add.form', ['shop_type' => request()->shop_type])}}" class="btn btn-info">Добавить</a>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Магазин</label>
                            <select id="shop_id" name="shop_id" class="form-control">
                                <option value="0">(Не выбрано)</option>
                                @foreach($shops as $shop)
                                    <option value="{{$shop->id}}">{{$shop->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Категория</label>
                            <select id="category_id" name="category_id" class="form-control">
                                <option value="0">(Не выбрано)</option>
                                @include('admin/products/categories', ['categories' => $categories, 'split' => '']) 
                            </select>
                        </div>
                    </div>
                </div>

                <div class="x_content">
                    <table class="data-table table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>E-mail</th>
                                <th>Изображение</th>
                                <th>Наименование</th>
                                <th>Магазин</th>
                                <th>Цена</th>
                                <th>Статус</th>
                                <th class="action">Действие</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="detail-product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success publish-product hide" data-id="" data-status="2">Опубликовать</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<script id="product-detail-ejs" type="text/template">
    
    <div class="form-group">
        <label>Изображения</label>
        <div>
            <% $.each(product.images.split('|'), function(i, image){%>
                <div style="display: inline-block;">
                    <img src="<%= path %>small/<%= image %>" style="max-width: 130px;"/>
                </div>
            <% }); %>
        </div>
    </div>
    
    <div class="form-group">
        <label>Заголовок</label>
        <div>
            <%= product.title %>
        </div>
    </div>
    <div class="form-group">
        <label>Текст</label>
        <div>
            <%= product.text %>
        </div>
    </div>
    <div class="row">  
        <div class="col-md-6">
            <div class="form-group">
                <label>Цена</label>
                <div>
                    <%= product.price %>
                </div>
            </div>
        </div>
        
        <% if(product.discount){ %>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Скидка</label>
                    <div>
                        <%= product.discount %>
                    </div>
                </div>
            </div>
        <% } %>
    </div>
</script>

<script>
    var columnsName = [
        {data: 'id', visible: false},
        {data: 'email'},
        {data: 'image', searchable: false, orderable: false},
        {data: 'title'},
        {data: 'shops_title'},
        {data: 'price'},
        {data: 'status'},
        {data: 'actions', searchable: false, orderable: false}
    ];
    
    var dataTableAdditionalData = [
        {name: 'shop_type', value: {{request()->shop_type}}},
        {name: 'shop_id', value: document.getElementById('shop_id').options[document.getElementById('shop_id').selectedIndex].value},
        {name: 'category_id', value: document.getElementById('shop_id').options[document.getElementById('shop_id').selectedIndex].value}
        
    ];
</script>

@stop