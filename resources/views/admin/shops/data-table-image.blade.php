<div class="text-center">
    @if(Helper::getImg($image, 'shops', 'small'))
        <img src="{{Helper::getImg($image, 'shops', 'small')}}" alt="" class="data-table-image"/>
    @else
        <img src="/img/no-image-1x1.jpg" alt="" class="data-table-image"/>
    @endif
</div>