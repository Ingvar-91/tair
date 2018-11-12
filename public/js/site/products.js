(function ($) {
    
    //Main.deleteCookie('cart')
    
    $('#filter').find('.toggle-cat').siblings('ul').hide();
    
    //$(this).toggleClass('active').siblings('ul').slideToggle();
    
    $('[data-toggle="tooltip-product"]').tooltip({
        trigger:'manual'
    });
    
    var page = location.pathname.split('/')[1],
        $sliderPrice = $('#slider-price'),
        $priceMin = $('#filter .price-min'),
        $priceMax = $('#filter .price-max')
        
    var $filterSticker = $('#filter-sticker'),
        $filter = $('#filter');
        
    if($('#gallery-top').length && $('#gallery-thumbs').length){
        var galleryTop = new Swiper('#gallery-top', {
            nextButton: '.swiper-fa-button-next',
            prevButton: '.swiper-fa-button-prev',
            spaceBetween: 10,
            loop: true,
            loopedSlides: 5
        });
        var galleryThumbs = new Swiper('#gallery-thumbs', {
            spaceBetween: 10,
            centeredSlides: true,
            slidesPerView: 3,
            loop: true,
            loopedSlides: 5,
            touchRatio: 0.2,
            slideToClickedSlide: true
        });
        galleryTop.params.control = galleryThumbs;
        galleryThumbs.params.control = galleryTop;
    }
    
    $('#product .show-gallery-img').click(function () {
        var dynamicEl = [],
            slideNum = $(this).attr('data-num');
        
        var $objs = $(this).parents('.swiper-wrapper').find('.swiper-slide:not(.swiper-slide-duplicate) img');
        
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
    
    //добавить товар в корзину на странице товара
    $('#product, .item-product').on('click', '.add-cart', function (){
        var chars = [],
            error = 0;
        
        if(page == 'product'){
            var image = '';
            $('#chars-order').find('select').each(function(i, item){
                chars[i] = $(item).val();
            });
        }
        
        if(error) return;
        
        var id = $(this).attr('data-id'),
            shop_id = $(this).attr('data-shop_id'),
            cart = Main.getCookie('cart'),
            count = $('#product').find('.product-add-container').find('input.count').val()

        if (!cart) {
            cart = [{id: id, count: count, chars:chars}]
        } 
        else {
            //проверка на имеющийся id товара в корзине
            for (var i = 0; i < cart.length; i++) {
                if(cart[i].id == id){
                    alert('Данный товар уже есть в корзине')
                    return;
                }
            }
            cart.push({id: id, count: count, chars:chars});
        }
        Main.setCookie('cart', cart, {expires: 86400, path:'/'});//устанавливаем куки на 24 часа
        
        $('#product').find('.add-cart').each(function( key, el) {
            $(el).removeClass('add-cart').addClass('open-cart').text('В корзине')
        });
        $('#btn-cart .badge').text(cart.length)
        
        toastr.success('Товар был добавлен в корзину')
        //showPNotify('success', 'Готово', 'Товар был добавлен в корзину');
    });
    
    //удалить из корзины на других страницах
    $('#product, .item-product').on('click', '.remove-cart', function (){
        var id = $(this).attr('data-id'),
            cart = Main.getCookie('cart'),
            newCart = [],
            $this = $(this)
            
            for (var i = 0; i < cart.length; i++) {
                if (cart[i].id != id)
                    newCart.push(cart[i])
            }
            
        Main.setCookie('cart', newCart, {expires: 86400, path:'/'});//устанавливаем куки на 24 часа
        $this.removeClass('remove-cart').addClass('add-cart').text('Купить');
        $('#btn-cart .badge').text(newCart.length);
    });
    
    //удалить из корзины в окне корзины
    $('#cart').on('click', '.remove-cart', function (e) {
        var id = $(this).attr('data-id'),
            cart = Main.getCookie('cart'),
            newCart = [],
            $thisShop = $(this).parents('.shop');

        for (var i = 0; i < cart.length; i++) {
            if (cart[i].id != id)
                newCart.push(cart[i])
        }

        Main.setCookie('cart', newCart, {expires: 86400, path:'/'});//устанавливаем куки на 24 часа

        if ($(this).parents('#cart').length){
            var $thisCartItem = $(this).parents('.cart-item'),
                count = $thisCartItem.find('.count input').val(),
                price = $thisCartItem.find('.count input').attr('data-price'),
                oldPrice = $thisCartItem.find('.count input').attr('data-old-price'),
                min_price = $thisCartItem.find('.count input').attr('data-min_price'),
                total = $thisCartItem.find('.count input').attr('data-total')
            
            
            $thisCartItem.remove();
            
            $thisCartItem.find('.price > .old-price > span').text((count * oldPrice).toLocaleString());//oldPrice
            $thisCartItem.find('.price > .current-price > span').text((count * price).toLocaleString());//current-price
            $thisCartItem.find('.count input').attr('data-total', parseInt(count * price));

            //в зависимости от общей цены и минимальной цифры заказа, выводим сообщение и блокируем кнопку оформления заказа
            Main.minPriceMessage($thisShop, min_price);
            
            //если товаров не осталось, удаляем магазин
            if(!$thisShop.find('.cart-item').length){
                $thisShop.remove();
            }
            
            /*
            //вычисляем общую стоимость всех товаров
            var price = $(this).parents('tr').find('input[type="number"]').attr('data-price');
            $(this).parents('tr').remove();

            totalPriceInCart();
            */
           
           //если товаров не осталось, скрываем блок оформления заказа и отображаем текст отсутствия товаров
            if(!newCart.length){
                $('#cart > .list').html('<h3 class="text-center">Ваша корзина пуста</h3>');
            }
            
            if(page == 'product'){
                $('#product').find('.open-cart').each(function( key, el) {
                    $(el).removeClass('open-cart').addClass('add-cart').text('Купить')
                });
                //$('#product').find('.remove-cart').removeClass('remove-cart').addClass('add-cart').text('Купить')
            }
        } 
        else {
            $(this).removeClass('remove-cart').addClass('add-cart').text('Купить')
        }
        $('#btn-cart .badge').text(newCart.length);
    });
    
    //отображаем поле выбора даты окончания скидки
    $('input[name="discount"]').on('keyup', function(){
        if($(this).val().length > 0){
            $('input[name="start_discount"]').parent().removeClass('hide')
            $('input[name="end_discount"]').parent().removeClass('hide')
        }
        else{
            $('input[name="start_discount"]').parent().addClass('hide')
            $('input[name="end_discount"]').parent().addClass('hide')
        }
    });
    
    //добавить отзыв о товаре
    $('#review-product-form').on('submit', function(e){
        e.preventDefault();
        
        var $thisForm = $('#review-product-form'),
            data = $thisForm.serializeArray()
        
        $.ajax({
            beforeSend: function () {
                
            },
            url: $thisForm.attr('action'),
            type: 'POST',
            data: data,
            complete: function () {
                
            },
            success: function (data) {
                if(data.status == 0){
                    toastr.error('Произошла ошибка при добавлении отзыва');
                    //showPNotify('error', 'Ошибка', 'Произошла ошибка при добавлении отзыва');
                }
                else if(data.status == 1){
                    $.magnificPopup.close();
                    $thisForm.find('[name="text"]').val('');
                    toastr.success('Отзыв был успешно добавлен');
                    //showPNotify('success', 'Готово', 'Отзыв был успешно добавлен');
                }
                else if(data.status == 2){
                    toastr.warning('Вероятно вы не покупали этот товар, поэтому, у вас нет возможности оставить о нем отзыв');
                    //showPNotify('warning', 'Внимание', 'Вероятно вы не покупали этот товар, поэтому, у вас нет возможности оставить о нем отзыв');
                }
                else if(data.status == 3){
                    toastr.warning('Вы уже оставляли отзыв об этом товаре');
                    //showPNotify('warning', 'Внимание', 'Вы уже оставляли отзыв об этом товаре');
                }
            }
        });
    });
    
    //добавить отзыв о магазине
    $('#review-shop-form').on('submit', function(e){
        e.preventDefault();
        
        var $thisForm = $('#review-shop-form'),
            data = $thisForm.serializeArray()
        
        $.ajax({
            beforeSend: function () {
                
            },
            url: $thisForm.attr('action'),
            type: 'POST',
            data: data,
            complete: function () {
                
            },
            success: function (data) {
                if(data.status == 0){
                    toastr.error('Произошла ошибка при добавлении отзыва');
                    //showPNotify('error', 'Ошибка', 'Произошла ошибка при добавлении отзыва');
                }
                else if(data.status == 1){
                    $.magnificPopup.close();
                    $thisForm.find('[name="text"]').val('');
                    toastr.success('Отзыв был успешно добавлен');
                    //showPNotify('success', 'Готово', 'Отзыв был успешно добавлен');
                }
                else if(data.status == 2){
                    toastr.warning('Вероятно, вы не покупали не одного товара у этого продовца, поэтому, у вас нет возможности оставить о нем отзыв');
                    //showPNotify('warning', 'Внимание', 'Вероятно вы не покупали ещё товары у этого продовца, поэтому, у вас нет возможности оставить о нем отзыв');
                }
                else if(data.status == 3){
                    toastr.warning('Вы уже оставляли отзыв у этого продавца');
                    //showPNotify('warning', 'Внимание', 'Вы уже оставляли отзыв у этого продавца');
                }
            }
        });
    });
    
    //range price filter
    var priceEvent = false;//метка того что цена менялась юзером
    if($sliderPrice.length){
        if($priceMin.val() && $priceMax.val()){
            $sliderPrice.slider({
                step: 2
            }).on('slideStop', function (ev) {
                priceEvent = true;
                $priceMin.val(ev.value[0])
                $priceMax.val(ev.value[1])
                generateLinkFilter();
            });
        }

        $priceMax.on('keyup', function () {
            var min = $sliderPrice.slider('getValue')[0],
                max = parseInt($(this).val());
                
            if(max > $(this).attr('max')){
                max = parseInt($(this).attr('max'));
                $(this).val(max)
            }

            $sliderPrice.slider('setValue', [min, max])
            priceEvent = true;
            generateLinkFilter()
        });

        $priceMin.on('keyup', function () {
            var max = $sliderPrice.slider('getValue')[1],
                min = parseInt($(this).val());
                
            if(min < $(this).attr('min')){
                min = parseInt($(this).attr('min'));
                $(this).val(min)
            }    
                
            $sliderPrice.slider('setValue', [min, max]);
            priceEvent = true;
            generateLinkFilter()
        });
    }

    //click checkbox filter
    $('#filter input[type="checkbox"]').on('change', function () {
        generateLinkFilter();
    });
    
    function generateLinkFilter(){
        var filterChar = [],
            link = '',
            obj = {}
        $('#filter input[type="checkbox"]:checked').each(function( key, val) {
            filterChar[key] = $(val).val();
        });
        
        if(Main.findGetParameter('sort')) obj['sort'] = Main.findGetParameter('sort');
        if(filterChar.length) obj['filterChar'] = filterChar;
        if(priceEvent) obj['price'] = [$priceMin.val(), $priceMax.val()];
        else{
            if(Main.findGetParameter('price')) obj['price'] = Main.findGetParameter('price').split(',');
        }
        
        link = Main.addGet(location.pathname, obj);//формируем ссылку для кнопки фильтра
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
                if(data.countProducts == null) data.countProducts = 0;
                $filterSticker.find('.count-products-flter-sticker').text(data.countProducts+' '+Main.declOfNum(data.count, ['товар', 'товара', 'товаров']));
                
                $(data.countChars).each(function( key, val) {
                    if(!val.countProduct){
                        $('.checkbox[data-char-id="'+val.id+'"]').find('input[type="checkbox"]').prop('disabled', true);
                    } else {
                        $('.checkbox[data-char-id="'+val.id+'"]').find('input[type="checkbox"]').prop('disabled', false);
                    }
                    $('.checkbox[data-char-id="'+val.id+'"]').find('.count-products').text('('+val.countProduct+')')
                });
            }
        });
    }
    
    if($filterSticker.length){
        //смещаем стикер фильтра при скролле 
        window.onscroll = function () {
            stickerOffset();
        }
    }
    
    function stickerOffset(){
        if(window.pageYOffset < ($filter.height() - ((document.documentElement.clientHeight - $filter.offset().top) - 60)) + 25){
            $filterSticker.css('top', ((window.pageYOffset + ((document.documentElement.clientHeight - $filter.offset().top) - 60))+'px'))
        }
        else $filterSticker.css('top', (($filter.height() + 20)+'px'))
    }
    
    
    
})(jQuery);