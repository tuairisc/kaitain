/**
 * Post Meta JavaScript
 * -----------------------------------------------------------------------------
 * @category   JavaScript
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 *
 * This file is part of Tuairisc.ie.
 *
 * Tuairisc.ie is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * Tuairisc.ie is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Tuairisc.ie. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Dates
 * -----------------------------------------------------------------------------
 * Current year, month, day and calendar year as Bearla.
 */

// Widget date will be set by WordPress.
var date = new Date();
var expiry;

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

if (tuairiscMetaInfo.sticky) {
    var expiry = new Date(tuairiscMetaInfo.expiry * 1000);

    console.log(expiry);

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
 * Inputs
 * -----------------------------------------------------------------------------
 * Checkbox inputs for featured post and whether to sticky it too.
 * Options for expiry: minute, hour, day, month and year.
 * Classes for the sticky checkbox, and sticky expiry information.
 */

var input = {
    checkbox: {
        featured: '#meta-tuairisc-featured',
        sticky: '#meta-tuairisc-sticky'
    },
    select: {
        day: '#expiry-day',
        month: '#expiry-month',
        year: '#expiry-year',
        hour: '#expiry-hour',
        minute: '#expiry-minute'
    },
    info: {
        check: '.stickycheck',
        expiry: '.expiryinfo'
    }
};

/**
 * Setup Checkboxes
 * -----------------------------------------------------------------------------
 */

jQuery(input.checkbox.featured).prop('checked', tuairiscMetaInfo.featured);
jQuery(input.checkbox.sticky).prop('checked', tuairiscMetaInfo.sticky);

/**
 * Toggle Element if Box Checked
 * ---------------------------------------------------------------------
 * @param   object      element         Target element.
 * @param   object      checkbox        Checkbox.
 */

jQuery.fn.stickyCheckToggle = function() {
    var allBoxesChecked = [].every.call(arguments, function(v) {
        return (jQuery(v).is('input') && jQuery(v).prop('checked'));
    });

    if (allBoxesChecked) {
        jQuery(this).show();
    } else {
        jQuery(this).hide();
    }
};

/**
 * Generate Option HTML
 * ---------------------------------------------------------------------
 * @param   object      element         DOM select element. 
 * @param   string      value           Value for a given option.
 * @param   string      text            Text for the option.       
 */

Array.prototype.addOptionHtml = function(value, text) {
    this.push('<option value="' + value + '">' + text + '</option>');    
}

/**
 * Reset Select Selected Option
 * ---------------------------------------------------------------------
 * Re-set old value of option/select after the number of selects was changed.
 * 
 * @param   object      element         DOM select element. 
 * @param   string      value           Value for a given option.
 */

jQuery.fn.setSelectedOption = function(value) {
    if (value && this.children('option[value=' + value + ']').length > 0) {
        this.val(value);
    }
}
    
/*
 * Reset Select
 * -----------------------------------------------------------------------------
 * Empty it, append text, and set selected value.
 */

jQuery.fn.reset = function(options, value) {
    this.empty().append(options);

    if (value) {
        // Yearly input doesn't care about old value.
        this.setSelectedOption(value);
    }
}

/**
 * Option Update Wrapper
 * ---------------------------------------------------------------------
 * Generic wrapper for option update. Case the supplied time period
 * and pass arguments along to the correct function.
 */

jQuery.fn.update = function() {
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
}

/**
 * Populate Yearly Select Options
 * ---------------------------------------------------------------------
 * @param   int     padding         Years to pad forward from this one.
 * @param   object  element         DOM element.
 */

function yearOptionUpdate(padding, year) {
    padding = padding || 5;
    year = parseInt(year) || date.year;

    var options = [];
    var value = jQuery(this).val() || year;

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
}

/**
 * Populate Monthly Select Options
 * ---------------------------------------------------------------------
 * @param   int         year            Current or target year.
 */

function monthOptionUpdate(year, month) {
    year = parseInt(year) || date.year;
    month = parseInt(month) || date.month;

    var options = [];
    var value = jQuery(this).val() || month;
    
    jQuery.each(date.calendar, function(i, v) {
        if (year === date.year && i < date.month) {
            return true;
        }
            
        options.addOptionHtml(i, v);
    });

    this.reset(options, value);
}

/**
 * Populate Daily Select Options
 * ---------------------------------------------------------------------
 * @param   int         year            Current or target year.
 * @param   int/string  month           Current or target month.
 */

function dayOptionUpdate(year, month, day) {
    year = parseInt(year) || date.year;
    month = parseInt(month) || date.month;
    day = parseInt(day) || date.day;

    var value = jQuery(this).val() || day;
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
}


/**
 * Populate Hourly Select Options
 * ---------------------------------------------------------------------
 * @param   int         hour            Current or target hour.
 */

function hourOptionUpdate(hour) {
    hour = hour || date.hour;
    hour = (hour < 10) ? '0' + hour : hour;
    this.val(hour);
}

/**
 * Populate Minute Select Options
 * ---------------------------------------------------------------------
 * @param   int         minute            Current or target minute.
 */

function minuteOptionUpdate(minute) {
    minute = minute || date.minute;
    minute = (minute < 10) ? '0' + minute : minute;
    this.val(minute);
}

/**
 * Setup ALL the Things
 * ---------------------------------------------------------------------
 */

// Setup input fields.
jQuery(input.select.year).update('year', 5, expiry.year);
jQuery(input.select.month).update('month', expiry.year, expiry.month);
jQuery(input.select.day).update('day', expiry.year, expiry.month, expiry.day);
jQuery(input.select.hour).update('hour', expiry.hour);
jQuery(input.select.minute).update('minute', expiry.minute);

// Setup checkboxes.
jQuery(input.info.check).stickyCheckToggle(input.checkbox.featured);
jQuery(input.info.expiry).stickyCheckToggle(input.checkbox.featured, input.checkbox.sticky);

// Input field change handlers.
jQuery(input.select.year).on('change', function() {
    var year = jQuery(this).val();
    var month = jQuery(input.select.month).val();
    
    jQuery(input.select.month).update('month', year);
    jQuery(input.select.day).update('day', year, month);
});

jQuery(input.select.month).on('change', function() {
    var year = jQuery(input.select.year).val();
    var month = jQuery(this).val();

    jQuery(input.select.day).update('day', year, month);
});

// Checkbox state change handlers.
jQuery(input.checkbox.featured).on('change', function() {
    // Uncheck "sticky" if post isn't featured.
    if (!jQuery(this).prop('checked')) {
        jQuery(input.checkbox.sticky).prop('checked', false);
        jQuery(input.info.expiry).stickyCheckToggle(this, input.checkbox.sticky);
    }

    jQuery(input.info.check).stickyCheckToggle(this);
});

jQuery(input.checkbox.sticky).on('change', function() { 
    jQuery(input.info.expiry).stickyCheckToggle(this, input.checkbox.featured);
});
