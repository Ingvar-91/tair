@extends('admin/index')

@push('css')
<!-- jquery-ui -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!-- jquery-tag-editor -->
<link href="/vendors/jquery-tag-editor/jquery.tag-editor.css" rel="stylesheet" />
@endpush 

@push('scripts')
<!-- jquery-ui -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- jquery-tag-editor -->
<script src="/vendors/jquery-tag-editor/jquery.tag-editor.min.js"></script>
<script src="/vendors/jquery-tag-editor/jquery.caret.min.js"></script>

<!-- chars -->
<script src="/js/admin/chars.js"></script>
@endpush 

@section('content')

<div class="clearfix"></div>

<section id="chars">
    <form method="post" action="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Характеристики <small>Категория: {{$category->title}}</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        @include('alerts')

                        <div class="form-group">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                Добавить характеристику
                            </button>
                        </div>

                        <hr/>

                        @foreach($chars as $char)
                        <div class="form-group">
                            <label>
                                <span class="title">{{$char->title}}</span> 
                                <span class="edit-parent-category" data-id="{{$char->id}}" style="margin-left: 6px;" role="button"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
                                <span class="remove-parent-category" data-id="{{$char->id}}" style="margin-left: 2px;" role="button"><i class="fa fa-remove" aria-hidden="true"></i></span>
                            </label>
                            <input type="text" class="form-control chars-tag-edit" name="chars[{{$char->id}}]" data-child="{{json_encode($char->child)}}" data-category_id="{{request()->category_id}}" data-parent_id="{{$char->id}}" data-common="{{$char->common}}" data-selected_order="{{$char->selected_order}}"/>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<!-- add chars -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{Route('admin.chars.add')}}" method="POST">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Добавить характеристику</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Наименование характеристики</label>
                        <input type="text" class="form-control" name="title"/>
                        <input type="hidden" name="parent_id" value="0"/>
                        <input type="hidden" name="category_id" value="{{request()->category_id}}"/>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="selected_order" value="1"/> Можно выбрать в заказе
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop