<?php 
/**
 * Site Sections
 * -------------
 * @category   PHP Script
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 */ 

/**
 * Variables
 * -----------------------------------------------------------------------------
 */

$body_classes = array(
    'has_section' => 'is-site-section',
    'individual_section' => 'site-section-'
);

$section_categories = array(
    'tuairimiocht' => 154,
    'spoirt' => 155,
    'cultur' => 156, 
    'saol' => 157,
    'greann' => 158, 
    'pobal' => 159, 
    'foghlaimeoiri' => 187,
    'nuacht' => 191,
    'other_cat' => 'TODO',
    'tag' => 'TODO',
    'cpt' => 'TODO',
    'page' => 'TODO'
);

/**
 * Functions
 * -----------------------------------------------------------------------------
 */

/**
 * Determine Loop Type
 * -------------------
 * I was surprised to find WordPress didn't already have just this.
 * 
 * @return  bool    $loop_type      The type of WordPress loop.
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
 * Print Loop Type
 * ---------------
 */

function loop_type() {
    printf('%s', get_loop_type());
}

/**
 * Test Function, Please Ignore
 * ----------------------------
 */

function yolo_swag() {
    $swag = '';

    switch (get_loop_type()) {
        case 'home': $swag = 'This is the home page!'; break;
        case 'single': $swag = 'This is a single post!'; break;
        case 'category': $swag = get_category_parent_id(get_query_var('cat')); break;
        default: 'This is the default message, yo!'; break;
    } 

    return $swag; 
}

/**
 * Get ID of Category's Ultimate Parent
 * ------------------------------------
 * The site is sectioned into several parent categories with children and 
 * grandchildren beneath. Recursively ascend through parent categories until you
 * hit the top.
 * 
 * @param   int     $cat_id     
 * @return  int     $parent         Numeric ID of category's ultimate parent.
 */

function get_category_parent_id($cat_id) {
    $category = get_category($cat_id);
    $parent = $category->category_parent;

    if ($parent) {
        get_category_parent_id($parent);
    } 

    return $parent;
}

/**
 * Echo ID of Category's Ultiamte Parent
 * -------------------------------------
 */

function category_parent_id($cat_id = null) {
    printf('%s', get_category_parent_id($cat_id));
}

?>