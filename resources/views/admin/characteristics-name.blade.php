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
                <input type="text" class="form-control tokenfield-char" data-parent_id="<%= val.id %>" data-child="<% if(val.child){%><%=JSON.stringify(val.child)%><% } %>"  <% if(val.valueData){%>data-value="<%=JSON.stringify(val.valueData)%>"<% } %> />
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
