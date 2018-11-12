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

<!-- news -->
<script src="/js/admin/news.js"></script>
@endpush 

@section('content')

<script id="images-ejs" type="text/template">
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

<div class="clearfix"></div>
{!! Breadcrumbs::render('admin.news.add.form') !!}


<section>
    <form id="news-form" autocomplete="off" method="POST">
        {{ csrf_field() }}
        {{ method_field('POST') }}

        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Добавить новость</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab_content1" role="tab" data-toggle="tab" aria-expanded="true">Новость</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content2" role="tab" data-toggle="tab" aria-expanded="false">Превью изображения</a>
                                </li>

                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                                    <div class="form-group">
                                        <label class="control-label" for="title">Заголовок</label>
                                        <input required="required" name="title" class="form-control col-md-7 col-xs-12" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="text">Текст новости</label>
                                        <textarea class="ckeditor hide" name="text" id="text"></textarea>
                                    </div>

                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                                    
                                    <div class="form-group">
                                        <label for="images" class="btn btn-primary">Выбрать изображение</label>
                                        <input type="file" name="images" id="images" class="hide" accept="image/png, image/jpeg, image/gif">
                                    </div>

                                    <div id="images-preview" class="row">

                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Опубликовать</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label" for="first-name">Статус:</label>
                                <select class="form-control" autocomplete="off" name="status">
                                    <option value="0">На утверждении</option>
                                    @if(Auth::user()->role > 4)
                                    <option value="1">Опубликовано</option>
                                    @endif
                                    <option value="2">Черновик</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label" for="first-name">Дата:</label>
                                <input type="text" class="form-control daterange" name="created_at" value="{{date("Y-m-d H:i")}}"/>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="ln_solid"></div>
                        <div class="form-group text-right">
                            <button type="button" class="btn btn-success" id="add-submit">Добавить</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</section>



@stop