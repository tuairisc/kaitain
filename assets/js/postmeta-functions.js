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
    $.fn.checker = function(prefix, target) {
        var add = {
            /* Inputs are added without a value or options. These are set via
             * update.foo()
             */
            fieldset: function(prefix) {
                var $fieldset = $('<fieldset>').append('Until: ');

                $.each(['hour', 'minute'], function(index, name) {
                    add.input.call($fieldset, name, prefix);

                    if (index === 0) {
                        $fieldset.append(' : ');
                    }
                });

                $fieldset.append('<br />').append('on: ');

                $.each(['day', 'month', 'year'], function(index, name) {
                    add.input.call($fieldset, name, prefix);

                    if (index === 0 || index === 1) {
                        // Insert dividing forward slash.
                        $fieldset.append(' / ');
                    }
                });

                $fieldset.on('change', 'input', validate);
                this.append($fieldset);
            },
            input: function(name, prefix) {
                // Generate hour and minute input HTML.
                var attr = (prefix) ? prefix + '-' + name : name;
                var max = (name === 'hour') ? 23 : 59;

                var input = $('<input>', {
                    type: 'text',
                    'class': attr,
                    id: attr,
                    name: attr,
                    minlength: 2,
                    maxlength: 2,
                });

                // Size attr is ignored in Chrome if set above. 
                input.attr('size', 2).data('name', name);
                this.append(input);
            }
        };

        var regex = {
            minute: /^[0-5][0-9]$/,
            hour: /^([0-1][0-9]|2[0-3])$/,
            day: /^(0[1-9]|[12]\d|3[01])$/,
            month: /^(0[1-9]|1[0-2])$/,
            year: /^[1-2](9|0)[0-9]{2}$/
        };

        var isLeapYear = function(year) {
            return (year % 100 !== 0 && year % 4 === 0 || year % 400 === 0);
        }

        var validate = function(event) {
            console.log(this);
            return;

            // Order:
            // 0. If empty, pull in values from target.
            // 1. If fewer digits than max, pad out with leading 0's.
            // 2. After padding, validate against regex above.
            // 3. If regex is invalid flag input and keep focus there.
            // 4. If field validates, pass back values to date.target.
            // 5. If date.target is less than date.now, change date.target to date.now.
            // 6. If date.target is less than date.now, change all values to that of date.now.

            var name = $(this).data('name');
            var max = (name === 'hour') ? 23 : 59;

            value = parseInt($(this).val(), 10) || date.target[name];
            date.target[name] = value;

            if (targetLessThanNow() && value !== date.now[name]) {
                value = date.now[name];
                $(this).siblings('input').val('').trigger('change');
                $(this).siblings('select').empty();
            }

            // Conform valueue to sane maximums and pad.
            value = (value > max) ? max : value;
            // value = (value.toString().length === 1) ? '0' + value : value;
           
            $(this).val(value);
            return this;
        }

        var daysInMonth = function(year, month) {
            // Return days in given month.
            return new Date(year, month, 0).getDate();
        }

        var targetLessThanNow = function() {
            var now = 0;
            var target = 0;

            $.each(date.target, function(key) {
                now += parseInt(date.now[key], 10);
                target += parseInt(date.target[key], 10);
            });

            return (now > target);
        }

        var calendar = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November',
            'December'
        ];

        var date = {
            now: new Date(),
            target: target || new Date()
        };

        date = {
            now: {
                minute: date.now.getMinutes(),
                hour: date.now.getHours(),
                day: date.now.getDate(),
                month: date.now.getMonth(),
                year: date.now.getFullYear()
            },
            target: {
                minute: date.target.getMinutes(),
                hour: date.target.getHours(),
                day: date.target.getDate(),
                month: date.target.getMonth(),
                year: date.target.getFullYear()
            },
        };

        add.fieldset.call(this, prefix);
        return this;
    }
})(jQuery);
