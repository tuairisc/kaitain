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

/**
 * Add Data Attribute to Menu Item
 * -----------------------------------------------------------------------------
 * Rant: WordPress /really does not like it when you fuck with menu items/. 
 * Menus? Yes! Menu links? Yes! Menu span items? Yes! Menu items? Fuck no!
 * 
 * So:
 *  
 *  * Individual menu items are nightmare to extract.
 *  * There is /no function whatsoever/ through which you can add custom attributes.
 *  * Menu items are stored in the wp_posts table as post objects (WTF?), and so have
 *    no fields for things like data attributes.
 *  * The menu walker output string...is a string. Not an array or something easy
 *    to manipulate. Seriously, what the fuck WordPress? The WordPress has the
 *    dubious honour of being one of the most fucked-up and pointlessly convoluted
 *    pieces of code with which I've had to work.
 *  * I would rather take a vacation with my ex-wife than have to ever again deal
 *    with the menu code.
 *
 * This Walker_Nav_Menu class:
 *
 *  1. Identifies topmost menu items (those without a parent ID).
 *  2. Searches the string for their <li id="menu-item-$foo" string and replace it
 *     with the provided Knockout.js data binding.
 *
 *  This code is liable to break at some future point if WordPress changes menu
 *  structure.
 */

class Kaitain_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        global $sections;

        $classes = array(
            // Menu item CSS classes.
            'menu-item' => 'section--menu-item',
            'current' => 'section--current-bg',
            'uncurrent' => 'section--%s-bg-hover',
            'focused' => 'navmenu--focused',
            'text-shadow' => 'section--%s-shadow-hover'
        );

        $binding = array(
            // Array in case I need to add more.
            'parent' => 'data-bind="event: { mouseover: setFocusMenu, touchstart: setFocusMenu }, mouseoverBubble: false"',
        );

        // Get category section parent.
        $category = get_category($sections->get_category_section_id(intval($item->object_id)));

        // Add appropriate menu classes to a given menu item.

        if ($item->object === 'category' && !$item->menu_item_parent) {
            $item->classes[] = $classes['menu-item'];

            if ($sections::$current_section === $category->cat_ID) {
                // Add focused and current classes if the the section is current.
                $item->classes[] = sprintf($classes['current'], $category->slug);
                // Uncomment this line to have the section menu popout by default.
                // $item->classes[] = $classes['focused'];
            } else {
                // Elsewise add the hover BG class.
                $item->classes[] = sprintf($classes['uncurrent'], $category->slug);
            }
        } else if ($item->menu_item_parent) {
            $item->classes[] = sprintf($classes['text-shadow'], $category->slug);
        }

        // Reduce code by extending the parent function.
        parent::start_el($output, $item, $depth = 0, $args, $id);

        // Add data attribute and binding with regex.
        
        if (!$item->menu_item_parent) {
            $match = '/\<li\sid="menu-item-' . $item->ID . '"/';
            $replace = '<li id="menu-item-'. $item->ID . '" ' . $binding['parent'];

            $output = preg_replace($match, $replace, $output, 1);
        }
    }
}

?>
