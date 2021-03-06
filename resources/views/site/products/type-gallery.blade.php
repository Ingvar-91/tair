@extends('site/index')

@push('css')

@endpush 

@push('scripts')

@endpush

@section('title', $currentCategory->title)

@section('content')
<nav class="box box-control m-b-0">
    {!! Breadcrumbs::render('products', $breadcrumb) !!}
</nav>

<input type="hidden" name="category_id" id="category_id" value="{{request()->category_id}}"/>

<div id="products-wrap">
    <div class="box box-control p">
        Галлерея
    </div>
</div>

@stop