@extends('admin/index') 

@push('css')

@endpush 

@push('scripts')

@endpush 

@section('content')

<div class="clearfix"></div>

<section>
    <form autocomplete="off" method="post" action="{{Route('admin.shop_categories.edit')}}">
        <input name="id" type="hidden" value="{{$shop_category->id}}"/>
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        
        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Редактировать категорию магазина</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        
                        @include('alerts')

                        <div class="clearfix"></div>
                        
                        <div class="form-group">
                            <label class="control-label" for="title">Заголовок</label>
                            <input required="required" name="title" class="form-control" type="text" value="{{$shop_category->title}}"/>
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
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-success btn-control" id="edit-submit">Сохранить</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</section>

@stop