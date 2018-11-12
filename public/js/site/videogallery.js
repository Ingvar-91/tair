(function ($) {
    
    $('#more-video-youtube').on('click', function () {
        var nextToken = $(this).attr('data-next_page_token');
            
        if(!nextToken){
            $('#more-video-youtube').addClass('hide')
            return;
        }
        
        $.ajax({
            beforeSend: function () {
                $('#loader').addClass('active');
            },
            url: '/video/nextPage/',
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                nextToken: nextToken
            },
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                var tmpl = ejs.render($('#youtube-list').html(), {listVideo:data.results});
                $('#video').find('.row').append(tmpl);
                $('#more-video-youtube').attr('data-next_page_token', data.info.nextPageToken);
            }
        });
    });

})(jQuery);