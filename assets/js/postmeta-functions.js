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
                hour: function() {
                    hour = hour || date.hour;
                    hour = (hour < 10) ? '0' + hour : hour;
                    this.val(hour);
                    return this;
                },
                minute: function() {
                    minute = minute || date.minute;
                    minute = (minute < 10) ? '0' + minute : minute;
                    this.val(minute);
                    return this;
                },
            },
            date: {
                day: function(day, month, year) {
                    day = parseInt(day) || date.day;
                    month = parseInt(month) || date.month;
                    year = parseInt(year) || date.year;

                    var value = $(this).val() || day;
                    var options = [];

                    var days = {
                        start: 1,
                        end: 0
                    };

                    if (year == date.year && month == date.month) {
                        // If month and year are current, use current day.
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
                },
                month: function(month, year) {
                    // Update month option.
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
                },
                year: function(year, padding) {
                    year = parseInt(year) || date.year;
                    padding = padding || 5;

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
                },
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

        method = (method === 'time') ? method : 'date';
        prefix = prefix || randChars(10);
        expiry = expiry || $.now();

        add.fieldset[method].apply(this, Array.prototype.slice.call(arguments, 1));
        return this;
    }
})(jQuery);
