<?php

/**
 * Post Meta Box
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

/**
 * Add Post Editor Meta Box
 * -----------------------------------------------------------------------------
 */

function kaitain_featured_meta_box() {
    add_meta_box(
        'kaitain_featured_meta',
        __('Feature', 'kaitain'),
        'kaitain_featured_box_content',
        'post'
    );
}

add_action('add_meta_boxes', 'kaitain_featured_meta_box');

/**
 * Add Post Editor Meta Box
 * -----------------------------------------------------------------------------
 * @param   object      $post           Post object.
 */

function kaitain_featured_box_content($post) {
    wp_nonce_field('kaitain_featured_box_data', 'kaitain_featured_box_nonce');

    // These three values will be echoed out as JavaScript variables.
    $is_featured = kaitain_is_featured_post($post);
    $is_sticky = false;
    $is_sticky = kaitain_is_post_sticky($post);
    $expiry = false;

    if ($is_featured) {
        $is_sticky = kaitain_is_post_sticky($post);

        if ($is_featured && $is_sticky) {
            if (!($expiry = get_option('kaitain_sticky_post')['expires'])) {
                // 0 is falsy in both JavaScript and PHP.
                $expiry = 0;
            } else {
                // To make it a JavaScript Unix timestamp.
                $expiry *= 1000;
            }
        }
    }
    ?>

    <p>
        <?php _e('Featured posts are displayed on the website\'s homepage in the lead articles widget.', 'kaitain'); ?>
    </p>

    <ul>
        <li>
            <fieldset>
                <input id="kaitain-featured-checkbox" name="make_featured" type="checkbox">
                <label for="kaitain-featured-checkbox"><?php _e('Feature Post', 'kaitain'); ?></label>
            </fieldset>
        </li>
        <li class="kaitain-stickycheck6">
            <fieldset>
                <input id="kaitain-sticky-checkbox" name="make_sticky" type="checkbox">
                <label for="kaitain-sticky-checkbox"><?php _e('Sticky Post', 'kaitain'); ?></label>
            </fieldset>
        </li>
        <li class="kaitain-sticky-expiryinfo" id="kaitain-sticky-expiry">
            <?php // Inputs are added and set via JS. ?>
        </li>
        <p class="kaitain-sticky-expiryinfo" id="meta-kaitain-sticky-info">
            <em><?php _e('A sticky post will remain in the top position on the front page until either the set time passes, or another post is set to replace it.', 'kaitain'); ?></em>
        </p>   
    </ul>
    
    <script>
        var postmetaFeatured = {
            featured: <?php printf('%s', $is_featured ? 'true' : 'false'); ?>,
            sticky: <?php printf('%s', $is_sticky ? 'true' : 'false'); ?>,
            expiry: <?php printf('%u', $expiry); ?>
        };
        jQuery('#kaitain-featured-checkbox').prop('checked', postmetaFeatured['featured'] );
        jQuery('#kaitain-sticky-checkbox').prop('checked', postmetaFeatured['sticky'] );
    </script>

    <?php
}

/**
 * Update Featured Post Meta
 * -----------------------------------------------------------------------------
 * Validate /ALL/ the things!
 * 
 * @param   int      $post_id           Post object ID.
 */

function kaitain_update_featured_meta_box($post_id) {
    if (!isset($_POST['kaitain_featured_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['kaitain_featured_box_nonce'], 'kaitain_featured_box_data')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return; 
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $make_featured = (isset($_POST['make_featured']) && $_POST['make_featured'] === 'on');
    $make_sticky = (isset($_POST['make_sticky']) && $_POST['make_sticky'] === 'on');

    // Update meta.
    kaitain_update_featured_posts($post_id, $make_featured);

    if ($make_featured && $make_sticky) {
        // Sanitiize date input and mkdate.
        $year = filter_var($_POST['stickyexpires-year'], FILTER_SANITIZE_NUMBER_INT);
        $month = filter_var($_POST['stickyexpires-month'], FILTER_SANITIZE_NUMBER_INT);
        $day = filter_var($_POST['stickyexpires-day'], FILTER_SANITIZE_NUMBER_INT);
        $hour = filter_var($_POST['stickyexpires-hour'], FILTER_SANITIZE_NUMBER_INT); $hour--;
        $minute = filter_var($_POST['stickyexpires-minute'], FILTER_SANITIZE_NUMBER_INT);
        $expiry = mktime($hour, $minute, 0, $month, $day, $year);

        if ($expiry) {
            // Set sticky if validated.
            kaitain_set_sticky_post($post_id, $expiry);
        }
    } else if (!$make_sticky && kaitain_is_post_sticky($post_id)) {
        // If post was sticky, but no longer.
        kaitain_remove_sticky_post();
    }
}

add_action('save_post', 'kaitain_update_featured_meta_box');

?>