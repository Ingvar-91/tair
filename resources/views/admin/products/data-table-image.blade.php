<div class="text-center">
    @if(Helper::getImg($images, 'products', 'small'))
    <img src="{{Helper::getImg($images, 'products', 'small')}}" alt="" class="data-table-image show-gallery-img" data-large-img="{{Helper::getImg($images, 'products', 'large')}}" style="cursor: zoom-in;"/>
    @else
        <img src="/img/no-image-1x1.jpg" alt="" class="data-table-image"/>
    @endif
</div>