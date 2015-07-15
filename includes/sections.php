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
 * Variables
 * -----------------------------------------------------------------------------
 */

$section_category_ids = array(
    /* The eight sections of the Tuairisc site, with a ninth fallback class for
     * every other thing that does not fit neatly into these. */
    191, 154, 155, 156, 157, 159, 187, 158 
);

/**
 * CSS Classes 
 * -----------------------------------------------------------------------------
 * These are used throughout the entire theme 
 */

// Prefix for all sections, either main or specific.
define('SECTION_PREFIX', 'section-');
define('HAS_SECTION_CLASS', 'website-section');
// Sitewide text and background colour classes to use the current section's trim.
define('SECTION_TRIM_TEXT', 'section-trim-text');
define('SECTION_TRIM_TEXT_HOVER', 'section-trim-text-hover');
define('SECTION_TRIM_BACKGROUND', 'section-trim-background');
define('SECTION_TRIM_BACKGROUND_HOVER', 'section-trim-background-hover');
// Suffixes for text and background hovering.
define('SECTION_SUFFIX_BACKGROUND_HOVER', '-background-hover');
define('SECTION_SUFFIX_TEXT_HOVER', '-text-hover');
// Suffix for the fallback section. .section-fallback instead of .section-foo
define('SECTION_FALLBACK_SUFFIX', 'fallback');

/**
 * Classes
 * -----------------------------------------------------------------------------
 */

/**
 * Sectioneer
 * -----------------------------------------------------------------------------
 * Manage the sections of the site. As of April 27 2015, it is crude in 
 * function and in need of expansion.
 */

class Sectioneer {
    public $categories;
    public $size;
    public $current_set;
    public $current_id;
    public $current_slug;
    public $current_class;

    public function __construct($size = 8) {
        $this->categories = array();
        $this->size = $size;
        $this->current_set = false;
        $this->current_id = 0;
        $this->current_slug = '';
        $this->current_class = '';
    }

    public function add($id, $slug, $class) {
        if (count($this->categories) < $this->size) {
            $this->categories[$id] = array('id' => $id, 'slug' => $slug, 'class' => $class);
            return current($this->categories);
        } else {
            throw new RunTimeException('You\'ve added too many categories!');
        }
    }

    public function remove($id) {
        unset($this->categories, $id);
        return $this->categories;
    }

    public function set_current($id = -1) {
        if (array_key_exists($id, $this->categories)) {
            $this->current_id = $this->categories[$id]['id'];
            $this->current_slug = $this->categories[$id]['slug'];
            $this->current_class = $this->categories[$id]['class'];
            $this->current_set = true;
        } else {
            throw new RunTimeException('Invalid category specified!');
        }
    }
}

if (!is_admin()) {
    $Sections = new Sectioneer(8);
}

/**
 * Functions
 * -----------------------------------------------------------------------------
 */

/**
 * Set Site Section
 * -----------------------------------------------------------------------------
 */

function setup_sections() {
    // 1. Determine loop type.
    // 2. If post or category, get root category ID.
    // global $post, $section_category_ids, $Sections;

    global $section_category_ids, $Sections;

    $category = 0;
    $cat_id = 0;
    $slug = SECTION_FALLBACK_SUFFIX;
    $class = '';
    $is_section = true;

    foreach($section_category_ids as $id) {
        $category = get_category($id);
        $slug = $category->slug;
        $class = SECTION_PREFIX . $slug;

        $Sections->add($id, $slug, $class);
    }

    if (!$Sections->current_set) {
        switch(get_loop_type()) {
            case 'single': 
                // If single, fetch first category.
                $cat_id = get_the_category($post->ID);
                $cat_id = category_parent_id($cat_id[0]->term_id);
                break;
            case 'category':
                // Fetch category parent ID.
                $cat_id = category_parent_id(get_query_var('cat'));
                break;
            default: 
                // Everything-*everything*-else is grouped under 'other'. 
                $is_section = false;
                break;
        }

        if (in_array($cat_id, $section_category_ids) && $is_section) {
            // Set section to whatever is in the sections array.
            $category = get_category($cat_id);
            $slug = $category->slug;
            $class = SECTION_PREFIX . $slug;

            $Sections->set_current($cat_id);
        }
    }
}

function add_section_class_to_body($classes) {
    global $Sections;

    if ($Sections->current_set) {
        $classes[] = $Sections->current_class;
        $classes[] = HAS_SECTION_CLASS;
    }
    
    return $classes;
}

/**
 * Generate Primary Section Menu
 * -----------------------------------------------------------------------------
 * Add the primary section menu, based on 
 */

function primary_section_menu() {
    global $Sections;

    foreach ($Sections->categories as $category) {
        printf(
            '<li class="%s%s%s">%s</li>', 
            ($category['id'] === $Sections->current_id) ? SECTION_TRIM_BACKGROUND : '',
            ($category['id'] === $Sections->current_id) ? ' ' : '',
            $category['class'] . SECTION_SUFFIX_BACKGROUND_HOVER,
            generate_menu_link('category', $category['id'])
        );
    }
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
 * Return ID of Category Children
 * -----------------------------------------------------------------------------
 * @param   int     $category       ID of category.
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
 * Determine Loop Type
 * -----------------------------------------------------------------------------
 * I was surprised to find WordPress didn't already have just this.
 * 
 * @return  string      $loop_type          Type of current loop.
 */

function get_loop_type() {
    global $wp_query; 
    $loop_type = 'notfound';

    if ($wp_query->is_page) {
        $loop_type = is_front_page() ? 'front' : 'page';
    } elseif ($wp_query->is_home) {
        $loop_type = 'home';
    } elseif ($wp_query->is_single) {
        $loop_type = ($wp_query->is_attachment) ? 'attachment' : 'single';
    } elseif ($wp_query->is_category) {
        $loop_type = 'category';
    } elseif ($wp_query->is_tag) {
        $loop_type = 'tag';
    } elseif ($wp_query->is_tax) {
        $loop_type = 'tax';
    } elseif ($wp_query->is_archive) {
        if ($wp_query->is_day) {
            $loop_type = 'day';
        } elseif ($wp_query->is_month) {
            $loop_type = 'month';
        } elseif ($wp_query->is_year) {
            $loop_type = 'year';
        } elseif ($wp_query->is_author) {
            $loop_type = 'author';
        } else {
            $loop_type = 'archive';
        }
    } elseif ($wp_query->is_search) {
        $loop_type = 'search';
    } elseif ($wp_query->is_404) {
        $loop_type = 'notfound';
    }

    return $loop_type;
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
 * Get ID of Category's Ultimate Parent
 * -----------------------------------------------------------------------------
 * The site is sectioned into several parent categories with children and 
 * grandchildren beneath. Recursively ascend through parent categories until you
 * hit the top.
 * 
 * @param   int     $cat_id     
 * @return  int     $cat_id         Numeric ID of category's ultimate parent.
 */

function category_parent_id($cat_id = null) {
    if (is_null($cat_id) || !is_integer($cat_id) || !term_exists($cat_id, 'category')) {
        return false;
    }

    $category = get_category($cat_id); 

    if ($category->category_parent) {
        $cat_id = category_parent_id($category->category_parent);
    }

    return $cat_id;
}

/**
 * Filters, Options and Actions
 * -----------------------------------------------------------------------------
 */

add_action('wp_head', 'setup_sections');
add_filter('body_class', 'add_section_class_to_body');

?>
