(function($) {
    $.fn.caira = function(options) {
        var settings = $.extend({
            date: new Date(),
        }, options);

        settings.date = {
            minute: settings.date.getMinutes(),
            hour: settings.date.getHours(),
            day: settings.date.getDate(),
            month: settings.date.getMonth(),
            year: settings.date.getFullYear()
        };

        this.on('change', '[class*=datepicker-]', update);
    };

    var update = function(date) {
        var date = date || settings.date;

        var inputs = {
            minute: '.datepicker-minute',
            hour:   '.datepicker-hour',
            day:    '.datepicker-day',
            month:  '.datepicker-month',
            year:   '.datepicker-year'
        }

        if ($(this).is(inputs.minute)) {
            updateYear.call(this);
        } else if ($(this).is(inputs.hour)) {
            updateYear.call(this);
        } else if ($(this).is(inputs.day)) {
            updateYear.call(this);
        } else if ($(this).is(inputs.month)) {
            updateYear.call(this);
        } else if ($(this).is(inputs.year)) {
            year = $(this).val();
        }
    }

    function reset(yolo, swag) {
        console.log(yolo, swag);
        $(this).remove();
    }

    function daysInMonth(year, month) {
        return new Date(year, month, 0).getDate();
    }

    function updateYear(padding, year) {
        // padding = padding || 5;
        // year = parseInt(year) || date.year;
    
        var options = ['this is option'];
        // var value = $(this).val() || year;
        var value = 3;

        reset.apply(this, [options, value]);
        return;
    
        var years = {
            start: year,
            end: year + padding
        }
    
        if (years.start > date.year) {
            years.start -= (year - date.year);
        }
    
        for (var i = years.start; i <= years.end; i++) {
            options.addOptionHtml(i, i); 
        }
    
        this.apply(reset, [options, value]);
        return this;
    }
    
    function updateMonth(year, month) {
        year = parseInt(year) || date.year;
        month = parseInt(month) || date.month;
    
        var options = [];
        var value = $(this).val() || month;
        
        $.each(date.calendar, function(i, v) {
            if (year === date.year && i < date.month) {
                return true;
            }
                
            options.addOptionHtml(i, v);
        });
    
        this.reset(options, value);
        return this;
    }
    
    function updateDay(year, month, day) {
        year = parseInt(year) || date.year;
        month = parseInt(month) || date.month;
        day = parseInt(day) || date.day;
    
        var value = $(this).val() || day;
        var options = [];
    
        var days = {
            start: 1,
            end: 0
        };
    
        if (year == date.year && month == date.month) {
            days.start = date.day;
        }
    
        month++;
    
        days.end = date.daysInMonth(year, month);
    
        for (var i = days.start; i <= days.end; i++) {
            options.addOptionHtml(i, i);
        }
    
        this.reset(options, value);
        return this;
    }
}(jQuery));

jQuery('#tuairisc_featured_meta').caira();

