<?php 

/**
 * Advanced Menu Functions
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Kaitain
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/kaitain-theme
 * @link       http://www.tuairisc.ie
 */

/**
 * Fetch the Menu Attached to a Nav Location
 * -----------------------------------------------------------------------------
 * @param   string      $location       Menu location. Should be slug.
 * @return  object      $menu           The menu associated with that location.
 */

function kaitain_get_menu_from_location($location) {
    if (!($location = get_nav_menu_locations()[$location])) {
        return false;
    }

    if (!($menu = get_term($location, 'nav_menu')->term_id)) {
        return false;
    }

    if (!($menu = wp_get_nav_menu_items($menu))) {
        return false;
    }

    return $menu;
}

?>
