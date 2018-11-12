<div id="categories">
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
                    <input <% if(val.id == current_category_id){%> checked <%}%> autocomplete="off" type="radio" name="category_id" class="categories"  data-id="<%= val.id %>" value="<%= val.id %>"/> <span><%= val.title %></span> 
                </label>
            <% } else{ %>
                <span class="name-categories" role="button"><%= val.title %></span>
            <% }%>
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