<?php

/**
 * Theme Functions
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

/**
 * Theme Version and Text Domain
 * -----------------------------------------------------------------------------
 */

define('THEME_VER', 1.9);
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
 *  Other Variables
 * -----------------------------------------------------------------------------
 */

add_option('tuairisc_hidden_users', array(
    // Users whose avatar should not display in single posts.
    1, 2, 37, 48
), '', true);

// Transient API timeout in minutes.
add_option('tuairisc_transient_timeout', 60 * 20, '', true);
// Flag post as job.
add_option('tuairisc_notice_post_key', 'is_tuairisc_notice', '', true);
// Ghetto view counter meta key.
add_option('tuairisc_view_counter_key', 'tuairisc_view_counter', '', true);

add_option('tc_dns_prefetch_domains', array(
    // Media prefetch domains. Add any domains you feel are worthy.
    preg_replace('/^www\./', '', $_SERVER['SERVER_NAME'])
),'', true);

/**
 * Theme Includes
 * -----------------------------------------------------------------------------
 */

$included_scripts = array(
    // All theme widgets.
    'theme-widgets.php',
    // Theme CSS.
    'theme-css.php',
    // Theme JavaScript.
    'theme-js.php',
    // Featured and sticky posts.
    'featured-sticky-posts.php',
    // Site sections.
    'section-manager/section-manager.php',
    // Open Graph and Twitter Card <head> meta tag links.
    'social-meta/social-meta.php',
    // Avatar output.
    'avatars.php',
    // Home and archive widget category output.
    'category-widget-output.php',
    // Single post social sharing links.
    'social-share.php',
    // Categorically-related posts.
    'single-post-related-posts.php',
    // Localized date.
    'date-strftime.php',
    // Favicon management.
    'favicon-meta.php',
    // Theme image sizes.
    'theme-image-sizes.php'
);

foreach ($included_scripts as $script) {
    include_once(THEME_INCLUDES . $script);
}

/**
 * Theme Admin Includes
 * -----------------------------------------------------------------------------
 */

$included_admin_scripts = array(
    // Featured/Sticky post meta box.
    'featured-edit-box',
    'notice-edit-box',
);

foreach($included_admin_scripts as $script) {
    include_once(THEME_ADMIN  . $script . '.php');
}

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
 * Register Menu Areas
 * -----------------------------------------------------------------------------
 */

function register_menus() {
    register_nav_menus(array(
        'top-external-social' => __('Site Social Presences', TTD),
        'footer-site-links' => __('Footer Site Information Links', TTD)
    ));
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
        $title = "$title $separator ";
        $title .= sprintf(__('Leathanach %s', TTD), max($paged, $page));
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

function archive_page_count($echo = false, $page_num = null, $total = null) {
    global $wp_query;

    if (is_null($total)) {
        $total = $wp_query->found_posts;
    }

    if (is_null($page_num)) {
        $page_num = (get_query_var('paged')) ? get_query_var('paged') : 1;
    }

    $posts_per_page = get_option('posts_per_page');
    $total_pages = ceil($total / $posts_per_page);
    $page_count = sprintf(__('%s / %s', TTD), $page_num, $total_pages);

    if (!$echo) {
        return $page_count;
    }

    printf($page_count);
}

/**
 * Pagination Classes
 * -----------------------------------------------------------------------------
 */

function pagination_classes() {
    return 'class="green-link-hover"';
}

add_filter('next_posts_link_attributes', 'pagination_classes');
add_filter('previous_posts_link_attributes', 'pagination_classes');

/**
 * Media Prefetch
 * -----------------------------------------------------------------------------
 * Set prefetch for a given media domain. Useful if your site is image heavy.
 */

function dns_prefetch() {
    $domains = get_option('tc_dns_prefetch_domains');
    
    if (!empty($domains)) {
        foreach ($domains as $domain) {
            printf('<link rel="dns-prefetch" href="//%s">', $domain);
        }
    }
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

function set_view_count() {
    if (is_singular('post') && !is_user_logged_in()) {
        global $post;

        $key = get_option('tuairisc_view_counter_key');
        $count = (int) get_post_meta($post->ID, $key, true);
        $count++;
        update_post_meta($post->ID, $key, $count);
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
    set_view_count();
    return $content;
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
 * Wrap Comment Fields in Elements
 * -----------------------------------------------------------------------------
 * @link https://goo.gl/m9kv1z
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

// Remove the "Generate by WordPress x.y.x" tag from the header.
remove_action('wp_head', 'wp_generator');

// Stop WordPress loading JavaScript that helps render emoji correctly.
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Set prefetch domain for media.
add_action('wp_head', 'dns_prefetch');

// Wrap comment form fields in <div></div> tags.
add_action('comment_form_before_fields', 'wrap_comment_fields_before');
add_action('comment_form_after_fields', 'wrap_comment_fields_after');

add_action('init', 'register_menus');

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

/**
 * Theme Supports
 * -----------------------------------------------------------------------------
 */

if (!isset($content_width)) {
    $content_width = 1140;
}

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
