var Categories = (function ($) {

    var page = location.pathname.split('/')[2],
        current_category_id = $('#current_category_id').val(),
        product_id = $('#product_id').val()

    //получение шаблона категории и вставка его на страницу
    if ($('#categories').length){
        getCategories();
    }
    
    //открыть/закрыть категорию
    $('#categories').on('click', '.name-categories', function(e) {
        $(this).toggleClass('text-yellow').parentsUntil('.category-item').siblings('.item-ul').slideToggle()
    });


    function getCategories() {
        $('#categories').find('.categories-list').html('');
        $.ajax({
            beforeSend: function () {
                $('#categories').find('.categories-loader').removeClass('hide')
            },
            url: '/products-vendor/categories',
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                page: page
            },
            complete: function () {
                //$('#categories').find('.categories-loader').addClass('hide')
            },
            success: function (data) {
                if (data.error == false) {
                    var tmpl = ejs.render($('#categories-ejs').html(), {categories: data.categories, current_category_id:current_category_id});
                    $('#categories').find('.categories-list').html(tmpl);
                    
                    /*if(current_category_id && product_id){//если имеется категория и id товара, вытаскиваем шаблон характеристик
                        Charactiristics.getCharName(current_category_id);
                    }*/
                    Chars.initSelectPicker();
                }
                $('#categories').find('.categories-loader').addClass('hide')
            }
        });
    }


})(jQuery);