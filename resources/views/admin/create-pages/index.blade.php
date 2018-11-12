@extends('admin/index')

@section('content')

<section>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Создание страницы</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <form class="form-horizontal form-label-left" method="POST" name="form" >
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Наименование страницы <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Url страницы <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="url" required="required" class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">meta-keywords</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input name="meta_keywords" class="form-control col-md-7 col-xs-12" type="text">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">meta-description</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input name="meta_description" class="form-control col-md-7 col-xs-12" type="text">
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button class="btn btn-primary" type="reset">Очистить форму</button>
                                <button type="submit" class="btn btn-success">Создать</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


</section>

@stop