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
        'name' => __('Front Page', TTD),
        'description' => __('Front page widget area.', TTD),
        'id' => 'widgets-front-page'
    ),
    array(
        'name' => __('Sidebar', TTD),
        'description' => __('Sidebar widget area.', TTD),
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
