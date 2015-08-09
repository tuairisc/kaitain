<?php

/**
 * Featured and Sticky Post Control
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

$keys = array(
    'sticky' => 'tc_sticky_post',
    'featured' => 'tc_feautred_posts'
);

add_option($keys['sticky'], array(), '', true);
add_option($keys['featured'], array(), '', true);

/**
 * Check if Sticky Expired
 * -----------------------------------------------------------------------------
 * @return  bool        Post has expired, true/false.
 */

function has_sticky_been_set() {
    global $keys; 

    $sticky = get_option($keys['sticky']);

    // Check if sticky ID matches a valid post ID; the default ID is -1.
    $set = !!get_post($sticky['id']);

    if ($set) {
        $expiry = $sticky['expires'];
        $date = date('U');
        $set = ($date <= $expiry);

        if (!$set) {
            // Remove sticky post by setting post ID to -1, which doesn't exist.
            remove_sticky_post();
        }
    }

    return $set;
}

/**
 *  Test if Post is Sticky
 * -----------------------------------------------------------------------------
 * Return whether the current post is the set sticky post.
 * 
 * @param   object/int  $post               Post ID or post object.
 * @return  bool                            Post ID is sticky, true/false.
 */

function is_post_sticky($post) {
    global $keys; 

    $post = get_post($post);

    if (!$post || !has_sticky_been_set()) {
        return false;
    }

    $sticky = get_option($keys['sticky'])['id'];
    return ($sticky === $post->ID);
}

/**
 * Update Sticky Post
 * -----------------------------------------------------------------------------
 * @param   int     $post       ID of post.
 */

function set_sticky_post($post, $expiry) {
    global $keys; 

    $post = get_post($post);

    $post = !!$post ? $post->ID : -1;
    $expiry = !!$post ? $expiry : -1;

    update_option($keys['sticky'], array(
        'id' => $post,
        'expires' => $expiry
    ));
}

/**
 * Remove Sticky Post
 * -----------------------------------------------------------------------------
 * Reset sticky post.
 */

function remove_sticky_post() {
    set_sticky_post(-1, -1);
}

/**
 * Get Sticky Post
 * -----------------------------------------------------------------------------
 */

function get_sticky_post($use_fallback = false) {
    global $keys; 

    $sticky_id = get_option($keys['sticky'])['id'];
    $sticky = get_post($sticky_id);

    if (!has_sticky_been_set() && $use_fallback) {
        // Grab a featured post as fallback if requested.
        $sticky = get_tc_featured(1);
    }

    return $sticky;
}

/**
 * Check if Post is Featured
 * -----------------------------------------------------------------------------
 * @param   int/object      $post       Post object.
 * @return  bool            Post is featured, true/false.
 */

function is_featured_post($post) {
    global $keys;
    $featured = get_option($keys['featured']);
    $post = get_post($post);
    return (!!$post && in_array($post->ID, $featured));
}

/**
 * Make Post Featured
 * -----------------------------------------------------------------------------
 * @param   int/object      $post       Post object.
 * @param   bool            $feature    Make post featured.
 * @reutrn  array           $featured   Array of all featured posts.
 */

function update_featured_posts($post = null, $make_featured = true) {
    global $keys;

    $post = get_post($post);
    $featured_posts = get_option($keys['featured']);
    $is_featured_post = is_featured_post($post);

    if ($post && $make_featured && !$is_featured_post) {
        $featured_posts[] = $post->ID;
    } else if ($post && !$make_featured && $is_featured_post) {
        $key = array_search($post->ID, $featured_posts);
        unset($featured_posts[$key]);
    }

    update_option($keys['featured'], $featured_posts);
    return $featured_posts;
}

/**
 * Get Featured Post
 * -----------------------------------------------------------------------------
 * @param   int     $number         Number of posts to retrieve.
 * @param   bool    $use_sticky     Include sticky post in returned posts.
 * @param   bool    $add_filler     Include filler post if query comes up short.
 */

function get_featured_posts($num = 8, $no_sticky = true, $add_filler = false) {
    global $keys; 
    $featured_posts = get_option($keys['featured']);
    $featured_query = array();

    if ($num > 0) {
        $featured_query = array(
            'numberposts' => $num,
            'post_status' => 'publish',
            'post__in' => $featured_posts,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        if (!$no_sticky && has_sticky_been_set()) {
            /* Is a sticky is set, but you elect to /not/ show it. Sticky post
             * will probably be included otherwise. */
            $sticky = get_option($keys['sticky'])['id'];
            $featured_query['exclude'] = array($sticky);
        }

        $featured = get_posts($featured_query);

        if ($add_filler && sizeof($featured_posts) < $num) {
            // Pad out query.
            $featured = array_merge(
                $featured,
                featured_filler($num - sizeof($featured))
            );
        }
    }

    return $featured;
}

/**
 * Fill Out or Replace Missing Featured Posts
 * -----------------------------------------------------------------------------
 * @param   int     $num        Number of posts to return.
 * @return  array   $filler     Filler posts.
 */

function featured_filler($num = 1) {
    global $keys; 
    $featured_posts = get_option($keys['featured']);
    $filler = array();
    
    $filler = get_posts(array(
        // Filler posts are any posts outside of featured.
        'numberposts' => $num,
        'order' => 'DESC',
        'orderby' => 'date',
        'post_status' => 'publish',
        'post__not_in' => $featured_posts
    ));

    return $filler;
}

?>
