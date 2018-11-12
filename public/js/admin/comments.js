var Comments = (function ($) {

    //поулчить всю историю сообщения
    $('body').on('click', '#all-history-comment', function (){
        $('#all-history-comment-wd').find('.modal-body').html()
        var $this = $(this); 
        
        $.ajax({
            beforeSend: function (){
                $('#loader').addClass('active');
            },
            url: '/admin/'+location.pathname.split('/')[2]+'/getAllHistoryComment',
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                first_parent_id: $this.attr('data-first_parent_id'),
                id: $this.attr('data-id')
            },
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                var tmpl = ejs.render($('#comments-ejs').html(), { comments:data.comments, commentId:$this.attr('data-id') });
                $('#all-history-comment-wd').find('.modal-body').html(tmpl)
                $('#all-history-comment-wd').modal('show');
            }
        });
    });
    
    //открыть окно ответа на комментарий
    $('body').on('click', '#reply-comment', function (){
        var $this = $(this);
        $('#user_id').val($this.attr('data-user_id'));
        $('#reply-comment-id-input').val($this.attr('data-id'));
        $('#reply-comment-first_parent_id-input').val($this.attr('data-first_parent_id'));
        $('#reply-comment-wd').modal('show');
    });
    
    //ответить на комментарий
    $('body').on('click', '#reply-comment-button', function (){
        var $this = $(this),
            $form = $('#reply-comment-form'),
            formFields = System.getFormsFields($form);
            
        formFields._token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            beforeSend: function (){
                $('#loader').addClass('active');
            },
            url: '/admin/'+location.pathname.split('/')[2]+'/add',
            type: 'POST',
            data: formFields,
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                if(data.error == false){
                    showPNotify('success', 'Готово', 'Запись успешно добавлена');
                    DataTables.UpdateRow();
                    $('#reply-comment-wd').modal('hide');
                    $form[0].reset();
                }
                else showPNotify('error', 'Ошибка', 'Ошибка при добавлении записи');
            }
        });
    });
    
    //получить комментарий и открыть окно редактирования
    $('body').on('click', '#edit-comment', function (){
        var $this = $(this); 
        $.ajax({
            beforeSend: function (){
                $('#loader').addClass('active');
            },
            url: '/admin/'+location.pathname.split('/')[2]+'/getComment',
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: $this.attr('data-id')
            },
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                console.log(data)
                if(data.error == false){
                    $('#comment-name-wd').text(data.comment.name);
                    $('#comment-text-wd').val(data.comment.text);
                    $('#comment-id-wd').val(data.comment.id);
                    $('#edit-comment-wd').modal('show');
                }
                else showPNotify('error', 'Ошибка', 'Ошибка при получение записи');
            }
        });
    });
    
    //сохранить редактированное сообщение
    $('body').on('click', '#comment-edit-save', function (){
        var formFields = System.getFormsFields($('#edit-comment-form-wd'));
        formFields._token = $('meta[name="csrf-token"]').attr('content');
        
        var $this = $(this); 
        $.ajax({
            beforeSend: function (){
                $('#loader').addClass('active');
            },
            url: '/admin/'+location.pathname.split('/')[2]+'/edit',
            type: 'PUT',
            data: formFields,
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                if(data.warning){
                    showPNotify('warning', 'Внимание', data.message);
                    $('#edit-comment-wd').modal('hide');
                    return;
                }
                if(data.error == false){
                    showPNotify('success', 'Готово', 'Запись успешно обновлена');
                    DataTables.UpdateRow();
                    $('#edit-comment-wd').modal('hide');
                }
                else showPNotify('error', 'Ошибка', 'Ошибка при обновлении');
            }
        });
    });
    
    //поменять статус
    $('body').on('change', '.comment-status', function() {
        var id = $(this).attr('data-id'),
            status = this.value;
            
        $.ajax({
            beforeSend: function (){
                $('#loader').addClass('active');
            },
            url: '/admin/'+location.pathname.split('/')[2]+'/editStatus',
            type: 'PUT',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                status: status,
                id: id,
            },
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                if(data.error == false){
                    showPNotify('success', 'Готово', 'Запись успешно обновлена');
                }
                else showPNotify('error', 'Ошибка', 'Ошибка при обновлении');
            }
        });
    })
    
})(jQuery);