<?php
/**
 * The Glorious Tuairisc Functions
 * -------------------------------
 * Except for the files included in the head, this represents most of the PHP 
 * work on the Tuairisc site. 
 * 
 * @category   PHP Script
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 */

define('TUAIRISC_WIDGETS', get_template_directory() . '/widgets/');
define('TUAIRISC_FUNCTIONS', get_template_directory() . '/functions/');
define('TUAIRISC_INCLUDES', get_template_directory() . '/includes/');

require_once(TUAIRISC_FUNCTIONS . 'irish-dates.php');
require_once(TUAIRISC_FUNCTIONS . 'sharing-links.php');
require_once(TUAIRISC_FUNCTIONS . 'section-banners.php');
require_once(TUAIRISC_FUNCTIONS . 'sidebar.php');
require_once(TUAIRISC_FUNCTIONS . 'social-meta.php');

// Used internally.
require_once(TUAIRISC_FUNCTIONS . 'tuairisc/tuairisc-mostviewed.php');

require_once(TUAIRISC_WIDGETS . 'recentposts.php');
require_once(TUAIRISC_WIDGETS . 'featured-category.php');
require_once(TUAIRISC_WIDGETS . 'popularnews.php');
require_once(TUAIRISC_WIDGETS . 'tabbed-categories.php');
require_once(TUAIRISC_WIDGETS . 'tuairisc-authors.php');

require_once(TUAIRISC_INCLUDES . '/get-the-image/get-the-image.php');

/* This is the author account used for small or generic posts on the Tuairisc 
 * site. By default Sean does not want any attribution to appear for them. */
$default_author_id = 37;

$custom_post_types = array(
    // All custom post types declared and used in this theme.
    'foluntais'
);

$custom_post_fields = array(
    // All important custom fields.
    'tuairisc_view_counter'
);

$index_excluded_categories = array(
    // Categories specified for exclusion from index loop display.
    216, 182
);

$tuairisc_javascript = array(
    // All JavaScript loaded by theme.
    'modernizr' => 'modernizr-touch.min.js',
    'browser-detect' => 'browser-detect.min.js',
    'adrotate-fallback' => 'adrotate.min.js',
    'eventdrop' => 'eventdrop.min.js',
    'general-functions' => 'functions.min.js',
    'author-report' => 'author-report.min.js'
);

$tuairisc_css = array(
    'tuairisc' => get_template_directory_uri() . '/assets/sass/tuairisc.css'
);

function load_tuairisc_scripts() {
    /** 
     * Load Tuairisc JavaScript
     * ------------------------
     * Load all theme JavaScript.
     * 
     * @param {none}
     * @return {none}
     */

    global $tuairisc_javascript;
    $path = get_stylesheet_directory_uri() . '/assets/js/';

    foreach ($tuairisc_javascript as $key => $value) {
        if (WP_DEBUG) {
            $value = str_replace('.min', '', $value);
        }

        wp_enqueue_script($key, $path . $value, array(), '2.0', true);
    }
}

function load_tuairisc_styles() {
    /**
     * Load Tuairisc Custom Styles
     * ---------------------------
     * Load all theme CSS.
     * 
     * @param {none}
     * @return {none}
     */

    global $tuairisc_css;

    foreach ($tuairisc_css as $key => $value) {
        wp_enqueue_style($key, $value);
    }
}

function get_thumbnail_url($post_id = null, $thumb_size = 'large', $return_arr = false) {
    /** 
     * Return Thumbnail Image URL
     * --------------------------
     * Taken from: http://goo.gl/NhcEU6
     * 
     * WordPress, by default, only has a handy function to return a glob of HTML
     * -an image inside an anchor-for a post thumbnail. This wrapper extracts
     * and returns only the URL.
     * 
     * @param {int} $post_id The ID of the post.
     * @param {int} $thumb_size The requested size of the thumbnail.
     * @param {bool} $return_arr Return either the entire thumbnail object or just the URL.
     * @return {string} $thumb_url[0] URL of the thumbnail.
     * @return {array} $thumb_url All information on the attachment.
     */

    if (is_null($post_id)) {
        $post_id = get_the_ID();
    }

    $thumb_id = get_post_thumbnail_id($post_id);
    $thumb_url = wp_get_attachment_image_src($thumb_id, $thumb_size, true);
    return ($return_arr) ? $thumb_url : $thumb_url[0];
}

function remove_read_more($excerpt) {
    /** 
     * Remove Excerpt Read More Link
     * -----------------------------
     * @param {string} $excerpt The post excerpt.
     * @return {string} $excerpt THe post excerpt sans the read more link.
     */

    return preg_replace('/(<a class="more.*<\/a>)/', '', $excerpt);
}

function replace_excerpt_breaks($excerpt) {
    /** 
     * Replace Excerpt Break Tags
     * --------------------------
     * Replace break tags in an excerpt with a paragaraph tag. The excerpt will
     * already have an opening and closing <p></p> tags.
     * 
     * @param {string} $excerpt The post excerpt.
     * @return {string} $excerpt The post excerpt.
     */

    return str_replace('<br />', '</p><p>', $excerpt);
}

function get_avatar_url($user_id = null, $avatar_size = null) {
    /**
     * Return URL of User Avatar 
     * -------------------------
     * WordPress does not provide an easy way to access only the URL of the 
     * user's avatar, hence this.
     * 
     * @param {int} $user_id The ID of the user.
     * @param {int} $avatar_size Size of the avatar to be returned.
     * @return {string} $avatar_url The URL of the avatar. 
     */

    if (is_null($user_id)) {
        $user_id = get_the_author_meta('ID');
    }

    if (is_null($avatar_size)) {
        $avatar_size = 100;
    }

    $avatar_url = get_avatar($user_id, $avatar_size);
    $avatar_url = preg_replace('/(^.*src="|".*$)/', '', $avatar_url);
    return $avatar_url;
}

function has_local_avatar($user_id = null) {
    /**
     * Check Avatar Source
     * -------------------
     * WordPress fetches avatars by sending the user's email to Gravatar. The 
     * plugin 'WP User Avatar' allows you to upload and serve avatars locally.
     * 
     * Gravatar is treated as a fallback from this. The preference from Sean is
     * that /only/ local avatars should be shown.
     * 
     * @param {int} $user_id
     * @return {bool} $avatar_is_local
     */

    if (is_null($user_id)) {
        $user_id = get_the_author_meta('ID');
    }

    $avatar_is_local = (strpos(get_avatar_url($user_id), 'gravatar') === false);

    return $avatar_is_local;
}

function is_default_author($author_id = null) {
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
     * @param {int} $author_id
     * @return {bool} $is_default_account
     */

    global $default_author_id;

    if (is_null($author_id)) {
        $author_id = get_the_author_meta('ID');
    }

    $is_default_account = ($author_id === $default_author_id);
    return $is_default_account;
}

function author_is_columnist($author_id = null) {
    /**
     * Parse User Role
     * ---------------
     * Sean wished to flag certain users are site columnists. This flag is set
     * as a 'yes' through extra user fields.
     * 
     * @param {int} $author_id ID of the author.
     * @return {bool} $is_columnist Is user a columnist true/false.
      */

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

function is_columnist_article() {
    /**
     * Article-is-Column
     * -----------------
     * Identiy whether an article is part of an ongoing column, as set through
     * post custom fields.
     * 
     * @param {none}
     * @return {bool} $is_column Is article a column piece true/false.
     */

    $col_article = get_post_meta(get_the_ID(), 'is_column', true);
    $col_article = strtolower($col_article);
    $col_article = strip_tags($col_article);
    $is_column = ($col_article === '1');

    return $is_column;
}

function tweak_title($title, $sep) {
    /**
     * Title Tweak
     * -------------
     * Customize the title format so it looks like:
     *  site_title | section_title 
     * 
     * @param {string} $title Item title.
     * @param {string} $sep Separator between title words.
     * @return {string} $title
     */

    $title = str_replace($sep, '', $title); 

    if (!is_home()) {
        $title = preg_replace('/^/', ' ' . $sep . ' ', $title);
        $title = preg_replace('/^/', bloginfo('name'), $title);
    }

    return $title;
}

function is_excluded_category() {
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
     * @param {none}
     * @return {bool} Article is in excluded category true/false.
     */

    global $index_excluded_categories;

    foreach(get_the_category() as $c) {
        $cat_id = get_cat_id($c->cat_name);

        if (in_array($cat_id, $index_excluded_categories)) {
            return true;
        }
    }

    return false;;
}

function get_view_count($post_id = null) {
    /**
     * Fetch Article View Count
     * ------------------------
     * @param {int} $post_id
     * @return {int} $count Post view count.
     */

    global $custom_post_fields;

    if (is_null($post_id)) {
        return;
    }

    $key = $custom_post_fields[0];
    $count = (int) get_post_meta($post_id, $key, true);

    if (!is_integer($count)) {
        update_post_meta($post_id, $key, 0);
        return 0;
    }

    return $count;
}

function increment_view_counter($post_id = null) {
    /**
     * Increment Post View Count
     * -------------------------
     * Requested by Sean. If post is not of custom type and viewer is not logged
     * in, then increment counter by +1.
     *  
     * @param {int} $post_id
     * @return {none}
     */

    global $custom_post_fields;

    if (is_null($post_id)) {
        $post_id = get_the_ID();
    }

    if (!is_custom_type() && !is_user_logged_in()) {
        $key = $custom_post_fields[0];
        $count = (int) get_post_meta($post_id, $key, true);
        $count++;
        update_post_meta($post_id, $key, $count);
    }
}

/*
 * Debug and Helpers
 * -----------------
 */

function list_post_types() {
    /**
     * Dump Post Types to JavaScript Console
     * -------------------------------------
     * Useful for debug on occasion. 
     * 
     * @param {none}
     * @return {none}
     */
    
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

// Change large size to match post content width.
update_option('large_size_w', 770);
// Load JavaScript scripts. 
add_action('wp_enqueue_scripts', 'load_tuairisc_scripts');
add_action('wp_enqueue_scripts', 'load_tuairisc_styles');
// Rearrange title.
add_filter('wp_title', 'tweak_title', 10, 2);
// Remove read more links from excerpts.
add_filter('the_excerpt', 'remove_read_more');
add_filter('the_excerpt', 'replace_excerpt_breaks');

// Page excerpts for SEO and the education landing page. 
add_action('init', add_post_type_support('page', 'excerpt'));
?>