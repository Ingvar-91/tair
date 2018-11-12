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
<!-- comments -->
<script src="/js/admin/comments.js"></script>
<!-- comments END -->
@endpush 

@section('content')

<div class="clearfix"></div>
{!! Breadcrumbs::render('admin.comments.form') !!}

<section>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Комментарии</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <table class="data-table table table-striped table-bordered dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Имя</th>
                                <th>Комментарий</th>
                                <th class="action">Действие</th>
                                <th class="status">Статус</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script id="comments-ejs" type="text/template">
<ul>
<% $.each(comments, function(key, val){%>
            
    <% 
    if(val.name){
        var user_name = val.name;
    }
    else{ 
        var user_name = val.user_name;   
    }
    %>
    
    <% if(commentId == val.id){ %>
        <li class="active">
        <% } else{ %>
        <li>
        <% } %>
            <div class="comment <% if(val.status == 3){%> bg-danger <%}%>">
                <div class="user-name h4">
                    <%= user_name %>
                </div>  
                <div class="text">
                    <%- val.text %>
                </div>
            </div>
            <% if(val.child){ %>
                <%- ejs.render($('#comments-ejs').html(), { comments:val.child, commentId:commentId }) %>
            <% }%>
        </li>
<% }); %>
</ul>
</script>

<script>
    var columnsName = [
        {data: 'id', visible: false},
        {data: 'user_name'},
        {data: 'text'},
        {data: 'actions', searchable: false, orderable: false},
        {data: 'status', searchable: false}
    ];
</script>

<!-- all history comment -->
<div class="modal fade" id="all-history-comment-wd" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">История комментария</h4>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>
        
<!-- reply comment -->
<div class="modal fade" id="reply-comment-wd" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="reply-comment-form" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Ответить на сообщение</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="user_id"/>
                    <input type="hidden" name="id" id="reply-comment-id-input"/>
                    <input type="hidden" name="first_parent_id" id="reply-comment-first_parent_id-input"/>
                    <div class="form-group">
                        <label class="control-label">Комментарий</label>
                        <div>
                            <textarea name="text" class="form-control" rows="6"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="reply-comment-button" class="btn btn-primary">Ответить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- edit-comment -->
<div class="modal fade" id="edit-comment-wd" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="edit-comment-form-wd">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Редактировать комментарий</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="comment-id-wd"/>
                    <h4 id="comment-name-wd"></h4>
                    <div class="form-group">
                        <label class="control-label">Комментарий</label>
                        <div>
                            <textarea name="text" class="form-control" rows="6" id="comment-text-wd" autocomplete="off"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="comment-edit-save" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- add comment -->
<!--<div class="modal fade" id="add-comment-wd" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Добавить новый комментарий</h4>
            </div>
            <div class="modal-body">
                23532523523636
            </div>
        </div>
    </div>
</div> -->

@stop