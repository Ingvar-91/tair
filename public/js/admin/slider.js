(function ($) {
    
    var $dropzoneProduct,
        $detailProduct = $('#detail-product'),
        $productImages = $('#images')
    
    //инициализируем dropzone
    initDropzoneImageProduct();
    var el = document.getElementById('images');
    if(el){
        Sortable.create(el);
    }

    Dropzone.autoDiscover = false;
    
    function initDropzoneImageProduct(){
        var images = $productImages.attr('data-images'),
            path = $productImages.attr('data-path');
    
        $dropzoneProduct = $productImages.dropzone({
            maxFiles: 99,
            maxFilesize: 15,
            addRemoveLinks: true,
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
                var tmpl = '<input type="hidden" name="dz_image_name[]" class="dz-image-name" value="'+response.fileName+'" />';

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
                             var tmpl = '<input type="hidden" class="dz-image-name" name="dz_image_name[]" value="'+image+'" />';

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
                console.log(response)
                console.log(xhr)
                alert("Не удалось загрузить файл.");
                this.removeFile(file);
            }
        })
    }
    
    //обновить слайдер
    $('#update-slider').on('click', function (){
        var $images = $($dropzoneProduct).find('.dz-image-name'),
            images = [],
            id = $productImages.attr('data-id')
            
        if($images.length){
            $images.each(function( i, image){
                if($(image).val()){
                    images[i] = $(image).val();
                }
            });
        }
        
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
                images: images,
                id: id
            },
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                console.log(data)
                if(data.error == false){
                    showPNotify('success', 'Готово', 'Запись успешно обновлена');
                }
                else showPNotify('error', 'Ошибка', 'Ошибка при обновлении записи');
            }
        });
    });

})(jQuery);