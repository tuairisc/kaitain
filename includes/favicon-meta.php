<?php 

add_option('tuairisc_favicons', array(
    // Website favicon assets.
    'favicon' => array(
        'path' => THEME_IMAGES . 'icons/favicon.ico',
        'sizes' => array(16, 24, 32, 48, 64),
    ),
    'windows' => array(
        'name' => get_bloginfo('name'),
        'colour' => '#475967',
        'path' => THEME_IMAGES . 'icons/icon-windows.png',
    ),
    'apple' => array(
        'path' => THEME_IMAGES . 'icons/icon-apple.png',
        'sizes' => array(152),
    )
),'', true);

/**
 * Reduce Favicon Sizes
 * -----------------------------------------------------------------------------
 * @param   array       $sizes      Array of icon sizes (32, 48, etc.).
 * @return  string      $sizes      Sizes as strings separated by ', '.
 */

function reduce_sizes($sizes) {
    for ($i = 0; $i < count($sizes); $i++) {
        $sizes[$i] .= 'x' . $sizes[$i];
    }

    return implode(' ', $sizes);
}

/**
 * Generate ICO Favicon Meta Tag
 * -----------------------------------------------------------------------------
 * @param   array       $icon       Icon information.
 * @return  string                  Favicon HTML meta tag.
 */

function favicon_ico($icon) {
    $favicon = array();
    $sizes = '';

    $sizes = reduce_sizes($icon['sizes']);
    $favicon[] = sprintf('<link rel="shortcut icon" sizes="%s" type="image/x-icon" href="%s">', $sizes, $icon['path']);

    return implode('', $favicon);
}

/**
 * Generate iOS Icon Meta Tag
 * -----------------------------------------------------------------------------
 * @param   array       $icon       Icon information.
 * @return  string                  Apple icon HTML meta tag.
 */

function favicon_apple($icon) {
    $apple_icon = array();
    $sizes = '';

    $sizes = reduce_sizes($icon['sizes']);
    $apple_icon[] = sprintf('<link rel="apple-touch-icon" sizes="%s" href="%s">', $sizes, $icon['path']);

    return implode('', $apple_icon);
}

/**
 * Generate Windows 8/10 Pinned Tile Meta Tag
 * -----------------------------------------------------------------------------
 * @param   array       $icon       Icon information.
 * @return  string                  Windows icon HTML meta tag.
 */

function favicon_windows($icon) {
    $windows_icon = array();

    $windows_icon[] = sprintf('<meta name="application-name" content="%s">', $icon['name']);
    $windows_icon[] = sprintf('<meta name="msapplication-TileImage" content="%s">', $icon['path']);
    $windows_icon[] = sprintf('<meta name="msapplication-TileColor" content="%s">', $icon['colour']);

    return implode('', $windows_icon);
}

/**
 * Load Favicon
 * -----------------------------------------------------------------------------
 * Every different browser has their own special snowflake favicon format. 
 */

function set_favicon() {
    $favicons = get_option('tuairisc_favicons'); 
    $meta_tags = array();

    $meta_tags[] = favicon_ico($favicons['favicon']);
    $meta_tags[] = favicon_apple($favicons['apple']);
    $meta_tags[] = favicon_windows($favicons['windows']);

    printf(implode('', $meta_tags));
}

// Set site favicon.
add_action('wp_head', 'set_favicon');

?>
