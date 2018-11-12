@extends('site/index')

@push('css')
@endpush 

@push('scripts')
<!-- vendor -->
<script src="/js/site/vendor.js"></script>
@endpush

@section('title', 'Добавить магазин')

@section('content')
<div class="row">
    <div class="col-3">
        
        @include('/site/account-menu')
        
    </div>
    <div class="col-9">
        <h4>Добавить магазин</h4>
        
        <div>
            @include('alerts')
        </div>
        
        <form autocomplete="off" method="POST" action="{{Route('account.shops.add')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('POST') }}

            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <nav class="nav nav-tabs" id="myTab" role="tablist">
                  <a class="nav-item nav-link active" data-toggle="tab" href="#tab1" role="tab" aria-controls="tab1" aria-expanded="true">Магазин</a>
                  <a class="nav-item nav-link" data-toggle="tab" href="#tab2" role="tab" aria-controls="tab2">Изображения</a>
                  <a class="nav-item nav-link" data-toggle="tab" href="#tab3" role="tab" aria-controls="tab3">Категории</a>
                </nav>
                <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade active show" id="tab1" aria-labelledby="home-tab">

                        <div class="form-group">
                            <label class="control-label" for="title">Заголовок</label>
                            <input required="required" name="title" class="form-control" type="text">
                        </div>
                        <div class="form-group">
                            <label class="control-label">О нас</label>
                            <textarea class="form-control" name="about"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Вакансии</label>
                            <textarea class="form-control" name="vacancy"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Контакты</label>
                            <textarea class="form-control" name="contacts"></textarea>
                        </div>

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab2" aria-labelledby="profile-tab">
                        <div class="form-group">
                            <label for="images">Выбрать изображения</label>
                            <input type="file" name="images[]" multiple accept="image/png, image/jpeg, image/gif">
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab3" aria-labelledby="profile-tab">

                        @foreach($shop_categories as $key => $val)
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="shop_categories_relations[]" value="{{$val->id}}"/> {{$val->title}}
                                </label>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </div>
            </div>
        </form>
        
    </div>
</div>
@stop