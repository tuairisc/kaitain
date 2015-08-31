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

$notice_nonce = array(
    'action' => 'kaitain_notice_box',
    'name' => 'kaitain_notice_box_nonce'
);

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
    global $notice_nonce;
    wp_nonce_field($notice_nonce['action'], $notice_nonce['name']);

    $key = get_option('kaitain_notice_post_key');
    $is_notice = !!get_post_meta($post->ID, $key, true) ? 'checked' : '';;

    ?>

    <p>
        <?php _e('This post is a public notice.', 'kaitain'); ?>
    </p>

    <ul>
        <li>
            <input id="meta-tuairisc-notice" name="make_notice" type="checkbox" <?php printf($is_notice); ?>>
            <label for="meta-tuairisc-notice"><?php _e('Public Notice', 'kaitain'); ?></label>
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
    global $notice_nonce;
    
    if (!ctype_alnum($_POST[$notice_nonce['name']]) || !isset($_POST[$notice_nonce['name']])) {
        return;
    }

    if (!wp_verify_nonce($_POST[$notice_nonce['name']], $notice_nonce['action'])) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return; 
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $key = get_option('kaitain_notice_post_key');
    $value = false;

    if (isset($_POST['make_notice'])) {
        $value = (isset($_POST['make_notice']) && filter_var($_POST['make_notice'], FILTER_SANITIZE_STRIPPED) === 'on');
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
