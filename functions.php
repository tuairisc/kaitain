<?php

/**
 * Theme Functions
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
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

define('THEME_VERSION', 1.1);
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

define('THEME_INCLUDES', THEME_PATH . '/includes/');
define('THEME_ADMIN', THEME_PATH . '/admin/');
define('THEME_WIDGETS', THEME_PATH . '/widgets/');
define('THEME_PARTIALS', '/partials/');

/**
 * Theme Partial Templates
 * -----------------------------------------------------------------------------
 */

define('PARTIAL_ARTICLES', THEME_PARTIALS . 'articles/article');
define('PARTIAL_ARCHIVES', THEME_PARTIALS . 'archives/archive');
define('PARTIAL_PAGES', THEME_PARTIALS . 'pages/');

/**
 * Image, CSS and JavaScript Assets
 * -----------------------------------------------------------------------------
 */

define('NODE_SCRIPTS', THEME_URL . '/node_modules/');
define('THEME_JS', ASSETS_URL . 'js/');
define('THEME_IMAGES', ASSETS_URL . 'images/');
define('THEME_CSS', ASSETS_URL . 'css/');

/**
 * Featured and Sticky Post Keys
 * -----------------------------------------------------------------------------
 */

add_option('tuairisc_sticky_post', array(
    'id' => 0,
    'expires' => 0
), '', true);

add_option('tuairisc_feature_post_key', 'tuairisc_is_featured_post');

/**
 *  Other Variables
 * -----------------------------------------------------------------------------
 */

// Flag post as job.
add_option('tuairisc_notice_post_key', 'is_tuairisc_notice', '', true);

// strftime date and locale.
add_option('tuairisc_fallback_locale', 'ga_IE','', true);
add_option('tuairisc_strftime_date_format', '%A, %B %e %Y','', true);

// Ghetto view counter meta key.
add_option('tuairisc_view_counter_key', 'tuairisc_view_counter', '', true);

add_option('tuairisc_prefetch_domains', array(
    // Media prefetch domains.
    preg_replace('/^www\./','',
    $_SERVER['SERVER_NAME'])
),'', true);

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
 * Theme Includes
 * -----------------------------------------------------------------------------
 */

// Featured and sticky posts.
include(THEME_INCLUDES . 'featured.php');
// Site sections.
include(THEME_INCLUDES . 'section-manager/section-manager.php');
// Open Graph and Twitter Card <head> meta tag links.
include(THEME_INCLUDES . 'social-meta/social-meta.php');
// Home and archive widget category output.
include(THEME_INCLUDES . 'home-category-output.php');

/** 
 * Social Media Accounts
 * -----------------------------------------------------------------------------
 */

$tuairisc_social_meta = new Social_Meta(array(
    'twitter' => '@tuairiscnuacht',
    'facebook' => 'tuairisc.ie',
    'fallback_image' => array(
        'url' => THEME_URL . '/assets/images/tuairisc.jpg',
        'path' => THEME_PATH . '/assets/images/tuairisc.jpg'
    )
));

/**
 * Site Sections
 * -----------------------------------------------------------------------------
 */

$sections = new Section_Manager(array(
    'categories' => array(191, 154, 155, 156, 157, 159, 187, 158), 
    'home' => 191
));

/**
 * Theme Admin Includes
 * -----------------------------------------------------------------------------
 */

// Featured/Sticky post meta box.
include(THEME_ADMIN . 'featured-edit-box.php');
include(THEME_ADMIN . 'notice-edit-box.php');

/** 
 * Widgets
 * -----------------------------------------------------------------------------
 */

// Link to selected author profiles.
include(THEME_WIDGETS . 'home-authors.php');
// Front page featured and sticky article widget.
include(THEME_WIDGETS . 'home-featured-articles.php');
// Front page category widgets.
include(THEME_WIDGETS . 'home-category.php');
// Sidebar featured category.
include(THEME_WIDGETS . 'sidebar-featured-category.php');
// Popular posts, sorted by internally-tracked view count.
include(THEME_WIDGETS . 'sidebar-popular-viewcount.php');
// Recent posts in $foo category.
include(THEME_WIDGETS . 'sidebar-recent-posts.php');

$widget_defaults = array(
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
);

$widget_areas = array(
    array(
        'name' => __('Front Page', TTD),
        'description' => __('Front page widget area.', TTD),
        'id' => 'widgets-front-page'
    ),
    array(
        'name' => __('Sidebar', TTD),
        'description' => __('Sidebar widget area.', TTD),
        'id' => 'widgets-sidebar'
    ),
    array(
        'name' => __('Footer #1', TTD),
        'description' => __('Footer widget area #1.', TTD),
        'id' => 'widgets-footer-1'
    ),
    array(
        'name' => __('Footer #2', TTD),
        'description' => __('Footer widget area #2.', TTD),
        'id' => 'widgets-footer-2'
    ),
    array(
        'name' => __('Footer #3', TTD),
        'description' => __('Footer widget area #3.', TTD),
        'id' => 'widgets-footer-3'
    ),
    array(
        'name' => __('Footer #4', TTD),
        'description' => __('Footer widget area #4.', TTD),
        'id' => 'widgets-footer-4'
    ),
);

/** 
 * Fonts, Styles and Scripts
 * -----------------------------------------------------------------------------
 */

$google_fonts = array(
    /* All Google Fonts to be loaded.
     * Use format 'Open Sans:300', 'Droid Sans:400'
     * etc. */
);

$theme_javascript = array(
    'google-analytics' => THEME_JS . 'analytics.js',
    'object-fit' => NODE_SCRIPTS . 'object-fit/dist/polyfill.object-fit.min.js',
    'functions' => THEME_JS . 'functions.js'
);

$theme_admin_javascript = array(
    'post-meta-box' => array('post.php', THEME_JS . 'meta-box.js')
);

$conditional_scripts = array(
    'html5-shiv' => array(
        NODE_SCRIPTS . 'html5shiv/dist/html5shiv.min.js',
        'lte IE 9'
    )
);

$theme_styles = array(
    // Compressed, compiled theme CSS.
    'main-style' => THEME_CSS . 'main.css',
    // WordPress style.css. Not really used.
    'wordpress-style' => THEME_URL . '/style.css',
    'object-fit-css' => NODE_SCRIPTS . 'object-fit/dist/polyfill.object-fit.css'
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
 */

function tuairisc_scripts() {
    global $theme_javascript, $conditional_scripts, $wp_scripts;

    foreach ($theme_javascript as $name => $script) {
        if (!WP_DEBUG) {
            // Instead load minified version if you aren't debugging.
            $script = str_replace(THEME_JS, THEME_JS . 'min/', $script);
            $script = str_replace('.js', '.min.js', $script);
        }

        wp_enqueue_script($name, $script, array('jquery'), THEME_VERSION, true);
    }

    foreach ($conditional_scripts as $name => $script) {
        $path = $script[0];
        $condition = $script[1];

        wp_enqueue_script($name, $path, array(), THEME_VERSION, false);
        wp_script_add_data($name, 'conditional', $condition);
    }
}

/**
 * Load Theme Custom Styles
 * -----------------------------------------------------------------------------
 * Load all theme CSS.
 */

function tuairisc_styles() {
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
 * Load Site JS in Footer
 * -----------------------------------------------------------------------------
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
        
        wp_enqueue_script($name, $script[1], array('jquery'), THEME_VERSION, true);
    }
}

/**
 * Register Widget Areas
 * -----------------------------------------------------------------------------
 * register_sidebars() doesn't give me enough options to name and identify 
 * several unique widget areas, but either do I want a half dozen 
 * register_sidebar() calls littering the function. They all share the same
 * defaults, so...
 */

function register_widget_areas() {
    global $widget_areas, $widget_defaults;

    foreach ($widget_areas as $widget) {
        register_sidebar(array_merge($widget, $widget_defaults));
    }
}

/**
 * Blog Title
 * -----------------------------------------------------------------------------
 * Stolen from Twenty Twelve. 
 * 
 * @param   string      $title          Title of whatever.
 * @param   string      $sep            Title separator.
 * @param   string      $side           Side on which separator will appear.
 * @return  string      $title          Modded title.
 */

function theme_title($title, $separator, $side) {
    global $paged, $page;
    if (is_feed()) {
        return $title;
    }

    if (is_404()) {
        $title = _e('Earráid 404', TTD);

        if ($separator) {
            if ($side === 'left') {
                $title = " $separator $title";
            } else {
                $title = "$title $separator ";
            }
        }
    }

    $title .= get_bloginfo('name');
    $site_description = get_bloginfo('description', 'display');

    if ($site_description && (is_home() || is_front_page())) {
        $title = "$title $separator $site_description";
    }

    if ($paged >= 2 || $page >= 2) {
        $title = "$title $separator " . sprintf(__('Page %s', TTD), max($paged, $page));
    }

    return $title;
}

/**
 * Pagination Post Counter
 * -----------------------------------------------------------------------------
 * Fetch and display total post count in format of 'Page 1 of 10'.
 * This only counts published, public posts; drafts, pages, custom
 * post types and private posts are all excluded unless you specify
 * inclusion.
 * 
 * @param   int     $page_num       Current page in pagination.
 * @param   int     $total_results  Total results, for pagination.
 * @return  string                  The post counter.
 */

function archive_page_count($echo = false, $page_num = null, $total_results = null) {
    global $wp_query;

    if (is_null($total_results)) {
        $total_results = $wp_query->found_posts;
    }

    if (is_null($page_num)) {
        $page_num = (get_query_var('paged')) ? get_query_var('paged') : 1;
    }

    $posts_per_page = get_option('posts_per_page');
    $total_pages = ceil($total_results / $posts_per_page);
    $page_count = sprintf(__('Page %s of %s', TTD), $page_num, $total_pages);

    if (!$echo) {
        return $page_count;
    }

    printf($page_count);
}

/**
 * Media Prefetch
 * -----------------------------------------------------------------------------
 * Set prefetch for a given media domain. Useful if your site is image heavy.
 */

function dns_prefetch() {
    $domains = get_option('tuairisc_prefetch_domains');
    
    if (!empty($domains)) {
        foreach ($domains as $domain) {
            printf('<link rel="dns-prefetch" href="//%s">', $domain);
        }
    }
}

/**
 * Get Date Using System Locale Files
 * -----------------------------------------------------------------------------
 * This function mirrors get_the_date(), except it uses strftiime(), and any 
 * localization supported by your system.
 * 
 * @param   string      $format      Format to use for the date.
 * @param   int         $post        ID of post whose date is needed.
 * @param   string      $locale      Locale to be used. Must be present on system!
 * @return  string                   Date in desired locale, with fallback to default locale.
 * 
 * @link https://secure.php.net/manual/en/function.strftime.php
 * @link http://www.bhalash.com/archives/13544804637  
 */

function get_the_date_strftime($format = null, $post = null, $locale = null) {
    $post = get_post($post);

    if (!$post) {
       return $false;
    } else {
        $time = mysql2date('U', $post->post_date);
    }

    if (!$locale) {
        $locale = get_option('tuairisc_fallback_locale');
    }

    if (!$format) {
        $format = get_option('tuairisc_strftime_date_format');
    }

    $locale = array(
        // Try to match common variants of the locale.
        $locale,
        $locale . '.utf8',
        $locale . '@euro',
        $locale . '@euro.utf8'
    );

    // @link http://stackoverflow.com/a/19351555/1433400
    setlocale(LC_ALL, '');
    setlocale(LC_ALL, $locale[0], $locale[1], $locale[2], $locale[3]);

    return strftime($format, $time);
}

/*
 * Print Date using System Locale
 * -----------------------------------------------------------------------------
 * @param   string      $format      Format to use for the date.
 * @param   int         $post        ID of post whose date is needed.
 * @param   string      $locale      Locale to be used. Must be present on system!
 * @param   bool        $echo        Print the date, if true.
 */

function the_date_strftime($format = null, $post = null, $locale = null, $echo = true) {
    $date = get_the_date_strftime($format, $post, $locale); 

    if ($echo) {
        printf($date);
    } else {
        return $date;
    }
}

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

    return implode(', ', $sizes);
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

/**
 * Increment Ghetto View Counter
 * -----------------------------------------------------------------------------
 * This was requested by the client for internal use. I do not consider this to
 * be an objectively reliable means to tally view counters for buisness use, but
 * it is Good Enough.
 *
 * @param   int     $post_id        ID of the post.
 */

function set_view_count($post_id = null) {
    if (is_singular('post') && !is_user_logged_in()) {
        $post = get_post($post);

        if (!$post) {
            return false;
        }
        
        $key = get_option('tuairisc_view_counter_key');
        $count = (int) get_post_meta($post->ID, $key, true);
        $count++;
        update_post_meta($post_id, $key, $count);
    }
}

/*
 * Fetch Ghetto View Counter
 * -----------------------------------------------------------------------------
 * @param   int     $post_id        ID of the post.
 * @return  int     $count          View count of the post.
 */

function get_view_count($post = null) {
    $post = get_post($post);
    
    if (!$post) {
        return false;
    }

    $key = get_option('tuairisc_view_counter_key');
    $count = (int) get_post_meta($post->ID, $key, true);

    if (!is_integer($count)) {
        update_post_meta($post->ID, $key, 0);
        return 0;
    }

    return $count;
}

/*
 * Increment Counter within Post
 * -----------------------------------------------------------------------------
 * The only part of the theme that calls the full post content are single
 * articles. This is /good enough/ for me. 
 * 
 * @param   string      $content        Post content.
 * @return  string      $content        Post content.
 */

function increment_view_counter($content) {
    set_view_count(get_the_ID());
    return $content;
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

function get_avatar_url_only($avatar, $id_or_email, $size, $default, $alt) {
    if (!is_admin()) {
        $avatar = preg_replace('/(^.*src="|"\s.*$)/', '', $avatar);
   }

   return $avatar;
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

function theme_comments($comment, $args, $depth) {
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
add_action('wp_enqueue_scripts', 'tuairisc_styles');
add_action('wp_enqueue_scripts', 'tuairisc_scripts');
add_action('admin_enqueue_scripts', 'admin_styles');
add_action('admin_enqueue_scripts', 'admin_scripts');

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

// Register widget areas.
add_action('widgets_init', 'register_widget_areas');

// Load all site JS in footer.
add_action('wp_enqueue_scripts', 'clean_header');

/**
 * Filters 
 * ----------------------------------------------------------------------------
 */

// Wordpress repeatedly inserted emoticons. No more, ever.
remove_filter('the_content', 'convert_smilies');
remove_filter('the_excerpt', 'convert_smilies');

// Title function.
add_filter('wp_title', 'theme_title', 1, 3);

/* This theme only calls content on the load of a full page article. It's a good
 * point at which to insert the post count increment. */
add_filter('the_content', 'increment_view_counter');

// Strip HTML from avatar URL.
add_filter('get_avatar', 'get_avatar_url_only', 10, 5);

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
