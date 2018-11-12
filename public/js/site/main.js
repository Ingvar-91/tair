var Main = (function ($) {
    
    if(toastr){
        toastr.options = {}
        
        if ($(window).width() >= '768'){
            toastr.options.positionClass = 'toast-top-left';
        }
        else{
            toastr.options.positionClass = 'toast-top-center';
        }
    }
    
    if($('.popover-item-product').length){
        var options = {
            placement:'top',
            html:true,
            trigger:'hover',
            template:'<div class="popover" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>'
        }
        
        $('.popover-item-product').each(function( key, el) {
            options['content'] = $(el).find('.popover-content-item').html();
            $(el).popover(options)
        });
    }

    //загрузка страницы в iframe для распечатки заказа
    /*$('#printPage').on('click', function() {
        $.get( $(this).data('src'), function( html ) {
            var newWin = window.frames["printf"];
            newWin.document.write(html);
            newWin.document.close();
        });
    });*/

    //deleteCookie('cart')

    var $cart = $('#cart'),
        page = location.pathname.split('/')[1],
        $body = $('body')
        
    //magnific-popup
    $body.magnificPopup({
        delegate: '.open-popup-mfp',
        alignTop: false,
        removalDelay: 500, //delay removal by X to allow out-animation
        fixedContentPos: false,
        type: 'inline',
        callbacks: {
            beforeOpen: function() {
                this.st.mainClass = this.st.el.attr('data-effect');
            },
            open: function() {
                $body.addClass('no-scroll')
            },
            close: function() {
                if(page == 'order'){//если окно было открыто и закрыто на странице оформления товара, тогда обновляем страницу т.к. данные могли поменяться
                    if($($.magnificPopup.instance.currItem.el[0]).attr('id') == 'btn-cart'){
                        location.reload();
                    }
                }
                $body.removeClass('no-scroll')
            }
        },
        midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
    });
        
    //открыть корзину кнопкой на странице товара
    $('.buy').on('click', function () {
        var $this = $(this);
        
        if($this.hasClass('open-cart')){
            $.magnificPopup.open({
                removalDelay: 500,
                fixedContentPos: false,
                alignTop: false,
                items: {
                    src: '#mfp-cart',
                    type: 'inline'
                },
                callbacks: {
                    beforeOpen: function() {
                        this.st.mainClass = 'mfp-zoom-in';
                    },
                    open: function() {
                        $body.addClass('no-scroll')
                    },
                    close: function() {
                        $body.removeClass('no-scroll')
                    }
                },
                midClick: true
            });

            loadCart();
        }
        else{
            if ($(window).width() >= '768'){
                $('body,html').animate({scrollTop:0},500);
            }
        }
    });
    
    //открыть корзину основной кнопкой
    $('#btn-cart').on('click', function () {
        loadCart();
    });
    
    function loadCart(){
        $.ajax({
            beforeSend: function () {
                $cart.find('.list').addClass('hide').siblings('.loader').removeClass('hide');
            },
            url: '/cart',
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            complete: function () {
                $cart.find('.list').removeClass('hide').siblings('.loader').addClass('hide');
            },
            success: function (data) {
                if (data.exist) {
                    var tmpl = ejs.render($('#card-list').html(), {productsShops: data.productsShops, cookieCart: data.cookieCart});
                    $cart.find('.list').html(tmpl)
                } else {
                    $cart.find('.list').html('<h3 class="text-center">Ваша корзина пуста</h3>')
                }
            }
        });
    }

    //меняем цену в зависимости от количества (click)
    $('#cart').on('click', '.btn-number', function (e) {
        e.preventDefault();

        btnNumber(this);

        var $thisCartItem = $(this).parents('.cart-item'),
            id = $thisCartItem.find('.count input').attr('data-id'),
            count = $thisCartItem.find('.count input').val(),
            price = $thisCartItem.find('.count input').attr('data-price'),
            oldPrice = $thisCartItem.find('.count input').attr('data-old-price'),
            cart = getCookie('cart'),
            min_price = $thisCartItem.find('.count input').attr('data-min_price'),
            total = $thisCartItem.find('.count input').attr('data-total')

        //устанавливаем количество товара в куки
        for (var i = 0; i < cart.length; i++) {
            if (cart[i].id == id) {
                cart[i].count = count;
            }
        }
        setCookie('cart', cart, {expires: 86400, path: '/'});//устанавливаем куки на 24 часа

        $thisCartItem.find('.price > .old-price > span').text((count * oldPrice).toLocaleString());//oldPrice
        $thisCartItem.find('.price > .current-price > span').text((count * price).toLocaleString());//current-price
        $thisCartItem.find('.count input').attr('data-total', parseInt(count * price));

        //в зависимости от общей цены и минимальной цифры заказа, выводим сообщение и блокируем кнопку оформления заказа
        minPriceMessage($thisCartItem.parents('.shop'), min_price);
    });

    //меняем цену в зависимости от количества (keyup)
    $('#cart').on('keyup', '.input-number', function (e) {
        var $this = $(this),
            count = $this.val(),
            id = $this.attr('data-id'),
            price = $this.attr('data-price'),
            oldPrice = $this.attr('data-old-price'),
            cart = getCookie('cart'),
            $thisCartItem = $this.parents('.cart-item'),
            min_price = $this.attr('data-min_price'),
            total = $this.attr('data-total')

        if (count < 1) {
            $(this).val(1)
            count = 1
        }

        if (count > 99999) {
            $(this).val(99999)
            count = 99999
        }

        //меняем общую цену в шаблоне
        $thisCartItem.find('.price > .old-price > span').text((count * oldPrice).toLocaleString());//oldPrice
        $thisCartItem.find('.price > .current-price > span').text((count * price).toLocaleString());//current-price
        $this.attr('data-total', parseInt(count * price))

        //устанавливаем количество товара в куки
        for (var i = 0; i < cart.length; i++) {
            if (cart[i].id == id) {
                cart[i].count = count;
            }
        }
        setCookie('cart', cart, {expires: 86400, path: '/'});//устанавливаем куки на 24 часа

        //в зависимости от общей цены и минимальной цифры заказа, выводим сообщение и блокируем кнопку оформления заказа
        minPriceMessage($thisCartItem.parents('.shop'), min_price);
    });

    $('#cart').on('change', '.input-number', function (e) {
        var minValue =  parseInt($(this).attr('min')),
        maxValue =  parseInt($(this).attr('max')),
        valueCurrent = parseInt($(this).val()),
        name = $(this).attr('name');
        
        if (valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
        }
        
        if (valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
        }
    });

    //
    $('body').on('click', '.disable-link', function (e) {
        e.preventDefault()
    });

    function minPriceMessage($thisShop, min_price) {
        var $messageMinPrice = $thisShop.find('.min-price-message'),
            newTotal = 0;
        $thisShop.find('.input-number').each(function (key, input) {
            newTotal += parseInt($(this).attr('data-price')) * parseInt($(input).val());
        });
        
        //меняем общую цену в шаблоне
        $thisShop.find('.total > .price > span').text(newTotal.toLocaleString())

        if (min_price <= newTotal) {
            $messageMinPrice.addClass('hide').find('.total').text(newTotal.toLocaleString())
            $thisShop.find('.btn-order').removeClass('btn-secondary disable-link').addClass('btn-orange');
        } else {
            $messageMinPrice.removeClass('hide').find('.total').text(newTotal.toLocaleString())
            $thisShop.find('.btn-order').addClass('btn-secondary disable-link').removeClass('btn-orange');
        }
    }

    //добавить в список желаемого
    $('.item-product, #product').on('click', '.add-wishlist', function (e) {
        e.preventDefault()
        
        var id = $(this).attr('data-id'),
            wishlist = getCookie('wishlist');

        if (!wishlist) {
            wishlist = [id];
        } 
        else wishlist.push(id);

        setCookie('wishlist', wishlist, {expires: 864000, path:'/'});//устанавливаем куки на 10 дней

        $(this).removeClass('add-wishlist').addClass('remove-wishlist').find('.fa').removeClass('fa-heart-o').addClass('fa-heart')
        $('#btn-wishlists > .badge').text(wishlist.length)
    });

    //удалить из списка желаемого
    $('.item-product, #product').on('click', '.remove-wishlist', function (e) {
        e.preventDefault()
        
        var id = $(this).attr('data-id'),
            wishlist = getCookie('wishlist'),
            newWishlist = [];

        for (var i = 0; i < wishlist.length; i++) {
            if (wishlist[i] != id) newWishlist.push(wishlist[i])
        }
        setCookie('wishlist', newWishlist, {expires: 864000, path:'/'});//устанавливаем куки на 10 дней

        /*if(page == 'wishlists'){
            $(this).parents('.wishlists-item').fadeOut('normal')
        } 
        else{
            $(this).removeClass('remove-wishlist').addClass('add-wishlist').find('.text').text('Желаемые')
        }*/
        $(this).addClass('add-wishlist').removeClass('remove-wishlist').find('.fa').removeClass('fa-heart').addClass('fa-heart-o')
        $('#btn-wishlists > .badge').text(newWishlist.length)
    });
    
    
    //показать панораму
    $('#pano').find('.show-pano').on('click', function (e) {
        var $panoFrame = $('#pano').find('iframe');
        $panoFrame.attr({
            //'webkitallowfullscreen': 'true',
            //'mozallowfullscreen': 'true',
            //'allowfullscreen': 'true',
            'src': $panoFrame.attr('data-pano')
        });
        
        $('#pano').find('.preview-container').addClass('hide')
        $('#pano').find('.pano-container').removeClass('hide')
    });

    // возвращает cookie с именем name, если есть, если нет, то undefined
    function getCookie(name) {
        var matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
                ));

        return matches ? JSON.parse(decodeURIComponent(matches[1])) : undefined;
    }

    //удалить cookie
    function deleteCookie(name) {
        setCookie(name, "", {
            expires: -1,
            path: '/',
        })
    }

    function setCookie(name, value, options) {
        options = options || {};

        var expires = options.expires;

        if (typeof expires == "number" && expires) {
            var d = new Date();
            d.setTime(d.getTime() + expires * 1000);
            expires = options.expires = d;
        }
        if (expires && expires.toUTCString) {
            options.expires = expires.toUTCString();
        }

        value = JSON.stringify(value)

        //value = encodeURIComponent(value)
        var updatedCookie = name + "=" + value;
        for (var propName in options) {
            updatedCookie += "; " + propName;
            var propValue = options[propName];
            if (propValue !== true) {
                updatedCookie += "=" + propValue;
            }
        }
        document.cookie = updatedCookie;
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
    
    //Склонение числительных
    function declOfNum(number, titles) {  
        var cases = [2, 0, 1, 1, 1, 2];  
        return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];  
    }

    return{
        getCookie: function (name) {
            return getCookie(name);
        },
        deleteCookie: function (name) {
            return deleteCookie(name);
        },
        setCookie: function (name, value, options) {
            return setCookie(name, value, options);
        },
        findGetParameter: function (param) {
            return findGetParameter(param);
        },
        addGet: function (url, get) {
            return addGet(url, get);
        },
        declOfNum: function (number, titles) {
            return declOfNum(number, titles);
        },
        minPriceMessage: function ($thisShop, min_price) {
            return minPriceMessage($thisShop, min_price);
        }
    }
    

}(jQuery));

/*PNotify*/
function showPNotify(type, title, text){
    //if ($(window).width() >= '1024'){
        PNotify.prototype.options.styling = "fontawesome";
        var opts = {
            addclass: "stack-topleft",
        };
        opts.title = title;
        opts.text = text;
        opts.type = type;
        new PNotify(opts);
    //}
}
/*PNotify END*/



//поиск по ЗНАЧЕНИЯ В МАССИВЕ
/*ПРИМЕР
 var types = ['', 'image/png', 'image/jpeg', 'image/gif'];
 console.log(types.indexOf(file.type))
 */
if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function (searchElement, fromIndex) {
        var k;
        if (this == null) {
            throw new TypeError('"this" is null or not defined');
        }
        var O = Object(this);
        var len = O.length >>> 0;
        if (len === 0) {
            return -1;
        }
        var n = +fromIndex || 0;

        if (Math.abs(n) === Infinity) {
            n = 0;
        }
        if (n >= len) {
            return -1;
        }
        k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);
        while (k < len) {
            if (k in O && O[k] === searchElement) {
                return k;
            }
            k++;
        }
        return -1;
    };
}

//var haystack = {0:71, 2:75, 3:76};

function array_search( needle, haystack, strict ) {
    var strict = !!strict;
    for(var key in haystack){
        if( (strict && haystack[key] === needle) || (!strict && haystack[key] == needle) ){
            return key;
        }
    }
    return false;
}

function is_numeric( mixed_var ) {
	//return !isNaN( mixed_var );
    var anum = /^\-?\d+(\.?\d+)?$/;
    return anum.test(mixed_var);

}



Number.prototype.format = function(n, x, s, c) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
        num = this.toFixed(Math.max(0, ~~n));
    return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};

function initDateRangePicker() {
    $('.daterange').daterangepicker({
        "singleDatePicker": true,
        "timePicker": true,
        "timePicker24Hour": true,
        "locale": {
            "format": "YYYY-MM-DD H:mm",
            "separator": " - ",
            "applyLabel": "Применить",
            "cancelLabel": "Отмена",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "weekLabel": "W",
            "daysOfWeek": [
                "Вс",
                "Пн",
                "Вт",
                "Ср",
                "Чт",
                "Пт",
                "Сб"

            ],
            "monthNames": [
                "Январь",
                "Февраль",
                "Март",
                "Апрель",
                "Май",
                "Июнь",
                "Июль",
                "Август",
                "Сентябрь",
                "Октябрь",
                "Ноябрь",
                "Декабрь"
            ],
            "firstDay": 1
        },
        "linkedCalendars": false,
        "autoUpdateInput": true,
        "opens": "left"
    }, function (start, end, label){

    });
}