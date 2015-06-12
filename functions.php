<?php
/**
 * The Glorious Tuairisc Functions
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
 */

define('THEME_VERSION', 0.1);

/**
 * Theme Text Domain
 * -----------------------------------------------------------------------------
 */

define('TTD', 'tuairisc');

/**
 * Theme File Paths
 * -----------------------------------------------------------------------------
 */

define('THEME_PATH', get_template_directory());
define('THEME_URL', get_template_directory_uri());

/**
 * Theme Asset Paths
 * -----------------------------------------------------------------------------
 */

define('ASSETS_PATH', THEME_PATH . '/assets/');
define('ASSETS_URL', THEME_URL . '/assets/');

/**
 * Theme Includes and Partials Paths
 * -----------------------------------------------------------------------------
 * File paths are inconsistent between get_template_part() and include() or
 * require(). 
 * 
 * 1. With include(), / is the ultimate root on the filesystem, as provided by 
 *    get_template_directory();
 * 2. With get_template_parth(), / is the WordPress theme folder. 
 * 
 * Included files are entire standalone scripts, and partials are partials 
 * templates.
 */

define('THEME_FUNCTIONS',  THEME_PATH . '/functions/');
define('THEME_INCLUDES',  THEME_PATH . '/includes/');
define('THEME_WIDGETS', THEME_PATH . '/widgets/');
define('THEME_PARTIALS',  '/partials/');

/**
 * Image, CSS and JavaScript Assets
 * -----------------------------------------------------------------------------
 */

define('THEME_JS', ASSETS_URL . 'js/');
define('THEME_IMAGES', ASSETS_URL . 'images/');
define('THEME_CSS', ASSETS_URL . 'css/');

/**
 * Included Libraries
 * -----------------------------------------------------------------------------
 */

$theme_includes = array(
    // Retrive arbitrary image sizes from the WordPress media library.
    'get-the-image/get-the-image.php',
    // Easily create and structure custom post types.
    'wp-custom-post-type-class/src/CPT.php'
);

foreach ($theme_includes as $include) {
    require_once(THEME_INCLUDES . $include);
}

/**
 * PHP Scripts
 * -----------------------------------------------------------------------------
 */

$theme_functions = array(
    // Translate English dates to Irish as the server does not support ga_IE
   'irish-dates.php', 
    // Generate social sharing links on demand.
   'sharing-links.php',
    // Generate banners for sections and subsections.
   'section-banners.php',
    // Declare widget areas.
   'widget-areas.php',
    // Declare theme menus.
   'menus.php',
    // All theme custom post types.
   'custom-post-types.php',
    // All theme custom post types.
   'sections.php',
    // Used internally for reporting.
   'tuairisc/tuairisc-mostviewed.php'
);

foreach ($theme_functions as $script) {
    require_once(THEME_FUNCTIONS . $script);
}

/**
 * Theme Widgets
 * -----------------------------------------------------------------------------
 */

$theme_widgets = array(
    'recentposts.php',
    'featured-category.php',
    'popularnews.php',
    'tabbed-categories.php',
    'tuairisc-authors.php'
);

foreach ($theme_widgets as $widget) {
    require_once(THEME_WIDGETS . $widget);
}

/**
 * Theme JavaScript
 * -----------------------------------------------------------------------------
 */

$theme_javascript = array(
    // All JavaScript loaded by theme.
    'modernizr' => THEME_JS . 'modernizr-touch.min.js',
    'adrotate-fallback' => THEME_JS . 'adrotate.min.js',
    'eventdrop' => THEME_JS . 'eventdrop.min.js',
    'general-functions' => THEME_JS . 'functions.min.js',
    'author-report' => THEME_JS . 'author-report.min.js',
    'analytics' => THEME_JS . 'google-analytics.min.js',
    'sharing' => THEME_JS . 'sharing.js',
);

/**
 * Google Fonts
 * -----------------------------------------------------------------------------
 * Zero-indexed array of all Google Fonts fonts to be loaded. Use this 
 * format for typefaces:
 * 
 * 'Open Sans Condensed',
 * 'Open Sans:300,400,700,800',
 */

$google_fonts = array();

/**
 * Theme CSS Stylesheets
 * -----------------------------------------------------------------------------
 */

$theme_styles = array(
    'nuacht' => THEME_CSS . 'tuairisc.css'
);

/**
 * Miscellaneous Variables
 * -----------------------------------------------------------------------------
 */

// Media prefetch domain: If null or empty, defaults to site domain.
$prefetch_domains = array(
    preg_replace('/^www\./','', $_SERVER['SERVER_NAME'])
);

/* This is the author account used for small or generic posts on the Tuairisc 
 * site. By default Sean does not want any attribution to appear for them. */
$default_author_id = 37;

// All important custom fields.
$custom_post_fields = array('tuairisc_view_counter');

// Categories specified for exclusion from index loop display.
$index_excluded_categories = array(216, 182);

$social_twitter = '@tuairiscnuacht';

/** 
 * Load Tuairisc JavaScript
 * -----------------------------------------------------------------------------
 * Load all theme JavaScript.
 */

function load_theme_scripts() {
    global $theme_javascript;

    if (!is_admin()) {
        /* Load jQuery into the footer instead of the header.
         * See: http://biostall.com/how-to-load-jquery-in-the-footer-of-a-wordpress-website */
        wp_deregister_script('jquery');
        wp_register_script('jquery-argh', '/wp-includes/js/jquery/jquery.js', false, '1.11.1', true);
        wp_enqueue_script('jquery-argh');
    }

    foreach ($theme_javascript as $name => $script) {
        if (WP_DEBUG) {
            // Load unminified versions while debugging.
            $script = str_replace('.min', '', $script);
        }

        wp_enqueue_script($name, $script, array('jquery-argh'), THEME_VERSION, true);
    }
}

/**
 * Parse Google Fonts from Array
 * -----------------------------------------------------------------------------
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
 * -----------------------------------------------------------------------------
 * Load all theme CSS.
 */

function load_theme_styles() {
    global $theme_styles, $google_fonts;

    foreach ($theme_styles as $name => $style) {
        wp_enqueue_style($name, $style, array(), THEME_VERSION);
    }

    if (!empty($google_fonts)) {
        wp_register_style('google-fonts', google_font_url($google_fonts));
        wp_enqueue_style('google-fonts');
    }
}

/** 
 * Remove Excerpt Read More Link
 * -----------------------------------------------------------------------------
 * @param   string  $excerpt    The post excerpt.
 * @return  string  $excerpt    The post excerpt sans the read more link.
 */

function remove_read_more($excerpt) {
    return preg_replace('/(<a class="more.*<\/a>)/', '', $excerpt);
}

/** 
 * Replace Excerpt Break Tags
 * -----------------------------------------------------------------------------
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
 * -----------------------------------------------------------------------------
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
 * Get Avatar URL
 * -----------------------------------------------------------------------------
 * Wrapper for get_avatar that only returns the URL. Yes, WordPress added a 
 * get_avatar_url() function in version 4.2. The Tuairisc site, however, uses 
 * a plugin named WP User Avatar (https://wordpress.org/plugins/wp-user-avatar/)
 * to upload and serve avatars from a local source.
 * 
 * 1. WP User Avatar hooks into get_avatar()
 * 2. As of April 29 2015 the plugin does not support the new get_avatar_data()
 *    and get_avatar_url() functions. 
 * 
 * That is to say both new functions will stil only serve from Gravatar without 
 * consideration of locally-uploaded avatars.
 * 
 * @param   string  $id_or_email    Either user ID or email address.
 * @param   int     $size           Avatar size.
 * @param   string  $default        URL for fallback avatar.
 * @param   string  $alt            Alt text for image.
 * @param   string                  The avatar's URL.
 */

function get_avatar_url_only($id_or_email, $size, $default, $alt) {
   $avatar = get_avatar($id_or_email, $size, $default, $alt); 
   return preg_replace('/(^.*src="|"\s.*$)/', '', $avatar); 
}

/**
 * Check Avatar Source
 * -----------------------------------------------------------------------------
 * See the description for get_avatar_url_only() directly above this. Check that
 * 
 * 1. Avatar is not a Gravatar fallback.
 * 2. Avatar is not a WP USer Avatar fallback.
 *
 * @param   int     $user_id
 * @return  bool    $avatar_is_local
 */

function has_local_avatar($user_id = null) {
    if (is_null($user_id)) {
        $user_id = get_the_author_meta('ID');
    }

    $avatar = get_avatar_url_only($user_id);
    return (!strpos($avatar, 'gravatar') && !strpos($avatar, 'fallback-avatar'));
}

/**
 * Identify Site Default Author
 * -----------------------------------------------------------------------------
 * Certain articles are written on behalf of the site without attribution to
 * a specific author-recycled articles and press releases are typical of 
 * such posts.
 * 
 * Sean does not want any attribution for this account to appear at or above
 * these articles.
 * 
 * @param   int     $author_id
 * @return  bool    
 */

function is_default_author($author_id = null) {
    global $default_author_id;
    $author_id = 0;

    if (is_null($author_id)) {
        $author_id = get_the_author_meta('ID');
    }

    return ($author_id === $default_author_id);
}

/**
 * Parse User Role
 * -----------------------------------------------------------------------------
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
 * -----------------------------------------------------------------------------
 * Identiy whether an article is part of an ongoing column, as set through
 * post custom fields.
 * 
 * @return  bool    $is_column      Is article a column piece true/false.
 */

function is_columnist_article($post_id = null) {
    if (is_null($post_id)) {
        $post_id = get_the_ID();
    }

    $col_article = get_post_meta($post_id, 'is_column', true);
    $col_article = strtolower($col_article);
    $col_article = (int) strip_tags($col_article);
    return ($col_article === 1);
}

/**
 * Title Tweak
 * -----------------------------------------------------------------------------
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
 * Blog Title
 * -----------------------------------------------------------------------------
 * Shamelessly stolen from Twenty Twelve. 
 * 
 * @param   string      $title          Title of whatever.
 * @param   string      $sep            Title separator.
 */

function tuairisc_title($title, $sep) {
    global $paged, $page;

    if (is_feed()) {
        return $title;
    }

    $title .= get_bloginfo('name');
    $site_description = get_bloginfo('description', 'display');

    if ($site_description && (is_home() || is_front_page())) {
        $title = "$title $sep $site_description";
    }

    if ($paged >= 2 || $page >= 2) {
        $title = "$title $sep " . sprintf(__('Page %s', TTD), max($paged, $page));
    }

    return $title;
}

/** 
 * Index Category Exclusion
 * -----------------------------------------------------------------------------
 * Global exclusion and different treatment of the job categories were 
 * requested by Ciaran and Sean. The currently excluded categories are: 
 * 
 * # Category Name               Category ID
 * -----------------------------------------------------------------------------
 * 1 Imeachtaí                   182  
 * 2 Fógraí Poiblí/Folúntais     216   
 * 
 * I can exclude categories from post display with WP_Query, but these
 * exclusions are more nuanced, in that we want to both change how the 
 * categories are styled in the loop or exclude it entirely.
 * 
 * @return  bool    $is_excluded    Article is in excluded category true/false.
 */

function is_excluded_category() {
    global $index_excluded_categories;
    $is_excluded = false;

    foreach(get_the_category() as $c) {
        $cat_id = get_cat_id($c->cat_name);

        if (in_array($cat_id, $index_excluded_categories)) {
            $is_excluded = true;
            break;
        }
    }

    return $is_excluded;
}

/**
 * Increment Post View Count
 * -----------------------------------------------------------------------------
 * @param   int     $post_id
 */

function increment_view_counter($post_id = null) {
    if (is_null($post_id)) {
        $post_id = get_the_ID();
    }

    global $custom_post_fields;
    $key = $custom_post_fields[0];

    if (!is_custom_type() && !is_user_logged_in()) {
        $count = (int) get_post_meta($post_id, $key, true);
        $count++;
        update_post_meta($post_id, $key, $count);
    }
}

/**
 * Media Prefetch
 * -----------------------------------------------------------------------------
 * Set prefetch for a given media domain. Useful if your site is image heavy.
 */

function dns_prefetch() {
    global $prefetch_domains;

    foreach ($prefetch_domains as $domain) {
        printf('<link rel="dns-prefetch" href="//%s">', $domain);
    }
}

/**
 * Fetch Article View Count
 * -----------------------------------------------------------------------------
 * @param   int     $post_id
 * @return  int     $count      Post view count.
 */

function get_view_count($post_id = null) {
    if (is_null($post_id)) {
        return;
    }

    global $custom_post_fields;
    $key = $custom_post_fields[0];

    $count = (int) get_post_meta($post_id, $key, true);

    if (!is_integer($count)) {
        update_post_meta($post_id, $key, 0);
        return 0;
    }

    return $count;
}

/**
 * Options and Actions
 * -----------------------------------------------------------------------------
 */

// Enqueue JavaScript and CSS. 
add_action('wp_enqueue_scripts', 'load_theme_scripts', 0);
add_action('wp_enqueue_scripts', 'load_theme_styles', 0);

// Set prefetch domain for media.
add_action('wp_head', 'dns_prefetch');

// Remove WordPress version from header.
remove_action('wp_head', 'wp_generator');

// Clean search URL rewrite.
add_action('template_redirect', 'clean_search_url');

// Change large size to match post content width.
update_option('large_size_w', 770);

/**
 * Filters
 * -----------------------------------------------------------------------------
 */

// Wordpress repeatedly inserted emoticons. No more, ever.
remove_filter('the_content', 'convert_smilies');
remove_filter('the_excerpt', 'convert_smilies');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Remove read more links from excerpts.
add_filter('the_excerpt', 'remove_read_more');
add_filter('the_excerpt', 'replace_excerpt_breaks');

// Page excerpts for SEO and the education landing page. 
add_action('init', add_post_type_support('page', 'excerpt'));

// Title function.
add_filter('wp_title', 'tuairisc_title', 10, 2);
// add_filter('wp_title', 'tweak_title', 10, 2);

/**
 * Theme Support
 * -----------------------------------------------------------------------------
 */

// HTML5 support in theme.
current_theme_supports('html5');
current_theme_supports('menus');

add_theme_support('post-thumbnails');

add_theme_support('html5', array(
    'comment-list', 'comment-form', 'search-form', 'gallery', 'caption'
));

?>