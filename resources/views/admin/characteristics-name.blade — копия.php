<script id="characteristics-name-ejs" type="text/template">
<% var i = 0 %>
<% $.each(charName, function(key, val){%>
    <% if(!val.parent_id){%>
        <div class="form-group">
            <label class="control-label"><%= val.name %></label>
            <div class="input-group">
                <span class="input-group-addon">
                    <input type="checkbox" autocomplete="off" class="chars-ckeckbox" name="characteristics_remove[]" value="<%= val.id %>" role="button"/> 
                </span>
                <input type="text" class="char-filed form-control" name="characteristics[<%= val.id %>|<%= val.child_id %>]" data-value="<%=val.value%>" data-parent_id="<%=val.id%>" data-id="<%=val.child_id%>" autocomplete="off" <% if(val.value){%> value="<%=val.value%>"<%}%>/>
                <% if(val.child){%>
                <div class="dropdown dropdown-char-name"> 
                    <ul class="dropdown-menu"> 
                    <% $.each(val.child, function(key, val){%>
                        <li>
                            <a href="#" class="dropdown-char-a" data-name="<%= val.name %>" data-id="<%= val.id %>"><%= val.name %></a>
                        </li>
                    <% }); %>
                    </ul> 
                </div>
                <% } %>
                    <span class="input-group-btn">
                        <button class="btn btn-default edit-characteristics-name" type="button" title="Редактировать" data-id="<%= val.id %>" data-name="<%= val.name %>" ><i class="fa fa-pencil" aria-hidden="true"></i></button>
                    </span>
            </div>
            
        </div>
    <% } %>
<% }); %>
</script>

<div id="characteristics-name">
    <h4 class="text-center warning">Сначала выберите категорию и магазин</h4>

        <div class="form-group characteristics-name-control hide">
            <input type="button" class="btn btn-info" value="Добавить" id="add-characteristics-name">
            <input type="button" class="btn btn-danger" value="Удалить" id="remove-characteristics-name">
        </div>
        <div class="characteristics-name">

        </div>

</div>
