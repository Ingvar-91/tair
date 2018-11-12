var DataTables = (function ($) {
    
    /*Подтверждение и удаление записи через ajax*/
    $('body').on('click', '.remove-entry', function (){
        var $this = $(this); 
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
                beforeSend: function (){
                    $('#loader').addClass('active');
                },
                url: '/admin/'+location.pathname.split('/')[2]+'/remove',
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: $this.attr('data-id')
                },
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
                        showPNotify('success', 'Готово', 'Запись успешно удалена');
                        DeleteRow($this.parents('tr'));
                    }
                    else showPNotify('error', 'Ошибка', 'Ошибка при удалении записи');
                }
            });
        });
    });
    /**/
    
    /*Пометить запись как удаленную*/
    /*$('body').on('click', '.delete-entry', function (){
        var $this = $(this); 
        swal({
            title: 'Вы уверены?',
            text: 'Пометить запись как удаленную?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Да',
            cancelButtonText: 'Нет',
            closeOnConfirm: true,
            closeOnCancel: true,
        }, function () {
            $.ajax({
                beforeSend: function (){
                    $('#loader').addClass('active');
                },
                url: '/admin/'+location.pathname.split('/')[2]+'/delete',
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: $this.attr('data-id')
                },
                complete: function () {
                    $('#loader').removeClass('active');
                },
                success: function (data) {
                    if(data.error !== null){
                        showPNotify('success', 'Готово', 'Данные успешно обновлены.');
                        UpdateRow($this.parents('tr'));
                    }
                    else showPNotify('error', 'Ошибка', 'Ошибка при обновлении записи');
                }
            });
        });
    });*/
    /**/
    
    /*DataTable*/
    if($('.data-table').length){
        var $dataTable = $('.data-table').DataTable({
            "order": [[ 0, "ask" ]],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "type": "GET",
                "url": "/admin/"+location.pathname.split('/')[2],
                "data": function ( d ) {
                    d._token = $('meta[name="csrf-token"]').attr('content')
                    
                    //дополнительные данные
                    if (typeof dataTableAdditionalData !== 'undefined') {
                        if(dataTableAdditionalData.length){
                            $(dataTableAdditionalData).each(function( key, val) {
                                console.log(val)
                                d[val.name] = val.value
                            });
                        }
                    }
                },
                "dataSrc": function ( json ) {
                    return json.data;
                },
                "complete": function ( json ) {
                    
                }
            },
            columns: columnsName,
            language: getTableLang() 
        });
    }
    
    function AddRow(data, table) {
        table = table || $('.data-table');
        table.dataTable().fnAddData(data);
    }
    
    function UpdateRow() {
        $('.data-table').dataTable().fnDraw();
    }
    
    function DeleteRow(row) {
        row.closest('.data-table').DataTable().row(row).remove().draw();
    }
    
    
    function getTableLang() {
        return {
            "processing": "Подождите...",
            "search": "Поиск:",
            "lengthMenu": "Показать _MENU_ записей",
            "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
            "infoEmpty": "Записи с 0 до 0 из 0 записей",
            "infoFiltered": "(отфильтровано из _MAX_ записей)",
            "infoPostFix": "",
            "loadingRecords": "Загрузка записей...",
            "zeroRecords": "Записи отсутствуют.",
            "emptyTable": "В таблице отсутствуют данные",
            "paginate": {
                "first": "Первая",
                "previous": "Предыдущая",
                "next": "Следующая",
                "last": "Последняя"
            },
            "aria": {
                "sortAscending": ": активировать для сортировки столбца по возрастанию",
                "sortDescending": ": активировать для сортировки столбца по убыванию"
            }

        }
    }
    /*DataTable END*/
    
    return {
        UpdateRow: function (data) {
            UpdateRow();
        },
        draw: function () {
            $dataTable.draw();
        }
    }
    
})(jQuery);