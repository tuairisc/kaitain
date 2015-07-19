<?php

/**
 * Job Checkbox
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

$job_nonce = array(
    'action' => 'tuairisc_job_box',
    'name' => 'tuairisc_job_box_nonce'
);

/**
 * Add Post Editor Meta Box
 * -----------------------------------------------------------------------------
 */

function tuairisc_job_meta_box() {
    add_meta_box(
        'tuairisc_job_meta',
        __('Job Listing', TTD),
        'tuairisc_job_box_content',
        'post'
    );
}

/**
 * Add Post Editor Meta Box
 * -----------------------------------------------------------------------------
 * @param   object      $post           Post object.
 */

function tuairisc_job_box_content($post, $args) {
    global $job_nonce;
    wp_nonce_field($job_nonce['action'], $job_nonce['name']);

    $key = get_option('tuairisc_job_post_key');
    $is_job = !!get_post_meta($post->ID, $key, true) ? 'checked' : '';;

    ?>

    <p>
        <?php _e('Mark post as a listing for a government or private business employment position.', TTD); ?>
    </p>

    <ul>
        <li>
            <input id="meta-tuairisc-job" name="make-job" type="checkbox" <?php printf($is_job); ?>>
            <label for="meta-tuairisc-job"><?php _e('Job Listing', TTD); ?></label>
        </li>
    </ul>

    <?php
}

/**
 * Update Featured Post Meta
 * -----------------------------------------------------------------------------
 * @param   int      $post_id           Post object ID.
 */

function update_job_meta_box($post_id) {
    global $job_nonce;
    
    if (!ctype_alnum($_POST[$job_nonce['name']]) || !isset($_POST[$job_nonce['name']])) {
        return;
    }

    if (!wp_verify_nonce($_POST[$job_nonce['name']], $job_nonce['action'])) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return; 
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $key = get_option('tuairisc_job_post_key');
    $value = (filter_var($_POST['make-job'], FILTER_SANITIZE_STRIPPED) === 'on');

    update_post_meta($post_id, $key, $value);
}

/**
 * Update Post Meta Box
 * -----------------------------------------------------------------------------
 */

add_action('add_meta_boxes', 'tuairisc_job_meta_box');
add_action('save_post', 'update_job_meta_box');

?>
