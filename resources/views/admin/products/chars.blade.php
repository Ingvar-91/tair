<script id="chars-ejs" type="text/template">
<% $.each(chars, function(key, char){%>
            
    <div class="form-group">
        <label><%= char.title %> 
            <span class="char-select-all" role="button" style="font-size: 135%; margin-left: 10px;"><i class="fa fa-check-square-o" aria-hidden="true"></i></span>
            <span class="char-clear-all" role="button" style="font-size: 135%; margin-left: 10px;"><i class="fa fa-times" aria-hidden="true"></i></span>
        </label>
        <select class="selectpicker form-control char" multiple data-live-search="true">
            <% if(char.child){ %>
                <% $.each(char.child, function(key, child){%>
                    <option value="<%= child.id %>" <% if(child.check){%>selected<% } %> ><%= child.title %></option>
                <% }); %>
            <% } %>
        </select>
    </div>
    
<% }); %>
</script>

<div id="chars">
    <h4 class="text-center warning @if(isset($chars)) hide @endif">Сначала выберите категорию</h4>
    <div id="chars-list">
        @if(isset($chars))
            @foreach($chars as $char)
                <div class="form-group">
                    <label>{{$char->title}}
                        <span class="char-select-all" role="button" style="font-size: 135%; margin-left: 10px;"><i class="fa fa-check-square-o" aria-hidden="true"></i></span>
                        <span class="char-clear-all" role="button" style="font-size: 135%; margin-left: 10px;"><i class="fa fa-times" aria-hidden="true"></i></span>
                    </label>
                    <select class="selectpicker form-control char" multiple data-live-search="true">
                        @if($char->child)
                            @foreach($char->child as $child)
                                <option value="{{$child->id}}" @if($child->check) selected @endif>{{$child->title}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            @endforeach
        @endif
        
    </div>
</div>
