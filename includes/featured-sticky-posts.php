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
 */

$fe_keys = array(
    'sticky' => 'tc_sticky_post',
    'featured' => 'tc_feautred_posts'
);

add_option($fe_keys['sticky'], array(), '', true);
add_option($fe_keys['featured'], array(), '', true);

/**
 * Check if Sticky Expired
 * -----------------------------------------------------------------------------
 * @return  bool        Post has expired, true/false.
 */

function has_sticky_been_set() {
    $set = false;

    if (($set = get_sticky_id())) {
        if (!($set = (date('U') <= get_sticky_expiry()))) {
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
    if (!($post = get_post($post)) || !has_sticky_been_set()) {
        return false;
    }

    $sticky = get_sticky_id();
    return ($sticky === $post->ID);
}

/**
 * Update Sticky Post
 * -----------------------------------------------------------------------------
 * @param   int     $post       ID of post.
 */

function set_sticky_post($post, $expiry) {
    global $fe_keys; 

    $post = get_post($post);

    $post = !!$post ? $post->ID : false;
    $expiry = !!$post ? $expiry : false;

    update_option($fe_keys['sticky'], array(
        'id' => $post,
        'expires' => $expiry
    ));
}

/**
 * Return Sticky Post ID
 * -----------------------------------------------------------------------------
 * @return bool/int     Sticky ID, if set. false if not.
 */

function get_sticky_id() {
    global $fe_keys;
    return get_option($fe_keys['sticky'])['id'];
}

/**
 * Return Sticky Post Expiry
 * -----------------------------------------------------------------------------
 * @return bool/int     Sticky expiry, if set. false if not.
 */

function get_sticky_expiry() {
    global $fe_keys;
    return get_option($fe_keys['sticky'])['expires'];
}

/**
 * Remove Sticky Post
 * -----------------------------------------------------------------------------
 * Reset sticky post.
 */

function remove_sticky_post() {
    set_sticky_post(false, false);
}

/**
 * Get Sticky Post
 * -----------------------------------------------------------------------------
 * @return object/bool          Sticky post, if set. Otherwise false.
 */

function get_sticky_post() {
    global $fe_keys; 
    return get_post(get_option($fe_keys['sticky'])['id']);
}

/**
 * Check if Post is Featured
 * -----------------------------------------------------------------------------
 * @param   int/object      $post       Post object.
 * @return  bool            Post is featured, true/false.
 */

function is_featured_post($post) {
    $featured = get_featured_list(true);
    return (($post = get_post($post)) && in_array($post->ID, $featured));
}

/**
 * Make Post Featured
 * -----------------------------------------------------------------------------
 * @param   int/object      $post       Post object.
 * @param   bool            $feature    Make post featured.
 * @reutrn  array           $featured   Array of all featured posts.
 */

function update_featured_posts($post = null, $make_featured = true) {
    global $fe_keys;
    $featured = get_featured_list(true);
    $is_featured_post = is_featured_post($post);

    if (($post = get_post($post)) && $make_featured && !$is_featured_post) {
        $featured[] = $post->ID;
    } else if ($post && !$make_featured && $is_featured_post) {
        $featured = array_diff($featured, [$post->ID]);
    }

    update_option($fe_keys['featured'], $featured);
    return $featured;
}

/**
 * Get Featured Post
 * -----------------------------------------------------------------------------
 * @param   int     $count         Number of posts to retrieve.
 * @param   bool    $add_filler     Include filler post if query comes up short.
 * @return  array   $featured       Array of featured posts.
 */

function get_featured($count = 8, $add_filler = false) {
    $featured = array();

    if ($count > 0) {
        // Transient name and timeout period.
        $trans = 'featured_posts';
        $timeout = get_option('tuairisc_transient_timeout');

        // ID of sticky post.
        $sticky_id = get_sticky_id();

        if (!($featured = get_transient($trans)) || sizeof($featured) < $count) {
            $featured = get_posts(array(
                'numberposts' => $count,
                'post_status' => 'publish',
                'post__in' => get_featured_list(false),
                'orderby' => 'date',
                'order' => 'DESC',
                'exclude' => array($sticky_id)
            ));

            $missing = $count - sizeof($featured); 

            if ($add_filler && $missing > 0) {
                // Pad out query.
                $featured = featured_filler($missing, $featured);
            }

            set_transient($trans, $featured, $timeout);
        }
    }

    return $featured;
}

/**
 * Return List of Featured Posts
 * -----------------------------------------------------------------------------
 * @param   bool        $no_sticky      Exclude sticky post from list.
 * @return  array       $featured       List of featured posts.
 */

function get_featured_list($use_sticky = true) {
    global $fe_keys;

    $featured = get_option($fe_keys['featured']);

    if (!$use_sticky) {
        $sticky = get_sticky_id();
        $featured = array_diff($featured, [$sticky]);
    }

    return $featured;
}

/**
 * Get Featured Posts from Given Category
 * -----------------------------------------------------------------------------
 * @param   int/object      $category           Category ID/object.
 * @return  array           $cat_featured       Category featured posts.
 */

function get_cat_featured_post($category) {
    if (!($category = get_category($category))) {
        return;
    }

    $trans = sprintf('featured_posts_%s', $category->slug);
    $timeout = get_option('tuairisc_transient_timeout');
    $cat_featured = array();

    if (!($featured = get_transient($trans))) {
        $featured = get_posts(array(
            'numberposts' => -1,
            'cat' > $category->cat_ID,
            'post__in' => get_featured_list(false),
            'order' => 'DESC',
            'orderby' => 'date'
        ));

        foreach ($featured as $post) {
            if (in_category($post, $category)) {
                $cat_featured[] = $post;
            }
        }

        set_transient($trans, $cat_featured, $timeout);
    }

    return $cat_featured;
}

/**
 * Fill Out or Replace Missing Featured Posts
 * -----------------------------------------------------------------------------
 * Filler is not transiently cached as I may need new posts /now/.
 * 
 * @param   int     $count        Number of posts to return.
 * @return  array   $filler     Filler posts.
 */

function featured_filler($count = 1, $featured_posts = null) {
    $exclude = array();
    
    $filler = get_posts(array(
        // Filler posts are any posts outside of featured.
        'numberposts' => $count,
        'order' => 'DESC',
        'orderby' => 'date',
        'post_status' => 'publish',
        'post__not_in' => get_featured_list(true)
    ));

    if ($featured_posts && is_array($featured_posts)) {
        $filler = array_merge($featured_posts, $filler);
    }

    return $filler;
}

?>
