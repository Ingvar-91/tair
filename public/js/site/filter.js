(function ($) {
    
    var page = location.pathname.split('/')[1],
        $sliderPrice = $('#slider-price'),
        $priceMin = $('#filter .price-min'),
        $priceMax = $('#filter .price-max'),
        $filterSticker = $('#filter-sticker'),
        $filter = $('#filter');
    
    //range price filter
    var priceEvent = false;//метка того что цена менялась юзером
    
    //click checkbox filter
    $('#filter input[type="checkbox"]').on('change', function () {
        generateLinkFilter()
    });
    
    function generateLinkFilter(){
        var filterChar = [],
            link = '',
            obj = {};
    
        $('#filter input[type="checkbox"]:checked').each(function( key, val) {
            filterChar[key] = $(val).val();
        });
        
        if(findGetParameter('category_id')){
            obj['category_id'] = findGetParameter('category_id');
        }
        
        if(filterChar.length) obj['filterChar'] = filterChar;
        if(priceEvent) obj['price'] = [$priceMin.val(), $priceMax.val()];
        else{
            if(findGetParameter('price')) obj['price'] = findGetParameter('price').split(',');
        }

        link = addGet(location.pathname, obj);//формируем ссылку для кнопки фильтра
        $filterSticker.find('a').attr('href', link);
        
        //получаем общее количество товаров и количество товаров у каждой характеристики
        var dataAjax = obj;
        dataAjax._token = $('meta[name="csrf-token"]').attr('content')
        dataAjax.category_id = $('#category_id').val()
        
        $.ajax({
            beforeSend: function (){
                stickerOffset();//смещаем стикер
                $filterSticker.removeClass('hide');//отображаем стикер
                $filterSticker.find('.loader-text').removeClass('hide').parent().find('.count-text').addClass('hide')
            },
            url: '/filter',
            type: 'GET',
            data: dataAjax,
            complete: function () {
                $filterSticker.find('.loader-text').addClass('hide').parent().find('.count-text').removeClass('hide')
            },
            success: function (data) {
                if(data.count == null) data.count = 0;
                $filterSticker.find('.count-products').text(data.count+' '+declOfNum(data.count, ['товар', 'товара', 'товаров']));
                for(var key in data.charsCount){
                    $('.checkbox[data-char-id="'+key+'"]').find('.count-products').text('('+data.charsCount[key]+')')
                }
            }
        });
    }

    //задаем GET параметры
    function addGet(url, get) {
        if (typeof (get) === 'object') {
            get = serializeGet(get);
        }
        if (url.match(/\?/)) {
            return url + '&' + get;
        }
        if (!url.match(/\.\w{3,4}$/) && url.substr(-1, 1) !== '/') {
            url += '/';
        }
        return url + '?' + get;
    }
    
    function serializeGet(obj) {
        var str = [];
        for (var p in obj)
            if (obj.hasOwnProperty(p)) {
                str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
            }
        return str.join("&");
    }
    
    //поиск GET параметра
    function findGetParameter(parameterName) {
        var result = null,
            tmp = [];
        location.search
            .substr(1)
            .split("&")
            .forEach(function (item) {
              tmp = item.split("=");
              if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
            });
        return result;
    }
    
    function stickerOffset(){
        if(window.pageYOffset < ($filter.height() - ((document.documentElement.clientHeight - $filter.offset().top) - 60)) + 25){
            $filterSticker.css('top', ((window.pageYOffset + ((document.documentElement.clientHeight - $filter.offset().top) - 60))+'px'))
        }
        else $filterSticker.css('top', (($filter.height() + 10)+'px'))
    }
    
    //Склонение числительных
    function declOfNum(number, titles) {  
        var cases = [2, 0, 1, 1, 1, 2];  
        return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];  
    }

})(jQuery);