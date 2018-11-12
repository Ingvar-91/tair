<ul>
    @foreach($child as $childVal)
    <li> 
        @if(isset($childVal->child)) 
            <span class="name-categories" role="button">{{$childVal->title}} 
                <i class="fa fa-angle-down" aria-hidden="true"></i>
            </span>
            <a href="{{Route('admin.chars.form', ['category_id' => $childVal->id])}}" target="_blank" class="add-chars" title="Добавить характеристики"><i class="fa fa-cogs" aria-hidden="true"></i></a>
            @include('/admin/product_categories/list', ['child' => $childVal->child])
        @else
            <a href="{{Route('admin.chars.form', ['category_id' => $childVal->id])}}" target="_blank">{{$childVal->title}}</a>
        @endif
    </li>
    @endforeach
</ul>