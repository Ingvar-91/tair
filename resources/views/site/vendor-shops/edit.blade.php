@extends('site/index') 

@push('css')
@endpush 

@push('scripts')
<!-- ckeditor -->
<script src="/vendors/ckeditor/ckeditor.js"></script>

<!-- vendor -->
<script src="/js/site/vendor.js"></script>
@endpush 

@section('title', 'Редактировать магазин')

@section('content')

<section class="box box-control m-b-0">
    {!! Breadcrumbs::render('shops.edit', $shop) !!}
</section>

<section class="m">
    <div class="row custom-row">
        <div class="col-sm-8">
            <div class="box p">
                
                <div>
                    @include('alerts')
                </div>

                <form autocomplete="off" method="POST" action="{{Route('vendor.shops.edit', ['id' => $shop->id])}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group">
                        <label class="control-label">О нас</label>
                        <textarea class="form-control ckeditor" name="about">{!!$shop->about!!}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Вакансии</label>
                        <textarea class="form-control ckeditor" name="vacancy">{!!$shop->vacancy!!}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Контакты</label>
                        <textarea class="form-control ckeditor" name="contacts">{!!$shop->contacts!!}</textarea>
                    </div>
                    
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-orange btn-medium">Сохранить</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="col-sm-4 m-t-sm">
            
            @include('site.profile-menu')
            
        </div>
    </div>
</section>
@stop