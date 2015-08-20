<?php

/**
 * Theme JavaScript
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

$theme_javascript = array(
    'google-analytics' => THEME_JS . 'analytics.js',
    'functions' => THEME_JS . 'functions.js'
);

$theme_admin_javascript = array(
    'post-meta-box' => array('post.php', THEME_JS . 'meta-box.js'),
    // 'new-meta-box' => array('post.php', THEME_JS . 'new-meta-box.js')
);

$conditional_scripts = array(
    'html5-shiv' => array(
        NODE_SCRIPTS . 'html5shiv/dist/html5shiv.min.js',
        'lte IE 9'
    ),
    'jquery-placeholder' => array(
        NODE_SCRIPTS . 'jquery-placeholder/jquery.placeholder.min.js',
        'lte IE 9'
    ),
    'functions-ie' => array(
        THEME_JS . 'functions-ie.js',
        'lte IE 9'
    )
);

/** 
 * Load Theme JavaScript
 * -----------------------------------------------------------------------------
 */

function tuairisc_scripts() {
    global $theme_javascript, $conditional_scripts, $wp_scripts;

    foreach ($conditional_scripts as $name => $script) {
        $path = $script[0];
        $condition = $script[1];

        wp_enqueue_script($name, $path, array(), THEME_VER, false);
        wp_script_add_data($name, 'conditional', $condition);
    }

    foreach ($theme_javascript as $name => $script) {
        if (!WP_DEBUG) {
            // Instead load minified version if you aren't debugging.
            $script = str_replace(THEME_JS, THEME_JS . 'min/', $script);
            $script = str_replace('.js', '.min.js', $script);
        }

        wp_enqueue_script($name, $script, array('jquery'), THEME_VER, true);
    }
}

/**
 * Load Administration Scripts
 * -----------------------------------------------------------------------------
 * Custom styling for theme elements on the admin side.
 * 
 * @param   string      $hook       The current admin page.
 */

function admin_scripts($hook) { 
    global $theme_admin_javascript;

    foreach ($theme_admin_javascript as $name => $script) {
        if ($script[0] && $hook !== $script[0]) {
            continue;
        }
        
        wp_enqueue_script($name, $script[1], array('jquery'), THEME_VER, true);
    }
}

/**
 * Load Site JS in Footer
 * -----------------------------------------------------------------------------
 * This forces /all/ JavaScript, including plugin JavaScript, to load into the 
 * site footer, which can make a drastic difference in loading time. 
 * 
 * @link http://www.kevinleary.net/move-javascript-bottom-wordpress/
 */

function clean_header() {
    if (!is_admin()) {
        remove_action('wp_head', 'wp_print_scripts');
        remove_action('wp_head', 'wp_print_head_scripts', 9);
        remove_action('wp_head', 'wp_enqueue_scripts', 1);
    }
}

/**
 * Actions
 * -----------------------------------------------------------------------------
 */

add_action('wp_enqueue_scripts', 'tuairisc_scripts');
add_action('admin_enqueue_scripts', 'admin_scripts');
add_action('wp_enqueue_scripts', 'clean_header');

?>
