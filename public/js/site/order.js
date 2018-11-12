(function ($) {
    
    var $orderForm = $('#order-form'),
        $productsOrder = $('#products-order'),
        $addressOrder = $('#address-order'),
        $deliveryOrder = $('#delivery-order'),
        $deliveryAddress = $('#delivery-address'),
        $paymentOrder = $('#payment-order'),
        $buyerOrder = $('#buyer-order'),
        formMessage = [],
        //page = location.pathname.split('/')[1],
        errorAlertMessage = [],
        firm = $orderForm.find('[name="firm"]').val(),
        floors = $orderForm.find('[name="floors"]').val()
        
        
    var deliveryMessages = {
        1:{
            1:{
                text:'Оплата заказа при получении в магазине, наличными либо банковской картой.'
            },
            2:{
                text:'Оплата с помощью процессингового центра АО "Казкоммерцбанк" epay.kkb.kz. всеми видами кредитных карт международных платежных систем. При оплате с клиента удерживается только комиссия за обслуживание карты.'
            }
        },
        2:{
            1:{
                text:'Оплата курьеру при получении заказа. <span class="text-red">Просьба иметь при себе сумму указанную в заказе, т.к. у курьера может не оказаться сдачи!</span>'
            },
            2:{
                text:'Оплата банковской картой курьеру  при получении заказа. Производится через  мобильный терминал. К оплате принимаются карты VISA и MasterCard.'
            }
        }
    };
    
    //Товары в заказе
    $productsOrder.on('click', '.onwards', function () {
        $productsOrder.find('.title').addClass('bg-success').siblings('.item-content').find('.btn-control').hide().parents('.section').next('.section').find('.item-content').removeClass('hide');
    });
    
    //Самовывоз
    $deliveryAddress.on('click', '.onwards', function () {
        var textResult = $deliveryAddress.find('.contacts-group').html(),
            $parent = $(this).parents('.section')
            
        var $nextSection = $parent.find('.section-field')
                .addClass('hide')
                .parents('.section')
                .find('.section-preiew')
                .removeClass('hide')
                .find('b')
                .html(textResult)
                .parents('.section')
        .find('.title').addClass('text-green').parents('.section').next('.section');
        
        if($nextSection.hasClass('hide')){
           $nextSection.next().find('.item-content').removeClass('hide');
        }
        else{
            $nextSection.find('.item-content').removeClass('hide');
        }
        
    });
    
    //Местоположение получателя
    $addressOrder.on('click', '.onwards', function () {
        if($(this).hasClass('disable-link')){
            return;
        }
        
        var $parent = $(this).parents('.section'),
            city_id = parseInt($parent.find('[name="city_id"]').val()),
            district_id = parseInt($parent.find('[name="district_id"]').val()),
            street = $parent.find('[name="street"]').val(),
            error = false;
        
        if(!city_id){
            $('[name="city_id"]')[0].reportValidity();
            error = true;
        }
        
        if(!district_id){
            $('[name="district_id"]')[0].reportValidity(); 
            error = true;
        }
        
        if(!street){
            $('[name="street"]')[0].reportValidity(); 
            error = true;
        }
        
        if(error) return;
        
        var textResult = $('[name="city_id"] option:selected').text()+' - '+
                        $('[name="district_id"] option:selected').text()+', '+
                        $('[name="street"]').val()+'<br/>';
                
        if($('[name="apartment"]').val()) textResult += 'Квартира / офис - '+$('[name="apartment"]').val()+'<br/>'
        if($('[name="home"]').val()) textResult += 'Дом - '+$('[name="home"]').val()+'<br/>'
        if($('[name="floor"]').val()) textResult += 'Этаж - '+$('[name="floor"]').val()+'<br/>'
        if($('[name="intercom"]').val()) textResult += 'Код домофона - '+$('[name="intercom"]').val()+'<br/>'
        if($('[name="building"]').val()) textResult += 'Корпус, строение - '+$('[name="building"]').val()+'<br/>'
        if($('[name="entrance"]').val()) textResult += 'Подъезд - '+$('[name="entrance"]').val()
        
        $parent.find('.section-field')
                .addClass('hide')
                .parents('.section')
                .find('.section-preiew')
                .removeClass('hide')
                .find('b')
                .html(textResult)
                .parents('.section')
        .find('.title').addClass('text-green').parents('.section').next('.section').find('.item-content').removeClass('hide');
    });
    
    //пересчет цены с учетом цены доставки и её отображение
    $deliveryOrder.on('change', '[name="delivery_id"]', function (){
        var $this = $(this),
            newTotalPrice = 0;
        
        if($this.attr('value') == 2){/* если курьерская */
            $('#rate-shipping-h').removeClass('hide');
            newTotalPrice = parseInt($('#order-price-val').val()) + parseInt($('#rate-shipping-val').val());
            
            //скрываем блок самовывоза
            $deliveryAddress.addClass('hide');
            //отображаем блок "Местоположение получателя"
            $addressOrder.removeClass('hide');
        }
        else if($this.attr('value') == 1){/* если самовывоз */
            $('#rate-shipping-h').addClass('hide');
            newTotalPrice = parseInt($('#order-price-val').val());
            
            //отображаем блок самовывоза
            $deliveryAddress.removeClass('hide');
            //скрываем блок "Местоположение получателя"
            $addressOrder.addClass('hide'); 
        }
  
        $('#rate_shipping').text($('#rate-shipping-val').val());
        $('#total-price').text(newTotalPrice.toLocaleString());
        
        //
        $paymentOrder.find('[name="payment_id"]').each(function( key, val) {
            $(val).siblings('.popover-item-product').attr('data-content', deliveryMessages[$this.attr('value')][$(val).val()].text)
        });
    });
    
    //Способ доставки
    $deliveryOrder.on('click', '.onwards', function () {
        if($(this).hasClass('disable-link')){
            return;
        }
        
        var $parent = $(this).parents('.section'),
            delivery = $deliveryOrder.find('input[name="delivery_id"]:checked').val(),
            error = false

        if(!delivery){
            $('[name="delivery_id"]')[0].reportValidity(); 
            error = true;
        }
        
        if(error) return;
        
        var delivery_name = '';
        if(delivery == 1){
            delivery_name = 'Самовывоз';
            
            //инициализируем карту этажей
            DG.FloorsWidget.init({
                container: 'map-delivery',
                width: '100%',
                height: '550px',
                initData: {
                    complexId: floors,
                    options: {
                        initialFirm: firm
                    }
                }
            });
            
            //вставляем текст описания оплаты товара
            
            
            
        }
        else if(delivery == 2){
            delivery_name = 'Курьерская доставка';
        }

        var $nextSection = $parent.find('.section-field')
            .addClass('hide')
            .parents('.section')
            .find('.section-preiew')
            .removeClass('hide')
            .find('b')
            .html(delivery_name)
            .parents('.section')
            .find('.title').addClass('text-green').parents('.section').next('.section');
        
        if($nextSection.hasClass('hide')){
           $nextSection.next().find('.item-content').removeClass('hide');
        }
        else{
            $nextSection.find('.item-content').removeClass('hide');
        }
    });
    
    //выбрать город
    $('select[name="city_id"]').change(function () {
        var city_id = $(this).val(),
            $parent = $(this).parents('.section'),
            shop_id = location.pathname.split('/')[2]
        
        if(city_id != 0){
           $.ajax({
                beforeSend: function () {
                    $('#loader').addClass('active');
                },
                url: '/order/getDistricts/',
                type: 'GET',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    city_id: city_id,
                    shop_id: shop_id
                },
                complete: function () {
                    $('#loader').removeClass('active');
                },
                success: function (data){
                    if(data.districts.length){
                        var districtsOptionTmpl = '<option></option>';
                        $(data.districts).each(function( key, val) {
                            if(val.price != null){
                                districtsOptionTmpl += '<option value="'+val.district_id+'">'+val.districts_title+'</option>';
                            }
                        });
                        $('select[name="district_id"]').html(districtsOptionTmpl)
                        $('#district').removeClass('hide')
                    }
                    else{
                        toastr.warning('В этом городе нет районов, в котором работал бы этот продавец');
                    }
                }
            });
        }  
    });
    
    //выбираем район
    $('select[name="district_id"]').change(function(){
        var $this = $(this),
            district_id = $this.val(),
            $parent = $this.parents('.section'),
            shop_id = location.pathname.split('/')[2]
        
        if(district_id != 0){
           $.ajax({
                beforeSend: function (){
                    $('#loader').addClass('active');
                },
                url: '/order/getDelivery/',
                type: 'GET',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    district_id: district_id,
                    shop_id: shop_id
                },
                complete: function(){
                    $('#loader').removeClass('active');
                },
                success: function(data){
                    if(data.delivery){
                        var delivery = data.delivery,
                            districts_min_price = data.districts_min_price,
                            free_shipping = parseInt(delivery.data.free_shipping.price),
                            rate_shipping = parseInt(delivery.data.rate_shipping.price),
                            total = parseInt(data.total)
                        
                        if(parseInt(districts_min_price.price) >= total){
                            var message = '<div class="text-yellow m-sm-t">Минимальная сумма заказа для данного региона составляет <b>'+districts_min_price.price.toLocaleString()+' ₸</b> <br/> У вас <b>'+total.toLocaleString()+'</b> ₸ Закажите ещё что-нибудь.</div>';
                            $this.siblings('.district-message').html(message);
                            
                            $parent.find('.onwards').removeClass('btn-blue').addClass('btn-secondary disable-link');
                        }
                        else{
                            $this.siblings('.district-message').html('')
                            $parent.find('.onwards').removeClass('btn-secondary disable-link').addClass('btn-blue');
                        }
                        
                        if(free_shipping <= total){
                            $('#rate_shipping').text(0)
                            $('#rate-shipping-val').val(0)
                            $('#total-price').text((parseInt($('#order-price-val').val()) + parseInt($('#rate-shipping-val').val())).toLocaleString());
                            //$('[name="delivery"]').val('Курьерская доставка 0 тг.')
                        }
                        else{
                            if(delivery.data.rate_shipping.price){
                                $('#rate-shipping-val').val(delivery.data.rate_shipping.price)
                                $('#rate_shipping').text(delivery.data.rate_shipping.price.toLocaleString())
                                
                                //складываем сумму заказа и доставки, затем отображаем
                                $('#total-price').text((parseInt(delivery.data.rate_shipping.price) + parseInt($('#order-price-val').val())).toLocaleString());
                            }
                            else{
                                $('#rate_shipping').text($('#rate-shipping-val').val().toLocaleString())
                                $('#total-price').text((parseInt($('#order-price-val').val()) + parseInt($('#rate-shipping-val').val())).toLocaleString());
                            }
                        }
                    }
                }
            });
        }
    });
    
    /*$('input[name="street"]').on('keyup', function () {
        if($(this).val().length >= 1){
            removeAlertMessage($addressOrder, 'street');
        }
        else{
            errorAlertMessage.push({text:'Укажите район', obj:$addressOrder, type:'danger', className:'district'});
            addAlertMessage(errorAlertMessage);
            errorAlertMessage = [];
        }
    });*/
    
    //Оплата
    $paymentOrder.on('click', '.onwards', function () {
        if($(this).hasClass('disable-link')){
            return;
        }
        
        var $parent = $(this).parents('.section'),
            payment = $parent.find('input[name="payment_id"]:checked').attr('title'),
            error = false;
        
        if(!payment){
            $('[name="payment_id"]')[0].reportValidity(); 
            error = true;
        }
        
        if(error) return;
        
        $parent.find('.section-field')
                    .addClass('hide')
                    .parents('.section')
                    .find('.section-preiew')
                    .removeClass('hide')
                    .find('b')
                    .text(payment)
                    .parents('.section')
            .find('.title').addClass('text-green').parents('.section').next('.section').find('.item-content').removeClass('hide');
    });
    
    //Покупатель
    $buyerOrder.on('click', '.onwards', function (e) {
        if($(this).hasClass('disable-link')){
            return;
        }
        
        e.preventDefault();
        
        var $parent = $(this).parents('.section'),
            fio = $parent.find('input[name="fio"]').val(),
            phone = $parent.find('input[name="phone"]').val(),
            error = '';
            
            if(!fio){
                $('[name="fio"]')[0].reportValidity(); 
                error = true;
            }
            
            if(!phone){
                $('[name="phone"]')[0].reportValidity(); 
                error = true;
            }

            if(error) return;
        
        $(this).attr('disabled', 'disabled')
        $orderForm.submit(); 
    });
    
    //Назад
    $('.back').on('click', function () {
        var $parent = $(this).parents('.section');
        
        var $prevSection = $parent.find('.item-content')
                    .addClass('hide')
                    .parents('.section')
                    .prev('.section')
                    
            
        if($prevSection.hasClass('hide')){
            $prevSection = $prevSection.prev()
        }
        
        $prevSection.find('.title')
                .removeClass('text-green')
                .parents('.section')
                .find('.section-field')
                .removeClass('hide')
                .siblings('.section-preiew')
                .addClass('hide');
        
    });

}(jQuery));