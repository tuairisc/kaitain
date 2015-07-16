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

$current_section = null;

/**
 * Variables
 * -----------------------------------------------------------------------------
 */

$section_categories = array(
    /* The eight sections of the Tuairisc site, with a ninth fallback class for
     * every other thing that does not fit neatly into these. */
    191 => 'nuacht',
    154 => 'tuairimiocht',
    155 => 'sport',
    156 => 'cultur',
    157 => 'saol',
    159 => 'pobal',
    187 => 'education',
    158 => 'greann',
    999 => 'other'
);

/**
 * Get ID of Category's Ultimate Parent
 * -----------------------------------------------------------------------------
 * The site is sectioned into several parent categories with children and 
 * grandchildren beneath. Recursively ascend through parent categories until you
 * hit the top.
 * 
 * @param   int     $category     
 * @return  int     $category         Numeric ID of category's ultimate parent.
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
 * @param   array    $category       ID of category.
 */

function category_children_ids($category) {
    $category = get_category($category);

    if (!$category) {
        return false;
    }

    $categories = get_categories(array('child_of' => $category));

    if (!$categories) {
        return false;
    }

    $children = array();

    foreach($categories as $cat) {
        $children[] = $cat->term_id;
    }

    if (sizeof($children) === 0) {
        return false;
    }

    return $children;
}

/**
 * Generate Primary Section Menu
 * -----------------------------------------------------------------------------
 * Add the primary section menu, based on 
 */

function sections_menu($echo = false) {
    global $section_categories, $section_id;
    $menu = array();

    $menu[] = '<ul id="sections-menu">';
    
    foreach ($section_categories as $id => $section) {
           // TODO: Add menu link, with text.
        if (category_exists($id)) {
            $category = get_category($id);

            $menu[] = sprintf('<li class="%s">%s</li>',
               'a',
               $category->name
            );
        }
    }
    
    $menu[] = '</ul>';

    $menu = implode('', $menu);

    if (!$echo) {
        return $menu;
    }

    printf($menu);
}

/**
 * Generate Secondary Section Menu
 * -----------------------------------------------------------------------------
 */

function secondary_section_menu() {
    global $Sections;
    $children = category_children_ids($Sections->current_id);

    if (count($children) > 0) {
        foreach ($children as $child) {
            printf('<li>%s</li>', generate_menu_link('category', $child));
        }
    }
}

/**
 * Get Object Link
 * -----------------------------------------------------------------------------
 * Return the permalink for several WordPress objects from its type and ID.
 * 
 * @param   string  $object_type        Type of object-post, page, etc.
 * @param   int     $object_id          ID of object.    
 * @return  string  $object_permalink   Permalink to object.
 */

function get_object_permalink($object_type = null, $object_id = null) {
    if (is_null($object_type) || is_null($object_id)) {
        // TODO: throw error
    }

    $object_permalink = '';

    switch ($object_type) {
        case 'category': 
            $object_permalink = get_category_link($object_id); break;
        case 'post':
        case 'page':
            $object_permalink = get_permalink($object_id); break;
        case 'tag': 
            $object_permalink = get_tag_link($object_id); break;
        // default: 
        //     $object_permalink = get_home_url(); break;            
    }

    return $object_permalink;
}

/**
 * Get Object Name
 * -----------------------------------------------------------------------------
 * Return the name/label of several WordPress objects, from its type and ID.
 * 
 * @param   string  $object_type        Type of object-post, page, etc.
 * @param   int     $object_id          ID of object.    
 * @return  string  $object_name        Permalink to object.
 */

function get_object_name($object_type = null, $object_id = null) {
    if (is_null($object_type) || is_null($object_id)) {
        // TODO: throw error
    }

    $object_name = '';

    switch ($object_type) {
        case 'category': 
            $object_name = get_cat_name($object_id); break;
        case 'post':
        case 'page':
            $object_name = get_the_title($object_id); break;
        case 'tag': 
            $object_name = get_term_by('id', $object_id, 'post_tag'); break;
    }

    return $object_name;
}

/**
 * Generate HTML Link for Item
 * -----------------------------------------------------------------------------
 * @param   string  $object_type    Type of object.
 * @param   int     $object_id      ID of object.
 * @param   array   $classes        Option classes to append to hyperlink.
 * @param   array   $ids            Optional IDs to append to hyperlink.
 * @return  string  $hyperlink      The generated hyperlink to the object.
 */

function generate_menu_link($object_type = null, $object_id = null) {
    if (is_null($object_type) || is_null($object_id)) {
        // throw error
    }

    $hyperlink = array('<a href="');
    $hyperlink[] = get_object_permalink($object_type, $object_id) . '"';
    $hyperlink[] = '>';
    $hyperlink[] = get_object_name($object_type, $object_id); 
    $hyperlink[] = '</a>';

    return implode('', $hyperlink);
}

/**
 * Get ID of Site Section
 * -----------------------------------------------------------------------------
 * Get the ID of the section of the site. The site is broken up into sections 
 * defined by category-one each for major categories, with a final fallback 
 * section for everything else.
 * 
 * @return  int     $section_id         Numerical ID of section.
 */

function get_section_id() {
    global $section_id;

    if (is_null($section_id)) {
        $section_id = set_section_id();
    }

    return $section_id;
}

/**
 * Set ID of Site Section
 * -----------------------------------------------------------------------------
 * Get the ID of the section of the site. The site is broken up into sections 
 * defined by category-one each for major categories, with a final fallback 
 * section for everything else.
 * 
 * @return  int     $section_id         Numerical ID of section.
 */

function set_site_section() {
    global $post, $section_categories, $section_id;

    if (is_home() || is_front_page()) {
        $section_id = 191;
    } else if (is_category() || is_single()) {
        if (is_category()) {
            $category = get_query_var('cat');
        } else if (is_single()) {
            $category = get_the_category($post->ID)[0]->cat_ID;
        }

        $category = category_parent_id($category);

        if (array_key_exists($category, $section_categories)) {
            $section_id = $category;
        }

        // Add more sections here if they need to be evaluated.
    }

    return $section_id;
}

/**
 * Get Section Class from Site ID
 * -----------------------------------------------------------------------------
 * Each numerically-identified section also has an attached class.
 * 
 * @param   bool    $prepend            Prepend class with 'section-'.
 * @param   int     $section_id         ID of section which needs a class.
 * @param   string                      Classname for section.
 */

function get_section_class($prepend = false, $section_id = null) {
    global $section_categories, $section_id;
    $section_class = array();

    error_log($section_id);

    if ($prepend) {
        $section_class[] = 'section-';
    }

    $section_class[] = $section_categories[$section_id];
    
    return implode('', $section_class);
}

/**
 * Set Body Classes
 * -----------------------------------------------------------------------------
 */

function set_section_classes($classes) {
    $classes[] = get_section_class(true);
    return $classes;
}

/**
 * Filters, Options and Actions
 * -----------------------------------------------------------------------------
 */

add_action('wp_head', 'set_site_section');
add_filter('body_class', 'set_section_classes');

?>
