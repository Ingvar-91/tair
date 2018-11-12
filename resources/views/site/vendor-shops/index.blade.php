@extends('site/index')

@push('css')
@endpush 

@push('scripts')
<!-- vendor -->
<script src="/js/site/vendor.js"></script>
@endpush

@section('title', 'Мои магазины')

@section('content')
<nav class="box box-control m-b-0">
    {!! Breadcrumbs::render('shops') !!}
</nav>

<section id="vendor-shops" class="m">
    <div class="row custom-row">
        <div class="col-sm-8">
            <div class="box p">
                @if(empty($shops) == false)
                <div>
                    @foreach($shops as $val)
                        <div class="media">
                            <div class="media-left">
                                <a href="{{Route('vendor.shops.edit.form', ['id' => $val->shop_id])}}">
                                    @if(Helper::getImg($val->shop_images, 'shops', 'small'))
                                        <img class="media-object" style="max-height: 100px;" src="{{Helper::getImg($val->shop_images, 'shops', 'small')}}" alt=""/>
                                    @else
                                    <img class="img-responsive w-100" src="/img/no-image-16x9.jpg" alt=""/>
                                    @endif
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="{{Route('vendor.shops.edit.form', ['id' => $val->shop_id])}}">{{$val->title}}</a>
                                </h4>
                                <div>
                                    {{str_limit($val->short_description, 130)}}
                                </div>
                                <div class="m-sm-t">
                                    <a class="btn btn-blue btn-medium m-sm-r" href="{{Route('vendor.products.form', ['shop_id' => $val->shop_id])}}">Показать товары</a>
                                    <a class="btn btn-orange btn-medium" href="{{Route('vendor.products.add.form', ['shop_id' => $val->shop_id])}}">Добавить товар</a>
                                </div>
                            </div>
                        </div>
                        @if(!$loop->last)
                        <hr/>
                        @endif
                    @endforeach
                </div>
                @else
                <div>
                    <h4>Магазины отсутствуют, либо их ещё не активировали</h4>
                </div>
                @endif

            </div>
        </div>
        <div class="col-sm-4 m-t-sm">

            @include('site.profile-menu')

        </div>
    </div>
</section>
@stop