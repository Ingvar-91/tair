<div class="text-center">
    @if(Helper::getImg($images, 'slider', 'small'))
        <img src="{{Helper::getImg($images, 'slider', 'small')}}" alt="" class="data-table-image"/>
    @else
        <img src="/img/no-image-1x1.jpg" alt="" class="data-table-image"/>
    @endif
</div>