var Chars = (function ($) {
    
    var page = location.pathname.split('/').slice(2)[0],
        product_id = $('#product_id').val()
        
    //при нажатии на checkbox категории, получить список характеристик
    $("body").on('click', 'input[name="category_id"]', function () {
        var category_id = $('input[name="category_id"]:radio:checked').val();
        
        if(category_id){
            getChars(category_id, product_id);
        }
    });
    
    //выбрать все значения характеристик
    $("body").on('click', '.char-select-all', function () {
        $(this).parents('.form-group').find('.selectpicker').selectpicker('selectAll');
    });
    
    //очистить все значения характеристик
    $("body").on('click', '.char-clear-all', function () {
        $(this).parents('.form-group').find('.selectpicker').selectpicker('deselectAll');
    });
    
    function getChars(category_id, product_id){
        $.ajax({
            beforeSend: function (){
                $('#loader').addClass('active');
            },
            headers:{
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/vendor-chars/chars/',
            type: 'GET',
            data: {
                category_id: category_id,
                product_id: product_id,
            },
            complete: function () {
                $('#loader').removeClass('active');
            },
            success: function (data) {
                console.log(data)
                if(data.chars.length){
                    var tmpl = ejs.render($('#chars-ejs').html(), {chars: data.chars});
                    $('#chars-list').html(tmpl);
                    
                    $('#chars').find('.warning').hide();
                    
                    initSelectPicker();
                }
                else{
                    $('#chars-list').html('Характеристики отсутствуют')
                }
            }
        });
    }
    
    // init selectpicker
    function initSelectPicker(){
        if ($('.selectpicker').length){
            console.log($('.selectpicker'))
            $('.selectpicker').selectpicker({
                size: 4
            });
        }
    }
    
    //поиск значений
    /*$('#chars-list').on('keyup', '[name="search-char"]', function () {
        var $this = $(this),
            value = $this.val(),
            $options = $this.parents('.form-group').find('select >')
            
        var $option = '';
        $options.each(function( key, option) {
            $option = $(option);
            if(!RegExp(value, 'i').test($option.text())){
                $option.hide();
            }
            else{
               $option.show(); 
            }
            $option = '';
        });
    });*/
    
    //сбросить выделение поля характеристики на странице товара
    /*$('#chars-list').on('click', '.retweet', function () {
        $(this).parents('.form-group').find('select').children('option:selected').prop('selected', false);
    });*/
    
    function clearChars(){
        $('#chars-list').html('');
        $('#chars').find('.warning').show();
    }
    
    return {
        clearChars:function(){
            return clearChars();
        },
        getChars:function(category_id, product_id){
            return getChars(category_id, product_id);
        },
        initSelectPicker:function(){
            return initSelectPicker();
        }
        
    }

})(jQuery);