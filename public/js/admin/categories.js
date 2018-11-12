var Categories = (function ($) {

    var page = location.pathname.split('/')[2],
        current_category_id = $('#current_category_id').val(),
        product_id = $('#product_id').val()

    //получение шаблона категории и вставка его на страницу
    if ($('#categories').length) {
        getCategories();
    }
    
    //открыть/закрыть категорию
    $('#categories').on('click', '.name-categories', function(e) {
        $(this).parentsUntil('.category-item').siblings('.item-ul').slideToggle()
    });

    //добавить категорию
    $('#categories').on('click', '.add-category', function () {
        var $this = $(this),
            id = $this.attr('data-id');

        swal({
            title: "",
            text: "Введите наименование категории",
            type: "input",
            showCancelButton: true,
            cancelButtonText: 'Отмена',
            confirmButtonText: 'Создать',
            closeOnConfirm: true,
            inputPlaceholder: "Наименование категории"
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
                url: '/admin/categories/add',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    title: title,
                    parent_id: id
                },
                complete: function () {
                    $('#loader').removeClass('active');
                },
                success: function (data) {
                    if (data.error == false) {
                        showPNotify('success', 'Готово', 'Запись успешно добавлена');
                        getCategories();
                    } else
                        showPNotify('error', 'Ошибка', 'Ошибка при добавлении записи');
                }
            });
        });
    });

    //удалить категорию
    $('#categories').on('click', '.remove-category', function () {
        var $this = $(this),
            id = $(this).attr('data-id');

        swal({
            title: 'Вы уверены?',
            text: 'Так же будут удалены все подкатегории, если они имеются.',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Да',
            cancelButtonText: 'Отмена',
            closeOnConfirm: true,
            closeOnCancel: true,
        }, function () {
            
            $.ajax({
                beforeSend: function () {
                    $('#loader').addClass('active');
                },
                url: '/admin/categories/remove',
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: id
                },
                complete: function () {
                    $('#loader').removeClass('active');
                },
                success: function (data) {
                    if (data.error == false) {
                        showPNotify('success', 'Готово', 'Запись успешно удалена');
                        getCategories();
                        
                        //очищаем значения характеристик, если удаляетя категория которая выбрана в данный момент
                        if($this.parents('.radio').find('input[type="radio"]').prop("checked") == true){
                            Charactiristics.clearCharName();
                        }
                    } else
                        showPNotify('error', 'Ошибка', 'Ошибка при удалении записи');
                }
            });
        });
    });

    //открыть окно редактирования категории
    $('#categories').on('click', '.edit-category', function () {
        var id = $(this).attr('data-id');

        $.ajax({
            beforeSend: function () {
                $('#loader').addClass('active');
            },
            url: '/admin/categories/getCategory',
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: id
            },
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                console.log(data)
                if (data.error == false) {
                    var tmpl = ejs.render($('#category-edit-ejs').html(), {categories: data.categories, strip:''});
                    $('#category-edit-wd-select').html(tmpl).prepend('<option value="0">---</option>')

                    $('#category-edit-wd-id').val(data.category.id)
                    $('#category-edit-wd-name').val(data.category.title)
                    $('#category-edit-wd-select option[value=' + data.category.parent_id + ']').attr('selected', 'selected');
                    $('#category-edit-wd').modal('show')
                } 
                else showPNotify('error', 'Ошибка', 'Ошибка при получении записи');
            }
        });
    });

    $('#category-save').on('click', function () {
        var $this = $(this),
            title = $('#category-edit-wd-name').val(),
            parent_id = $('#category-edit-wd-select').val(),
            id = $('#category-edit-wd-id').val(),
            formData = new FormData($('#category-edit-form')[0])
        
        $.ajax({
            beforeSend: function (){
                $('#loader').addClass('active');
            },
            headers:{
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/categories/edit',
            type: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                console.log(data)
                if(data.warning){
                    showPNotify('warning', 'Внимание', data.message);
                    return;
                }
                if(data.error == false){
                    document.getElementById("category-edit-input-file").value = "";
                    showPNotify('success', 'Готово', 'Данные успешно обновлены');
                    $('#category-edit-wd').modal('hide');
                    getCategories();
                }
                else showPNotify('error', 'Ошибка', 'Ошибка при обновлении данных');
            }
        });

        /*$.ajax({
            beforeSend: function () {
                $('#loader').addClass('active');
            },
            headers:{
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/categories/huita',
            type: 'PUT',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: id,
                parent_id: parent_id,
                title: title
            },
            data: formData,
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                console.log(data)
                if(data.warning){
                    showPNotify('warning', 'Внимание', data.message);
                    return;
                }
                if(data.error == false){
                    showPNotify('success', 'Готово', 'Данные успешно обновлены');
                    $('#category-edit-wd').modal('hide');
                    getCategories();
                }
                else showPNotify('error', 'Ошибка', 'Ошибка при обновлении данных');
            }
        });*/
        
    });

    function getCategories() {
        $('#categories').find('.categories-list').html('');
        $.ajax({
            beforeSend: function () {
                $('#categories').find('.categories-loader').removeClass('hide')
            },
            url: '/admin/categories',
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                page: page
            },
            complete: function () {
                $('#categories').find('.categories-loader').addClass('hide')
            },
            success: function (data) {
                if (data.error == false) {
                    var tmpl = ejs.render($('#categories-ejs').html(), {categories: data.categories, current_category_id:current_category_id});
                    $('#categories').find('.categories-list').html(tmpl);
                    
                    Chars.initSelectPicker();
                    /*if(current_category_id && product_id){//если имеется категория и id товара, вытаскиваем шаблон характеристик
                        Charactiristics.getCharName(current_category_id);
                    }*/
                }
            }
        });
    }

})(jQuery);