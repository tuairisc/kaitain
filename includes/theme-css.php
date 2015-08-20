<?php

/**
 * Theme CSS
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

$google_fonts = array(
    /* All Google Fonts to be loaded.
     * Use format:
     * 
     *      'Open Sans:300',
     *      'Droid Sans:400'
     */
     'Open Sans:400'
);

$conditional_styles = array(
    // Conditional IE stylesheets. CSS file, and conditional.
    'ie-fallback' => array(THEME_CSS . 'ie.css', 'lte IE 9')
);

$theme_styles = array(
    // Compressed, compiled theme CSS.
    'main-style' => THEME_CSS . 'main.css',
    // WordPress style.css. Not really used.
    // 'wordpress-style' => THEME_URL . '/style.css',
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
 * Load Theme Custom Styles
 * -----------------------------------------------------------------------------
 * Load all theme CSS.
 */

function tuairisc_styles() {
    global $theme_styles, $google_fonts, $conditional_styles;

    foreach ($theme_styles as $name => $style) {
        wp_enqueue_style($name, $style, array(), THEME_VER);
    }

    if (!empty($google_fonts)) {
        wp_register_style('google-fonts', google_font_url($google_fonts));
        wp_enqueue_style('google-fonts');
    }

    foreach ($conditional_styles as $name => $style) {
        $path = $style[0];
        $condition = $style[1];

        wp_enqueue_style($name, $path, array(), THEME_VER);
        wp_style_add_data($name, 'conditional', $condition);
    }
}

/**
 * Load Administration Stylesheet
 * -----------------------------------------------------------------------------
 * Custom styling for theme elements on the admin side.
 * 
 * @param   string      $hook       The current admin page.
 */

function admin_styles($hook) { 
    wp_enqueue_style('tuairisc-admin', THEME_CSS . 'admin.css');
}

/**
 * Actions
 * -----------------------------------------------------------------------------
 */

add_action('wp_enqueue_scripts', 'tuairisc_styles');
add_action('admin_enqueue_scripts', 'admin_styles');

?>
