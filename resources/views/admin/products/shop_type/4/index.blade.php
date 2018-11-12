<section id="slider">

    <div class="row">
        <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Галерея</h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <div id="images" class="dropzone dropzone-product" data-id="{{$posts->id}}" data-images="{{$posts->images}}" data-path="/{{config('filesystems.gallery_shops.path').'small/'}}">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12">

            <div class="x_panel">
                <div class="x_title">
                    <h2>Действие</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-success btn-control" id="update-slider">Обновить</button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
</section>