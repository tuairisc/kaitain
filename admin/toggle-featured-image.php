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

function kaitain_toggle_fullwidth_featured_image() {
    add_meta_box(
        'kaitain_toggle_fullwidth_featured_image',
        __('Fullwidth Featured Image', 'kaitain'),
        'kaitain_toggle_fullwith_featured_image_metabox',
        'post'
    );
}

add_action('add_meta_boxes', 'kaitain_toggle_fullwidth_featured_image');

/**
 * Add Post Editor Meta Box
 * -----------------------------------------------------------------------------
 * @param   object      $post           Post object.
 */

function kaitain_toggle_fullwith_featured_image_metabox($post) {
    wp_nonce_field('kaitain_fullwidth_featured_image_data', 'kaitain_fullwidth_featured_image_content_nonce');

    // check if meta option is empty, if so set to default on, otherwise use whatever has been set
    if ( empty(get_post_meta($post->ID, 'kaitain_is_fullwidth_feature_image', true))  ) {
        echo "IT's EMPTY when there are not set";
        $is_fullwidth_featured = true;
    } else {
        $is_fullwidth_featured = !!get_post_meta($post->ID, 'kaitain_is_fullwidth_feature_image', true);   
    }

    ?>

    <p>
        <?php _e('Featured images are displayed by default but can be unchecked to disable.', 'kaitain'); ?>
    </p>

    <ul>
        <li>
            <fieldset>
                <input id="kaitain-fullwith-featured-image-checkbox" name="fullwidth_featured_image" type="checkbox">
                <label for="kaitain-fullwith-featured-image-checkbox"><?php _e('Feature Image Full Width', 'kaitain'); ?></label>
            </fieldset>
        </li>
    </ul>
    
    <script>
        var postmetaFullwidthFeaturedImage = {
            fullwidth: <?php printf('%s', $is_fullwidth_featured ? 'true' : 'false'); ?>,
        };
        jQuery('#kaitain-fullwith-featured-image-checkbox').prop('checked', postmetaFullwidthFeaturedImage['fullwidth'] );
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

function kaitain_update_toggle_fullwidth_featured_image($post_id) {
    if (!isset($_POST['kaitain_fullwidth_featured_image_content_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['kaitain_fullwidth_featured_image_content_nonce'], 'kaitain_fullwidth_featured_image_data')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return; 
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $is_fullwidth_featured_image = (isset($_POST['fullwidth_featured_image']) && $_POST['fullwidth_featured_image'] === 'on');

    // Update meta.
    update_post_meta($post_id, 'kaitain_is_fullwidth_feature_image', $is_fullwidth_featured_image);
}

add_action('save_post', 'kaitain_update_toggle_fullwidth_featured_image');

?>