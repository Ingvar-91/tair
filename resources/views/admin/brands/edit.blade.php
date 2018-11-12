@extends('admin/index') 

@push('css')

@endpush 

@push('scripts')
<!-- ckeditor -->
<script src="/vendors/ckeditor/ckeditor.js"></script>
@endpush 

@section('content')

<div class="clearfix"></div>

<section>
    <form autocomplete="off" method="post" action="{{Route('admin.slider.edit')}}" enctype="multipart/form-data">
        <input name="id" type="hidden" value="{{$slider->id}}"/>
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        
        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Сменить изображение слайдера</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        
                        @include('alerts')

                        <div class="clearfix"></div>
                        
                        <div class="form-group">
                            <label for="images">Выбрать изображение</label>
                            <div>
                                Размер изображения 1280х500 px, в ином случае, изображение будет откорректировано до нужных пропорций
                            </div>
                            <input type="file" name="images[]" accept="image/png, image/jpeg, image/gif">
                        </div>
                        
                        <div class="form-group">
                            @if(Helper::getImg($slider->images, 'slider', 'small'))
                                <img src="{{Helper::getImg($slider->images, 'slider', 'small')}}" alt="" class="img-thumbnail"/>
                            @else
                                <img src="/img/no-image-1x1.jpg" alt="" class="img-thumbnail"/>
                            @endif
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