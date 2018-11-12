(function ($) {
    
    var $productImages = $('#product-images')
    
    if ($('.daterange').length) {
        initDateRangePicker();
    }
    
    var $form = $('#product-form'),
        $dropzoneProduct = [];
    
    //инициализируем dropzone
    initDropzoneImageProduct();
    var el = document.getElementById('product-images');
    if(el){
        Sortable.create(el);
    }

    Dropzone.autoDiscover = false;

    function initDropzoneImageProduct(){
        var images = $productImages.attr('data-images'),
            path = $productImages.attr('data-path');
    
        $dropzoneProduct = $productImages.dropzone({
            maxFiles: 9,
            maxFilesize: 15,
            addRemoveLinks: true,
            //autoQueue: false,//автозагрузка
            acceptedFiles: "image/jpeg,image/png,image/gif",
            url: '/products-vendor/uploadFiles',
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
                    url: '/products-vendor/removeImageProduct',
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
    
    //
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
            toastr.warning('Укажите цену');
            //showPNotify('warning', 'Внимание', 'Укажите цену')
            error = true
        }*/
        if(!formData.get('title')){
            toastr.warning('Заголовок отсутствует');
            //showPNotify('warning', 'Внимание', 'Заголовок отсутствует')
            error = true
        }
        if(!formData.get('category_id')){
            toastr.warning('Выберите категорию');
            //showPNotify('warning', 'Внимание', 'Выберите категорию')
            error = true
        }
        
        if(!formData.get('shop_id')){
            toastr.warning('Выберите магазин');
            //showPNotify('warning', 'Внимание', 'Выберите магазин')
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
            url: '/products-vendor/edit',
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
                    //Charactiristics.getCharName($('[name="category_id"]:checked').val());
                    toastr.success('Запись успешно обновлена');
                }
                else{
                    toastr.error('Ошибка при обновлении записи');
                }
            }
        });
        
    });
    
    //
    $('#add-submit').on('click', function (){
        var $this = $(this),
            formData = new FormData($form[0]),
            error = false
            
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
            toastr.warning('Укажите цену');
            //showPNotify('warning', 'Внимание', 'Укажите цену')
            error = true
        }*/
        if(!formData.get('title')){
            toastr.warning('Заголовок отсутствует');
            //showPNotify('warning', 'Внимание', 'Заголовок отсутствует')
            error = true
        }
        if(!formData.get('category_id')){
            toastr.warning('Выберите категорию');
            //showPNotify('warning', 'Внимание', 'Выберите категорию')
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
            url: '/products-vendor/add',
            type: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                if(data.error == false){
                    toastr.success('Запись успешно добавлена');
                    $form[0].reset();
                    Chars.clearChars();
                    
                    $productImages[0].dropzone.files.forEach(function(file){ 
                        file.previewElement.remove(); 
                    });
                    $productImages.removeClass('dz-started');
                }
                else{ 
                    toastr.error('Ошибка при добавлении записи');
                }
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


})(jQuery);