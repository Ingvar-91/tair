@extends('admin/index')

@push('css')
<!-- DataTables -->
<link href="/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<!-- DataTables END -->
@endpush 

@push('scripts')
<!-- DataTables -->
<script src="/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="/js/admin/data-tables.js"></script>
<!-- DataTables END -->
@endpush 

@section('content')

<div class="clearfix"></div>
{!! Breadcrumbs::render('admin.orders.form') !!}

<section>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Заказы</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <table class="data-table table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>№ заказа</th>
                                <th>Доставка</th>
                                <th>Оплата</th>
                                <th>Статус</th>
                                <th class="action">Действие</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    var columnsName = [
        {data: 'id', visible: false},
        {data: 'order_num'},
        {data: 'delivery_title'},
        {data: 'payment_title'},
        {data: 'status'},
        {data: 'actions', searchable: false, orderable: false}
    ];
</script>

@stop