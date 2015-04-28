<?php

/**
 * Theme Custom Post Types
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 *
 * This file is part of Nuacht.
 * 
 * Nuacht is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Nuacht is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Nuacht. If not, see <http://www.gnu.org/licenses/>.
 * -----------------------
 * The Tuairisc site has a subsection that advertises government and education
 * employment position. The particular needs included things such as: no 
 * comment support, banners and entirely separate admin listings.
 * 
 * It made sense to create a custom post type as they can fulfil all of these 
 * criteria.
 */

$custom_post_types = array(
    // The names of custom post types declared and used in this theme.
    'foluntais'
);

$Foluntais = new CPT($custom_post_types[0], array(
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

/**
 * Evaluate Post Type 
 * ------------------
 * Evaluate whether the post/archive/whatever is part of any custom Tuairisc
 * type.
 * 
 * @return  bool    Whether the post is of a custom type true/false.
 */

function is_custom_type() {
    global $custom_post_types;
    return (in_array(get_post_type(), $custom_post_types));
}

/**
 * Evaluate Post Type 
 * ------------------
 * Evaluate whether the post/archive/whatever is part of any custom Tuairisc
 * type.
 * 
 * @param   int     $post_id
 * @return  bool    Whether the post is of a custom type true/false.
 */

function is_custom_type_singular($post_id = null) {
    if (is_null($post_id)) {
        $post_id = get_the_id();
    }

    global $custom_post_types;
    return (in_array(get_post_type($post_id), $custom_post_types) && is_singular($custom_post_types));
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
//      * @return string $foluntais_link The generated breadcrumb trail.
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