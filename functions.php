<?php

/**
 * The Glorious Tuairisc Functions
 * -------------------------------
 * Except for the files included in the head, this represents most of the PHP 
 * work on the Tuairisc site. 
 * 
 * @author     Mark Grealish <mark@bhalash.com>
 * @link       http://www.bhalash.com
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    1.2
 * @link       http://www.tuairisc.ie
 * @link       https://github.com/bhalash/tuairisc.ie
 */

/**
 * File Paths
 * -----------------------------------------------------------------------------
 */

define('TUAIRISC_WIDGETS', get_template_directory() . '/widgets/');
define('TUAIRISC_FUNCTIONS', get_template_directory() . '/functions/');
define('TUAIRISC_INCLUDES', get_template_directory() . '/includes/');
define('TUAIRISC_ASSETS', get_template_directory_uri() . '/assets/');
define('TUAIRISC_JS', TUAIRISC_ASSETS . 'js/');
define('TUAIRISC_CSS', TUAIRISC_ASSETS . 'sass/');
define('TUAIRISC_IMAGES', TUAIRISC_ASSETS . 'images/');
define('TUAIRISC_LOGO', TUAIRISC_IMAGES . 'branding/brand-tuairisc.svg');

/**
 * Included Libraries
 * -----------------------------------------------------------------------------
 */

// Generate thumbnail images.
require_once(TUAIRISC_INCLUDES . 'get-the-image/get-the-image.php');
// Easily create and structure custom post types.
require_once(TUAIRISC_INCLUDES . 'wp-custom-post-type-class/src/CPT.php');

/**
 * PHP Scripts
 * -----------------------------------------------------------------------------
 */

// Translate English dates to Irish as the server does not support ga_IE
require_once(TUAIRISC_FUNCTIONS . 'irish-dates.php');
// Generate social sharing links on demand.
require_once(TUAIRISC_FUNCTIONS . 'sharing-links.php');
// Generate banners for sections and subsections.
require_once(TUAIRISC_FUNCTIONS . 'section-banners.php');
// Declare widget areas.
require_once(TUAIRISC_FUNCTIONS . 'widget-areas.php');
// Declare theme menus.
require_once(TUAIRISC_FUNCTIONS . 'menus.php');
// Generate head tag Open Graph and Twitter Card information.
require_once(TUAIRISC_FUNCTIONS . 'social-meta.php');
// All theme custom post types.
require_once(TUAIRISC_FUNCTIONS . 'custom-post-types.php');

// All theme custom post types.
require_once(TUAIRISC_FUNCTIONS . 'sections.php');

// Used internally for reporting.
require_once(TUAIRISC_FUNCTIONS . 'tuairisc/tuairisc-mostviewed.php');

/**
 * Theme Widgets
 * -----------------------------------------------------------------------------
 */

require_once(TUAIRISC_WIDGETS . 'recentposts.php');
require_once(TUAIRISC_WIDGETS . 'featured-category.php');
require_once(TUAIRISC_WIDGETS . 'popularnews.php');
require_once(TUAIRISC_WIDGETS . 'tabbed-categories.php');
require_once(TUAIRISC_WIDGETS . 'tuairisc-authors.php');

/**
 * Theme Variables
 * -----------------------------------------------------------------------------
 */

/* This is the author account used for small or generic posts on the Tuairisc 
 * site. By default Sean does not want any attribution to appear for them. */
$default_author_id = 37;

$custom_post_fields = array(
    // All important custom fields.
    'tuairisc_view_counter'
);

$index_excluded_categories = array(
    // Categories specified for exclusion from index loop display.
    216, 182
);

$theme_javascript = array(
    // All JavaScript loaded by theme.
    'modernizr' => 'modernizr-touch.min.js',
    'browser-detect' => 'browser-detect.min.js',
    'adrotate-fallback' => 'adrotate.min.js',
    'eventdrop' => 'eventdrop.min.js',
    'general-functions' => 'functions.min.js',
    'author-report' => 'author-report.min.js',
    'analytics' => 'google-analytics.min.js'
);

$theme_styles = array(
    'nuacht' => 'tuairisc.css'
);

$google_fonts = array(
    /* Zero-indexed array of all Google Fonts fonts to be loaded. Use this 
     * format for typefaces:
     * 
     * 'Open Sans Condensed 300',
     * 
     * */
);

/**
 * Theme Functions
 * -----------------------------------------------------------------------------
 */

/** 
 * Load Tuairisc JavaScript
 * ------------------------
 * Load all theme JavaScript.
 */

function load_theme_scripts() {
    global $theme_javascript;

    foreach ($theme_javascript as $name => $script) {
        if (WP_DEBUG) {
            // Load unminified versions while debugging.
            $script = str_replace('.min', '', $script);
        }

        wp_enqueue_script($name, TUAIRISC_JS . $script, array(), '2.0', true);
    }
}

/**
 * Parse Google Fonts from Array
 * -----------------------------
 * @param   array   $fonts          Array of fonts to be used.
 * @return  string  $google_url     Parsed URL of fonts to be enqueued.
 */

function google_font_url($fonts) {
    $google_url = array('//fonts.googleapis.com/css?family=');

    foreach ($fonts as $key => $value) {
        $google_url[] = str_replace(' ', '+', $value);

        if ($key < sizeof($google_fonts) - 1) {
            $google_url[] = '|';
        }
    }

    return implode('', $google_url);
}

/**
 * Load Tuairisc Custom Styles
 * ---------------------------
 * Load all theme CSS.
 */

function load_theme_styles() {
    global $theme_styles, $google_fonts;

    foreach ($theme_styles as $name => $style) {
        wp_enqueue_style('tuairisc', TUAIRISC_CSS . $style);
    }

    if (!empty($google_fonts)) {
        wp_register_style('google-fonts', google_font_url($google_fonts));
        wp_enqueue_style('google-fonts');
    }
}

// Load JavaScript scripts. 
add_action('wp_enqueue_scripts', 'load_theme_scripts');
add_action('wp_enqueue_scripts', 'load_theme_styles');

/** 
 * Return Thumbnail Image URL
 * --------------------------
 * Taken from: http://goo.gl/NhcEU6
 * 
 * WordPress, by default, only has a handy function to return a glob of HTML
 * -an image inside an anchor-for a post thumbnail. This wrapper extracts
 * and returns only the URL.
 * 
 * @param   int     $post_id        The ID of the post.
 * @param   int     $thumb_size     The requested size of the thumbnail.
 * @param   bool    $return_arr     Return either the entire thumbnail object or just the URL.
 * @return  string  $thumb_url[0]   URL of the thumbnail.
 * @return  array   $thumb_url      All information on the attachment.
 */

function get_thumbnail_url($post_id = null, $thumb_size = 'large', $return_arr = false) {

    if (is_null($post_id)) {
        $post_id = get_the_ID();
    }

    $thumb_id = get_post_thumbnail_id($post_id);
    $thumb_url = wp_get_attachment_image_src($thumb_id, $thumb_size, true);
    return ($return_arr) ? $thumb_url : $thumb_url[0];
}

/** 
 * Remove Excerpt Read More Link
 * -----------------------------
 * @param   string  $excerpt    The post excerpt.
 * @return  string  $excerpt    The post excerpt sans the read more link.
 */

function remove_read_more($excerpt) {
    return preg_replace('/(<a class="more.*<\/a>)/', '', $excerpt);
}

/** 
 * Replace Excerpt Break Tags
 * --------------------------
 * Replace break tags in an excerpt with a paragaraph tag. The excerpt will
 * already have an opening and closing <p></p> tags.
 * 
 * @param   string  $excerpt    The post excerpt.
 * @return  string  $excerpt    The post excerpt.
 */

function replace_excerpt_breaks($excerpt) {
    return str_replace('<br />', '</p><p>', $excerpt);
}

/**
 * Rewrite Search URL Cleanly
 * --------------------------
 * Cleanly rewrite search URL from ?s=topic to /search/topic
 * See: http://wpengineer.com/2258/change-the-search-url-of-wordpress/
 */

function clean_search_url() {
    if (is_search() && !empty($_GET['s'])) {
        wp_redirect(home_url('/search/') . urlencode(get_query_var('s')));
        exit();
    }
}

/**
 * Check Avatar Source
 * -------------------
 * WordPress fetches avatars by sending the user's email to Gravatar. The 
 * plugin 'WP User Avatar' allows you to upload and serve avatars locally.
 * 
 * Gravatar is treated as a fallback from this. The preference from Sean is
 * that /only/ local avatars should be shown.
 * 
 * @param   int     $user_id
 * @return  bool    $avatar_is_local
 */

function has_local_avatar($user_id = null) {
    if (is_null($user_id)) {
        $user_id = get_the_author_meta('ID');
    }

    $avatar_is_local = (strpos(get_avatar_url($user_id), 'gravatar') === false);

    return $avatar_is_local;
}

/**
 * Identify Site Default Author
 * ----------------------------
 * Certain articles are written on behalf of the site without attribution to
 * a specific author-recycled articles and press releases are typical of 
 * such posts.
 * 
 * Sean does not want any attribution for this account to appear at or above
 * these articles.
 * 
 * @param   int     $author_id
 * @return  bool    $is_default_account
 */

function is_default_author($author_id = null) {
    global $default_author_id;

    if (is_null($author_id)) {
        $author_id = get_the_author_meta('ID');
    }

    $is_default_account = ($author_id === $default_author_id);
    return $is_default_account;
}

/**
 * Parse User Role
 * ---------------
 * Sean wished to flag certain users are site columnists. This flag is set
 * as a 'yes' through extra user fields.
 * 
 * @param   int     $author_id      ID of the author.
 * @return  bool    $is_columnist   Is user a columnist true/false.
 */

function author_is_columnist($author_id = null) {
    if (is_null($author_id)) {
       $author_id = get_the_author_meta('id');
    }

    $meta_tag = get_the_author_meta('columnist', $author_id);
    $is_columnist = false;

    if (!empty($meta_tag)) {
        $meta_tag = strtolower($meta_tag);
        $meta_tag = strip_tags($meta_tag);
        $is_columnist = ($meta_tag === 'yes');
    } 

    return $is_columnist;
}

/**
 * Article-is-Column
 * -----------------
 * Identiy whether an article is part of an ongoing column, as set through
 * post custom fields.
 * 
 * @return  bool    $is_column      Is article a column piece true/false.
 */

function is_columnist_article() {
    $col_article = get_post_meta(get_the_ID(), 'is_column', true);
    $col_article = strtolower($col_article);
    $col_article = strip_tags($col_article);
    $is_column = ($col_article === '1');

    return $is_column;
}

/**
 * Title Tweak
 * -------------
 * Customize the title format so it looks like:
 *  site_title | section_title 
 * 
 * @param   string  $title      Item title.
 * @param   string  $sep        Separator between title words.
 * @return  string  $title
 */

function tweak_title($title, $sep) {
    $title = str_replace($sep, '', $title); 

    if (!is_home()) {
        $title = preg_replace('/^/', ' ' . $sep . ' ', $title);
        $title = preg_replace('/^/', bloginfo('name'), $title);
    }

    return $title;
}

/** 
 * Index Category Exclusion
 * ------------------------
 * Global exclusion and different treatment of the job categories were 
 * requested by Ciaran and Sean. The currently excluded categories are: 
 * 
 * # Category Name               Category ID
 * -----------------------------------------
 * 1 Imeachtaí                   182  
 * 2 Fógraí Poiblí/Folúntais     216   
 * 
 * I can exclude categories from post display with WP_Query, but these
 * exclusions are more nuanced, in that we want to both change how the 
 * categories are styled in the loop or exclude it entirely.
 * 
 * @return  bool    Article is in excluded category true/false.
 */

function is_excluded_category() {
    global $index_excluded_categories;

    foreach(get_the_category() as $c) {
        $cat_id = get_cat_id($c->cat_name);

        if (in_array($cat_id, $index_excluded_categories)) {
            return true;
        }
    }

    return false;
}

/**
 * Fetch Article View Count
 * ------------------------
 * @param   int     $post_id
 * @return  int     $count      Post view count.
 */

function get_view_count($post_id = null) {
    if (is_null($post_id)) {
        return;
    }

    global $custom_post_fields;
    $key = 'tuairisc_view_counter';

    $count = (int) get_post_meta($post_id, $key, true);

    if (!is_integer($count)) {
        update_post_meta($post_id, $key, 0);
        return 0;
    }

    return $count;
}

/**
 * Increment Post View Count
 * -------------------------
 * Requested by Sean. If post is not of custom type and viewer is not logged
 * in, then increment counter by +1.
 * @param   int     $post_id
 */

function increment_view_counter($post_id = null) {
    if (is_null($post_id)) {
        $post_id = get_the_ID();
    }

    global $custom_post_fields;
    $key = 'tuairisc_view_counter';

    if (!is_custom_type() && !is_user_logged_in()) {
        $count = (int) get_post_meta($post_id, $key, true);
        $count++;
        update_post_meta($post_id, $key, $count);
    }
}

/**
 * Dump Post Types to JavaScript Console
 * -------------------------------------
 * Useful for debug on occasion. 
 */

function list_post_types() {
    $type_args = array(
        'public' => true,
        '_builtin' => false
    );

    $output = 'names';
    $operator = 'and';
    $post_types = get_post_types($type_args, $output, $operator); 

    foreach ($post_types as $post_type) {
        printf('<script>console.log("%s");</script>', $post_type);
    }
}

/**
 * Filters, Options and Actions
 * -----------------------------------------------------------------------------
 */

// Clean search URL rewrite.
add_action('template_redirect', 'clean_search_url');
// Change large size to match post content width.
update_option('large_size_w', 770);
// Rearrange title.
add_filter('wp_title', 'tweak_title', 10, 2);
// Remove read more links from excerpts.
add_filter('the_excerpt', 'remove_read_more');
add_filter('the_excerpt', 'replace_excerpt_breaks');
// Page excerpts for SEO and the education landing page. 
add_action('init', add_post_type_support('page', 'excerpt'));

?>