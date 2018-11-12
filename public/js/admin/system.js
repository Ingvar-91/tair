var System = (function ($) {

    if ($('.daterange').length) {
        initDateRangePicker();
    }

    function getFormsFields(form) {
        var formFields = {};
        $.each($(form).serializeArray(), function (key, val) {
            formFields[val.name] = val.value;
        });
        return formFields;
    }
    
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
            //datePost = end.format('YYYY-MM-DD H:mm:ss')
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

/*PNotify*/
PNotify.prototype.options.styling = "bootstrap3";
function showPNotify(type, title, text) {
    //var stack_bottomright = {"dir1": "up", "dir2": "left", "firstpos1": 25, "firstpos2": 25};
    var opts = {
        addclass: "stack-topleft",
        //stack: stack_bottomright
    };
    opts.title = title;
    opts.text = text;
    opts.type = type;
    new PNotify(opts);
}
/*PNotify END*/

//поиск по ЗНАЧЕНИЯ В МАССИВЕ
/*ПРИМЕР
 var types = ['', 'image/png', 'image/jpeg', 'image/gif'];
 console.log(types.indexOf(file.type))
 */
if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function (searchElement, fromIndex) {
        var k;
        if (this == null) {
            throw new TypeError('"this" is null or not defined');
        }
        var O = Object(this);
        var len = O.length >>> 0;
        if (len === 0) {
            return -1;
        }
        var n = +fromIndex || 0;

        if (Math.abs(n) === Infinity) {
            n = 0;
        }
        if (n >= len) {
            return -1;
        }
        k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);
        while (k < len) {
            if (k in O && O[k] === searchElement) {
                return k;
            }
            k++;
        }
        return -1;
    };
}