@extends('site/index')

@push('css')
<!-- DataTables -->
<link href="/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<!-- DataTables END -->

<!-- sweetalert -->
<link rel="stylesheet" href="/vendors/sweetalert/dist/sweetalert.css">
@endpush 

@push('scripts')
<!-- DataTables -->
<script src="/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
<!-- DataTables END -->

<!-- sweetalert -->
<script src="/vendors/sweetalert/dist/sweetalert.min.js"></script>

<!-- vendor -->
<script src="/js/site/vendor.js"></script>
@endpush

@section('title', 'Мои товары')

@section('content')

<nav class="box box-control m-b-0">
    {!! Breadcrumbs::render('vendor.products.form') !!}
</nav>

<section id="products-vendor" class="m">
    <div class="row custom-row">
        <div class="col-sm-8">
            <div class="box p">

                <table class="data-table table table-bordered dt-responsive" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Изображение</th>
                            <th>Наименование</th>
                            <th>Магазин</th>
                            <th>Статус</th>
                            <th class="action">Действие</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
        <div class="col-sm-4 m-t-sm">

            @include('site.profile-menu')

        </div>
    </div>
</section>

<script>
    var columnsName = [
        {data: 'id', visible: false},
        {data: 'images', searchable: false, orderable: false},
        {data: 'title'},
        {data: 'shops_title'},
        {data: 'status'},
        {data: 'actions', searchable: false, orderable: false}
    ];
    
    var dataTableAdditionalData = [
        {name: 'shop_id', value: {{request()->shop_id}} }
    ];
</script>

@stop