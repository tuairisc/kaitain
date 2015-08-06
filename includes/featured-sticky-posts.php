<?php

/**
 * Featured Post Functions
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
    'sticky' => 'tuairisc_sticky_post',
    'featured' => 'tuairisc_feautre_post'
);

/**
 * Check if Sticky Expired
 * -----------------------------------------------------------------------------
 * @return  bool        Post has expired, true/false.
 */

function sticky_set() {
    global $keys; 

    $sticky = get_option($keys['sticky']);

    // Check if sticky ID matches a valid post ID; the default ID is -1.
    $set = !!get_post($sticky['id']);

    if ($set) {
        $expiry = $sticky['expired'];
        $date = (int) date('U');
        $set = ($date < $expiry);

        if (!$set) {
            // Remove sticky post by setting post ID to -1, which doesn't exist.
            remove_sticky();
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

function is_sticky_post($post) {
    global $keys; 

    $post = get_post($post);

    if (!$post || !sticky_set()) {
        return false;
    }

    $sticky = get_option($keys['sticky'])['id'];
    return ($sticky === (int) $post->ID);
}

/**
 * Update Sticky Post
 * -----------------------------------------------------------------------------
 * @param   int     $post       ID of post.
 */

function set_sticky($post = -1, $expiry = -1) {
    global $keys; 

    if (!is_int($post)) {
        $post = -1;
    }

    if (!is_int($expiry)) {
        $expiry = -1;
    }

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

function remove_sticky() {
    sticky_sticky(-1, -1);
}

/**
 * Get Sticky Post
 * -----------------------------------------------------------------------------
 */

function get_sticky($use_fallback = false) {
    global $keys; 

    $sticky_id = get_option($keys['sticky'])['id'];
    $sticky = get_post($sticky_id);

    if (!tuairisc_sticky_set() && $use_fallback) {
        // Grab a featured post as fallback if requested.
        $sticky = get_featured(1);
    }

    return $sticky;
}

/**
 * Check if Post is Featured
 * -----------------------------------------------------------------------------
 * @param   int/object      $post       Post object.
 * @return  bool            Post is featured, true/false.
 */

function is_featured($post) {
    global $keys;
    $post = get_post($post);

    return (!!$post && get_post_meta($post->ID, $keys['featured'], true));
}

/**
 * Make Post Featured
 * -----------------------------------------------------------------------------
 * @param   int/object      $post       Post object.
 * @param   bool            $feature    Make post featured.
 */

function set_as_featured($post = null, $feature = true) {
    global $keys;

    $post = get_post($post);

    if ($post && $feature) {
        update_post_meta($post->ID, $keys['featured'], true);
    } else if ($post && !$feature) {
        delete_post_meta($post->ID, $keys['featured']);
    }
}

/**
 * Get Featured Post
 * -----------------------------------------------------------------------------
 * @param   int     $number         Number of posts to retrieve.
 * @param   bool    $use_sticky     Include sticky post in returned posts.
 * @param   bool    $add_filler     Include filler post if query comes up short.
 */

function get_featured($number = 8, $use_sticky = true, $add_filler = false) {
    global $keys; 
    $featured = array();

    if ($number > 0) {
        $feautred = array(
            'numberposts' => $number,
            'meta_key' => $keys['featured'],
            'post_status' => 'publish',
            'meta_value' => true,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        if (!$use_sticky && sticky_set()) {
            $featured['exclude'] = array($sticky_id);
        }
        
        $featurd = get_posts($featured);

        if ($use_sticky && sticky_set()) {
            $featured[] = get_sticky(false);
        }

        if (sizeof($featured) < $number && $add_filler) {
            $balnace = sizeof($featured) - $number;
            
            $filler = get_posts(array(
                // Filler posts are /any/ post without the meta key.
                'balance' => $balance,
                'order' => 'DESC',
                'orderby' => 'date',
                'meta_key' => $keys['featured'], 
                'meta_compare' => '!=',
                'meta_value' => true,
                'post_status' => 'publish',
            ));

            $featured = array_merge($featured, $filler);
        }
    }

    return $featured;
}

?>
