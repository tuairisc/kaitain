<?php

/**
 * Featured and Sticky Post Control
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

$GLOBALS['kaitain_featured_keys'] = array(
    'sticky' => 'kaitain_sticky_post',
    'featured' => 'kaitain_featured_posts_list'
);

add_option('kaitain_sticky_post', array(), '', true);
add_option('kaitain_featured_posts_list', array(), '', true);

/**
 * Check if Sticky Expired
 * -----------------------------------------------------------------------------
 * @return  bool        Post has expired, true/false.
 */

function kaitain_has_sticky_been_set() {
    $set = false;

    if (($set = kaitain_get_sticky_id())) {
        if (!($set = (date('U') <= kaitain_get_sticky_expiry()))) {
            kaitain_remove_sticky_post();
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

function kaitain_is_post_sticky($post) {
    if (!($post = get_post($post)) || !kaitain_has_sticky_been_set()) {
        return false;
    }

    $sticky = kaitain_get_sticky_id();
    return ($sticky === $post->ID);
}

/**
 * Update Sticky Post
 * -----------------------------------------------------------------------------
 * @param   int     $post       ID of post.
 */

function kaitain_set_sticky_post($post, $expiry) {
    $key = $GLOBALS['kaitain_featured_keys']['sticky'];
    $post = get_post($post);

    $post = !!$post ? $post->ID : false;
    $expiry = !!$post ? $expiry : false;

    update_option($key, array(
        'id' => $post,
        'expires' => $expiry
    ));
}

/**
 * Return Sticky Post ID
 * -----------------------------------------------------------------------------
 * @return bool/int     Sticky ID, if set. false if not.
 */

function kaitain_get_sticky_id() {
    return get_option($GLOBALS['kaitain_featured_keys']['sticky'])['id'];
}

/**
 * Return Sticky Post Expiry
 * -----------------------------------------------------------------------------
 * @return bool/int     Sticky expiry, if set. false if not.
 */

function kaitain_get_sticky_expiry() {
    return get_option($GLOBALS['kaitain_featured_keys']['sticky'])['expires'];
}

/**
 * Remove Sticky Post
 * -----------------------------------------------------------------------------
 * Reset sticky post.
 */

function kaitain_remove_sticky_post() {
    kaitain_set_sticky_post(false, false);
}

/**
 * Get Sticky Post
 * -----------------------------------------------------------------------------
 * @return object/bool          Sticky post, if set. Otherwise false.
 */

function kaitain_get_sticky_post() {
    return get_post(get_option($GLOBALS['kaitain_featured_keys']['sticky'])['id']);
}

/**
 * Check if Post is Featured
 * -----------------------------------------------------------------------------
 * @param   int/object      $post       Post object.
 * @return  bool            Post is featured, true/false.
 */

function kaitain_is_featured_post($post) {
    $featured = kaitain_get_featured_list(true);
    return (($post = get_post($post)) && in_array($post->ID, $featured));
}

/**
 * Make Post Featured
 * -----------------------------------------------------------------------------
 * @param   int/object      $post       Post object.
 * @param   bool            $feature    Make post featured.
 * @reutrn  array           $featured   Array of all featured posts.
 */

function kaitain_update_featured_posts($post = null, $make_featured = true) {
    $featured_key = $GLOBALS['kaitain_featured_keys']['featured'];
    $featured = kaitain_get_featured_list(true);
    $is_featured_post = kaitain_is_featured_post($post);

    if (($post = get_post($post)) && $make_featured && !$is_featured_post) {
        $featured[] = $post->ID;
    } else if ($post && !$make_featured && $is_featured_post) {
        $featured = array_diff($featured, [$post->ID]);
    }

    update_option($featured_key, $featured);
    return $featured;
}

/**
 * Get Featured Post
 * -----------------------------------------------------------------------------
 * @param   int     $count         Number of posts to retrieve.
 * @param   bool    $add_filler     Include filler post if query comes up short.
 * @return  array   $featured       Array of featured posts.
 */

function kaitain_get_featured($count = 8, $add_filler = false) {
    $featured = array();

    if ($count > 0) {
        // Transient name and timeout period.
        $trans = 'featured_posts';
        $timeout = get_option('kaitain_transient_timeout');

        // ID of sticky post.
        $sticky_id = kaitain_get_sticky_id();

        if (!($featured = get_transient($trans)) || sizeof($featured) < $count) {
            $featured = get_posts(array(
                'numberposts' => $count,
                'post_status' => 'publish',
                'post__in' => kaitain_get_featured_list(false),
                'orderby' => 'date',
                'order' => 'DESC',
                'exclude' => array($sticky_id)
            ));

            $missing = $count - sizeof($featured); 

            if ($add_filler && $missing > 0) {
                // Pad out query.
                $featured = kaitain_featured_filler($missing, $featured);
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

function kaitain_get_featured_list($use_sticky = true) {
    $featured_key = $GLOBALS['kaitain_featured_keys']['featured'];

    if (!($featured = get_option($featured_key))) {
        $featured = array();
    }

    if (!$use_sticky) {
        $sticky = kaitain_get_sticky_id();
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

function kaitain_get_cat_featured_post($category) {
    if (!($category = get_category($category))) {
        return;
    }

    $trans = sprintf('featured_posts_%s', $category->slug);
    $timeout = get_option('kaitain_transient_timeout');
    $cat_featured = array();

    if (!($featured = get_transient($trans))) {
        $featured = get_posts(array(
            'numberposts' => -1,
            'cat' > $category->cat_ID,
            'post__in' => kaitain_get_featured_list(false),
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

function kaitain_featured_filler($count = 1, $featured_posts = null) {
    $exclude = array();
    
    $filler = get_posts(array(
        // Filler posts are any posts outside of featured.
        'numberposts' => $count,
        'order' => 'DESC',
        'orderby' => 'date',
        'post_status' => 'publish',
        'post__not_in' => kaitain_get_featured_list(true)
    ));

    if ($featured_posts && is_array($featured_posts)) {
        $filler = array_merge($featured_posts, $filler);
    }

    return $filler;
}

?>
