var System = (function ($) {

    if ($('.daterange').length) {
        initDateRangePicker();
    }

    /*function getFormsFields(form) {
        var formFields = {};
        $.each($(form).serializeArray(), function (key, val) {
            formFields[val.name] = val.value;
        });
        return formFields;
    }*/
    
    function initDateRangePicker() {
        $('.daterange').daterangepicker({
            "singleDatePicker": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "locale": {
                "format": "YYYY-MM-DD H:mm",
                "separator": " - ",
                "applyLabel": "Применить",
                "cancelLabel": "Отмена",
                "fromLabel": "From",
                "toLabel": "To",
                "customRangeLabel": "Custom",
                "weekLabel": "W",
                "daysOfWeek": [
                    "Вс",
                    "Пн",
                    "Вт",
                    "Ср",
                    "Чт",
                    "Пт",
                    "Сб"

                ],
                "monthNames": [
                    "Январь",
                    "Февраль",
                    "Март",
                    "Апрель",
                    "Май",
                    "Июнь",
                    "Июль",
                    "Август",
                    "Сентябрь",
                    "Октябрь",
                    "Ноябрь",
                    "Декабрь"
                ],
                "firstDay": 1
            },
            "linkedCalendars": false,
            "autoUpdateInput": true,
            "opens": "left"
        }, function (start, end, label){
            
        });
    }
    
    /**************************************************************************/
    
    return{
        getFormsFields: function (form) {
            return getFormsFields(form);
        },
        initDateRangePicker: function () {
            return initDateRangePicker();
        }
    }

})(jQuery);

//добавляем функцию trim для вырезания пробелов с конца и с начала
if (!String.prototype.trim) {
    (function () {
        // Вырезаем BOM и неразрывный пробел
        String.prototype.trim = function () {
            return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
        };
    })();
}

/*PNotify
function showPNotify(type, title, text) {
PNotify.prototype.options.styling = "fontawesome";
    var opts = {
        addclass: "stack-topleft",
    };
    opts.title = title;
    opts.text = text;
    opts.type = type;
    new PNotify(opts);
}
PNotify END*/

/*
//
function addAlertMessage(data){
    var $obj = '';
    $(data).each(function( key, val) {
        $obj = val.obj.find('.messages');
        
        if($obj.find('.'+val.className).length){
            $obj.find('.'+val.className).remove()
        }

        var tmpl = '<div class="alert alert-'+val.type+' '+val.className+'" role="alert">'
            +val.text+
        '</div>';
        $obj.append(tmpl);
        
        $obj = '';
    });
}

function removeAlertMessage($obj, className){
    $obj.find('.'+className).remove()
}

//
function formErrorMessage(data){
    var $formGroup = '';
    $(data).each(function( key, val) {
        
        $formGroup = val.obj.find('[name="'+val.name+'"]').parents('.form-group');
        
        if($formGroup.hasClass('has-error')){
            $formGroup.find('.error-message').remove();
        }
        
        $formGroup.append('<div class="error-message">'+val.text+'</div>').addClass('has-error')
        
        $formGroup = '';
    });
}

function formErrorMessageHide(data){
    var $formGroup = data.obj.find('[name="'+data.name+'"]').parents('.form-group');
    $formGroup.removeClass('has-error').find('.error-message').remove()
}

*/
