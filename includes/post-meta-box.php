<?php

/**
 * Post Meta Box
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 *
 * This file is part of Tuairisc.ie.
 *
 * Tuairisc.ie is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * Tuairisc.ie is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Tuairisc.ie. If not, see <http://www.gnu.org/licenses/>.
 */

$nonce = array(
    'action' => 'tuairisc_meta_box',
    'name' => 'tuairisc_meta_box_nonce'
);

/**
 * Check if Sticky Expired
 * -----------------------------------------------------------------------------
 * @param   string      $expiry_date
 * @return  bool                            Post has expired, true/false.
 */

function sticky_expired() {
    $expiry_date = get_option('tuairisc_sticky_post')['expires'];
    $current_date = (int) date('U');
    return ($current_date >= $expiry_date);
}

/**
 *  Test if Post is Sticky
 * -----------------------------------------------------------------------------
 * @param   object/int  $post               Post ID or post object.
 * @return  bool                            Post ID is sticky, true/false.
 */

function is_sticky_post($post) {
    $post = get_post($post);

    if (!$post) {
        return false;
    }

    $sticky_id = get_option('tuairisc_sticky_post')['id'];
    return ($sticky_id === (int) $post->ID);
}

/**
 * Reset Sticky Post
 * -----------------------------------------------------------------------------
 */

function reset_sticky() {
    // TODO
}

/**
 * Update Sticky Post
 * -----------------------------------------------------------------------------
 */

function update_sticky() {
    // TODO
}

/**
 * Validate Sticky
 * -----------------------------------------------------------------------------
 */

// update_sticky_post($post, $expiry_date) {
//     $debug = true;
//     $post = get_post($post);
// 
//     if (!$post) {
//         return;
//     }
// 
//     update_option('tuairisc_sticky_post', array(
//         'id' => $post_id,
//         'expires' => $expiry
//     ));
// }

/**
 * Add Post Editor Meta Box
 * -----------------------------------------------------------------------------
 */

function tuairisc_meta_box() {
    add_meta_box(
        'tuairisc_post_meta',
        __('Feature', TTD),
        'meta_box_content',
        'post'
    );
}

/**
 * Add Post Editor Meta Box
 * -----------------------------------------------------------------------------
 * @param   object      $post           Post object.
 */

function meta_box_content($post) {
    global $nonce;
    wp_nonce_field($nonce['action'], $nonce['name']);

    $is_featured = get_post_meta($post->ID, get_option('tuairisc_feature_post_key'), true);
    $is_sticky = false;

    if ($is_featured) {
        if (is_sticky_post($post) && !sticky_expired()) {
            $is_sticky = !$is_sticky;
            $sticky = get_option('tuairisc_sticky_post');
            $expiry_date = $sticky['expires'];
        } else if (is_sticky_post($post) && sticky_expired()) {
            // TODO?
            reset_sticky();
        }
    }
    ?>

    <script>
        var tuairiscMetaInfo = {
            featured: <?php printf('%s', (!!$is_featured) ? 'true' : 'false'); ?>,
            sticky: <?php printf('%s', ($is_sticky) ? 'true' : 'false'); ?>,
            expiry: <?php printf('%u', ($is_sticky) ? $expiry_date : date('U')); ?>
        };
    </script>

    <p>
        <?php _e('Featured posts are displayed on the website\'s homepage in the lead articles widget.', TTD); ?>
    </p>

    <ul>
        <li>
            <input id="meta-tuairisc-featured" name="featured" type="checkbox">
            <label for="meta-tuairisc-featured"><?php _e('Feature Post', TTD); ?></label>
        </li>
        <li class="stickycheck">
            <input id="meta-tuairisc-sticky" name="sticky" type="checkbox">
            <label for="meta-tuairisc-sticky"><?php _e('Sticky Post', TTD); ?></label>
        </li>
        <li class="expiryinfo">
            <label><?php _e('Until', TTD); ?></label>
            <input id="expiry-hour" name="hour" type="text" min="00" max="23" minlength="2" maxlength="2" size="2" value="00"> :
            <input id="expiry-minute" name="minute" type="text" min="00" max="59" minlength="2" maxlength="2" size="2" value="00">
        </li>
        <li class="expiryinfo">
            on <select id="expiry-day" name="day"></select><select id="expiry-month" name="month"></select><select id="expiry-year" name="year"></select>
        </li>
    </ul>
    <p class="expiryinfo" id="meta-tuairisc-sticky-info">
        <em><?php _e('A sticky post will remain in the top position on the front page until either the set time passes, or another post is set to replace it.', TTD); ?></em>
   </p>

    <?php
}

/**
 * Update Featured Post Meta
 * -----------------------------------------------------------------------------
 * Validate /ALL/ the things!
 * 
 * @param   int      $post_id           Post object.
 */

function update_meta_box($post_id) {
    global $nonce;
    
    if (!ctype_alnum($_POST[$nonce['name']]) || !isset($_POST[$nonce['name']])) {
        return;
    }

    if (!wp_verify_nonce($_POST[$nonce['name']], $nonce['action'])) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return; 
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $is_featured = $_POST['featured'];
    $is_sticky = $_POST['sticky'];
    $sticky_id = get_option('tuairisc_sticky_post')['id'];

    $year = filter_var($_POST['year'], FILTER_SANITIZE_NUMBER_INT);
    $month = filter_var($_POST['month'], FILTER_SANITIZE_NUMBER_INT); $month++;
    $day = filter_var($_POST['day'], FILTER_SANITIZE_NUMBER_INT);
    $hour = filter_var($_POST['hour'], FILTER_SANITIZE_NUMBER_INT);
    $minute = filter_var($_POST['minute'], FILTER_SANITIZE_NUMBER_INT);

    $expiry = mktime($hour, $minute, 0, $month, $day, $year);

    update_post_meta($post_id, get_option('tuairisc_feature_post_key'), $is_featured);
    // update_sticky_post($post_id, $expiry, $is_sticky);

    update_option('tuairisc_sticky_post', array(
        'id' => $post_id,
        'expires' => $expiry
    ));
}

/**
 * Update Post Meta Box
 * -----------------------------------------------------------------------------
 */

add_action('add_meta_boxes', 'tuairisc_meta_box');
add_action('save_post', 'update_meta_box');

?>
