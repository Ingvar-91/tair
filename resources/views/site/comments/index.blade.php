<script id="comments-ejs" type="text/template">

    <% $.each(comments, function(key, val){ %>
    
    <% 
    if(val.name){
        var user_name = val.name;
    }
    else{ 
        var user_name = val.user_name;   
    }
    
    if(val.status == 3){
        var text_comment = '<span class="text-muted">Комментарий удален модератором</span>';
    }
    else{
        var text_comment = val.text
    }
    %>
    
    <li data-id="<%= val.id %>">
        <div>
            <div>
                <div class="padding-small-bottom">
                    <span class="h4"><%= user_name %></span>
                </div>
                <p><%- moment().format('DD.MM.YYYY - H:mm') %></p>
            </div>
            <div>
                <p><%- text_comment %></p>
            </div>
            <div class="text-right">
                <span class="reply-comment" data-id="<%= val.id %>" data-first_parent_id="<%= val.first_parent_id %>" data-name="<%= user_name %>" role="button">Ответить</span>
            </div>
        </div>
        <ul class="list-unstyled">
            <% if(val.child){ %>
                <%- ejs.render($('#comments-ejs').html(), { comments:val.child}) %>
            <% }%>
        </ul>
    </li>
    <% }); %>

</script>

<script id="comment-ejs" type="text/template">
<li data-id="<%= comment.id %>">
    <div>
        <div>
            <div class="padding-small-bottom">
                <span class="h4"><%= comment.name %></span>
            </div>
            <p><%- moment(comment.created_at).format('DD.MM.YYYY - H:mm') %></p>
        </div>
        <div>
            <p><%= comment.text %></p>
        </div>
        <div class="text-right">
            <span class="reply-comment" data-id="<%= comment.id %>" data-first_parent_id="<%= comment.first_parent_id %>" data-name="<%= comment.name %>" role="button">Ответить</span>
        </div>
    </div>
</li>
</script>

<div id="comments">
    <div class="padding">
        <div class="text-center">
            <span id="open-wd-comment" role="button">Добавить комментарий</span>
        </div>
        <hr>
        <div id="comments-list">
            <div class="text-center">
                <h3>Комментарии отсутствуют</h3>
            </div>
        </div>
    </div>

    <div class="text-center padding-large-bottom">
        <span id="more-comments" role="button">Ещё комментарии <i class="fa fa-angle-down" aria-hidden="true"></i></span>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="wd-comment">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавить комментарий</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form method="post" id="comment-form">
                    <input type="hidden" name="product_id" value="{{request()->id}}"/>
                    
                    <input type="hidden" id="first_parent_id" name="first_parent_id">
                    <input type="hidden" id="parent_id" name="parent_id"/>
                    
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    
                    
                    <div class="form-group @if(Auth::check()) hide @endif">
                        <input type="text" id="name" name="name" class="name-comment form-control" placeholder="Ваше имя" value="@if(Auth::check()){{Auth::user()->name}}@endif">
                    </div>
                    
                    <div class="form-group">
                        <textarea rows="6" required="required" placeholder="Текст вашего комментария" name="text" id="text" class="form-border-blue text-comment form-control" autocomplete="off"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="comment-reply" class="hide"><span class="text-muted">ответ</span> <span class="name"></span> <span class="text-muted" id="remove-comment-reply" role="button"><i class="fa fa-times" aria-hidden="true"></i></span></div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group text-right">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                <button type="submit" id="add-comment" name="post_comment" class="btn btn-info button-loader" value="Добавить">
                                    <span class="text">Добавить</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>