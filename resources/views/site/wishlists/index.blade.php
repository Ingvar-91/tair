@extends('site/index')

@push('css')

@endpush 

@push('scripts')
<script src="/js/site/products.js"></script>
@endpush

@section('content')

<nav class="box box-control m-b-0">
    {!! Breadcrumbs::render('wishlists') !!}
</nav>

<section id="products" class="box-control">
    <div>
        <h2 class="m-b">Желаемые товары</h2>
        
        @if(count($products) > 0)
            <div class="row product-list">
                @foreach($products as $i => $val)
                    <div class="col-xs-12 col-sm-6 col-md-3">

                        @include('site/products/item-product')

                    </div>
                @endforeach
            </div>
        @if($products->total() > $products->perPage())
            <div class="m-lg-b m-sm-t text-center">
                {{ $products->appends(['filterChar' => request()->filterChar, 'price' => request()->price])->links() }}
            </div>
        @endif

        @else
            <div class="box">
                <p class="p m-sm-t">Товары не найдены</p>
            </div>
        @endif
        
    </div>

</section>
@stop