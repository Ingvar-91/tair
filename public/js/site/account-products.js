(function ($) {
    
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