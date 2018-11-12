@extends('admin/index')

@push('css')

@endpush 

@push('scripts')
    <script>
        $('#categories-list-page').on('click', '.name-categories', function(e) {
            $(this).parent('li').find('> ul').slideToggle()
        });
    </script>
@endpush 

@section('content')
<section>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Категории</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <div id="categories-list-page" class="list-unstyled">
                        @include('/admin/product_categories/list', ['child' => $categories])
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop