(function ($) {
    
    $('#shop-gallery .show-gallery-img').click(function () {
        var dynamicEl = [],
            slideNum = $(this).attr('data-num');

        var $objs = $(this).parents('#shop-gallery').find('.show-gallery-img');

        $objs.each(function(key, val){
            dynamicEl[key] = {thumb:$(val).attr('src'), src:$(val).attr('data-large-img')}
        });

        $(this).lightGallery({
            dynamic: true,
            download: false,
            share: false,
            thumbnail: true,
            showThumbByDefault: true,
            index: parseInt(slideNum),
            dynamicEl: dynamicEl
        });
    });
    
})(jQuery);