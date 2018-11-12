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

<section>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Районы</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <a href="{{Route('admin.districts.add.form')}}" class="btn btn-info">Добавить</a>
                </div>

                <div class="x_content">
                    <table class="data-table table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Город</th>
                                <th>Район</th>
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
        { data: 'id', visible: false},
        {data: 'city_name'},
        {data: 'title'},
        {data: 'actions', searchable: false, orderable: false}
    ];
</script>

@stop