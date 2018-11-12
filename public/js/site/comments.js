var Comments = (function ($) {

    var product_id = $('#product_id').val(),
        $form = $('#comment-form'),
        offset = 0
    
    //получаем первые 10 комментариев как только страница загрузится
    getComments();
    
    //показать ещё комментарии
    $('#more-comments').on('click', function (){
        getComments();
    });
    
    //открыть окно добавления комментария
    $('#open-wd-comment').on('click', function (){
        clearFormComment();
        $('#wd-comment').modal('show')
    });
    
    //добавить комментарий
    $("#comment-form").validate({
        rules: {
            name: {
                required: true
            },
            text: {
                required: true
            }
        },
        errorClass: "invalid-feedback",
        messages: {
            name: {
                required: "Поле не может быть пустым"
            },
            text: {
                required: "Поле не может быть пустым"
            }
        },
        highlight: function(a) {
            $(a).closest(".form-group").addClass("has-error");
        },
        unhighlight: function(a) {
            $(a).closest(".form-group").removeClass("has-error");
        },
        submitHandler: function (form) {
            var formFields = $(form).serializeArray();
            
            $.ajax({
                beforeSend: function (){
                    //$('.icon-load.comments').show();
                },
                url: '/comments/add',
                type: 'POST',
                data: formFields,
                complete: function () {
                    //$('.icon-load.comments').hide();
                },
                success: function(data){
                    if(data.error == false){
                        var comment = {};
                        $.each(formFields, function(key, field) {
                            comment[field.name] = field.value;
                        });
                        comment['id'] = data.id;
                        
                        var tmpl = ejs.render($('#comment-ejs').html(), { comment });
                        
                        if(!$('#comments-list > ul').length){
                            $('#comments-list').html('<ul class="list-unstyled"></ul>');
                        }
                        
                        if(comment.parent_id){//если есть значение parent_id, тогда это означает что комментарий является ответом на другой комментарий
                            if(!$('#comments-list > ul').find('li[data-id="'+comment.parent_id+'"] > ul').length){//если ещё нет ответов к коментарию
                                tmpl = '<ul class="list-unstyled">'+tmpl+'</ul>';
                                $('#comments-list > ul').find('li[data-id="'+comment.parent_id+'"]').append(tmpl);
                            }
                            else $('#comments-list > ul').find('li[data-id="'+comment.parent_id+'"] > ul').prepend(tmpl);//если уже есть ответы к этому комментарию
                        }
                        else{//если не ответ
                            $('#comments-list > ul').prepend(tmpl);
                        }
                        
                        $('#wd-comment').modal('hide')
                        showPNotify('success', 'Готово', 'Комментарий успешно добавлен');
                        
                        clearFormComment();
                    }
                    else showPNotify('error', 'Ошибка', 'Произошла ошибка при добавлении комментария');
                    
                }
            });
            
        }
    });

    //открыть окно ответа на комментарий
    $('#comments').on('click', '.reply-comment', function (){
        var id = $(this).attr('data-id'),
            first_parent_id = $(this).attr('data-first_parent_id'),
            name = $(this).attr('data-name');
            
            if(!first_parent_id || first_parent_id == 0) first_parent_id = id;
        
            $('#wd-comment')
                    .modal('show')
                    .find('#parent_id').val(id)
                    .parents('#wd-comment')
                    .find('#first_parent_id').val(first_parent_id)
                    .parents('#wd-comment')
                    .find('#comment-reply').removeClass('hide')
                    .find('.name').text(name)
    });
    
    //убрать ответ
    $('#remove-comment-reply').on('click', function (){
        $('#wd-comment')
                    .find('#parent_id').val('')
                    .parents('#wd-comment')
                    .find('#first_parent_id').val('')
                    .parents('#wd-comment')
                    .find('#comment-reply').addClass('hide')
                    .find('.name').text('')
    });
    
    function getComments(){
        $.ajax({
            beforeSend: function (){
                //$('.icon-load.comments').show();
            },
            url: '/comments',
            type: 'GET',
            data: {
                _token: $('body').attr('data-csrf'),
                product_id: product_id,
                parent_id: 0,
                offset: offset,
            },
            complete: function () {
                //$('.icon-load.comments').hide();
            },
            success: function(data){
                if(data.comments.length){
                    var tmpl = ejs.render($('#comments-ejs').html(), { comments:data.comments});
                    if(offset > 0){
                        $('#comments-list > ul').append(tmpl)
                    }
                    else $('#comments-list').html('<ul class="list-unstyled">'+tmpl+'</ul>')
                    
                    offset += 10;
                }
                else{
                    $('#more-comments').hide()
                }98
            }
        });
    }
    
    function clearFormComment(){
        $form[0].reset();
        
        $('#wd-comment')
                .find('#parent_id').val('')
                .parents('#wd-comment')
                .find('#first_parent_id').val('')
                .parents('#wd-comment')
                .find('#comment-reply').addClass('hide')
                .find('.name').text('')
    }

})(jQuery);