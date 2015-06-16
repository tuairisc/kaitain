<?php

/**
 * Theme Functions
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
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
 * Theme Version and Text Domain
 * -----------------------------------------------------------------------------
 */

define('THEME_VERSION', 1.0);
define('TTD', 'tuairisc');

/**
 * Theme PHP File and URL Paths 
 * -----------------------------------------------------------------------------
 */

define('THEME_PATH', get_template_directory());
define('THEME_URL', get_template_directory_uri());

/**
 * Theme Asset File and URL Paths
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

define('THEME_INCLUDES',  THEME_PATH . '/includes/');
define('THEME_PARTIALS',  '/partials/');

/**
 * Image, CSS and JavaScript Assets
 * -----------------------------------------------------------------------------
 */

define('THEME_JS', ASSETS_URL . 'js/');
define('THEME_IMAGES', ASSETS_URL . 'images/');
define('THEME_CSS', ASSETS_URL . 'css/');

/** 
 * Social Media Accounts
 * -----------------------------------------------------------------------------
 */

$social_twitter = '@tuairiscnuacht';
$social_facebook = 'tuairisc.ie';

/**
 * Sitewide Fallback Image File
 * -----------------------------------------------------------------------------
 */

$fallback_image = array(
    'url' => THEME_URL . '/assets/images/tuairisc.jpg',
    'path' => THEME_PATH . '/assets/images/tuairisc.jpg'
);

/**
 *  Other Variables
 * -----------------------------------------------------------------------------
 */

// Media prefetch domains.
$prefetch_domains = array(
    preg_replace('/^www\./','', $_SERVER['SERVER_NAME'])
);

// Theme Favicons 
$favicon_path = THEME_IMAGES . 'favicon.png';

/**
 * Theme Includes
 * -----------------------------------------------------------------------------
 */

include(THEME_INCLUDES . 'social-meta/social-meta.php');
include(THEME_INCLUDES . 'get-the-image/get-the-image.php');
include(THEME_INCLUDES . 'wp-custom-post-type-class/src/CPT.php');

/** 
 * Fonts, Styles and Scripts
 * -----------------------------------------------------------------------------
 */

$google_fonts = array(
    // All Google Fonts to be loaded.
);

$theme_javascript = array(
    'google-analytics' => THEME_JS . 'analytics.js',
    'functions' => THEME_JS . 'functions.min.js'
);

$theme_styles = array(
    // Compressed, compiled theme CSS.
    'main-style' => THEME_CSS . 'main.css',
    // WordPress style.css. Not really used.
    'wordpress-style' => THEME_URL . '/style.css',
);

/**
 * Parse Google Fonts from Array
 * -----------------------------------------------------------------------------
 * @param   array   $fonts          Array of fonts to be used.
 * @return  string  $google_url     Parsed URL of fonts to be enqueued.
 */

function google_font_url($fonts) {
    global $google_fonts;
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
 * Load Theme JavaScript
 * -----------------------------------------------------------------------------
 * Load all theme JavaScript. It will jQuery into the footer instead of the header.
 * 
 * @link    http://biostall.com/how-to-load-jquery-in-the-footer-of-a-wordpress-website 
 */

function load_theme_scripts() {
    global $theme_javascript;

    if (!is_admin()) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js', false, '1.11.1', true);
        wp_enqueue_script('jquery');
    }

    foreach ($theme_javascript as $name => $script) {
        if (WP_DEBUG) {
            // Load unminified versions while debugging.
            $script = str_replace('.min', '', $script);
        }

        wp_enqueue_script($name, $script, array('jquery'), THEME_VERSION, true);
    }
}

/**
 * Load Theme Custom Styles
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
 * Blog Title
 * -----------------------------------------------------------------------------
 * Stolen from Twenty Twelve. 
 * 
 * @param   string      $title          Title of whatever.
 * @param   string      $sep            Title separator.
 * @return  string      $title          Modded title.
 */

function theme_title($title, $sep) {
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
 * Load Favicon
 * -----------------------------------------------------------------------------
 */

function set_favicon() {
    global $favicon_path;
    printf('<link rel="icon" type="image/png" href="%s" />', $favicon_path);
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
 * @return  string                  The avatar's URL.
 */

function get_avatar_url_only($id_or_email, $size, $default, $alt) {
   $avatar = get_avatar($id_or_email, $size, $default, $alt);
   return preg_replace('/(^.*src="|"\s.*$)/', '', $avatar);
}

/**
 * Rewrite Search URL Cleanly
 * -----------------------------------------------------------------------------
 * Cleanly rewrite search URL from ?s=topic to /search/topic
 *
 * @link    http://wpengineer.com/2258/change-the-search-url-of-wordpress/
 */

function clean_search_url() {
    if (is_search() && ! empty($_GET['s'])) {
        wp_redirect(home_url('/search/') . urlencode(get_query_var('s')));
        exit();
    }
}

/**
 * Custom Comment and Comment Form Output
 * -----------------------------------------------------------------------------
 * @param   string  $comment    The comment.
 * @param   array   $args       Array argument
 * @param   int     $depth      Depth of the comments thread.
 */

function rmwb_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment; ?>

    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div class="avatar-wrapper">
            <?php echo get_avatar($comment, 75); ?>
        </div>
        <div class="comment-interior">
            <header>
                <p class="author"><?php comment_author_link(); ?></p>
                <p class="date"><small><?php printf(__('%1$s at %2$s', TTD), get_comment_date(), get_comment_time()); ?></small></p>
            </header>

            <?php if ($comment->comment_approved === '0') {
                printf('<p>%s</p>', _e('Your comment has been held for moderation.', TTD));
            } ?>

            <div class="comment-body">
                <?php comment_text(); ?>
            </div>
            <?php if (is_user_logged_in()) : ?>
                <footer>
                    <p><small>
                        <?php edit_comment_link(__('edit', TTD),'  ',''); ?>
                    </small></p>
                </footer>
            <?php endif; ?>
        </div>
    </li><?php
}

/**
 * Wrap Comment Fields in Elements
 * -----------------------------------------------------------------------------
 * @link    https://wordpress.stackexchange.com/questions/172052/how-to-wrap-comment-form-fields-in-one-div
 */

function wrap_comment_fields_before() {
    printf('<div class="commentform-inputs">');
}

function wrap_comment_fields_after() {
    printf('</div>');
}

/**
 * Filters, Options and Actions
 * -----------------------------------------------------------------------------
 */

if (!isset($content_width)) {
    $content_width = 960;
}

// Enqueue all scripts and stylesheets.
add_action('wp_enqueue_scripts', 'load_theme_styles');
add_action('wp_enqueue_scripts', 'load_theme_scripts');

// Remove the "Generate by WordPress x.y.x" tag from the header.
remove_action('wp_head', 'wp_generator');

// Stop WordPress loading JavaScript that helps render emoji correctly.
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Set site favicon.
add_action('wp_head', 'set_favicon');

// Set prefetch domain for media.
add_action('wp_head', 'dns_prefetch');

// Wrap comment form fields in <div></div> tags.
add_action('comment_form_before_fields', 'wrap_comment_fields_before');
add_action('comment_form_after_fields', 'wrap_comment_fields_after');

/**
 * Filters 
 * ----------------------------------------------------------------------------
 */

// Wordpress repeatedly inserted emoticons. No more, ever.
remove_filter('the_content', 'convert_smilies');
remove_filter('the_excerpt', 'convert_smilies');

// Title function.
add_filter('wp_title', 'theme_title', 10, 2);

/**
 * Theme Supports
 * -----------------------------------------------------------------------------
 */

/* Critical part of the theme; every post has a crafted exerpt and thumbnail
 * image. */
add_theme_support('post-thumbnails');

// HTML5 support in theme.
current_theme_supports('html5');
current_theme_supports('menus');

add_theme_support('html5', array(
    'comment-list', 'comment-form', 'search-form', 'gallery', 'caption'
));    

?>
