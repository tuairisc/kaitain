<?php

/**
 * Kaitain Functions 
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

$GLOBALS['kaitain_version'] = 1.0;

/**
 * Sheepie Setup
 * -----------------------------------------------------------------------------
 */

function kaitain_setup() {
    // add_option('tuairisc_hidden_users', array(
    //     // Users whose avatar should not display in single posts.
    //     1, 2, 37, 48
    // ), '', true);

    // Transient API timeout in minutes.
    add_option('tuairisc_transient_timeout', 60 * 20, '', true);
    // Flag post as job.
    add_option('tuairisc_notice_post_key', 'is_tuairisc_notice', '', true);
    // View counter meta key.
    add_option('tuairisc_view_counter_key', 'tuairisc_view_counter', '', true);

    // All theme PHP.
    kaitain_includes(); 

    kaitain_image_sizes();

    // Header tag DNS prefetch.
    kaitain_dns_prefetch();

    // Theme widgets.
    add_action('widgets_init', 'kaitain_widgets');

    // Theme menus.
    add_action('init', 'kaitain_menus');

    // Them widget areas.
    add_action('widgets_init', 'kaitain_widgets');

    // Header DNS prefetch meta tags.
    add_action('wp_head', 'kaitain_dns_prefetch');

    // Remove WordPress version from site header.
    remove_action('wp_head', 'wp_generator');

    add_filter('wp_title', 'kaitain_title', 10, 2);

    // Remove the fuck out of emoji and emoticons.
    remove_filter('the_content', 'convert_smilies');
    remove_filter('the_excerpt', 'convert_smilies');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');

    add_theme_support('html5', array(
        'comment-list',
        'comment-form',
        'search-form',
        'gallery',
        'caption'
    ));

    // Content width.
    $GLOBALS['content_width'] = 1140;

    $tuairisc_social_meta = new Social_Meta(array(
        'twitter' => '@tuairiscnuacht',
        'facebook' => 'tuairisc.ie',
        'fallback_image' => array(
            'url' => get_template_directory() . '/assets/images/tuairisc.jpg',
            'path' => get_template_directory_uri(). '/assets/images/tuairisc.jpg'
        )
    ));

    $sections = new Section_Manager(array(
        'categories' => array(191, 154, 155, 156, 157, 159, 187, 158), 
        'home' => 191
    ));
}

add_action('after_setup_theme', 'kaitain_setup');

/**
 * Theme Includes
 * -----------------------------------------------------------------------------
 */

function kaitain_includes() {
    $includes = array(
        // Theme scripts
        'kaitain-scripts.php',
        // Avatar output.
        'kaitain-avatars.php',
        // Side-by-side category widget.
        'category-widget/category-widget.php',
        // All comment functions.
        'comment-functions.php',
        // Featured and sticky posts.
        'featured-sticky-posts.php',
        // Site sections.
        'section-manager/section-manager.php',
        // Open Graph and Twitter Card <head> meta tag links.
        'social-meta/social-meta.php',
        // Single post social sharing links.
        'social-share.php',
        // Categorically-related posts.
        'single-post-related-posts.php',
        // Localized date.
        'date-strftime.php'
    );

    $admin_incldues = array(
        // Featured/Sticky post meta box.
        'featured-edit-box.php',
        'notice-edit-box.php',
    );

    foreach ($includes as $script) {
        include_once(get_template_directory() . '/includes/' . $script);
    }

    if (is_admin()) {
        foreach($admin_includes as $script) {
            include_once(get_template_directory() . '/admin/' . $script);
        }
    }
}

/**
 * Kaitain Theme Widgets
 * -----------------------------------------------------------------------------
 * register_sidebars() doesn't give me enough options to name and identify 
 * several unique widget areas, but either do I want a half dozen 
 * register_sidebar() calls littering the function. They all share the same
 * defaults, so...
 */

function kaitain_widgets() {
    $included_widgets = array(
        // Link to selected author profiles.
        'home-authors.php',
        // Front page featured and sticky article widget.
        'home-featured-articles.php',
        // Front page category widgets.
        'home-category.php',
        // Sidebar featured category.
        'sidebar-featured-category.php',
        // Popular posts, sorted by internally-tracked view count.
        'sidebar-popular-viewcount.php',
        // Recent posts in $foo category.
        'sidebar-recent-posts.php',
    );

    $widget_defaults = array(
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>'
    );

    $widget_areas = array(
        array(
            'name' => __('Front Page', 'tuairisc'),
            'description' => __('Front page widget area.', 'tuairisc'),
            'id' => 'widgets-front-page'
        ),
        array(
            'name' => __('Sidebar', 'tuairisc'),
            'description' => __('Sidebar widget area.', 'tuairisc'),
            'id' => 'widgets-sidebar',
            'before_title' => '<h3 class="widget-title widget-subtitle">'
        )
    );

    foreach($included_widgets as $widget) {
        include_once(get_template_directory() . '/widgets/' . $widget);
    }

    foreach ($widget_areas as $widget) {
        register_sidebar(wp_parse_args($widget, $widget_defaults));
    }
}

function kaitain_image_sizes() {
    $crop = array('center', 'center');

    // Home featured posts.
    add_image_size('tc_home_feature_lead', 790, 385, $crop);
    add_image_size('tc_home_feature_small', 190, 125, $crop);

    // Home authot widget.
    add_image_size('tc_home_author', 180, 150, $crop);

    // Sidebar widget post.
    add_image_size('tc_post_sidebar', 70, 45, $crop);

    // Category archive.
    add_image_size('tc_post_archive', 390, 170, $crop);

    // Single post related post.
    add_image_size('tc_post_related', 255, 170, $crop);

    // Comment author and post author avatar.
    add_image_size('tc_post_avatar', 70, 70, $crop);

    // Sidebar featured category widget.
    add_image_size('tc_sidebar_category', 250, 140, $crop);

    // Main column category widget.
    add_image_size('tc_home_category_lead', 390, 200, $crop);
    add_image_size('tc_home_category_small', 110, 60, $crop);
}

/**
 * Partial Wrapper
 * -----------------------------------------------------------------------------
 * Shorthand wrapper for get_template_part to reduce the verbosity of calls.
 * 
 * @param   string      $name           Partial name.
 * @param   strgin      $slug           Partial slug.
 */

function kaitain_partial($name, $slug = '') {
    get_template_part('/partials/' . $name, $slug);
}

/**
 * Pagination Classes
 * -----------------------------------------------------------------------------
 */

function kaitain_pagination_classes() {
    return 'class="green-link-hover"';
}

add_filter('next_posts_link_attributes', 'pagination_classes');
add_filter('previous_posts_link_attributes', 'pagination_classes');

/**
 * Media Prefetch
 * -----------------------------------------------------------------------------
 * Set prefetch for a given media domain. Useful if your site is image heavy.
 */

function kaitain_dns_prefetch() {
    // Media prefetch domain: If null or empty, defaults to site domain.
    $prefetch = array(
        preg_replace('/^www\./','', $_SERVER['SERVER_NAME'])
    );
    
    foreach ($domains as $domain) {
        printf('<link rel="dns-prefetch" href="//%s">', $domain);
    }
}

/**
 * Increment View Counter
 * -----------------------------------------------------------------------------
 * This was requested by the client for internal use. I do not consider this to
 * be an objectively reliable means to tally view counters for buisness use, but
 * it is Good Enough.
 *
 * @param   int     $post_id        ID of the post.
 */

function kaitain_set_view_count() {
    if (is_singular('post') && !is_user_logged_in()) {
        global $post;

        $key = get_option('tuairisc_view_counter_key');
        $count = (int) get_post_meta($post->ID, $key, true);
        $count++;
        update_post_meta($post->ID, $key, $count);
    }
}

/*
 * Fetch View Counter
 * -----------------------------------------------------------------------------
 * @param   int     $post_id        ID of the post.
 * @return  int     $count          View count of the post.
 */

function kaitain_get_view_count($post = null) {
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

function kaitain_increment_view_counter($content) {
    set_view_count();
    return $content;
}

add_filter('the_content', 'increment_view_counter');







function kaitain_menus() {
    register_nav_menus(array(
        'top-external-social' => __('Site Social Presences', 'tuairisc'),
        'footer-site-links' => __('Footer Site Information Links', 'tuairisc')
    ));
}

?>
