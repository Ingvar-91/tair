<ul>
    @foreach($child as $childVal)
    <li> 
        @if(isset($childVal->child)) 
            <a href="#" class="toggle-cat">{{$childVal->title}} <small>({{$childVal->count}})</small> <i class="fa fa-angle-down" aria-hidden="true"></i></a>
            @include('/site/shops/categories', ['child' => $childVal->child])
        @else
        <a href="{{Route('shop', ['subdomain' => $shop->placeholder, 'category_id' => $childVal->id])}}">{{$childVal->title}} @if(isset($childVal->count)) <small>({{$childVal->count}})</small> @endif</a>
        @endif
    </li>
    @endforeach
</ul>