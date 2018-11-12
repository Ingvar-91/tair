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

<div class="clearfix"></div>
{!! Breadcrumbs::render('admin.news.edit.form') !!}


<section>
    <form id="news-form" autocomplete="off" method="POST">
        <input name="id" type="hidden" value="{{$news->id}}"/>
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        
        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Редактировать новость</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group">
                            <label class="control-label" for="title">Заголовок</label>
                            <input required="required" name="title" class="form-control" type="text" value="{{$news->title}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="text">Текст новости</label>
                            <textarea class="ckeditor hide" name="text" id="text">{!!$news->text!!}</textarea>
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
                                    <option @if($news->status == 0) selected="selected" @endif value="0">На утверждении</option>
                                    @if(Auth::user()->role > 4)
                                    <option @if($news->status == 1) selected="selected" @endif value="1">Опубликовано</option>
                                    @endif
                                    <option @if($news->status == 2) selected="selected" @endif value="2">Черновик</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label" for="first-name">Дата:</label>
                                <input type="text" class="form-control daterange" name="created_at" value="{{$news->created_at}}" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="ln_solid"></div>
                        <div class="form-group text-right">
                            <button type="button" class="btn btn-success" id="edit-submit">Сохранить</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </form>
</section>



@stop