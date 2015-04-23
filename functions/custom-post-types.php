<?php

/**
 * Theme Custom Post Types
 * -----------------------
 * The Tuairisc site has a subsection that advertises government and education
 * employment position. The particular needs included things such as: no 
 * comment support, banners and entirely separate admin listings.
 * 
 * It made sense to create a custom post type as they can fulfil all of these 
 * criteria.
 *  
 * @category   PHP Script
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    1.2
 * @link       https://github.com/bhalash/tuairisc.ie
 */

$custom_post_types = array(
    // The names of custom post types declared and used in this theme.
    'foluntais'
);

$foluntais = new CPT($custom_post_types[0], array(
    'post_type_name' => $custom_post_types[0],
    'description' => __('Tuairisc.ie job listings'),
    'singular' => __('Job'),
    'plural' => __('Jobs'),
    'slug' => 'foluntais',
    'menu_icon' => 'dashicons-groups',
    'supports' => array(
        'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'
    ),
    'taxonomies' => array(
        'category', 'post_tag'
    ),
    'labels' => array(
        'name' => _x('Jobs', 'post type general name'),
        'singlular_name' => _x('Job', 'post type individual name'),
        'add_new' => _x('Add New', 'job'),
        'add_new_item' => __('Add New Job'),
        'edit_item' => __('Edit Job'),
        'new_item' => __('New Job'),
        'menu_name' => __('Jobs'),
        'all_items' => __('All Jobs'),
        'search_items' => __('Search Jobs'),
        'not_found' => __('No jobs found'),
        'not_found_in_trash' => __('No jobs found in the Trash'),
        'parent_item_colon' => '',
    ),
));

function is_custom_type() {
    /**
     * Evaluate Post Type 
     * ------------------
     * Evaluate whether the post/archive/whatever is part of any custom Tuairisc
     * type.
     * 
     * @param {none}
     * @return {bool} Whether the post is of a custom type true/false.
     */

    global $custom_post_types;
    return (in_array(get_post_type(), $custom_post_types));
}

function is_custom_type_singular() {
    /**
     * Evaluate Post Type 
     * ------------------
     * Evaluate whether the post/archive/whatever is part of any custom Tuairisc
     * type.
     * 
     * @param {none}
     * @return {bool} Whether the post is of a custom type true/false.
     */

    global $custom_post_types;
    return (in_array(get_post_type(), $custom_post_types) && is_singular($custom_post_types));
}

// function generate_job_breadcrumbs() {
//     /** 
//      * Generate Foluntais Breadcrumbs
//      * ------------------------------ 
//      * I couldn't think of a better way to do this, because I needed to 
//      * ultimately link back to the /custom type archive/ instead of a 
//      * category archive. 
//      *
//      * I build a breadcrumb back to the type archive and then append a link
//      * to the first category attached to the custom type post.
//      * 
//      * @param {none}
//      * @return {string} $foluntais_link The generated breadcrumb trail.
//      */

//     global $custom_post_types;

//     $foluntais_link = array();
//     $foluntais_link[] = '<a href="';
//     $foluntais_link[] = get_post_type_archive_link($custom_post_types[0]);
//     $foluntais_link[] = '">';
//     $foluntais_link[] = get_post_type(); 
//     $foluntais_link[] = '</a>';

//     if (is_category()) {
//         $category = get_query_var('cat');
//     } else {
//         $category = get_the_category();
//     }

//     if (is_custom_type_singular() && has_category() || is_category()) {
//         /* If a category or single post with category, append the object's 
//          * category, or first category if single. */
//         $foluntais_link[] = '<a href="';
//         $foluntais_link[] = get_category_link($category[0]->cat_ID); 
//         $foluntais_link[] = '">';
//         $foluntais_link[] = $category[0]->name;
//         $foluntais_link[] = '</a>';
//     }

//     return implode('', $foluntais_link);
// }

?>