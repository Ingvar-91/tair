(function ($) {
    
    //var instancesCKeditor = 'text'
    var $form = $('#product-form'),
        $dropzoneProduct,
        $detailProduct = $('#detail-product'),
        $productImages = $('#product-images')
    
    /*CKEDITOR.replace( instancesCKeditor,{
        //filebrowserBrowseUrl : '/admin/products/getImages?dir=/img/ckeditor/&_token='+$('meta[name="csrf-token"]').attr('content'),
        //filebrowserUploadUrl : '/admin/products/addImage?_token='+$('meta[name="csrf-token"]').attr('content'),
    });*/
    
    //фильтрация товаров по бутику
    $('#shop_id').change(function () {
        var shop_id = $(this).val();
        $(dataTableAdditionalData).each(function( key, val) {
            if(val.name == 'shop_id'){
                val.value = shop_id
            }
        });
        DataTables.draw();
    });
    
    //фильтрация товаров по категории
    $('#category_id').change(function () {
        var category_id = $(this).val();
        $(dataTableAdditionalData).each(function( key, val) {
            if(val.name == 'category_id'){
                val.value = category_id
            }
        });
        DataTables.draw();
    });
	
	//
	$('#date_remove').change(function () {
        var date_remove = $(this).val();
        $(dataTableAdditionalData).each(function( key, val) {
            if(val.name == 'date_remove'){
                val.value = date_remove
            }
        });
        DataTables.draw();
    });
    
    //инициализируем dropzone
    if($productImages.length){
        initDropzoneImageProduct();
    }
    var el = document.getElementById('product-images');
    if(el){
        Sortable.create(el);
    }
    
    //
    $('#products').on('click', '.show-gallery-img', function () {
        var dynamicEl = [];
        
        dynamicEl[0] = {thumb:$(this).attr('src'), src:$(this).attr('data-large-img')}
        
        $(this).lightGallery({
            dynamic: true,
            download: false,
            share: false,
            thumbnail: true,
            showThumbByDefault: true,
            dynamicEl: dynamicEl
        });
    });
    
    //получить подробные данные о товаре
    $('body').on('click', '.get-detail', function (){
        var shop_type_id = $(this).attr('data-shop_type_id'),
            id = $(this).attr('data-id')
        
        $.ajax({
            beforeSend: function () {
                $('#loader').addClass('active');
            },
            headers:{
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/'+location.pathname.split('/')[2]+'/getProductInfo',
            type: 'GET',
            data: {
                shop_type_id: shop_type_id,
                id: id
            },
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function(data){
                data = data.data;
                console.log(data)
                
                $detailProduct.find('.modal-title').text(data.product.title)
                $detailProduct.find('.publish-product').attr('data-id', data.product.id)
                if(data.product.status == 1){
                    $detailProduct.find('.publish-product').removeClass('hide')
                }
                else{
                    $detailProduct.find('.publish-product').addClass('hide')
                }
                var tmpl = ejs.render($('#product-detail-ejs').html(), {product:data.product, path:data.path});
                $detailProduct.find('.modal-body').html(tmpl)
                $detailProduct.modal('show')
            }
        });
    });
    
    //опубликовать
    $('body').on('click', '.publish-product', function (){
        var id = $(this).attr('data-id'),
            status = $(this).attr('data-status')
        
        $.ajax({
            beforeSend: function () {
                $('#loader').addClass('active');
            },
            headers:{
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/'+location.pathname.split('/')[2]+'/editStatus',
            type: 'PUT',
            data: {
                id: id,
                status: status,
            },
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                console.log(data)
                if(data.error == false){
                    showPNotify('success', 'Готово', 'Запись успешно опубликована');
                    $detailProduct.modal('hide')
                    DataTables.UpdateRow();
                }
                else showPNotify('error', 'Ошибка', 'Ошибка при обновлении записи');
            }
        });
    });
    
    function initDropzoneImageProduct(){
        Dropzone.autoDiscover = false;
        
        var images = $productImages.attr('data-images'),
            path = $productImages.attr('data-path');
    
        $dropzoneProduct = $productImages.dropzone({
            maxFiles: 9,
            maxFilesize: 15,
            addRemoveLinks: true,
            //autoQueue: false,//автозагрузка
            acceptedFiles: "image/jpeg,image/png,image/gif",
            url: '/admin/'+location.pathname.split('/')[2]+'/uploadFiles',
            dictMaxFilesExceeded: "Максимальное количество файлов 9",
            dictInvalidFileType: "Только формат JPG/PNG/GIF",
            dictDefaultMessage: 'Перенесите сюда файлы для загрузки',
            dictFileTooBig: "Размер файла слишком большой, максимальный размер составляет {{maxFilesize}} МБ",
            dictRemoveFile: "Удалить",
            createImageThumbnails: false,
            headers: {
                'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (file, response){
                //удаляем вставленное превью
                file.previewElement.parentNode.removeChild(file.previewElement);
                
                //добавляем наше превью
                var file = { name: response.fileName, status: Dropzone.ADDED, accepted: true, kind: "image" };
                var tmpl = '<input type="hidden" class="dz-image-name" value="'+response.fileName+'" />';

                this.emit("addedfile", file);                                
                this.emit("thumbnail", file, path+response.fileName);
                this.emit("complete", file);
                this.files.push(file);
                $(file.previewElement).append(tmpl);
            },
            removedfile: function(file) {
                //удаление файла
                $.ajax({
                    beforeSend: function () {
                        $('#loader').addClass('active');
                    },
                    headers:{
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/admin/'+location.pathname.split('/')[2]+'/removeImageProduct',
                    type: 'DELETE',
                    data: {
                        image: file.name
                    },
                    complete: function () {
                        $('#loader').removeClass('active');
                    },
                    success: function (data) {
                        
                    }
                });
                file.previewElement.remove();
            },
            init:function(){
                var thisEl = this;
                if(images){
                    $(images.split('|')).each(function( key, image) {
                        if(image){
                             var file = { name: image, status: Dropzone.ADDED, accepted: true, kind: "image" };
                             var tmpl = '<input type="hidden" class="dz-image-name" value="'+image+'" />';

                             thisEl.emit("addedfile", file);                                
                             thisEl.emit("thumbnail", file, path+image);
                             thisEl.emit("complete", file);
                             thisEl.files.push(file);
                             $(file.previewElement).append(tmpl);
                        }
                    });
                }
            },
            error : function(file,response, xhr) {
                alert("Не удалось загрузить файл.");
                this.removeFile(file);
            }
        })
    }
    
    //редактировать товар
    $('#edit-submit').on('click', function (){
        var $this = $(this),
            formData = new FormData($form[0]),
            error = false
        
        var chars = [];
        $('#chars-list .char').each(function( i, el){
            if($(el).val()){
                chars.push($(el).val())
            }
        });
        console.log(chars)
        formData.set('chars', JSON.stringify(chars));
        
        var $images = $($dropzoneProduct).find('.dz-image-name'),
            images = [];
            
        if($images.length){
            $images.each(function( i, image){
                if($(image).val()){
                    images[i] = $(image).val();
                }
            });
        }
        
        formData.set('images', JSON.stringify(images));
        
        /*if(!formData.get('price')){
            showPNotify('warning', 'Внимание', 'Укажите цену')
            error = true
        }*/
        
        if(!formData.get('title')){
            showPNotify('warning', 'Внимание', 'Заголовок отсутствует')
            error = true
        }
        if(!formData.get('category_id')){
            showPNotify('warning', 'Внимание', 'Выберите категорию')
            error = true
        }
        
        if(!formData.get('shop_id')){
            showPNotify('warning', 'Внимание', 'Выберите магазин')
            error = true
        }
        
        if(error) return;
        //return;
        
        $.ajax({
            beforeSend: function (){
                $('#loader').addClass('active');
            },
            headers:{
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/'+location.pathname.split('/')[2]+'/edit',
            type: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                if(data.error == false){
                    showPNotify('success', 'Готово', 'Запись успешно обновлена');
                }
                else showPNotify('error', 'Ошибка', 'Ошибка при обновлении записи');
            }
        });
        
    });
    
    //добавить товар
    $('#add-submit').on('click', function (){
        var $this = $(this),
            formData = new FormData($form[0]),
            error = false;
            
        var chars = [];
        $('#chars-list .char').each(function( i, el){
            if($(el).val()){
                chars.push($(el).val())
            }
        });
        formData.set('chars', JSON.stringify(chars));
        
        var $images = $($dropzoneProduct).find('.dz-image-name'),
            images = [];
            
        if($images.length){
            $images.each(function( i, image){
                if($(image).val()){
                    images[i] = $(image).val();
                }
            });
        }
        
        formData.set('images', JSON.stringify(images));
        
        /*if(!formData.get('price')){
            showPNotify('warning', 'Внимание', 'Укажите цену')
            error = true
        }*/
        
        if(!formData.get('title')){
            showPNotify('warning', 'Внимание', 'Заголовок отсутствует')
            error = true
        }
        if(!formData.get('category_id')){
            showPNotify('warning', 'Внимание', 'Выберите категорию')
            error = true
        }
        
        if(error) return;

        $.ajax({
            beforeSend: function (){
                $('#loader').addClass('active');
            },
            headers:{
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/'+location.pathname.split('/')[2]+'/add',
            type: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                console.log(data)
                if(data.error == false){
                    showPNotify('success', 'Готово', 'Запись успешно добавлена');
                    $form[0].reset();
                    Chars.clearChars();
                    
                    $productImages[0].dropzone.files.forEach(function(file){ 
                        file.previewElement.remove(); 
                    });
                    $productImages.removeClass('dz-started');
                }
                else showPNotify('error', 'Ошибка', 'Ошибка при добавлении записи');
            }
        });
    });
    
    //отображаем поле выбора даты окончания скидки
    $('input[name="discount"]').on('keyup', function () {
        if($(this).val().length > 0){
            $('input[name="start_discount"]').parent().removeClass('hide')
            $('input[name="end_discount"]').parent().removeClass('hide')
        }
        else{
            $('input[name="start_discount"]').parent().addClass('hide')
            $('input[name="end_discount"]').parent().addClass('hide')
        }
    });
    
    //вставить данные последней записи
    $('#insert-last-record').on('click', function () {
        var $this = $(this)
        
        $.ajax({
            beforeSend: function (){
                $('#loader').addClass('active');
            },
            headers:{
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/products/getLastProduct',
            type: 'GET',
            data: {
                id: $this.attr('data-id')
            },
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                if(!data.error){
                    var response = data.response;
                    
                    $('[name="title"]').val(response.title)
                    $('[name="text"]').val(response.text)
                    $('[name="price"]').val(response.price)
                    $('[name="discount"]').val(response.discount)
                    $('[name="shop_id"]').filter('[value="'+response.shop_id+'"]').attr('checked', true);
                    
                    $('[name="category_id"]').filter('[value="'+response.category_id+'"]').attr('checked', true).parents('.item-ul').slideDown();
                    
                    Chars.getChars(response.category_id, response.id);
                    
                }
                
            }
        });
    });
    
})(jQuery);