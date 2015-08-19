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

$google_fonts = array(
    /* All Google Fonts to be loaded.
     * Use format 'Open Sans:300', 'Droid Sans:400'
     * etc. */
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
