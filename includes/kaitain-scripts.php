<?php

/**
 * Kaitain Scripts
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

function kaitain_scripts() {
    $assets = get_template_directory_uri() . '/assets/';
    $js_path = $assets . 'js/';
    $css_path = $assets . 'css/';
    $node_path = $assets . '/node_modules/';

    $kaitain_js = array(
        'google-analytics' => $js_path . 'analytics.js',
        'functions' => $js_path . 'functions.js'
    );

    $kaitain_conditional_js = array(
        'html5-shiv' => array(
            $node_path . 'html5shiv/dist/html5shiv.min.js',
            'lte IE 9'
        ),
        'jquery-placeholder' => array(
            $node_path . 'jquery-placeholder/jquery.placeholder.min.js',
            'lte IE 9'
        ),
        'functions-ie' => array(
            $js_path . 'functions-ie.js',
            'lte IE 9'
        )
    );
  
    $kaitain_admin_js = array(
        'post-meta-box' => array('post.php', $js_path . 'meta-box.js'),
        // 'new-meta-box' => array('post.php', $js_path . 'new-meta-box.js')
    );

    $kaitain_fonts = array(
        /* All Google Fonts to be loaded.
         * Use format:
         * 
         * 'Open Sans:300',
         */
         'Open Sans:400'
    );

    $kaitain_css = array(
        // Compressed, compiled theme CSS.
        'main-style' => $css_path . 'main.css'
    );

    $kaitain_conditional_css = array(
        // Conditional IE stylesheets. CSS file, and conditional.
        'ie-fallback' => array($css_path . 'ie.css', 'lte IE 9')
    );

    $kaitain_admin_css = array(
        'tuairic-admin' => $css_path . 'admin.css'
    );

    kaitain_js($kaitain_js, $kaitain_admin_js, $kaitain_conditional_js, $js_path);
    kaitain_css($kaitain_css, $kaitain_admmin_css, $kaitain_conditional_css, $kaitain_fonts);
}

/*
 * Load Site JS in Footer
 * -----------------------------------------------------------------------------
 * @link http://www.kevinleary.net/move-javascript-bottom-wordpress/#comment-56740
 */

function kaitain_clean_header() {
    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);
}

add_action('wp_enqueue_scripts', 'kaitain_clean_header');

/** 
 * Sheepie JavaScript Loader
 * -----------------------------------------------------------------------------
 */

function kaitain_js($kaitain_js, $kaitain_admin_js, $kaitain_conditional_js, $js_path) {
    if (is_404()) {
        return;
    }

    if (!is_admin()) {
        foreach ($kaitain_js as $name => $script) {
            // Regular frontend JavaScript.
            if (!WP_DEBUG) {
                // Instead load minified version if you aren't debugging.
                $script = str_replace($js_path, $js_path . 'min/', $script);
                $script = str_replace('.js', '.min.js', $script);
            }

            wp_enqueue_script($name, $script, array('jquery'), $GLOBALS['kaitain_version'], true);
        }

        foreach ($kaitain_conditional_js as $name => $script) {
            // Internet Explorer scripts.
            $path = $script[0];
            $condition = $script[1];

            wp_enqueue_script($name, $path, array(), $GLOBALS['kaitain_version'], false);
            wp_script_add_data($name, 'conditional', $condition);
        }

        if (is_singular()) {
            wp_enqueue_script('comment-reply');
        }
    }
    
    if (is_admin()) {
        // Admin JavaScript.
        foreach ($kaitain_admin_js as $name => $script) {
            if ($script[0] && $hook !== $script[0]) {
                continue;
            }
            
            wp_enqueue_script($name, $script[1], array('jquery'), THEME_VER, true);
        }
    }
}

/**
 * Sheepie CSS Loader
 * -----------------------------------------------------------------------------
 * Load all theme CSS.
 */

function kaitain_css($kaitain_css, $kaitain_admin_css, $kaitain_conditional_css, $kaitain_fonts) {
    foreach ($kaitain_css as $name => $style) {
        wp_enqueue_style($name, $style, array(), $GLOBALS['kaitain_version']);
    }

    if (!empty($kaitain_fonts)) {
        wp_register_style('google-fonts', kaitain_google_font_url($kaitain_fonts));
        wp_enqueue_style('google-fonts');
    }

    foreach ($kaitain_conditional_css as $name => $style) {
        $path = $style[0];
        $condition = $style[1];

        wp_enqueue_style($name, $path, array(), $GLOBALS['kaitain_version']);
        wp_style_add_data($name, 'conditional', $condition);
    }

    if (is_admin()) {
        foreach ($kaitain_admin_css as $name => $style) {
            wp_enqueue_style($name, $style);
        }
    }
}

/**
 * Parse Google Fonts from Array
 * -----------------------------------------------------------------------------
 * @param   array   $fonts          Array of fonts to be used.
 * @return  string  $google_url     Parsed URL of fonts to be enqueued.
 */

function kaitain_google_font_url($fonts) {
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

?>
