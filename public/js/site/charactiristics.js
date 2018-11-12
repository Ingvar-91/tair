var Charactiristics = (function ($) {
    
    var page = location.pathname.split('/').slice(2)[0],
        product_id = $('#product_id').val()
    
    var $charName = $('#characteristics-name');
    
    //при нажатии на категорию, получить список характеристик
    $("body").on('click', 'input[name="category_id"]', function () {
        var category_id = $(this).val()
        if(category_id){
            getCharName(category_id);
        }
    });
    
    //добавить
    $("#add-characteristics-name").on('click', function () {
        var category_id = $('input[name="category_id"]:radio:checked').val(),
            shop_id = $('input[name="shop_id"]').val();

        if(category_id && shop_id){
            swal({
                title: "",
                text: "Введите наименование поля для характеристики",
                type: "input",
                showCancelButton: true,
                cancelButtonText: 'Отмена',
                confirmButtonText: 'Создать',
                closeOnConfirm: true,
                inputPlaceholder: "Наименование"
            },
            function (name) {
                if(name === false) return false;
                if (!name) {
                    toastr.error('Вы не ввели наименование для поля!');
                    //showPNotify('error', 'Ошибка', 'Вы не ввели наименование для поля!');
                    return false;
                }
                $.ajax({
                    beforeSend: function () {
                        $('#loader').addClass('active');
                    },
                    url: '/products-vendor/characteristics-name/add',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: name,
                        category_id: category_id,
                        shop_id: shop_id,
                        shop_type_id: $('#shop_type_id').val()
                    },
                    complete: function () {
                        $('#loader').removeClass('active');
                    },
                    success: function (data) {
                        if (data.error == false) {
                            toastr.success('Данные успешно добавлены');
                            //showPNotify('success', 'Готово', 'Данные успешно добавлены');
                            getCharName(category_id);
                        } 
                        else{
                            toastr.error('Ошибка при добавлении данных');
                            //showPNotify('error', 'Ошибка', 'Ошибка при добавлении данных');
                        }
                    }
                });
            });
        }
    });
    
    //удалить
    /*$("#remove-characteristics-name").on('click', function(){
        var ids = $charName.find('.chars-ckeckbox:checked').map(function(){
            return $(this).val();
        }).get();
        var category_id = $('#categories input[type="radio"]:radio:checked').val();
        
        if(ids.length){
            $.ajax({
                beforeSend: function (){
                    $('#loader').addClass('active');
                },
                url: '/products-vendor//characteristics-name/remove',
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    ids: ids
                },
                complete: function () {
                    $('#loader').removeClass('active');
                },
                success: function (data) {
                    if (data.error == false) {
                        showPNotify('success', 'Готово', 'Данные успешно удалены');
                        getCharName(category_id);
                    } 
                    else showPNotify('error', 'Ошибка', 'Ошибка при удалении данных');
                }
            });
        }
    });*/
    
    //редактировать
    $('body').on('click', '.edit-characteristics-name', function () {
        var $this = $(this),
            id = $this.attr('data-id'),
            category_id = $('#categories input[type="radio"]:radio:checked').val();
        
        if(id){
            swal({
                title: "",
                text: "Введите новое наименование",
                type: "input",
                showCancelButton: true,
                cancelButtonText: 'Отмена',
                confirmButtonText: 'Обновить',
                closeOnConfirm: true,
                inputValue: $this.attr('data-name')
            },
            function (name) {
                if(name === false) return false;
                if (!name) {
                    toastr.error('Вы не ввели наименование для поля!');
                    //showPNotify('error', 'Ошибка', 'Вы не ввели наименование для поля!');
                    return false;
                }
                $.ajax({
                    beforeSend: function () {
                        $('#loader').addClass('active');
                    },
                    url: '/products-vendor/characteristics-name/edit',
                    type: 'PUT',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: name,
                        id: id
                    },
                    complete: function () {
                        $('#loader').removeClass('active');
                    },
                    success: function (data) {
                        if (data.error == false) {
                            toastr.success('Данные успешно обновлены');
                            //showPNotify('success', 'Готово', 'Данные успешно обновлены');
                            getCharName(category_id);
                        } 
                        else{
                            toastr.error('Ошибка при обновлении данных');
                            //showPNotify('error', 'Ошибка', 'Ошибка при обновлении данных');
                        }
                    }
                });
            });
            
        }
    });
    
    function getCharName(category_id){
        if(!$charName.find('.characteristics-name').length) return;
        
        $.ajax({
            beforeSend: function (){
                $('#loader').addClass('active');
            },
            url: '/products-vendor/characteristics-name/',
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                category_id: category_id,
                product_id: product_id,
            },
            success: function (data) {
                console.log(data)
                if(!data.charName.length) $charName.find('.characteristics-name').text('Нет данных')
                else{
                    var tmpl = ejs.render($('#characteristics-name-ejs').html(), {charName: data.charName});
                    $charName.find('.characteristics-name').html(tmpl)
                }
                $('#loader').removeClass('active');
                $charName.find('.characteristics-name-control').removeClass('hide')
                $charName.find('.warning').addClass('hide')
                
                //
                $('.tokenfield-char').each(function( key, el){
                    var prop = [],
                        $el = $(el),
                        obj = {};
                        
                    if($el.attr('data-child')){
                        obj = JSON.parse($el.attr('data-child'))
                        
                        for (var i = 0; i < obj.length; i++) {
                            prop[i] = {id:obj[i].id, parent_id:obj[i].parent_id, value:obj[i].name}
                        }

                        if(prop.length){
                            var engine = new Bloodhound({
                                local: prop,
                                datumTokenizer: function(d) {
                                    return Bloodhound.tokenizers.whitespace(d.value);
                                },
                                queryTokenizer: Bloodhound.tokenizers.whitespace
                            });
                            engine.initialize();

                            $el.tokenfield({
                                createTokensOnBlur: true,
                                delimiter: ['|', ','],
                                typeahead: [null, { source: engine.ttAdapter() }]
                                //showAutocompleteOnFocus:!0,
                            });

                            //
                            if($($el).attr('data-value')){
                                var value = JSON.parse($($el).attr('data-value'))
                                if(value.length){
                                    var arr = [];
                                    $(value).each(function( i, val) {
                                        arr[i] = { id:val.id, parent_id:val.parent_id, value:val.name }
                                    });
                                    $el.tokenfield('setTokens', arr);
                                }
                            }
                        }
                    }
                    else{
                        $el.tokenfield({
                            createTokensOnBlur: true,
                            delimiter: ['|', ',']
                            //showAutocompleteOnFocus:!0,
                        });
                    }
                });
                
            }
        });
    }

    function clearCharName(){
        $charName.find('.characteristics-name').html('')
        $charName.find('.characteristics-name-control').addClass('hide')
        $charName.find('.warning').removeClass('hide')
    }
    
    $charName.on('focus', 'input', function () {
        $(this).siblings('.dropdown-char-name').addClass('open')
    });
    
    $charName.on('blur', 'input', function (e) {
        if(!$(e.relatedTarget).is('a')){
            $(this).siblings('.dropdown-char-name').removeClass('open')
        }
    });
    
    $charName.on('keyup', 'input', function () {
        var $this = $(this),
            searchWord = $this.val(),
            list = $this.parents('.input-group').find('.dropdown-menu >');
        
        $this.parents('.input-group').find('.dropdown-menu >').removeClass('hide')
        if(list.length){
            var exp = new RegExp(searchWord,'i'),
                result = false;
            $.each(list, function (key, val) {
                result = $(val).find('a').text().search(exp);
                if(result < 0){
                    $(val).addClass('hide')
                }
            });
        }
    });
    
    $charName.on('click', '.dropdown-menu > li > a', function (e) {
        e.preventDefault();
        var $this = $(this),
            $targetInput = $this.parents('.input-group').find('input.char-filed'),
            targetInputNewAttr = $targetInput.attr('name').substring(16);
            
        var attr = targetInputNewAttr.substring(0, targetInputNewAttr.length - 1).split('|');//первое значение parent_id характеристики, второе значение id
        attr[1] = $this.attr('data-id');
        $targetInput.val($this.attr('data-name')).attr('name', 'characteristics['+attr[0]+'|'+attr[1]+']').siblings('.dropdown-char-name').removeClass('open');
    });
    
    $charName.on('keyup', '.char-filed', function (event) {
        if (event.ctrlKey && event.keyCode == 65){//ctrl + a
            return;
        }
        
        if (event.ctrlKey && event.keyCode == 67){//ctrl + c
            return;
        }

        var $targetInput = $(this);
        
        var targetInputNewAttr = $targetInput.attr('name').substring(16),
            attr = targetInputNewAttr.substring(0, targetInputNewAttr.length - 1).split('|');//первое значение parent_id характеристики, второе значение id
        attr[1] = '';
        
        if($(this).attr('data-value') == $(this).val()){
            attr[1] = $(this).attr('data-id');
        }
        
        $targetInput.attr('name', 'characteristics['+attr[0]+'|'+attr[1]+']');
    });
    
    //char-filed
    
    return {
        clearCharName:function(){//получить характеристики и их значение
            return clearCharName();
        },
        getCharName:function(category_id){
            return getCharName(category_id);
        }
    }

    
})(jQuery);