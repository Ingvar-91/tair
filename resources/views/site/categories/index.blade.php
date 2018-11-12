@extends('site/index')

@push('css')

@endpush 

@push('scripts')
@endpush

@section('title', 'Категории товаров')

@section('content')

<nav class="box box-control">
    {!! Breadcrumbs::render('products', $breadcrumb) !!}
</nav>

<section class="box-control">
    <h2>Категории товаров</h2>
    @if(empty($categories) == false)
        <div class="row custom-row">
            @foreach($categories as $category)
                <div class="col-md-3 col-xs-12">
                    <figure class="box text-center p-sm m-b">
                        <div>
                            <a class="h4" href="{{Route('category', ['id' => $category->id])}}" title="{{$category->title}}">
                                
                                @if(Helper::getImg($category->image, 'categories'))
                                    <img class="w-100" src="{{Helper::getImg($category->image, 'categories')}}"/>
                                @else
                                    <img class="w-100" src="/img/no-image-1x1.jpg"/>
                                @endif
                            </a>
                        </div>
                        <figcaption class="m-t">
                            <a class="h4" href="{{Route('category', ['id' => $category->id])}}" title="{{$category->title}}">{{str_limit($category->title, 20)}}</a> 
                        </figcaption>
                    </figure>
                </div>
            @endforeach
        </div>
    @endif
</section>
@stop