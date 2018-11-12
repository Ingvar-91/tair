@if(Helper::isDiscount($item->start_discount, $item->end_discount, $item->discount))
    @if($item->discount)
        <div>{{number_format($item->discount, 0, '', ' ')}} ₸</div>
        <strike>{{number_format($item->price, 0, '', ' ')}} ₸</strike>
    @endif
@else
    @if($item->price)
        <div>{{number_format($item->price, 0, '', ' ')}} ₸</div>
    @endif
@endif

