<?php 
/**
 * Site Sections
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
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

/**
 * Sections
 * -----------------------------------------------------------------------------
 * The eight sections of the Tuairisc site, with a ninth fallback class for
 * every other thing that does not fit neatly into these. The order of these 
 * elements is important, because this is the order in which the menu is output.
 */

$tuairisc_sections = array(
    191, 153, 155, 156, 157, 159, 187, 158
);

// ID for site home section.
$home_section = 191;
// ID to be used if none match.
$fallback_section = 999;
// Variable for current section ID.
$GLOBALS['tuairisc_section'] = null;

/**
 * Get ID of Category's Ultimate Parent
 * -----------------------------------------------------------------------------
 * The site is sectioned into several parent categories with children and 
 * grandchildren beneath. Recursively ascend through parent categories until you
 * hit the top.
 * 
 * @param   int     $cat_id          Category ID
 * @param   int     $cat_id          ID of original category's ultimate parent.
 */

function category_parent_id($cat_id = null) {
    $category = get_category($cat_id);

    if ($category->category_parent) {
        $cat_id = category_parent_id($category->category_parent);
    }

    return $cat_id;
}

/**
 * Get Category Children IDs
 * -----------------------------------------------------------------------------
 * Return array of all category childen categories.
 *
 * @param   int/object      $category      The category.
 * @return  array           $children      Array of category children IDs.
 */

function category_children($category) {
    $category = get_category($category);

    if (!$category) {
        return null;
    }

    $children = array();
    $categories = get_categories(array('child_of' => $category->cat_ID));

    foreach($categories as $cat) {
        $children[] = $cat->cat_ID;
    }

    return $children;
}

/**
 * Determine Current Section
 * -----------------------------------------------------------------------------
 * The site is segmented into n primary sections. This generates the WordPress
 * options for the site sections if the array of sections changes.
 */

function sections_opt_setup($new_sections) {
    $sections_option = array(
        'id' => array(),
        'section' => array()
    );

    foreach ($new_sections as $section) {
        $section = get_category($section);

        if ($section) {
            $sections_option['id'][] = $section->cat_ID;
            $sections_option['section'][$section->cat_ID] = $section->slug;
        }
    }

    update_option('tuairisc_sections', $sections_option);
    return $sections_option;
}

/**
 * Determine Current Section
 * -----------------------------------------------------------------------------
 * Get the ID of the section of the site. The site is broken up into sections 
 * defined by category-one each for major categories, with a final fallback 
 * section for everything else.
 */

function determine_section() {
    global $home_section, $fallback_section;

    $section = $fallback_section;
    $sections_opt = get_option('tuairisc_sections')['id'];

    if (is_home() || is_front_page()) {
        // 1. If home page or main index, default to first item.
        $section = $home_section;
    } else if (is_category() || is_single()) {
        // 2. Else set categroy by the parent category.
        if (is_category()) {
            $category = get_query_var('cat');
        } else if (is_single()) {
            $category = get_the_category($post->ID)[0]->cat_ID;
        }

        $category = category_parent_id($category);

        if (in_array($category, $sections_opt)) {
            $section = $category;
        }
    } 

    // 3. Add more sections here if they need to be evaluated.
    return $section;
}

/**
 * Sections Setup
 * -----------------------------------------------------------------------------
 * Setup everything related to sections:
 *
 * 1. Sections array, if not set, or changed.
 * 2. Sections menus, if not set, or changed.
 * 3. Current site section, if unset.
 */

function section_setup() {
    global $post, $tuairisc_sections;

    if (!isset($GLOBALS['tuairisc_section'])) {
        // Set current site section.
        $GLOBALS['tuairisc_section'] = determine_section();
    }

    // Ordered array of site sections + slugs.
    $sections_option = get_option('tuairisc_sections');

    // Generate menus for each section.
    $menus_opt = get_option('tuairisc_sections_menus');

    if (!$sections_option || !$menus_opt || $sections_option['id'] !== $tuairisc_sections) {
        // Setup sections option if it was changed, or hasn't been already set.
        sections_opt_setup($tuairisc_sections);
        sections_menus_setup();
    }
}

/**
 * Set Body Classes
 * -----------------------------------------------------------------------------
 * Attaches to body_class. I think it's a bit mad like that WordPress doesn't
 * have an action for body_id.
 *
 * @param   array       $classes        Array of body classes.
 * @return  array       $classes        Array of body classes.
 */

function set_section_body_class($classes) {
    $section_opt = get_option('tuairisc_sections')['section'];
    $section_class = array();

    $section_class[] = 'section-';

    if (array_key_exists($GLOBALS['tuairisc_section'], $section_opt)) {
        $section_class[] = $section_opt[$GLOBALS['tuairisc_section']];
    } else {
        $section_class[] = 'other';
    }

    $classes[] = implode('', $section_class);

    return $classes;
}

/**
 * Setup Section Menus
 * -----------------------------------------------------------------------------
 * Save generated sections menu to site options.
 */

function sections_menus_setup() {
    $sections_opt = get_option('tuairisc_sections')['section'];
    $menus = array();

    foreach ($sections_opt as $id => $slug) {
        $menus['primary'][$slug] = generate_menu_item($id);
        
        foreach (category_children($id) as $child) {
            $menus['secondary'][$slug][] = generate_menu_item($child);
        }
    }

    update_option('tuairisc_sections_menus', $menus);
}

/**
 * Generate HTML Category List Item
 * -----------------------------------------------------------------------------
 * @param   object/int  $category       Category which needs a link.
 * @return  string  $ln                 Generated menu item.
 */

function generate_menu_item($category) {
    $category = get_category($category);

    if (!$category) {
        return;
    }

    $li = array();

    $li[] = '<li%s role="menuitem">';

    $li[] = sprintf('<a title="%s" href="%s">%s</a>',
        $category->cat_name,
        esc_url(get_category_link($category->cat_ID)),
        $category->cat_name
    );

    $li[] = '</li>';

    return implode('', $li);
}

/*
 * Output Section Menu
 * -----------------------------------------------------------------------------
 * @param   array       $args      Arguments for menu output (type and classes).
 */

function sections_menu($args) {
    $defaults = array(
        'type' => 'primary',
        'classes' => array()
    );

    $args = wp_parse_args($args, $defaults);
    $slug = get_category($GLOBALS['tuairisc_section'])->slug;

    // Get menu from saved menu, and reduce secondary if called.
    $menu = get_option('tuairisc_sections_menus')[$args['type']];

    if ($args['type'] === 'secondary') {
        $menu = $menu[$slug];
    }

    foreach ($menu as $key => $item) {
        $class_attr = '';
        $classes = $args['classes'];

        if ($args['type'] === 'primary') {
            /* Primary menu items have hover and current section classes.
             * Uncurrent-section only show section colour on hover. */
            $uncurrent = ($key !== $slug) ? '-hover' : '';
            $classes[] = sprintf('section-%s-background%s', $key, $uncurrent);
        }
        
        if (!empty($classes)) {
            // Menu items are generated with '<li%s role=...'
            $class_attr = ' class="%s"';
        }

        // Put it all together and output.
        printf($item, sprintf($class_attr, implode(' ', $classes)));
    }
}

/**
 * Filters, Options and Actions
 * -----------------------------------------------------------------------------
 */

add_action('wp_head', 'section_setup');
add_filter('body_class', 'set_section_body_class');

?>
