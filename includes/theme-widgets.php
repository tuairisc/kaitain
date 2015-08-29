<?php

/**
 * Theme Widgets
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
    include_once(THEME_WIDGETS  . $widget);
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
        register_sidebar(wp_parse_args($widget, $widget_defaults));
    }
}

/**
 * Actions
 * -----------------------------------------------------------------------------
 */

add_action('widgets_init', 'register_widget_areas');

?>
