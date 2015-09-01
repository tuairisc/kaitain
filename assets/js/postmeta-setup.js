/**
 * Post Meta Box Setup
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
 * Inputs
 * -----------------------------------------------------------------------------
 * Checkbox inputs for featured post and whether to sticky it too.
 * Options for expiry: minute, hour, day, month and year.
 * Classes for the sticky checkbox, and sticky expiry information.
 */

var input = {
    select: {
        day: '#expiry-day',
        month: '#expiry-month',
        year: '#expiry-year',
        hour: '#expiry-hour',
        minute: '#expiry-minute'
    },
};

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

if (kaitainMetaInfo.sticky) {
    var expiry = new Date(kaitainMetaInfo.expiry * 1000);

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
 * Checkbox Setup
 * -----------------------------------------------------------------------------
 * Add change to checkboxes and set state.
 */

jQuery('#kaitain-featured-checkbox').linkedToggle(
    [], '.kaitain-stickycheck', kaitainMetaInfo.featured
);

jQuery('#kaitain-sticky-checkbox').linkedToggle(
    ['#kaitain-featured-checkbox'], '.kaitain-expiryinfo', kaitainMetaInfo.sticky
);
