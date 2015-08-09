<?php

/**
 * Category Archive
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 *
 * This file is part of Tuairisc.ie.
 * 
 * Tuairisc.ie is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Tuairisc.ie is distributed in the hope that it will be useful, but WITHOUT 
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Tuairisc.ie. If not, see <http://www.gnu.org/licenses/>.
 */

get_header();
global $cat;

$page_number = intval(get_query_var('paged'));
$meta_key = get_option('tuairisc_featured_post_key');
$featured_post_id = 0;

/**
 * Get Lead Featured Category Post
 * -----------------------------------------------------------------------------
 */

if ($page_number < 2) {
    $category_lead_featured = get_posts(array(
        // Get last featured post to go in the top slot.
        'numberposts' => 1,
        'meta_key' => $meta_key,
        'category' => $cat,
        'order' => 'DESC'
    ));

    set_transient('category_lead_featured', get_option('tuairisc_transient_timeout')); 

    if (sizeof($category_lead_featured) === 0) {
        // If it is empty, just grab the latest post to replace.
        $category_lead_featured = get_posts(array(
            'numberposts' => 1,
            'category' => $cat,
            'order' => 'DESC'
        ));
    }

    $featured_post_id = $category_lead_featured[0]->ID;

    foreach ($category_lead_featured as $post) {
        setup_postdata($post);
        get_template_part(PARTIAL_ARTICLES, 'archivelead');
    }
}

/**
 * Subcategory Widgets
 * -----------------------------------------------------------------------------
 */

if ($page_number < 2) {
    // Get category widgets. 
    $children_categories = get_categories(array(
        'parent' => $cat,
        'orderby' => 'name',
        'order' => 'ASC'
    ));

    if (!empty($children_categories)) {
        foreach ($children_categories as $child) {
            category_widget_output($child->cat_ID, 5);
        }
    }
}

if (have_posts()) {
    while (have_posts()) {
        // if (get_the_ID() !== $featured_post_id) {
            the_post();
            get_template_part(PARTIAL_ARTICLES, 'archive');
        // }
    }
}

get_template_part(THEME_PARTIALS . '/pagination');
get_footer();

?>
