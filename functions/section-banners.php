<?php
/**
 * Category Section and Education Banenrs
 * --------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 */

$banners = array(
    /* Classes and the current category ID for the Greann category, which has
     * a different banner style. */
    'classes' => array(
        /* See $banner_colours: If the correct colour-from-ID can't be 
         * determined by category ID, then consult this array for the ID to 
         * use. */
        'normal', 'greann'
    ),
    'greann_cat' => 158,
);

$education_categories = array(
    /* There are five sub-categories within the education category, 187 being
     * the parent. */
    187, 202, 203, 204, 205, 206
);

function get_banner_breadcrumb() {
    /** 
     * Get Post or Archive Banner
     * --------------------------
     * This returns the appropriate set of breadcrumb links for the given 
     * category/single post. Breadcrumb links are created in three different 
     * ways:
     * 
     * 1. Single, categorized posts and archive pages use get_category_parents
     * 2. The Greann category archive pages uses the category's description. 
     * 3. Foluntais posts use get_job_category_link. 
     * 
     * Breadcrumbs are a pain in the ass. 
     *
     * @param {none}
     * @return {none}
     */

    global $banners, $custom_post_types;
    $breadcrumb = '';
 
    if (has_category($banners['greann_cat'])) {
        // 1. Greann category post.
        $breadcrumb = '<span>' .  category_description($greann) . '</span>';
    } else if (!is_custom_type()) {
        // 2. Non-Foluntais posts and archives.
        $breadcrumb = generate_breadcrumbs();
    } else {
        // 3. Foluntais custom type archive, category archive and single posts.
        $breadcrumb = generate_job_breadcrumbs();
    }

    printf($breadcrumb);
}

function generate_breadcrumbs() {
    /** 
     * Generate Breadcrumbs
     * -------------------- 
     * Generate the breadcrumb trail for non-foluntais single posts and post 
     * archives.
     * 
     * @param {none}
     * @return {string} Breadcrumb trail for category-> parent category.
     */

    if (is_category()) {
        // Non-foluntais archive.
        $category = get_query_var('cat');
    } else {
        // Non-foluntais single.
        $category = get_the_category();
        $category = $category[0]->cat_ID;
    }

    return get_category_parents($category, true, '&nbsp;');
}

function banner_classes() {
    /**
     * Return Unique Banner Class
     * --------------------------
     * Despite different colours, there are only two CSS styles:
     * 
     * 1. Narrow width banner wih left-aligned breadcrumb.
     * 2. Wide Greann banner with the Greann logo.
     * 
     * This returns the correct CSS class.
     * 
     * @param {none}
     * @return {string} $banner_classes CSS classes for banner.
     */

    global $banners;

    $banner_classes = array(
        'breadcrumb-banner ',
        'banner-'
    );

    if (has_category($banners['greann_cat'])) {
        $banner_classes[] = $banners['classes'][1];
    } else {
        $banner_classes[] = $banners['classes'][0];
    }

    if (is_category()) {
        // Coloured banners only for categories.
        $category = get_category(get_query_var('cat'));
        $banner_classes[] = ' category-';

        if ($category->category_parent > 0) {
            $banner_classes[] = $category->category_parent;
        } else {
            $banner_classes[] = $category->cat_ID;
        }
    }

    return implode('', $banner_classes);
}


function education_landing_shortcode($atts) {
    /**
     * Education Landing Shortcode
     * ---------------------------
     * The education landing page links through to the five different segments. 
     * These are boxy clickable boxes complete with title and description.
     *
     * @param {array} $attributes Shortcode values.
     * @return {string} $education
     */

    global $education_categories;
    $shortcode_atts = shortcode_atts(array('id' => 0), $atts);
    $category_id = '';
    $education_html = '';

    // Change $id to 0 if it falls outside 0-5 range. 
    if ($shortcode_atts['id'] < 0 || $shortcode_atts['id'] > 5) {
        $category_id = $education_categories[0];
    } else {
        $category_id = $education_categories[$shortcode_atts['id']];
    }

    $education_html = '<div class="education-box education-'
        . $category_id . '"><a href="' . get_category_link($category_id) 
        . '"><p><span>' . get_cat_name($category_id) . '</span><br />' 
        . category_description($category_id) . '</a></p></div>';

    return $education_html;
}

function education_banner_shortcode($attributes, $content = null) {
    /**
     * Education Banner Shortcode
     * --------------------------
     * Generate either a tall or short dividing subheading banners for within 
     * education section posts.
     * 
     * @param {array} $attributes Shortcode attributes.
     * @param {string} $content Banner message.
     * @return {string} $banner Dividing banner.
     */

    $banner = array();
    // h2
    $headline_type = 2;
    $headline_class = 'edu-heading';
    $shortcode_atts = shortcode_atts(array('type' => 'main'), $attributes);

    if (is_null($content)) {
        $content = 'Did you forget to include text?';
    }

    if ('main' !== $shortcode_atts['type']) {
        // If the banner is not 'main', change h2 to h2 and heading to subheading.
        $headline_type = 3;
        $headline_class = str_replace('-h', '-subh', $headline_class);
    }

    $banner[] = '<h' . $headline_type . ' class="' . $headline_class . '">';
    $banner[] = $content;
    $banner[] = '</h' . $headline_type . '>';

    return implode('', $banner);
}

// Add shortcode for landing.
add_shortcode('landing', 'education_landing_shortcode');
// Add shortcode for education banners.
add_shortcode('banner', 'education_banner_shortcode');
?>