<?php

/**
 * Public Notice Meta Box
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

function kaitain_notice_meta_box() {
    add_meta_box(
        'kaitain_notice_meta',
        __('Public Notice', 'kaitain'),
        'kaitain_notice_box_content',
        'post'
    );
}

/**
 * Add Post Editor Meta Box
 * -----------------------------------------------------------------------------
 * @param   object      $post           Post object.
 */

function kaitain_notice_box_content($post, $args) {
    wp_nonce_field('kaitain_notice_box_data', 'kaitain_notice_box_nonce');
    $is_notice = !!get_post_meta($post->ID, 'kaitain_is_public_notice', true) ? 'checked' : '';;

    ?>
    <script>
        var pmNotice = {
            notice: <?php printf('%s', $is_notice ? 'true' : 'false'); ?>
        };
    </script>

    <p>
        <?php _e('Public notices include material like job listings and event announcements.', 'kaitain'); ?>
    </p>

    <ul>
        <li>
            <input id="kaitain-notice-checkbox" name="make_notice" type="checkbox" <?php printf($is_notice); ?>>
            <label for="kaitain-notice-checkbox"><?php _e('Public Notice', 'kaitain'); ?></label>
        </li>
        <li class="kaitain-noticecheck">
            <input id="kaitain-notice-expiry-checkbox" name="notice_expires" type="checkbox" <?php printf($is_notice); ?>>
            <label for="kaitain-notice-expiry-checkbox"><?php _e('Display Notice Until', 'kaitain'); ?></label>
        </li>
        <li class="kaitain-notice-expiryinfo" id="kaitain-notice-expiry">
            <?php // Inputs are added and set via JS. ?>
        </li>
    </ul>

    <?php
}

/**
 * Update Featured Post Meta
 * -----------------------------------------------------------------------------
 * @param   int      $post_id           Post object ID.
 */

function kaitain_notice_box_update($post_id) {
    if (!isset($_POST['kaitain_notice_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['kaitain_notice_box_nonce'], 'kaitain_notice_box_data')) {
        return;
    }
    
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return; 
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $key = 'kaitain_is_public_notice';
    $value = false;

    if (isset($_POST['make_notice'])) {
        $value = (filter_var($_POST['make_notice'], FILTER_SANITIZE_STRIPPED) === 'on');
    }

    update_post_meta($post_id, $key, $value);
}

/**
 * Update Post Meta Box
 * -----------------------------------------------------------------------------
 */

add_action('add_meta_boxes', 'kaitain_notice_meta_box');
add_action('save_post', 'kaitain_notice_box_update');

?>
