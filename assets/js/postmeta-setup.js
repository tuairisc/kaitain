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
 * Checkbox Setup
 * -----------------------------------------------------------------------------
 * Add change to checkboxes and set state.
 */

jQuery('#kaitain-featured-checkbox').linkedToggle(
    [], '.kaitain-stickycheck', pmFeatured.featured
);

jQuery('#kaitain-sticky-checkbox').linkedToggle(
    ['#kaitain-featured-checkbox'], '.kaitain-expiryinfo', pmFeatured.sticky
);

/**
 * Date and Time Setup
 * -----------------------------------------------------------------------------
 * Add change to checkboxes and set state.
 */

jQuery('#kaitain-sticky-time').checker(
    'time', 'stickyexpires', pmFeatured.expiry
);

jQuery('#kaitain-sticky-date').checker(
    'date', 'stickyexpires', pmFeatured.expiry
);
