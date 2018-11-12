@extends('admin/index') 

@push('css')

@endpush 

@push('scripts')

@endpush 

@section('content')

<div class="clearfix"></div>

<section>
    <form autocomplete="off" method="POST" action="{{Route('admin.slider.add')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('POST') }}

        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Добавить изображение в слайдер</h2>
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
                    
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">

                @include('admin/slider/publish')

            </div>
        </div>

    </form>
</section>

@stop