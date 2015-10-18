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
    $is_notice = !!get_post_meta($post->ID, 'kaitain_is_public_notice', true);

    ?>

    <script>
        var postmetaNotice = {
            notice: <?php printf('%s', $is_notice ? 'true' : 'false'); ?>,
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

    $is_notice = false;

    if (isset($_POST['make_notice'])) {
        // Evalute whether this ia notice, true/false.
        $is_notice = (filter_var($_POST['make_notice'], FILTER_SANITIZE_STRIPPED) === 'on');
    }

    // Article is a notice.
    update_post_meta($post_id, 'kaitain_is_public_notice', $is_notice);
}

/**
 * Update Post Meta Box
 * -----------------------------------------------------------------------------
 */

add_action('add_meta_boxes', 'kaitain_notice_meta_box');
add_action('save_post', 'kaitain_notice_box_update');

?>
