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
 */

get_header();
global $cat;

$trans_name = 'category_lead_post';
$page_number = intval(get_query_var('paged'));
$meta_key = get_option('tuairisc_featured_post_key');
$children = get_categories(array('child_of' => $cat));
$featured_post_id = 0;

/**
 * Get Lead Featured Category Post
 * -----------------------------------------------------------------------------
 */

if ($page_number < 2) {
    if (!($category_lead_post = get_cat_featured_post($cat))) {
        // If it is empty, just grab the latest post to replace.
        $category_lead_post = get_posts(array(
            'numberposts' => 1,
            'category' => $cat,
            'order' => 'DESC'
        ));
    } else {
        $category_lead_post = array_slice($category_lead_post, 0, 1);
    }

    $featured_post_id = $category_lead_post[0]->ID;

    foreach ($category_lead_post as $post) {
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

if (have_posts() && $page_number || empty($children)) {
    while (have_posts()) {
        the_post();

        if (get_the_ID() !== $featured_post_id) {
            get_template_part(PARTIAL_ARTICLES, 'archive');
        }
    }
}

get_template_part(THEME_PARTIALS . '/pagination');
get_footer();

?>
