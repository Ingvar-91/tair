var Mediafile = (function ($) {
    
    if (!String.prototype.trim) {//фанкция trim
        (function() {
            String.prototype.trim = function() {
                return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
            };
        })();
    }

    var $galleryBn = $('#show-media'),
        $galleryWd = $('#media-wd'),
        pathTmpl = '/static-admin/ejs/mediafiles', //путь к директории где хранятся шаблоны для админки
        folderPath = $('#folder-path').val(), //папка корневой директории, с файлами
        breadcrumb,
        select = false;//отображать ли кнопку выбора файлов

    //получить список файлов и каталогов при открытии окна медиафайлов
    $galleryBn.on('click', function (e) {
        e.preventDefault();
        showWdMediafiles();
        select = false;
    });

    //двойной клик по директории
    $('#multimedia').on('dblclick', '.folder', function () {
        var path = $(this).attr('data-dir'),
            nameThisFolder = $(this).find('.name').text().trim();
            showFilesAndDir(path, nameThisFolder);
    });
    
    //клик по хлебным крошкам
    $('#multimedia').on('click', '.breadcrumb > li > a', function(e){
        e.preventDefault();
        var path = $(this).attr('title'),
            nameThisFolder = $(this).text();
            showFilesAndDir(path, nameThisFolder);
    });
    
    //открыть окно медиафайлов и показать файлы
    function showWdMediafiles(){
        $.ajax({
            beforeSend: function () {
                $('#multimedia').html('');
                $galleryWd.find('.loader').show();
            },
            url: '/admin/mediafiles',
            type: 'GET',
            data: {
                _token: $('body').attr('data-csrf')
            },
            complete: function () {
                $galleryWd.find('.loader').hide();
            },
            success: function (data) {
                data = $.parseJSON(data);
                if (data) {
                    //breadcrumb
                    breadcrumb = folderPath.split('/');
                    breadcrumb = _.compact(breadcrumb);//удаляем пустые элементы
                    //
                    data['breadcrumb'] = breadcrumb;
                    data['nameThisFolder'] = folderPath;
                    var tmpl = new EJS({url: pathTmpl + '/folder-and-files.tpl'}).render(data);
                    $('#multimedia').html(tmpl);
                    
                    if(select){//отобразить кнопку выбора файлов
                        $('#select-files-btn').removeClass('hide')
                    }
                } 
                else $('#multimedia').html('<h2>Каталог пуст</h2>');
                $galleryWd.modal('show')
            }
        });
    }
    
    function showFilesAndDir(path, nameThisFolder){
        folderPath = path;
        
        $.ajax({
            beforeSend: function () {
                $('#multimedia').html('');
                $galleryWd.find('.loader').show();
            },
            url: '/admin/mediafiles',
            type: 'GET',
            data: {
                path: path,
                _token: $('body').attr('data-csrf')
            },
            complete: function () {
                $galleryWd.find('.loader').hide();
            },
            success: function (data) {
                data = $.parseJSON(data);
                if (data) {
                    //breadcrumb
                    breadcrumb = path;
                    breadcrumb = breadcrumb.split('/');
                    breadcrumb = _.compact(breadcrumb);//удаляем пустые элементы
                    //
                    //data['pathFiles'] = folderPath;//указываем путь до файлов
                    data['breadcrumb'] = breadcrumb;
                    data['nameThisFolder'] = nameThisFolder;
                    var tmpl = new EJS({url: pathTmpl + '/folder-and-files.tpl'}).render(data);
                    $('#multimedia').html(tmpl);
                    if(select){//отобразить кнопку выбора файлов
                        $('#select-files-btn').removeClass('hide')
                    }
                } 
                else $('#multimedia').html('<h2>Каталог пуст</h2>');
            }
        });
    }

    //двойной клик по файлу
    $('#multimedia').on('dblclick', '.file', function (e) {
        if ($(e.target).hasClass('checkbox')) return;
        else {
            $('#multimedia-image').find('.img').html('')
            var name = $(this).attr('data-name')
            var imgSrc = '/'+folderPath+'/x2-'+name
            
            var img = new Image();
            img.src = imgSrc;
            img.alt = '';
            $('#multimedia-image .filename > span').text(name)
            $('#multimedia-image').fadeIn().find('.img').html(img);
            $('#multimedia').hide();
            $('#x1-image').val('/'+folderPath+'/x1-'+name);
            $('#x2-image').val('/'+folderPath+'/x2-'+name);
            $('#x3-image').val('/'+folderPath+'/x3-'+name);
        }
    });
    
    //клик по файлу
    $('#multimedia').on('click', '.file, .folder', function (e) {
        if ($(e.target).hasClass('checkbox')) return;
        else {
            var $this = $(this)
            if ($this.find('.checkbox').is(':checked')) {
                $this.find('.checkbox').prop('checked', false);
            } 
            else {
                $this.find('.checkbox').prop('checked', true);
            }
        }
    });
    
    //назад к обзору каталогов и файлов
    $('#multimedia-image').on('click', '.back', function () {
        $('#multimedia').fadeIn();
        $('#multimedia-image').hide();
    });

    //удаление файлов/директорий
    $galleryWd.on('click', '#remove-multimedia', function () {
        var checkFilesObj = $('#multimedia .checkbox-file:checked'), //получить все отмеченные файлы
            checkFolderObj = $('#multimedia .checkbox-folder:checked'), //получить все отмеченные директории
            filesArr = [],
            folderArr = [];
        $.each(checkFilesObj, function (key, val) {
            filesArr[key] = $(val).attr('data-name')
        });
        $.each(checkFolderObj, function (key, val) {
            folderArr[key] = $(val).attr('data-name')
        });

        Alerts.Confirm('Вы действительно хотите удалить эти файлы или директории? удаленные файлы нельзя будет вернуть!', function (callback) {
            if (callback) {
                $.ajax({
                    url: '/admin/delete',
                    type: 'DELETE',
                    data: {
                        path: folderPath,
                        filesArr: filesArr,
                        folderArr: folderArr,
                        _token: $('body').attr('data-csrf')
                    },
                    success: function (data) {
                        console.log(data)
                        data = $.parseJSON(data);
                        if (data) {
                            if (data.resultDelFiles == true) {
                                $.each(checkFilesObj, function (key, val) {
                                    $(val).parent('li').remove();
                                });
                            }
                            if (data.resultDelFolder) {
                                $.each(checkFolderObj, function (key, val) {
                                    $(val).parent('li').remove();
                                });
                            }
                        }
                    }
                });
            }
        });
    });

    //добавление директории
    $galleryWd.on('click', '#add-folder', function () {
        Alerts.Prompt('Введите наменование каталога', function (name) {
            if (!name) {
                new PNotify({
                    title: "Ошибка",
                    type: "error",
                    text: "Введите наменование каталога",
                    styling: 'bootstrap3',
                });
                return;
            }
            var regexp = /^[-а-яА-ЯёЁa-zA-Z\d_,.\s]*$/i.test(name);
            if (!regexp){
                new PNotify({
                    title: "Ошибка",
                    type: "error",
                    text: "Только латинские буквы, кирилица, цифры, нижние подчеркивание и тире.",
                    styling: 'bootstrap3',
                });
                return;
            }
            else{
                $.ajax({
                    url: '/admin/create-dir',
                    type: 'POST',
                    data: {
                        name: name,
                        path: folderPath,
                        _token: $('body').attr('data-csrf')
                    },
                    success: function (data){
                        data = $.parseJSON(data);
                        if (data.result) {
                            var dataTmpl = {};
                            dataTmpl['nameDir'] = data.name;
                            dataTmpl['pathDir'] = folderPath+'/'+ data.name;
                            var tmpl = new EJS({url: pathTmpl + '/add-folder.tpl'}).render(dataTmpl);
                            $('#multimedia > ul').prepend(tmpl);
                        } 
                        else{
                            new PNotify({
                                title: "Ошибка",
                                type: "error",
                                text: data.message,
                                styling: 'bootstrap3',
                            });
                        }
                    }
                });
            }
        });
    });

    //открыть поле добавления изображения
    $galleryWd.on('click', '#add-img', function () {
        $('#load-image').fadeIn();
    });

    //закрыть поле добавления изображения
    $galleryWd.on('click', '#close-wd-img', function () {
        $('#load-image').hide();
    });

    /*drug and drop (загрузка изображений)*/
    function sendFileToServer(formData, className) {
        formData.append('_token', $('body').attr('data-csrf'));
        formData.append('path', folderPath);
        formData.append('ratio_images',  $('#ratio-images').find('.active > .radio').val());
        
        var jqXHR = $.ajax({
            url: '/admin/upload-files',
            type: "POST",
            contentType: false,
            processData: false,
            cache: false,
            data: formData,
            success: function (result) {
                result = $.parseJSON(result);
                if(result.status){
                    if(result.fileName){   
                        var $thisEl = $('#folders').find(className),
                            filePath = '/'+folderPath+'/'+result.fileName;//путь и наименование файла
                        $thisEl.removeClass('file-load').addClass('file').find('.name').text(result.fileName).siblings('.fa').hide().siblings('.thumb').attr('src', filePath)
                        $thisEl.attr('data-name', result.fileName).find('.checkbox').attr('name', "name-file['"+result.fileName+"']").attr('data-name', result.fileName)
                    }
                }
                else{
                    $('#folders').find(className).remove()
                    new PNotify({
                        title: "Ошибка",
                        type: "error",
                        text: result.message,
                        styling: 'bootstrap3',
                    });
                }
            }
        });
    }

    function handleFileUpload(files){
        var fd = new FormData();
        for (var i = 0; i < files.length; i++) {
            var types = ['', 'image/png', 'image/jpeg', 'image/gif'];//формат поддерживаемых файлов
            if (types.indexOf(files[i].type) <= 0){
                new PNotify({
                    title: "Внимание",
                    type: "warning",
                    text: 'Файл '+files[i].name+' не был добавлен так как имеет недопустимый формат. Допускаются файлы с форматом (jpg, gif, png).',
                    styling: 'bootstrap3',
                });
            }
            else{
                var date = new Date().getTime();
                fd.append('mediafile', files[i]);
                $('#folders').append(new EJS({url: pathTmpl + '/file-loader.tpl'}).render({className: 'file-'+date}))
                sendFileToServer(fd, '.file-'+date);
            }
        }
    }
    
    $galleryWd.on('change', '#files-multimedia', function () {
       handleFileUpload($(this)[0].files);
    });

    var obj = $("#dragandrophandler");
    obj.on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $(this).css('border', '2px solid #0B85A1');
    });

    obj.on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
    });

    obj.on('drop', function (e) {
        $(this).css('border', '2px dotted #0B85A1');
        e.preventDefault();
        var files = e.originalEvent.dataTransfer.files;
        handleFileUpload(files);
    });

    $(document).on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
    });

    $(document).on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        obj.css('border', '2px dotted #0B85A1');
    });

    $(document).on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();
    });
    /**/
    
    /**Превью изображений на страницах добавления контента**/
    //показать окно медиафайлов и отобразить кнопку выбора файлов
    $('#select-files').on('click', function (){
        showWdMediafiles();
        select = true;
    });
    
    //выбрать файлы и закрыть окно
    $galleryWd.on('click', '#select-files-btn', function (){
        var checkFilesObj = $('#multimedia .checkbox-file:checked'), //получить все отмеченные файлы
            filesArr = []
        $.each(checkFilesObj, function(key, val){
            filesArr[key] = $(val).attr('data-name')
        });
        Add(filesArr);
        $galleryWd.modal('hide')
        //отображаем миниатюры изображений
        var tmpl = new EJS({url: pathTmpl + '/files.tpl'}).render({files:filesArr, path:folderPath});
        $('#thumbnails-page').html(tmpl);
    });
    
    //удалить выбранное изображение
    $('#thumbnails-page').on('click', 'ul > li .remove', function (){
        $(this).parents('li').remove();
        var files = [];
        $.each($('#thumbnails-page').find('li'), function(key, val){
            files[key] = $(val).attr('data-name')
        });
        Update(files);
    });
    
    //удалить значения из полей, а также очистить контейнер с превью
    function Clear(){
        $('#images').val('');
        $('#path_files').val('');
        $('#thumbnails-page').text('');
    }
    
    //обновить контейнер и данные в полях
    function Update(files){
        if(!files.length) $('#path_files').val('');
        $('#images').val(files);
    }
    
    function Add(files){
        $('#images').val(files);
        $('#path_files').val(folderPath);
    }
    
    
    return {
        Clear:function(){//очистить значения и поля переданых значений
            Clear();
        },
        getImgsArr:function(){//получить массив вставленных изображений
            if($('#images').length){
                if($('#images').val().length) return $('#images').val().trim().split(',');
                else return null;
            }
            else return null;
        },
        getPath:function(){//получить путь из директории вставленных изображений
            if($('#path_files').length){
                if($('#path_files').val().length) return $('#path_files').val().trim();
                else return null;
            }
            else return null;
        }
    }
})(jQuery);