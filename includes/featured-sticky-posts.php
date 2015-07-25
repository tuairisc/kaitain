<?php

/**
 * Featured Post Functions
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

/**
 * Check if Sticky Expired
 * -----------------------------------------------------------------------------
 * @param   string      $expiry_date
 * @return  bool                            Post has expired, true/false.
 */

function tuairisc_sticky_expired() {
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

function is_tuairisc_sticky_post($post) {
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
 * Remove sticky post by setting post ID to -1, which doesn't exist.
 */

function reset_tuairisc_sticky() {
    update_option('tuairisc_sticky_post', array(
        'id' => -1,
        'expires', 0
    ));
}

/**
 * Update Sticky Post
 * -----------------------------------------------------------------------------
 */

function update_tuairisc_sticky($post = null, $expiry = null) {
    $post = get_post($post);

    if (!$post) {
        return false;
    }

    if (get_post_status($post->ID) !== 'publish') {
        return false;
    }

    update_option('tuairisc_sticky_post', array(
        'id' => $post->ID,
        'expires' => $expiry
    ));
}


?>
