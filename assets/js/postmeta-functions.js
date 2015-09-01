/**
 * Post Meta Box Functions
 * -----------------------------------------------------------------------------
 * @category   JavaScript
 * @package    Kaitain
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/kaitain-theme
 * @link       http://www.tuairisc.ie
 */

/**
 * Linked Toggle
 * -----------------------------------------------------------------------------
 * Linked checkbox toggle. When checkbox is checked, make connected elements
 * appear. When checkbox is unchecked, uncheck and hide all linked elements
 * and checkboxes.
 * 
 * @param   array       linkedElements      Array of checkboxes.
 * @param   object      targetElement       Linked selector to toggle.
 * @param   bool        state               Default state.
 * @return  object      this
 */

;(function($) {
    $.fn.linkedToggle = function(linkedElements, targetElement, state) {
        var isChecked = function(element) {
            return $(element).is(':checked');
        }

        linkedElements.push(this);
        state = state || false;

        this.on('change', function(event) {
            var checked = linkedElements.every(isChecked);

            $(targetElement).toggle(checked);

            if (!checked) {
                // Uncheck and hide all descendent elements when unchecked.
                $(targetElement).find('input[type=checkbox]')
                    .prop('checked', false).trigger('change');
            }
        });

        // Set default checkced unchecked state.
        this.prop('checked', state).trigger('change');
        return this;
    }
})(jQuery);

/**
 * Time and Date Checker
 * -----------------------------------------------------------------------------
 * Does:
 * 
 * 1. Append either time (hour:minute) or date (day/month/year) selects to
 *    target element.
 * 2. Selects are prefixed with a given string, and suffixed with the input
 *    type foo_year, foo_month, etc.
 * 3. A given time and date can be provided by a Unix timestamp, and the inputs
 *    will be set to this value. 
 */

;(function($) {
    $.fn.checker = function(method, prefix, expiry) {
        var add = {
            /* Inputs are added without a value or options. These are set via
             * update.foo()
             */

            fieldset: {
                time: function(prefix, expiry) {
                    // Append hour fieldset with hour and minute.
                    var fieldset = $('<fieldset>')
                        .append(add.input('hour', prefix))
                        .append(' : ')
                        .append(add.input('minute', prefix));

                    this.append(fieldset);
                },
                date: function(prefix, expiry) {
                    // Append date fieldset with day, month, year values.
                    var fieldset = $('<fieldset>')
                        .append(add.select('day', prefix))
                        .append('/')
                        .append(add.select('month', prefix))
                        .append('/')
                        .append(add.select('year', prefix));

                    this.append(fieldset);
                }
            },
            select: function(type, prefix, values) {
                // Generate select HTML.
                var attr = prefix + '-' + type; 

                var select = $('<select>', {
                    'class': attr,
                    id: attr,
                    name: attr
                });

                return select;
            },
            input: function(type, prefix) {
                // Generate hour and minute input HTML.
                var attr = prefix + '-' + type; 
                var max = (type === 'hour') ? 23 : 59;

                var input = $('<input>', {
                    type: 'text',
                    'class': attr,
                    id: attr,
                    name: attr,
                    min: '00',
                    max: max,
                    minlength: 2,
                    maxlength: 2,
                    value: '00'
                });

                // Size attr is ignored in Chrome if set above. 
                input.attr('size', 2);

                return input;
            }
        };

        var update = {
            time: {
                hour: function() {},
                minute: function() {},
            },
            date: {
                day: function() {},
                month: function() {},
                year: function() {},
            },
            option: function(value, text) {
                // Generate option HTML.
                return '<option value="' + value + '">' + text + '</option>';
            },
        };

        function randChars(amount, divider) {
            // Generate stream of random chars prefixed by a dividing char.
            amount = amount || 10;
            divider = divider || '';

            return divider + Math.random()
                .toString(36)
                .replace(/[^a-z]+/g, '')
                .substr(0, amount);
        }

        method = (method === 'time') ? method : 'date';
        prefix = prefix || randChars(10);
        expiry = expiry || $.now();

        add.fieldset[method].apply(this, Array.prototype.slice.call(arguments, 1));
        return this;
    }

/**
 * Dates
 * -----------------------------------------------------------------------------
 * Current year, month, day and calendar year as Bearla.
 */

// Widget date will be set by WordPress.
var date = new Date();

date = {
    year: date.getFullYear(),
    month: date.getMonth(),
    day: date.getDate(),
    hour: date.getHours(),
    minute: date.getMinutes(),
    calendar: [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ],
    daysInMonth: function(year, month) {
        // Return days in given month.
        return new Date(year, month, 0).getDate();
    }
};

var expiry;

if (pmFeatured.sticky) {
    var expiry = new Date(pmFeatured.expiry * 1000);

    expiry = {
        year: expiry.getFullYear(),
        month: expiry.getMonth(),
        day: expiry.getDate(),
        hour: expiry.getHours(),
        minute: expiry.getMinutes(),
    };
} else {
    expiry = date;
}


    /**
     * Generate Option HTML
     * -------------------------------------------------------------------------
     * @param   object      element         DOM select element. 
     * @param   string      value           Value for a given option.
     * @param   string      text            Text for the option.       
     */

    /**
     * Reset Select Selected Option
     * -------------------------------------------------------------------------
     * Re-set old value of option/select after the number of selects was changed.
     * 
     * @param   object      element         DOM select element. 
     * @param   string      value           Value for a given option.
     */

    $.fn.setSelectedOption = function(value) {
        if (value && this.children('option[value=' + value + ']').length > 0) {
            this.val(value);
        }

        return this;
    }
        
    /*
     * Reset Select
     * -------------------------------------------------------------------------
     * Empty it, append text, and set selected value.
     */

    $.fn.reset = function(options, value) {
        this.empty().append(options);

        if (value) {
            // Yearly input doesn't care about old value.
            this.setSelectedOption(value);
        }

        return this;
    }

    /**
     * Option Update Wrapper
     * -------------------------------------------------------------------------
     * Generic wrapper for option update. Case the supplied time period
     * and pass arguments along to the correct function.
     */

    $.fn.update = function() {
        var type = arguments[0];
        [].shift.apply(arguments);

        switch (type) {
            case 'year': yearOptionUpdate.apply(this, arguments); break;
            case 'month': monthOptionUpdate.apply(this, arguments); break;
            case 'day': dayOptionUpdate.apply(this, arguments); break;
            case 'hour': hourOptionUpdate.apply(this, arguments); break;
            case 'minute': minuteOptionUpdate.apply(this, arguments); break;
            default: break;
        }

        return this;
    }

    /**
     * Populate Yearly Select Options
     * -------------------------------------------------------------------------
     * @param   int     padding         Years to pad forward from this one.
     * @param   object  element         DOM element.
     */

    function yearOptionUpdate(padding, year) {
        padding = padding || 5;
        year = parseInt(year) || date.year;

        var options = [];
        var value = $(this).val() || year;

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

        this.reset(options, value);
        return this;
    }

    /**
     * Populate Monthly Select Options
     * -------------------------------------------------------------------------
     * @param   int         year            Current or target year.
     */

    function monthOptionUpdate(year, month) {
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

    /**
     * Populate Daily Select Options
     * -------------------------------------------------------------------------
     * @param   int         year            Current or target year.
     * @param   int/string  month           Current or target month.
     */

    function dayOptionUpdate(year, month, day) {
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
            // If month and year are current, use current day of month.
            days.start = date.day;
        }

        /* Month returned is 0, 1, 2, ... 
         * Month needed is 1, 2, 3, ... */
        month++;

        days.end = date.daysInMonth(year, month);

        for (var i = days.start; i <= days.end; i++) {
            options.addOptionHtml(i, i);
        }

        this.reset(options, value);
        return this;
    }


    /**
     * Populate Hourly Select Options
     * -------------------------------------------------------------------------
     * @param   int         hour            Current or target hour.
     */

    function hourOptionUpdate(hour) {
        hour = hour || date.hour;
        hour = (hour < 10) ? '0' + hour : hour;
        this.val(hour);
        return this;
    }

    /**
     * Populate Minute Select Options
     * -------------------------------------------------------------------------
     * @param   int         minute            Current or target minute.
     */

    function minuteOptionUpdate(minute) {
        minute = minute || date.minute;
        minute = (minute < 10) ? '0' + minute : minute;
        this.val(minute);
        return this;
    }

    /**
     * Setup ALL the Things
     * -------------------------------------------------------------------------
     */

    /*
    // Setup input fields.
    $(input.select.year).update('year', 5, expiry.year);
    $(input.select.month).update('month', expiry.year, expiry.month);
    $(input.select.day).update('day', expiry.year, expiry.month, expiry.day);
    $(input.select.hour).update('hour', expiry.hour);
    $(input.select.minute).update('minute', expiry.minute);

    // Input field change handlers.
    $(input.select.year).on('change', function() {
        var year = $(this).val();
        var month = $(input.select.month).val();
        
        $(input.select.month).update('month', year);
        $(input.select.day).update('day', year, month);
    });

    $(input.select.month).on('change', function() {
        var year = $(input.select.year).val();
        var month = $(this).val();

        $(input.select.day).update('day', year, month);
    });
    */
})(jQuery);
