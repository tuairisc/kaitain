<?php

/**
 * Kaitain Functions
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

$GLOBALS['kaitain_version'] = 1.0;

/**
 * Kaitain Setup
 * -----------------------------------------------------------------------------
 */

add_action('after_setup_theme', function() {
    kaitain_image_sizes();

    // Remove WordPress version from site header.
    remove_action('wp_head', 'wp_generator');

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
});

/**
 * Theme Options
 * -----------------------------------------------------------------------------
 */

// Transient API timeout in minutes.
add_option('kaitain_transient_timeout', 60 * 20, '', true);
// Flag post as job.
add_option('kaitain_notice_post_key', 'kaitain_is_notice', '', true);

// name of the meta key used for tracking post viewcount
add_option('kaitain_view_counter_key', 'kaitain_single_post_view_count', '', true );

// Users whose name and photo should not appear next to posts.
add_option('kaitain_verboten_users', array(1, 4, 37, 54), '', true);

add_option('kaitain_excluded_menu_categories', array(
    175, 177, 221
), '', true);

/**
 * Theme Includes
 * -----------------------------------------------------------------------------
 */

function kaitain_includes() {
    $includes = array(
        // Side-by-side category widget.
        'category-widget/category-widget.php',
        // Site sections.
        'section-manager/section-manager.php',
        'archive-functions/archive-functions.php',
        // Open Graph and Twitter Card <head> meta tag links.
        'social-meta/social-meta.php',
        // Categorically-related posts.
        'related-posts/related-posts.php',
        // Theme scripts
        'kaitain-scripts.php',
        // Avatar output.
        'kaitain-avatars.php',
        // All comment functions.
        'kaitain-comments.php',
        // Featured and sticky posts.
        'kaitain-featured-posts.php',
        // Single post social sharing links.
        'kaitain-social-share.php',
        // Localized date.
        'kaitain-date.php',
        // Education Section Custom Functions.
        'kaitain-education.php',
        // Advanced custom menu functions.
        'kaitain-menus.php'
    );

    $widgets = array(
        // Link to selected author profiles.
        'home-authors.php',
        // Front page featured and sticky article widget.
        //'home-featured-articles.php', // older version
        // Front page featured and recent articles
        'home-featured-recent-articles.php',
        // Front page Gallery Widget, displays Gailleraithe category posts by date, with option for featured posts
        'home-gallery-widget.php',
        // front page recent posts
        'home-recent-posts.php',
        // Front page recent posts container
        'home-recent-posts-container-widget.php',
        // Home page recent posts in selected category.
        'sidebar-recent-posts.php',
        // Front page Video Widget, displays Videos category posts by date, with option for featured posts
        'home-video-widget.php',
         // Sidebar featured category.
        'sidebar-featured-category.php',
        // Popular posts, sorted by internally-tracked view count.
        'sidebar-popular-viewcount.php',
        // Recent posts in $foo category.
        'sidebar-recent-posts.php'
    );

    $admin_includes = array(
        // Featured/Sticky post meta box.
        'featured-edit-box.php',
        'notice-edit-box.php',
        'toggle-featured-image.php',
        'columnist-edit-box.php',
        'category-image-edit-foghlaimeoiri.php',
        'category-children-order-meta.php'
    );

    foreach ($includes as $script) {
        include_once(get_template_directory() . '/includes/' . $script);
    }

    foreach($widgets as $widget) {
        include_once(get_template_directory() . '/widgets/' . $widget);
    }

    if (is_admin()) {
        foreach($admin_includes as $script) {
            include_once(get_template_directory() . '/admin/' . $script);
        }
    }
}

kaitain_includes();

/**
 * Kaitain Theme Widgets
 * -----------------------------------------------------------------------------
 * register_sidebars() doesn't give me enough options to name and identify
 * several unique widget areas, but either do I want a half dozen
 * register_sidebar() calls littering the function. They all share the same
 * defaults, so...
 */

add_action('widgets_init', function() {
    $widget_defaults = array(
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget__title vspace--full">',
        'after_title' => '</h4>'
    );

    $widget_areas = array(
        array(
            'name' => __('Front Page Top', 'kaitain'),
            'description' => __('Front page top widget area.', 'kaitain'),
            'id' => 'widgets-front-page-top',
            'before_widget' => '<div id="%1$s" class="widget widget--home %2$s">',
            'before_title' => '<h3 class="widget--home__title vspace--full">'
        ),
        array(
            'name' => __('Front Page', 'kaitain'),
            'description' => __('Front page widget area.', 'kaitain'),
            'id' => 'widgets-front-page',
            'before_widget' => '<div id="%1$s" class="widget widget--home %2$s">',
            'before_title' => '<h3 class="widget--home__title vspace--full">'
        ),
        array(
            'name' => __('Sidebar', 'kaitain'),
            'description' => __('Top sidebar widget area (above adverts).', 'kaitain'),
            'before_widget' => '<div id="%1$s" class="widget widget--sidebar %2$s">',
            'before_title' => '<h4 class="widget--sidebar__title">',
            'id' => 'widgets-sidebar',
        ),
        array(
            'name' => __('Advert Top Banner', 'kaitain'),
            'description' => __('Top advert widget area.', 'kaitain'),
            'before_widget' => '<div id="%1$s" class="widget widget--sidebar %2$s">',
            'before_title' => '<h4 class="widget--sidebar__title">',
            'id' => 'ad-top',
        ),
        array(
            'name' => __('Advert Sidebar 1', 'kaitain'),
            'description' => __('Sidebar adverts - Top', 'kaitain'),
            'before_widget' => '<div id="%1$s" class="widget widget--sidebar %2$s">',
            'before_title' => '<h4 class="widget--sidebar__title">',
            'id' => 'ad-sidebar-1',
        ),
        array(
            'name' => __('Advert Sidebar 2', 'kaitain'),
            'description' => __('Sidebar adverts - Middle', 'kaitain'),
            'before_widget' => '<div id="%1$s" class="widget widget--sidebar %2$s">',
            'before_title' => '<h4 class="widget--sidebar__title">',
            'id' => 'ad-sidebar-2',
        ),
        array(
            'name' => __('Advert Sidebar 3', 'kaitain'),
            'description' => __('Sidebar adverts - Bottom', 'kaitain'),
            'before_widget' => '<div id="%1$s" class="widget widget--sidebar %2$s">',
            'before_title' => '<h4 class="widget--sidebar__title">',
            'id' => 'ad-sidebar-3',
        )
    );

    foreach ($widget_areas as $widget) {
        register_sidebar(wp_parse_args($widget, $widget_defaults));
    }
});

/**
 * Kaitain Menus
 * -----------------------------------------------------------------------------
 */

add_action('init', function() {
    register_nav_menus(array(
        'header-section-navigation' => __('Site Section Navigation', 'kaitain'),
        'footer-external-social' => __('Site Social Presences (footer)', 'kaitain'),
        'footer-site-links-1' => __('Footer Site Information Links (left)', 'kaitain'),
        'footer-site-links-2' => __('Footer Site Information Menu (right)', 'kaitain')
    ));
});

/**
 * Kaitain Image Sizes
 * -----------------------------------------------------------------------------
 */

function kaitain_image_sizes() {
    $crop = array('center', 'center');

    // Home featured posts.
    add_image_size('tc_home_feature_lead', 790, 385, $crop);
    add_image_size('tc_home_feature_small', 190, 125, $crop);

    // Home authot widget.
    //add_image_size('tc_home_author', 180, 150, $crop);
    add_image_size('tc_home_author', 152, 152, $crop);

    // Sidebar widget post.
    //add_image_size('tc_post_sidebar', 136, 68, $crop);
    add_image_size('tc_post_sidebar', 173, 100, $crop);

    // Category archive.
    add_image_size('tc_post_archive', 390, 195, $crop);

    // Single post related post.
    add_image_size('tc_post_related', 255, 170, $crop);

    // Comment author and post author avatar.
    add_image_size('tc_post_avatar', 70, 70, $crop);

    // Sidebar featured category widget.
    add_image_size('tc_sidebar_category', 250, 140, $crop);

    // Main column category widget.
    add_image_size('tc_home_category_lead', 390, 200, $crop);
    add_image_size('tc_home_category_small', 90, 76, $crop);

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
    return 'class="green-link--hover"';
}

add_filter('next_posts_link_attributes', 'kaitain_pagination_classes');
add_filter('previous_posts_link_attributes', 'kaitain_pagination_classes');

/**
 * Media Prefetch
 * -----------------------------------------------------------------------------
 * Set prefetch for a given media domain. Useful if your site is image heavy.
 */

add_action('wp_head', function() {
    if (is_admin()) {
        // Can cause weird problems with widgets.
        return;
    }

    $prefetch = array(
        preg_replace('/^www\./','', $_SERVER['SERVER_NAME'])
    );

    foreach ($prefetch as $domain) {
        printf('<link rel="dns-prefetch" href="//%s">', $domain);
    }
});

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

        $key = 'kaitain_single_post_view_count';
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

    $key = 'kaitain_single_post_view_count';
    $count = (int) get_post_meta($post->ID, $key, true);

    if (!is_integer($count)) {
        update_post_meta($post->ID, $key, 0);
        return 0;
    }

    return $count;
}

/*
 * Verboten Users
 * -----------------------------------------------------------------------------
 * The site has certain default users whose name should not appear beside posts.
 * This function compares a user ID against this array.
 *
 * @param   int         $user_id        ID of user
 * @return  bool                        User is verboten, true/false.
 */

function kaitain_is_verboten_user($user_id) {
    return in_array($user_id, get_option('kaitain_verboten_users'));
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

add_filter('the_content', function($content) {
    kaitain_set_view_count();
    return $content;
});

/**
 * Theme Section Classes
 * -----------------------------------------------------------------------------
 * @param   object/id       $category       Category to lookup.
 * @return  array           $classes        Section classes.
 */

function kaitain_section_css($category) {
    global $sections;
    $section = $sections->get_category_section_slug($category);

    $classes = array(
        'text' => 'section--' . $section . '-text',
        'texthover' => 'section--' . $section . '-text-hover',
        'bg' => 'section--' . $section . '-bg',
        'bghover' => 'section--' . $section . '-bg-hover'
    );

    return $classes;
}

/**
 * Current Section Classes
 * -----------------------------------------------------------------------------
 * @return  array           $classes        Section classes.
 */

function kaitain_current_section_css() {
    global $sections;
    return kaitain_section_css($sections::$current_section);
}

/**
 * Current Section Category
 * -----------------------------------------------------------------------------
 * @return  object                          Current section category object.
 */

function kaitain_current_section_category() {
    global $sections;
    return get_category($sections::$current_section);
}

/**
 * Theme Sections
 * -----------------------------------------------------------------------------
 */

$sections = new Section_Manager(
    // Array of category sections.
    array(191, 154, 155, 156, 157, 159, 187, 158),
    // Default category section.
    191
);

/**
 * Open Graph and Twitter Card Meta Tags
 * -----------------------------------------------------------------------------
 */

$kaitain_social_meta = new Social_Meta(array(
    'twitter' => '@tuairiscnuacht',
    'facebook' => 'tuairisc.ie',
    'fallback_image' => array(
        'url' => get_template_directory() . '/assets/images/tuairisc.jpg',
        'path' => get_template_directory_uri(). '/assets/images/tuairisc.jpg'
    )
));

/**
 * Helper Functions used in theme
 * -----------------------------------------------------------------------------
 */
function kaitain_excerpt( $excerpt, $limit=60 ) {

    // Do a word limit excerpt 
    /*
    $excerpt = explode(' ', $excerpt, $limit+1);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
    } else {
        $excerpt = implode(" ",$excerpt);
    } 
    */

    // Do a character limit excerpt
    $limit = intval($limit);
    if ($limit != false && $limit != 0 ){
        $excerpt = substr($excerpt, 0, $limit);
        if (strlen($excerpt)>=$limit) {
            $excerpt = $excerpt . '...';
        }
    } else {
        $excerpt = substr($excerpt, 0);
    }

    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
}

if (!function_exists('write_log')) {
    function write_log ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    }
}

// Columnist page author list
// Use hard coded values when initialy switching to live server
if (!function_exists('kaitain_get_columnist_list')) {
    function kaitain_get_columnist_list (){
        $columnist_list = get_post_meta($post->ID, 'kaitain_columnist_list', true);
        if (empty($columnist_list)) {
            $columnist_list = array (
                0 => 96,
                1 => 109,
                2 => 26,
                3 => 38,
                4 => 39,
                5 => 74,
                6 => 27,
                7 => 47,
                8 => 32,
                9 => 14,
                10 => 92,
                11 => 67,
                12 => 19,
                13 => 28,
                14 => 93,
                15 => 20,
                16 => 68,
                17 => 73,
                18 => 41,
                19 => 21,
                20 => 15,
                21 => 9,
                22 => 57,
                23 => 8,
                24 => 23,
                25 => 34,
                26 => 18,
                27 => 89,
                28 => 40,
                29 => 17,
                30 => 10,
                31 => 104,
                32 => 42,
                33 => 63,
                34 => 2,
                35 => 138,
                36 => 97,
            );
            print_r("<!-- hard list -->");
        }
        return $columnist_list;
    }
}

// Home page author list
// Use hard coded values when initialy switching to live server
if (!function_exists('kaitain_get_home_authors')) {
    function kaitain_get_home_authors( $instance ) {
        $author_list = $instance['author_list'];
        if ( empty( $author_list ) ) {
            $author_list = array (
                0 => '8',
                1 => '17',
                2 => '19',
                3 => '32'
            );
        }
        return $author_list;
    }
}


// Rewrite the author base slug
function change_author_permalinks() {

    global $wp_rewrite;

    // Change the value of the author permalink base to whatever you want here
    $wp_rewrite->author_base = 'scribhneoiri';

    $wp_rewrite->flush_rules();
}

add_action('init','change_author_permalinks');



// // For the shortcodes from gazeti

// $education_categories = array(
//     /* There are five sub-categories within the education category, 187 being
//      * the parent. */
//     187, 202, 203, 204, 205, 206, 344
// );


// function education_landing_shortcode($atts) {
//     /**
//      * Education Landing Shortcode
//      * ---------------------------
//      * The education landing page links through to the five different segments.
//      * These are boxy clickable boxes complete with title and description.
//      *
//      * @param {array} $attributes Shortcode values.
//      * @return {string} $education
//      */

//     global $education_categories;
//     $shortcode_atts = shortcode_atts(array('id' => 0), $atts);
//     $category_id = '';
//     $education_html = '';

//     // Change $id to 0 if it falls outside 0-5 range.
//     if ($shortcode_atts['id'] < 0 || $shortcode_atts['id'] > 6) {
//         $category_id = $education_categories[0];
//     } else {
//         $category_id = $education_categories[$shortcode_atts['id']];
//     }

//     $education_html = '<div class="education-box education-'
//         . $category_id . '"><a href="' . get_category_link($category_id)
//         . '"><p><span>' . get_cat_name($category_id) . '</span><br />'
//         . category_description($category_id) . '</a></p></div>';

//     return $education_html;
// }

// function education_banner_shortcode($attributes, $content = null) {
//     /*
//      * Education Banner Shortcode
//      * --------------------------
//      * Generate either a tall or short dividing subheading banners for within
//      * education section posts.
//      *
//      * @param {array} $attributes Shortcode attributes.
//      * @param {string} $content Banner message.
//      * @return {string} $banner Dividing banner.
//      */

//     $banner = array();
//     // h2
//     $headline_type = 2;
//     $headline_class = 'edu-heading';
//     $shortcode_atts = shortcode_atts(array('type' => 'main'), $attributes);

//     if (is_null($content)) {
//         $content = 'Did you forget to include text?';
//     }

//     if ('main' !== $shortcode_atts['type']) {
//         // If the banner is not 'main', change h2 to h2 and heading to subheading.
//         $headline_type = 3;
//         $headline_class = str_replace('-h', '-subh', $headline_class);
//     }

//     $banner[] = '<h' . $headline_type . ' class="' . $headline_class . '">';
//     $banner[] = $content;
//     $banner[] = '</h' . $headline_type . '>';

//     return implode('', $banner);
// }

// // Add shortcode for landing.
// add_shortcode('landing', 'education_landing_shortcode');
// // Add shortcode for education banners.
// add_shortcode('banner', 'education_banner_shortcode');

?>
