(function ($) {
    
    var offset = 12;
    
    $('#more-albums').on('click', function () {
        var $this = $(this)
        $.ajax({
            beforeSend: function () {
                $('#loader').addClass('active');
            },
            url: '/photo/',
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                offset: offset
            },
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                console.log(data)
                if(data.items.length){
                    var tmpl = ejs.render($('#albums-list').html(), {albums:data.items});
                    $('#photo').find('.row').append(tmpl);
                    offset = offset + 12;
                }
                else{
                    $this.hide();
                }
                
            }
        });
    });
    
    $('#photo-album .show-gallery-img').click(function () {
        var dynamicEl = [],
            slideNum = $(this).attr('data-num');
        
        var $objs = $(this).parents('#photo-album').find('.image');
        
        $objs.each(function(key, val){
            dynamicEl[key] = {thumb:$(val).attr('src'), src:$(val).attr('data-large-img')}
        });
        
        $(this).lightGallery({
            dynamic: true,
            download: false,
            share: false,
            thumbnail: true,
            showThumbByDefault: true,
            index: parseInt(slideNum),//номер слайдера
            dynamicEl: dynamicEl
        });
    });

})(jQuery);