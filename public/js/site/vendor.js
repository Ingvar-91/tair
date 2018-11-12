var Vendor = (function ($) {

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
                url: '/products-vendor/remove',
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: $this.attr('data-id')
                },
                complete: function () {
                    $('#loader').removeClass('active');
                },
                success: function(data){
                    if(data.warning){
                        toastr.warning('Внимание', data.message);
                        //showPNotify('warning', 'Внимание', data.message);
                        return;
                    }
                    if(data.error == false){
                        toastr.success('Запись успешно удалена');
                        //showPNotify('success', 'Готово', 'Запись успешно удалена');
                        DeleteRow($this.parents('tr'));
                    }
                    else{
                        toastr.error('Ошибка при удалении записи');
                        //showPNotify('error', 'Ошибка', 'Ошибка при удалении записи');
                    }
                }
            });
        });
    });
    /**/
    
    /**/
    $('#wd-my-shops-btn').on('click', function (){
        var $wdMyShops = $('#wd-my-shops');
        $.ajax({
            beforeSend: function (){
                $wdMyShops.find('.loader').removeClass('hide');
                $wdMyShops.find('.list').addClass('hide');
            },
            url: '/shops',
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            complete: function () {
                $wdMyShops.find('.loader').addClass('hide');
                $wdMyShops.find('.list').removeClass('hide');
            },
            success: function(data){
                if(data){
                    var tmpl = ejs.render($('#ejs-wd-my-shops').html(), {shops: data.shops});
                    $wdMyShops.find('.list').html(tmpl);
                }
            }
        });
    });
    /**/
    
    /*DataTable*/
    if($('.data-table').length){
        $('.data-table').DataTable({
            "order": [[ 0, "ask" ]],
            "processing": true,
            "serverSide": true,
            responsive: true,
            "ajax": {
                "type": "GET",
                "url": "/"+location.pathname.split('/')[1],
                "data": function ( d ) {
                    d._token = $('meta[name="csrf-token"]').attr('content')
                    
                    //дополнительные данные
                    if (typeof dataTableAdditionalData !== 'undefined') {
                        if(dataTableAdditionalData.length){
                            $(dataTableAdditionalData).each(function( key, val) {
                                d[val.name] = val.value
                            });
                        }
                    }
                    
                    console.log(d)
                },
                "dataSrc": function ( json ) {
                    return json.data;
                },
                "complete": function ( json ) {
                    //console.log(json)
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
                "first": '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
                "previous": '<i class="fa fa-angle-left" aria-hidden="true"></i>',
                "next": '<i class="fa fa-angle-right" aria-hidden="true"></i>',
                "last": '<i class="fa fa-angle-double-right" aria-hidden="true"></i>'
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
            UpdateRow(data);
        }
    }

})(jQuery);