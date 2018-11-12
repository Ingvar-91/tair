(function ($) {
    
    var instancesCKeditor = 'text',
        $form = $('#news-form');
        
    CKEDITOR.replace( instancesCKeditor,{
        //filebrowserBrowseUrl : '/admin/news/getImages?dir=/img/ckeditor/&_token='+$('meta[name="csrf-token"]').attr('content'),
        filebrowserUploadUrl : '/admin/news/addImage?_token='+$('meta[name="csrf-token"]').attr('content'),
    });
    
    //
    $('#edit-submit').on('click', function (){
        var $this = $(this),
            formData = new FormData($form[0]),
            error = false
            
            formData.set('text', CKEDITOR.instances[instancesCKeditor].getData());
            
            if(!formData.get('title')){
                showPNotify('warning', 'Внимание', 'Заголовок отсутствует')
                error = true
            }
            if(!formData.get('text')){
                showPNotify('warning', 'Внимание', 'Добавьте текст')
                error = true
            }

            if(error) return;
        
        $.ajax({
            beforeSend: function (){
                $('#loader').addClass('active');
            },
            headers: {
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
                console.log(data)
                if(data.error == false){
                    showPNotify('success', 'Готово', 'Запись успешно обновлена');
                }
                else showPNotify('error', 'Ошибка', 'Ошибка при обновлении записи');
            }
        });
    });
    
    //
    $('#add-submit').on('click', function (){
        var $this = $(this),
            formData = new FormData($form[0]),
            error = false
            
        formData.set('text', CKEDITOR.instances[instancesCKeditor].getData());
         
        if(!formData.get('title')){
            showPNotify('warning', 'Внимание', 'Заголовок отсутствует')
            error = true
        }
        if(!formData.get('text')){
            showPNotify('warning', 'Внимание', 'Добавьте текст')
            error = true
        }
        if(!document.getElementById('images').files.length){
            showPNotify('warning', 'Внимание', 'Добавьте изображение')
            error = true
        }
        
        if(error) return;

        $.ajax({
            beforeSend: function (){
                $('#loader').addClass('active');
            },
            headers: {
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
                if(data.error == false){
                    showPNotify('success', 'Готово', 'Запись успешно добавлена');
                    $form[0].reset();
                    CKEDITOR.instances[instancesCKeditor].setData('');
                    clearImagePreview();
                }
                else showPNotify('error', 'Ошибка', 'Ошибка при добавлении записи');
            }
        });
    });
    
    //превью изображений
    $('#images').on('change', function (e){
        clearImagePreview();
        
        var files = e.target.files,
            tmpl = '';
        for (var i = 0, f; f = files[i]; i++) {
            if (!f.type.match('image.*')) {
              continue;
            }

            var reader = new FileReader();
            reader.onload = (function(theFile) {
              return function(e){
                  var tmpl = ejs.render($('#images-ejs').html(), {src:e.target.result, title:theFile.name});
                  $('#images-preview').append(tmpl);
              };
            })(f);
            reader.readAsDataURL(f);
        }
    });
    
    function clearImagePreview(){
        $('#images-preview').text('');
    }

})(jQuery);