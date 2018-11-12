var Chars = (function ($) {
    
    var page = location.pathname.split('/').slice(2)[0],
        product_id = $('#product_id').val()
        
    //при нажатии на checkbox категории, получить список характеристик
    $("body").on('click', 'input[name="category_id"]', function () {
        var category_id = $('input[name="category_id"]:radio:checked').val();
        
        if(category_id){
            getChars(category_id, product_id);
        }
    });
    
    //выбрать все значения характеристик
    $("body").on('click', '.char-select-all', function () {
        $(this).parents('.form-group').find('.selectpicker').selectpicker('selectAll');
    });
    
    //очистить все значения характеристик
    $("body").on('click', '.char-clear-all', function () {
        $(this).parents('.form-group').find('.selectpicker').selectpicker('deselectAll');
    });
    
    // init selectpicker
    function initSelectPicker(){
        if ($('.selectpicker').length) {
            $('.selectpicker').selectpicker({
                size: 4
            });
        }
    }
    
    function getChars(category_id, product_id){
        
        if(!product_id){
            product_id = $('#product_id').val();
        }
        
        console.log(product_id)
        
        $.ajax({
            beforeSend: function (){
                $('#loader').addClass('active');
            },
            headers:{
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/chars/',
            type: 'GET',
            data: {
                category_id: category_id,
                product_id: product_id,
            },
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                if(data.chars.length){
                    var tmpl = ejs.render($('#chars-ejs').html(), {chars: data.chars});
                    $('#chars-list').html(tmpl);
                    
                    $('#chars').find('.warning').hide();
                    
                    initSelectPicker();
                }
                else{
                    $('#chars-list').html('Характеристики отсутствуют')
                }
            }
        });
    }
    
    $('#chars').find('.chars-tag-edit').each(function( key, el) {
        var $thisEl = $(el),
            child = $thisEl.data('child'),
            array = [];
        
        if(child){
            for (var i = 0; i < child.length; i++) {
                array.push(child[i].title)
            }
        }
        
        $(el).tagEditor({
            initialTags:array,
            forceLowercase: false,
            sortable:true,
            removeDuplicates: true,
            onChange: function(field, editor, tags) {},
            beforeTagSave: function(field, editor, tags, tag, val) {
                var category_id =  $(field).data('category_id'),
                    parent_id =  $(field).data('parent_id'),
                    common =  $(field).data('common'),
                    selected_order =  $(field).data('selected_order')
                
                //если такого тега ещё нет
                if(tags.indexOf(val) == -1){
                    if(tag){//если есть значение значит тег редактируется
                        editTag(tag, val, category_id, parent_id);
                    }
                    else{//если нет значит тег новый
                        addTag(val, category_id, parent_id, common, selected_order);
                    }
                } 
            },
            onChange: function(field, editor, tags){
                var category_id =  $(field).data('category_id'),
                    parent_id =  $(field).data('parent_id')
            
                sortTag(tags, category_id, parent_id);
            },
            beforeTagDelete: function(field, editor, tags, val) {
                var category_id =  $(field).data('category_id'),
                    parent_id =  $(field).data('parent_id')
            
                var q = confirm('Хотите удалить "' + val + '"?');
                if(q){
                    removeTag(val, category_id, parent_id);
                }

                return q;
            }
        });
    });
    
    function addTag(title, category_id, parent_id, common, selected_order){
        if(title){
            $.ajax({
                beforeSend: function () {
                    $('#loader').addClass('active');
                },
                headers:{
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/admin/'+location.pathname.split('/')[2]+'/add',
                type: 'POST',
                data: {
                    title: title,
                    category_id: category_id,
                    parent_id: parent_id,
                    common: common,
                    selected_order: selected_order
                },
                complete: function () {
                    $('#loader').removeClass('active');
                },
                success: function(data){
                    if(data.error == false){
                        showPNotify('success', 'Готово', 'Данные успешно добавлены');
                    }
                    else{
                        showPNotify('error', 'Ошибка', 'Ошибка при добавлении данных');
                    }
                }
            });
        }
    }
    
    function sortTag(tags, category_id, parent_id){
        $.ajax({
            beforeSend: function () {
                $('#loader').addClass('active');
            },
            headers:{
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/'+location.pathname.split('/')[2]+'/sort',
            type: 'PUT',
            data: {
                tags: tags,
                category_id: category_id,
                parent_id: parent_id
            },
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function(data){
                /*if(data.error == false){
                    showPNotify('success', 'Готово', 'Данные успешно обновлены');
                }
                else{
                    showPNotify('error', 'Ошибка', 'Ошибка при обновлении данных');
                }*/
            }
        });
    }
    
    function editTag(oldValue, newValue, category_id, parent_id){
        $.ajax({
            beforeSend: function () {
                $('#loader').addClass('active');
            },
            headers:{
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/'+location.pathname.split('/')[2]+'/edit',
            type: 'PUT',
            data: {
                oldValue: oldValue,
                newValue: newValue,
                category_id: category_id,
                parent_id: parent_id
            },
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function(data){
                if(data.error == false){
                    showPNotify('success', 'Готово', 'Данные успешно обновлены');
                }
                else{
                    showPNotify('error', 'Ошибка', 'Ошибка при обновлении данных');
                }
            }
        });
    }
    
    function removeTag(title, category_id, parent_id){
        $.ajax({
            beforeSend: function () {
                $('#loader').addClass('active');
            },
            headers:{
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/'+location.pathname.split('/')[2]+'/remove',
            type: 'DELETE',
            data: {
                title: title,
                category_id: category_id,
                parent_id: parent_id
            },
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function(data){
                if(data.error == false){
                    showPNotify('success', 'Готово', 'Данные успешно удалены');
                }
                else{
                    showPNotify('error', 'Ошибка', 'Ошибка при удалении данных');
                }
            }
        });
    }
    
    //редактировать родительскую категорию
    $(".edit-parent-category").on('click', function () {
        var $this = $(this),
            id = $this.data('id'),
            title = $this.parent('label').find('.title').text()

        if(id){
            swal({
                title: title,
                text: "Введите новое наименование характеристики",
                type: "input",
                showCancelButton: true,
                cancelButtonText: 'Отмена',
                confirmButtonText: 'Обновить',
                closeOnConfirm: true,
                inputPlaceholder: "Наименование"
            },
            function (title) {
                if(title === false) return false;
                if (!title) {
                    showPNotify('error', 'Ошибка', 'Вы не ввели наименование для поля!');
                    return false;
                }
                
                $.ajax({
                    beforeSend: function () {
                        $('#loader').addClass('active');
                    },
                    headers:{
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/admin/'+location.pathname.split('/')[2]+'/editParent',
                    type: 'PUT',
                    data: {
                        title: title,
                        id: id
                    },
                    complete: function () {
                        $('#loader').removeClass('active');
                    },
                    success: function (data){
                        if(data.error == false){
                            showPNotify('success', 'Готово', 'Данные успешно обновлены');
                            $this.parent('label').find('.title').text(title)
                        }
                        else showPNotify('error', 'Ошибка', 'Ошибка при обновлении данных');
                    }
                });
            });
        }
    });
    
    //сбросить выделение поля характеристики на странице товара
    $('#chars-list').on('click', '.retweet', function () {
        $(this).parents('.form-group').find('select').children('option:selected').prop('selected', false);
    });
    
    //удалить родительскую категорию
    $(".remove-parent-category").on('click', function () {
        var $this = $(this),
            id = $this.data('id')

        if(id){
            swal({
                title: 'Вы уверены?',
                text: 'Удалить?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Да',
                cancelButtonText: 'Нет',
                closeOnConfirm: true,
                closeOnCancel: true,
            }, function () {
                
                $.ajax({
                    beforeSend: function () {
                        $('#loader').addClass('active');
                    },
                    headers:{
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/admin/'+location.pathname.split('/')[2]+'/removeParent',
                    type: 'DELETE',
                    data: {
                        id: id
                    },
                    complete: function () {
                        $('#loader').removeClass('active');
                    },
                    success: function (data){
                        console.log(data)
                        if(data.error == false){
                            showPNotify('success', 'Готово', 'Данные успешно удалены');
                            $this.parents('.form-group').remove()
                        }
                        else showPNotify('error', 'Ошибка', 'Ошибка при удалении данных');
                    }
                });
                
            });

        }
    });
    
    function clearChars(){
        $('#chars-list').html('');
        $('#chars').find('.warning').show();
    }
    
    return {
        clearChars:function(){
            return clearChars();
        },
        getChars:function(category_id, product_id){
            return getChars(category_id, product_id);
        },
        initSelectPicker:function(){
            return initSelectPicker();
        }
    }

})(jQuery);