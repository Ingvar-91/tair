<div class="text-center">
    @if(Helper::getImg($image, 'avatars'))
        <img src="{{Helper::getImg($image, 'avatars')}}" alt="" class="data-table-image"/>
    @else
        <img src="/img/no-image-1x1.jpg" alt="" class="data-table-image"/>
    @endif
</div>