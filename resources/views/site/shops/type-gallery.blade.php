<section class="box-control" id="shop-gallery">
    <h2 class="m-lg-b">Галерея</h2>
    @if(empty($shop->gallery) == false)
        <div class="row custom-row">
            @foreach($shop->gallery as $i => $photo)
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="">
                    <figure class="box overflow-hidden p-sm">
                        <img class="img-responsive show-gallery-img" src="/{{config('filesystems.shops_gallery.path').'middle/'.$photo}}" data-large-img="/{{config('filesystems.shops_gallery.path').'large/'.$photo}}" data-num="{{$i}}" alt=""/>
                    </figure>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</section>