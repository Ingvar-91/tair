@extends('admin/index') 

@push('css')
<!-- dropzone -->
<link href="/vendors/dropzone/min/dropzone.min.css" rel="stylesheet">
@endpush 

@push('scripts')
<!-- ckeditor -->
<script src="/vendors/ckeditor/ckeditor.js"></script>

<!-- sortable.min.js -->
<script src="/vendors/sortable/sortable.min.js"></script>

<!-- dropzone -->
<script src="/vendors/dropzone/min/dropzone.min.js"></script>

<!-- slider -->
<script src="/js/admin/slider.js"></script>
@endpush 

@section('content')
<div class="clearfix"></div>

<section>
    <form autocomplete="off" method="POST" action="{{Route('admin.shops.add')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('POST') }}

        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Добавить магазин</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
        
                    @include('alerts')

                    <div class="clearfix"></div>
                    
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab_content1" role="tab" data-toggle="tab" aria-expanded="true">Магазин</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content2" role="tab" data-toggle="tab" aria-expanded="false">Изображения</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content3" role="tab" data-toggle="tab" aria-expanded="false">Слайдер</a>
                                </li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="title">Заголовок</label>
                                                <input required="required" name="title" class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="title">Тип магазина</label>
                                                <select class="form-control" name="shop_type_id" required>
                                                    <option></option>
                                                    @foreach($shop_type as $val)
                                                        @if($val->status == 1)
                                                            <option value="{{$val->id}}">{{$val->title}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="min_price">Мин. сумма заказа</label>
                                                <input required="required" name="min_price" class="form-control" min="0" type="number" value=""/>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="cost_delivery">Стоимость доставки</label>
                                                <input required="required" name="cost_delivery" class="form-control" min="0" type="number" value=""/>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="link_whatsapp">Ссылка на WhatsApp</label>
                                                <input name="link_whatsapp" class="form-control" required="" type="text"/>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="placeholder">Наименование поддомена <small>(только латинские буквы в нижнем регистре)</small></label>
                                                <input name="placeholder" class="form-control" type="text" required=""  pattern="[a-z_]+$"/>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="main_phone">Основной номер телефона</label>
                                                <input required="required" name="main_phone" class="form-control" required="" type="text"/>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="pano">Панорама</label>
                                                <input name="pano" class="form-control" type="text"/>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="site_link">Ссылка на сайт</label>
                                                <input name="site_link" class="form-control" type="text"/>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="instagram">Ссылка на instagram</label>
                                                <input name="instagram" class="form-control" type="text"/>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label" for="map_2gis_url">Ссылка 2gis</label>
                                        <input name="map_2gis_url" class="form-control" type="text" required=""/>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label">Краткое описание</label>
                                        <textarea class="form-control" name="short_description" required=""></textarea>
                                    </div>
                                    
                                    <hr/>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if($payment_methods)
                                                <div class="form-group">
                                                    <label class="control-label">Способы оплаты</label>
                                                    @foreach($payment_methods as $payment_method)
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="payment_methods[]" value="{{$payment_method->id}}"/> {{$payment_method->title}}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            @if($payment_methods)
                                                <div class="form-group">
                                                    <label class="control-label">Способы доставки</label>
                                                    @foreach($delivery_methods as $delivery_method)
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="delivery_methods[]" value="{{$delivery_method->id}}"/> {{$delivery_method->title}}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    
                                    <div class="form-group hide">
                                        <label class="control-label">Тип магазина</label>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="as_shop" value="1"/> Каталог
                                            </label>
                                        </div>
                                        
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="as_shop" value="2" checked/> Интернет магазин
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <hr/>
                                    
                                    <div class="form-group">
                                        <label class="control-label">О нас</label>
                                        <textarea class="hide ckeditor" name="about"></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label">Вакансии</label>
                                        <textarea class="hide ckeditor" name="vacancy"></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label">Контакты</label>
                                        <textarea class="hide ckeditor" name="contacts"></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label">График работы</label>
                                        <textarea class="hide ckeditor" name="schedule"></textarea>
                                    </div>
                                    
                                    <div class="form-group hide">
                                        <label class="control-label">Телефонные номера</label>
                                        <textarea class="hide " name="phone_numbers"></textarea>
                                    </div>

                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                    <div class="form-group">
                                        <label for="images">Изображение магазина</label>
                                        <div>
                                            Размер изображения 1280х500 px, в ином случае изображение будет откорректировано до нужных пропорций
                                        </div>
                                        <input type="file" name="images[]" multiple accept="image/png, image/jpeg, image/gif">
                                    </div>
                                    
                                    <hr/>
                                    
                                    <div class="form-group">
                                        <label for="logo">Логотип</label>
                                        <div>
                                            Пропорция изображения 16:9
                                        </div>
                                        <input type="file" name="logo" multiple accept="image/png, image/jpeg, image/gif">
                                    </div>
                                    
                                    <hr/>
                                    
                                    <div class="form-group">
                                        <label for="preview_frontpage">Превью для главной страницы</label>
                                        <div>
                                            Размер изображения 320х182 px, в ином случае изображение будет откорректировано до нужных пропорций
                                        </div>
                                        <input type="file" name="preview_frontpage" accept="image/png, image/jpeg, image/gif"/>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                    <div class="form-group">
                                        <label class="control-label" for="slider_title">Заголовок слайдера</label>
                                        <input name="slider_title" class="form-control" type="text" value="" required/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Изображения</label>
                                        <div id="images" class="dropzone dropzone-product" data-id="" data-images="" data-path="/{{config('filesystems.shops_gallery.path').'small/'}}"></div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                @include('admin/shops/publish', ['actionName' => 'Добавить'])
            </div>
        </div>

    </form>
</section>

@stop