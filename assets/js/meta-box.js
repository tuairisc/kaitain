/**
 * Post Meta JavaScript
 * -----------------------------------------------------------------------------
 * @category   JavaScript
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 *
 * This file is part of Tuairisc.ie.
 *
 * Tuairisc.ie is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * Tuairisc.ie is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Tuairisc.ie. If not, see <http://www.gnu.org/licenses/>.
 */

'use strict';

/*
 * Dates
 * -----------------------------------------------------------------------------
 */

var date = new Date();

var dates = {
    year: date.getFullYear(),
    month: date.getMonth(),
    day: date.getDate()
};

var months = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
];

/*
 * Inputs
 * -----------------------------------------------------------------------------
 */

var inputs = {
    featured: {
        check: '#meta-tuairisc-featured',
        type: '.stickycheck'
    },
    sticky: {
        check: '#meta-tuairisc-sticky',
        type: '.stickyinfo'
    },
    time: {
        hour: '#expiry-hour',
        minute: '#expiry-minute'
    },
    date: {
        day: '#expiry-day',
        month: '#expiry-month',
        year: '#expiry-year'
    }
};

/**
 * Toggle Element if Box Checked
 * ---------------------------------------------------------------------
 * @param   object      element         Target element.
 * @param   object      checkbox        Checkbox.
 */

var toggle = function(element, checkbox) {
    if (jQuery(checkbox).is(':checked')) {
        jQuery(element).show(); 
    } else {
        jQuery(element).hide();
    }
}

/**
 * Days in Months
 * ---------------------------------------------------------------------
 * @param   int     year
 * @param   int     month
 * @return  int                         Days in month.
 */

function daysInMonth(year, month) {
    return new Date(year, month, 0).getDate();
}

/**
 * Add Option to Select
 * ---------------------------------------------------------------------
 * @param   object      element         DOM select element. 
 * @param   string      value           Element for the option.
 * @param   string      text            Text for the option.       
 */

function addOption(element, value, text) {
    jQuery(element).append('<option value="' + value + '">' + text + '</option>');    
}

function resetValue(element, value) {
    if (value && jQuery(element).children('option[value=' + value + ']').length > 0) {
        jQuery(element).val(value);
    }
}

/**
 * Populate Days Select
 * ---------------------------------------------------------------------
 * @param   int         year            Current or target year.
 * @param   int         month           Current or target month.
 */

var daysSelect = function(year, month) {
    var value = jQuery(inputs.date.day).val();

    var days = {
        start: 1,
        end: 0
    };
    
    year = parseInt(year) || dates.year;

    if (month && typeof month === 'string') {
        month = months.indexOf(month);
    } else {
        month = dates.month;
    }

    if (year == dates.year && month == dates.month) {
        days.start = dates.day;
    }

    days.end = daysInMonth(year, ++month);
    jQuery(inputs.date.day).empty();

    for (var i = days.start; i <= days.end; i++) {
        addOption(inputs.date.day, i, i);
    }

    resetValue(inputs.date.day, value);
}

/**
 * Populate Months Select
 * ---------------------------------------------------------------------
 * @param   int         year            Current or target year.
 */

var monthsSelect = function(year) {
    var value = jQuery(inputs.date.month).val();
    var sMonths = months;

    year = parseInt(year) || dates.year;

    if (year === dates.year) {
        sMonths = sMonths.filter(function(v, i) {
            if (i >= dates.month) {
                return v;
            }
        });
    }

    jQuery(inputs.date.month).empty();
    
    jQuery.each(sMonths, function(i, v) {
        addOption(inputs.date.month, v, v);
    });

    resetValue(inputs.date.month, value);
    daysSelect(year, jQuery(inputs.date.month).val());
}

/**
 * Populate Years Select
 * ---------------------------------------------------------------------
 * @param   int     padding         Years to pad forward from this one.
 */

var yearsSelect = function(padding) {
    padding = padding || 5;

    var years = {
        start: date.getFullYear(),
        end: date.getFullYear() + padding
    }

    jQuery(inputs.date.year).empty();
    
    for (var i = years.start; i <= years.end; i++) {
        addOption(inputs.date.year, i, i); 
    }
}

/**
 * Setup ALL the Things
 * ---------------------------------------------------------------------
 */

jQuery(function() {
    toggle(inputs.sticky.type, inputs.sticky.check); 
    toggle(inputs.featured.type, inputs.featured.check); 

    yearsSelect(5);
    monthsSelect(jQuery(inputs.date.year).val());
});

jQuery(inputs.sticky.check).on('click', function() {
    toggle(inputs.sticky.type, this); 
});

jQuery(inputs.featured.check).on('click', function() {
    toggle(inputs.featured.type, this); 
});

jQuery(inputs.date.year).on('change', function() {
    monthsSelect(jQuery(inputs.date.year).val());
});

jQuery(inputs.date.month).on('change', function() {
    monthsSelect(jQuery(inputs.date.year).val());
});
