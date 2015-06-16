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
 * Filters, Options and Actions
 * -----------------------------------------------------------------------------
 */

if (!isset($content_width)) {
    $content_width = 960;
}

// Enqueue all scripts and stylesheets.
add_action('wp_enqueue_scripts', 'load_theme_styles');
add_action('wp_enqueue_scripts', 'load_theme_scripts');

remove_action('wp_head', 'wp_generator');

/**
 * Filters 
 * ----------------------------------------------------------------------------
 */

// Wordpress repeatedly inserted emoticons. No more, ever.
remove_filter('the_content', 'convert_smilies');
remove_filter('the_excerpt', 'convert_smilies');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Title function.
add_filter('wp_title', 'theme_title', 10, 2);

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
