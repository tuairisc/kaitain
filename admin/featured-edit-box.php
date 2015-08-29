<?php

/**
 * Post Meta Box
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 */

$featured_nonce = array(
    'action' => 'tuairisc_featured_box',
    'name' => 'tuairisc_featured_box_nonce'
);

/**
 * Add Post Editor Meta Box
 * -----------------------------------------------------------------------------
 */

function tuairisc_featured_meta_box() {
    add_meta_box(
        'tuairisc_featured_meta',
        __('Feature', 'tuairisc'),
        'tuairisc_featured_box_content',
        'post'
    );
}

/**
 * Add Post Editor Meta Box
 * -----------------------------------------------------------------------------
 * @param   object      $post           Post object.
 */

function tuairisc_featured_box_content($post) {
    global $featured_nonce;
    wp_nonce_field($featured_nonce['action'], $featured_nonce['name']);

    $is_featured = is_featured_post($post);
    $is_sticky = false;
    $expiry = date('U');

    if ($is_featured) {
        $is_sticky = is_post_sticky($post);

        if ($is_featured && $is_sticky) {
            $expiry = get_option('tuairisc_sticky_post')['expires'];
        }
    }

    ?>

    <script>
        var tuairiscMetaInfo = {
            featured: <?php printf('%s', $is_featured ? 'true' : 'false'); ?>,
            sticky: <?php printf('%s', $is_sticky ? 'true' : 'false'); ?>,
            expiry: <?php printf('%u', $expiry); ?>
        };
    </script>

    <p>
        <?php _e('Featured posts are displayed on the website\'s homepage in the lead articles widget.', 'tuairisc'); ?>
    </p>

    <ul>
        <li>
            <input id="meta-tuairisc-featured" name="make_featured" type="checkbox">
            <label for="meta-tuairisc-featured"><?php _e('Feature Post', 'tuairisc'); ?></label>
        </li>
        <li class="stickycheck">
            <input id="meta-tuairisc-sticky" name="make_sticky" type="checkbox">
            <label for="meta-tuairisc-sticky"><?php _e('Sticky Post', 'tuairisc'); ?></label>
        </li>
        <li class="expiryinfo">
            <label><?php _e('Until', 'tuairisc'); ?></label>
            <input class="datepicker-hour" id="expiry-hour" name="hour" type="text" min="00" max="23" minlength="2" maxlength="2" size="2" value="00"> :
            <input class="datepicker-minute" id="expiry-minute" name="minute" type="text" min="00" max="59" minlength="2" maxlength="2" size="2" value="00">
        </li>
        <li class="expiryinfo">
            on <select class="datepicker-day" id="expiry-day" name="day"></select><select class="datepicker-month" id="expiry-month" name="month"></select><select class="datepicker-year" id="expiry-year" name="year"></select>
        </li>
    </ul>
    <p class="expiryinfo" id="meta-tuairisc-sticky-info">
        <em><?php _e('A sticky post will remain in the top position on the front page until either the set time passes, or another post is set to replace it.', 'tuairisc'); ?></em>
   </p>

    <?php
}

/**
 * Update Featured Post Meta
 * -----------------------------------------------------------------------------
 * Validate /ALL/ the things!
 * 
 * @param   int      $post_id           Post object ID.
 */

function update_featured_meta_box($post_id) {
    global $featured_nonce;
    
    if (!ctype_alnum($_POST[$featured_nonce['name']])
    || !isset($_POST[$featured_nonce['name']])) {
        return;
    }

    if (!wp_verify_nonce($_POST[$featured_nonce['name']], $featured_nonce['action'])) {
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
    update_featured_posts($post_id, $make_featured);

    if ($make_featured && $make_sticky) {
        // Sanitiize date input and mkdate.
        $year = filter_var($_POST['year'], FILTER_SANITIZE_NUMBER_INT);
        $month = filter_var($_POST['month'], FILTER_SANITIZE_NUMBER_INT); $month++;
        $day = filter_var($_POST['day'], FILTER_SANITIZE_NUMBER_INT);
        $hour = filter_var($_POST['hour'], FILTER_SANITIZE_NUMBER_INT);
        $minute = filter_var($_POST['minute'], FILTER_SANITIZE_NUMBER_INT);
        $expiry = mktime($hour, $minute, 0, $month, $day, $year);

        if ($expiry) {
            // Set sticky if validated.
            set_sticky_post($post_id, $expiry);
        }
    } else if (!$make_sticky && is_post_sticky($post_id)) {
        // If post was sticky, but no longer.
        remove_sticky_post();
    }
}

/**
 * Update Post Meta Box
 * -----------------------------------------------------------------------------
 */

add_action('add_meta_boxes', 'tuairisc_featured_meta_box');
add_action('save_post', 'update_featured_meta_box');

?>
