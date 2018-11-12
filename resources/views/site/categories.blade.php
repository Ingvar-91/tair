<ul>
    @foreach($child as $childVal)
    <li> 
        @if(isset($childVal->child)) 
            <a href="#" class="toggle-cat">{{$childVal->title}} @if($childVal->count) <small>({{$childVal->count}})</small> @endif <i class="fa fa-angle-down" aria-hidden="true"></i></a>
            @include('/site/categories', ['child' => $childVal->child])
        @else
            @if(isset($childVal->shop_type_id) and isset($childVal->placeholder))
                <a href="http://{{$childVal->placeholder.'.'.config('app.domain')}}">{{$childVal->title}} @if($childVal->count) <small>({{$childVal->count}})</small> @endif</a>
            @else
                <a href="{{Route('products', ['category_id' => $childVal->id])}}">{{$childVal->title}} @if($childVal->count) <small>({{$childVal->count}})</small> @endif</a> 
            @endif
        @endif
    </li>
    @endforeach
</ul>