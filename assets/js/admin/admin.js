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

(function($) {
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

(function($) {
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
                inputSetup.call($fieldset);
                this.append($fieldset);
            },
            input: function(name, prefix) {
                // Generate hour and minute input HTML.
                var attr = (prefix) ? prefix + '-' + name : name;
                var max = (name === 'hour') ? 23 : 59;
                var size = (name === 'year') ? 4 : 2;


                var input = $('<input>', {
                    type: 'text',
                    'class': attr,
                    id: attr,
                    name: attr,
                    minlength: size,
                    maxlength: size
                });

                // Size attr is ignored in Chrome if set above. 
                input.attr('size', size).data('name', name);
                this.append(input);
            }
        };

        var inputSetup = function() {
            // Reset all input values to whatever target says.
            $(this).find('input').empty().each(function() {
                padInputValue.call(this, target[$(this).data('name')]);
            });
        }

        var padInputValue = function(value) {
            // Pad input values with zeroes for neatness.
            var zeroes = '';

            value = value.toString() || $(this).val().toString();

            for (var i = 0; i < $(this).attr('size') - value.length; i ++) {
                zeroes += '0';
            }

            $(this).val(zeroes + value); 
        }

        var validate = function(event) {
            // 0. Get element type/name from added data.
            var name = $(this).data('name');
            // 1. Strip leading zeroes.
            var value = parseInt($(this).val(), 10);
            // 2. Validate regex. Regex acounts for leading zeros anyhow.
            var valid = regex[name].test(value);

            $(this).toggleClass('input-error', !valid);
            
            if (!valid) {
                // 3. If regex is invalid, focus back on input.
                $(this).focus().select();
                return;
            }

            // 5. Update target date object.
            target[name] = value;

            if (name.match(/^(day|month|year)$/)) {
                /* 6. If date change, ensure day of month isn't greater than
                 * days in month.
                 */

                var dim = date.daysInMonth(target.year, target.month);

                if (target.day > dim) {
                    target.day = dim;
                    value = dim;

                    if (name !== 'day') {
                        $(this).siblings('[id*=day]').val(dim);
                    }
                }
            }

            if (date.timeLessThanNow(target, name)) {
                // 7. If target date < current datetime, reset it.
                target = date.split($.now());
                inputSetup.call($(this).parent());
            }

            // 8. Pad value.
            padInputValue.call(this, value);
            return this;
        }

        var regex = {
            // Regex for input evaluation.
            minute: /^([0-5])?\d$/,
            hour: /^((\d)|[0-1]\d|2[0-3])$/,
            day: /^(([1-9])?|[1-2]\d|3[0-2])$/,
            month: /^(0?|[1-9]|1[0-2])$/,
            year: /^[1-2](9|0)\d{2}$/
        };

        var date = {
            daysInMonth: function(year, month) {
                // Return days in given month.
                return new Date(year, month, 0).getDate();
            },
            split: function(date) {
                // Split datetime object into comparison date.
                var valid = (new Date(date)) > 0;
                date = (valid) ? new Date(date) : new Date();

                return {
                    minute: date.getMinutes(),
                    hour: date.getHours(),
                    day: date.getDate(),
                    month: date.getMonth() + 1,
                    year: date.getFullYear()
                };
            },
            join: function(timestamp) {
                // Rejoin split datetime object for evaluation.
                return Math.floor(new Date(
                    timestamp.year,
                    timestamp.month - 1,
                    timestamp.day,
                    timestamp.hour,
                    timestamp.minute,
                    0, 0
                ).getTime() / 1000);
            },
            timeLessThanNow: function(time, name) {
                // Is updated target time less than the current time?
                return (date.join(time) < Math.floor($.now() / 1000));
            },
        };

        target = date.split(target || null);
        add.fieldset.call(this, prefix);
        return this;
    }
})(jQuery);

/**
 * Checkbox Setup
 * -----------------------------------------------------------------------------
 * Add change to checkboxes and set state.
 */

jQuery('#kaitain-featured-checkbox').linkedToggle(
    [], '.kaitain-stickycheck', postmetaFeatured.featured
);

jQuery('#kaitain-sticky-checkbox').linkedToggle(
    ['#kaitain-featured-checkbox'], '.kaitain-sticky-expiryinfo', postmetaFeatured.sticky
);

jQuery('#kaitain-notice-checkbox').linkedToggle(
    [], '.kaitain-noticecheck', postmetaNotice.notice
);

/**
 * Date and Time Setup
 * -----------------------------------------------------------------------------
 * Add change to checkboxes and set state.
 */

jQuery('#kaitain-sticky-expiry').checker('stickyexpires', postmetaFeatured.expiry);
