<?php

/**
 * Public Notice Meta Box
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

$notice_nonce = array(
    'action' => 'tuairisc_notice_box',
    'name' => 'tuairisc_notice_box_nonce'
);

/**
 * Add Post Editor Meta Box
 * -----------------------------------------------------------------------------
 */

function tuairisc_notice_meta_box() {
    add_meta_box(
        'tuairisc_notice_meta',
        __('Public Notice', TTD),
        'tuairisc_notice_box_content',
        'post'
    );
}

/**
 * Add Post Editor Meta Box
 * -----------------------------------------------------------------------------
 * @param   object      $post           Post object.
 */

function tuairisc_notice_box_content($post, $args) {
    global $notice_nonce;
    wp_nonce_field($notice_nonce['action'], $notice_nonce['name']);

    $key = get_option('tuairisc_notice_post_key');
    $is_notice = !!get_post_meta($post->ID, $key, true) ? 'checked' : '';;

    ?>

    <p>
        <?php _e('This post is a public notice.', TTD); ?>
    </p>

    <ul>
        <li>
            <input id="meta-tuairisc-notice" name="make-notice" type="checkbox" <?php printf($is_notice); ?>>
            <label for="meta-tuairisc-notice"><?php _e('Public Notice', TTD); ?></label>
        </li>
    </ul>

    <?php
}

/**
 * Update Featured Post Meta
 * -----------------------------------------------------------------------------
 * @param   int      $post_id           Post object ID.
 */

function tuairisc_notice_box_update($post_id) {
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

    $key = get_option('tuairisc_notice_post_key');
    $value = false;

    if (isset($_POST['make-notice'])) {
        $value = (filter_var($_POST['make-notice'], FILTER_SANITIZE_STRIPPED) === 'on');
    }

    update_post_meta($post_id, $key, $value);
}

/**
 * Update Post Meta Box
 * -----------------------------------------------------------------------------
 */

add_action('add_meta_boxes', 'tuairisc_notice_meta_box');
add_action('save_post', 'tuairisc_notice_box_update');

?>
