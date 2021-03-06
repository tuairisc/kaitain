<?php

/**
 * Kaitain Scripts
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Kaitain
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/kaitain-theme
 * @link       http://www.tuairisc.ie
 */

$GLOBALS['kaitain_asset_paths'] = array(
    'js' => get_template_directory_uri() . '/assets/js/min/',
    'css' => get_template_directory_uri() . '/assets/css/',
    'node' => get_template_directory_uri() . '/node_modules/'
);

add_action('wp_head', function() {
    $js_path = $GLOBALS['kaitain_asset_paths']['js'];
    $css_path = $GLOBALS['kaitain_asset_paths']['css'];
    $node_path = $GLOBALS['kaitain_asset_paths']['node'];

    $kaitain_js = array(
        'kaitain-functions' => array(
            $js_path . 'kaitain.js',
            array('jquery'),
        )
    );

    $kaitain_conditional_js = array(
        'html5-shiv' => array(
            $node_path . 'html5shiv/dist/html5shiv.min.js',
            'lte IE 9',
            array()
        ),
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
        'main-style' => $css_path . 'style.css'
    );

    $kaitain_conditional_css = array(
        // Conditional IE stylesheets. CSS file, and conditional.
        'ie-fallback' => array($css_path . 'ie.css', 'lte IE 9')
    );

    kaitain_js($kaitain_js, $kaitain_conditional_js, $js_path);
    kaitain_css($kaitain_css, $kaitain_conditional_css, $kaitain_fonts);
});

/*
 * Load Site JS in Footer
 * -----------------------------------------------------------------------------
 * @link http://www.kevinleary.net/move-javascript-bottom-wordpress/#comment-56740
 */

add_action('admin_head', function() {
    $js_path = $GLOBALS['kaitain_asset_paths']['js'];
    $css_path = $GLOBALS['kaitain_asset_paths']['css'];

    kaitain_admin_js(array(
        'postmeta-functions' => array(
            'post.php', $js_path . 'admin/admin.js'
        ),
    ));

    kaitain_admin_css(array(
        'tuairic-admin' => $css_path . 'admin.css'
    ));
});

/*
 * Forcibly Load JS in Footer
 * -----------------------------------------------------------------------------
 * This will affect plugin scripts too: all code will load in the footer.
 */

if (!is_admin()) {
    add_action('wp_enqueue_scripts', function() {
        remove_action('wp_head', 'wp_print_scripts');
        remove_action('wp_head', 'wp_print_head_scripts', 9);
        remove_action('wp_head', 'wp_enqueue_scripts', 1);
    });
}

/**
 * Kaitain JavaScript Loader
 * -----------------------------------------------------------------------------
 */

function kaitain_js($kaitain_js, $kaitain_conditional_js, $js_path) {
    if (is_404()) {
        return;
    }

    foreach ($kaitain_js as $name => $script) {
        wp_enqueue_script($name, $script[0], $script[1], $GLOBALS['kaitain_version'], true);
    }

    foreach ($kaitain_conditional_js as $name => $script) {
        wp_enqueue_script($name, $script[0], $script[2], $GLOBALS['kaitain_version'], false);
        wp_script_add_data($name, 'conditional', $script[1]);
    }

    if (is_singular()) {
        wp_enqueue_script('comment-reply');
    }
}

function kaitain_admin_js($kaitain_admin_js) {
    foreach ($kaitain_admin_js as $name => $script) {
        wp_enqueue_script(
            $name,
            $script[1],
            array('jquery'),
            $GLOBALS['kaitain_version'],
            true
        );
    }
}

/**
 * Kaitain CSS Loader
 * -----------------------------------------------------------------------------
 * Load all theme CSS.
 */

function kaitain_css($kaitain_css, $kaitain_conditional_css, $kaitain_fonts) {
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
}

function kaitain_admin_css($kaitain_admin_css) {
    foreach ($kaitain_admin_css as $name => $style) {
        wp_enqueue_style($name, $style);
    }
}

/**
 * Parse Google Fonts from Array
 * -----------------------------------------------------------------------------
 * @param   array   $fonts          Array of fonts to be used.
 * @return  string  $google_url     Parsed URL of fonts to be enqueued.
 */

function kaitain_google_font_url($fonts) {
    $google_url = array('//fonts.googleapis.com/css?family=');

    foreach ($fonts as $key => $value) {
        $google_url[] = str_replace(' ', '+', $value);

        if ($key < sizeof($fonts) - 1) {
            $google_url[] = '|';
        }
    }

    return implode('', $google_url);
}

?>
