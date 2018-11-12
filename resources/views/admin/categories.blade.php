<div id="categories">
    <div class="add-category text-success form-group text-right" data-id="<%= val.id %>">
        <button class="btn btn-dark" type="button" title="Добавить категорию"><i class="fa fa-plus" aria-hidden="true"></i></button>
    </div>
    <div>
        <div class="form-group categories-loader text-center hide">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
        </div>
        <div class="form-group categories-list">

        </div>
    </div>
</div>

<script id="categories-ejs" type="text/template">
<ul class="item-ul">
<% $.each(categories, function(key, val){%>
    <li class="category-item">
        <div class="radio">
            <% if(!val.child){ %>
                <label>
                    <input <% if(val.id == current_category_id){%> checked <%}%> autocomplete="off" type="radio" name="category_id" class="categories"  data-id="<%= val.id %>" value="<%= val.id %>"/> <span class="name-categories"><%= val.title %></span> 
                </label>
            <% } else{ %>
                <span class="name-categories"><%= val.title %></span>
            <% }%>
            <ul class="list-unstyled control">
                <li class="add-category text-success" data-id="<%= val.id %>">
                    <button class="btn btn-dark" type="button" title="Добавить категорию"><i class="fa fa-plus" aria-hidden="true"></i></button>
                </li>
                <li class="edit-category text-info" data-id="<%= val.id %>">
                    <button class="btn btn-info" type="button" title="Редактировать категорию"><i class="fa fa-edit" aria-hidden="true"></i></button>
                </li>
                <li class="remove-category text-danger" data-id="<%= val.id %>">
                    <button class="btn btn-danger" type="button" title="Удалить категорию"><i class="fa fa-close" aria-hidden="true"></i></button>
                </li>
            </ul>
        </div>
        <% if(val.child){ %>
            <%- ejs.render($('#categories-ejs').html(), { categories:val.child, current_category_id}) %>
        <% }%>
    </li>
<% }); %>
</ul>
</script>

<script id="category-edit-ejs" type="text/template">
<% $.each(categories, function(key, val){%>
    <option value="<%= val.id %>"><%= strip+val.title %></option>
    <% if(val.child){ %>
        <%- ejs.render($('#category-edit-ejs').html(), { categories:val.child, strip:strip+'--' }) %>
    <% }%>
<% }); %>
</script>


