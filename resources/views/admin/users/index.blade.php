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
{!! Breadcrumbs::render('admin.users.form') !!}

<div id="users">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Пользователи</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="form-group">
                    <a href="{{Route('admin.users.add.form')}}" class="btn btn-info">Добавить</a>
                </div>
                
                <div class="x_content">
                    <table class="data-table table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>E-mail</th>
                                <th>Имя</th>
                                <th>Фамилия</th>
                                <th>Отчество</th>
                                <th>Изображение</th>
                                <th>Действие</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var columnsName = [
    { data: 'id', visible: false},
    { data: 'email' },
    { data: 'name' },
    { data: 'lastname' },
    { data: 'patronymic' },
    { data: 'image', searchable: false, orderable: false },
    { data: 'actions', searchable: false, orderable: false }
];
</script>

@stop