<?php

/**
 * Archive Article
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

global $sections;
$trim = kaitain_section_css(get_the_category()[0]);


// copied from wp_list_authors source... modified

$author = get_userdata( $author_id );

if ( $args['exclude_admin'] && 'admin' == $author->display_name ) {
    continue;
}

$posts = isset( $author_count[$author->ID] ) ? $author_count[$author->ID] : 0;

if ( ! $posts && $args['hide_empty'] ) {
    continue;
}

if ( $args['show_fullname'] && $author->first_name && $author->last_name ) {
    $name = "$author->first_name $author->last_name";
} else {
    $name = $author->display_name;
}

if ( ! $args['html'] ) {
    $return .= $name . ', ';

    continue; // No need to go further to process HTML.
}

if ( 'list' == $args['style'] ) {
    $return .= '<li>';
}

$link = '<a href="' . get_author_posts_url( $author->ID, $author->user_nicename ) . '" title="' . esc_attr( sprintf(__("Posts by %s"), $author->display_name) ) . '">' . $name . '</a>';


if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
    $link .= ' ';
    if ( empty( $args['feed_image'] ) ) {
        $link .= '(';
    }

    $link .= '<a href="' . get_author_feed_link( $author->ID, $args['feed_type'] ) . '"';

    $alt = '';
    if ( ! empty( $args['feed'] ) ) {
         $alt = ' alt="' . esc_attr( $args['feed'] ) . '"';
         $name = $args['feed'];
    }

    $link .= '>';

    if ( ! empty( $args['feed_image'] ) ) {
         $link .= '<img src="' . esc_url( $args['feed_image'] ) . '" style="border: none;"' . $alt . ' />';
    } else {
         $link .= $name;
    }

    $link .= '</a>';

    if ( empty( $args['feed_image'] ) ) {
         $link .= ')';
    }
}

if ( $args['optioncount'] ) {
    $link .= ' ('. $posts . ')';
}

$return .= $link;
$return .= ( 'list' == $args['style'] ) ? '</li>' : ', ';


?>