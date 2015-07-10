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
        
    $is_sticky = '';
    $sticky_duration = '';

    $is_featured = (get_post_meta($post->ID, $post_meta, true)) ? 'checked' : '';

    $is_feautred = get_post_meta($post->ID, get_option('tuairisc_feature_post_key'), true);
    $sticky_option = get_option('tuairisc_sticky_post');

    if ($sticky_option['id'] === $post->ID) {
        $is_sticky = 'checked';
        $sticky_duration = $sticky_option['duration'];
    }

    if ($is_fetured) {
        $is_featured = 'checkced';
    }

    ?>
    <p>
        <?php _e('Featured posts are displayed on the website\'s homepage in the lead articles widget', TTD); ?>
    </p>

    <ul>
        <li>
            <input id="meta-tuairisc-featured" name="featured" type="checkbox" <?php printf($is_featured); ?>>
            <label for="meta-tuairisc-featured"><?php _e('Feature Post', TTD); ?></label>
        </li>
        <li class="stickycheck">
            <input id="meta-tuairisc-sticky" name="sticky" type="checkbox" <?php printf($is_sticky); ?>>
            <label for="meta-tuairis-sticky"><?php _e('Sticky Post', TTD); ?></label>
        </li>
        <li class="stickyinfo">
            <label for="meta-tuairis-sticky-duration"><?php _e('Until', TTD); ?></label>
            <input id="expiry-hour" name="hour" type="text" min="00" max="23" minlength="2" maxlength="2" size="2" value="00"> :
            <input id="expiry-minute" type="text" min="00" max="59" minlength="2" maxlength="2" size="2" value="00">
        </li>
        <li class="stickyinfo">
            on <select id="expiry-day" name="day"></select><select id="expiry-month" name="month"></select><select id="expiry-year" name="year"></select>
        </li>
    </ul>
    <p class="stickyinfo" id="meta-tuairisc-sticky-info">
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
    $post_meta = get_option('tuairisc_feature_post_key');
    
    if (!ctype_alnum($_POST[$nonce['name']]) || !isset($_POST[$nonce['name']])) {
        return;
    }

    if (!wp_verify_nonce($_POST[$nonce['name']], $nonce['action'])) {
        return;
    }
    
    if  (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return; 
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    update_post_meta($post_id, $post_meta, $_POST['featured']);
}

/**
 * Update Post Meta Box
 * -----------------------------------------------------------------------------
 */

add_action('add_meta_boxes', 'tuairisc_meta_box');
add_action('save_post', 'update_meta_box');

?>
