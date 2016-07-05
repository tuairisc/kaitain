<?php

/**
 * Columnist Meta Box
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
 * Add Columnist Meta Box
 * -----------------------------------------------------------------------------
 */

function kaitain_columnist_meta_box() {
    add_meta_box(
        'kaitain_columnist_meta',
        __('Columnist List', 'kaitain'),
        'kaitain_columnist_box_content',
        'page'
    );
}

add_action('add_meta_boxes', 'kaitain_columnist_meta_box');

/**
 * Add Post Editor Meta Box
 * -----------------------------------------------------------------------------
 * @param   object      $post           Post object.
 */

function kaitain_columnist_box_content($post) {


    echo "<pre>";
    var_dump($_POST);

    echo " # ";
    var_dump($_GET);

    echo " # ";
    var_dump($_REQUEST);
    echo "</pre>";

    // global $post_data;
    global $wpdb;

    //wp_nonce_field('kaitain_columnist_box_data', 'kaitain_columnist_box_nonce');

    
    // get saved settings
    $columnist_list = get_option('kaitain_columnist_group');



    $defaults = array(
        'orderby' => 'name', 'order' => 'ASC', 'number' => '',
        'optioncount' => false, 'exclude_admin' => true,
        'show_fullname' => false, 'hide_empty' => true,
        'feed' => '', 'feed_image' => '', 'feed_type' => '', 'echo' => true,
        'style' => 'list', 'html' => true, 'exclude' => '', 'include' => '',
                
    );
    $exclude_users = get_option('kaitain_verboten_users');

    $args = array(
        'orderby' => 'name', 'order' => 'ASC', 'number' => '',
        'exclude' => $exclude_users, 'include' => '',
    );
    $query_args = wp_array_slice_assoc( $args, array( 'orderby', 'order', 'number', 'exclude', 'include') );
    $query_args['fields'] = 'id';
    // Get authors
    $authors = get_users( $query_args );
    ?>

    <p>
        <?php _e('Featured columnists are displayed on the website\'s author page.', 'kaitain'); ?>
    </p>

    <?php

    ;?>

    <ul>
        <?php
        //  get all available authors
        //  for each author
        //      add a checkbox to display them
        //      set the checkbox based on the saved setting
        //foreach ( $authors as $author_id) {
        //    $author = get_userdata( $author_id );
            ?>
          <!--   <li>
                <fieldset>
                    <input id="kaitain-columnist-checkbox-<?php echo $author_id;?>" name="make_columnist[<?php echo $author_id;?>]" type="checkbox">
                    <label for="kaitain-columnist-checkbox-<?php echo $author_id;?>">
                        <?php echo $author->first_name.' '.$author->last_name.' ('.$author->user_nicename.')'; ?>
                    </label>
                </fieldset>
            </li>-->  
        <?php //} 
        ?>

        <input type="text" name="test"> 
    </ul>
    
    <script>
        //var postmetaFeatured = {
        //    featured: <?php printf('%s', $is_featured ? 'true' : 'false'); ?>,
        //    sticky: <?php printf('%s', $is_sticky ? 'true' : 'false'); ?>,
        //    expiry: <?php printf('%u', $expiry); ?>
        //};
        //jQuery('#kaitain-featured-checkbox').prop('checked', postmetaFeatured['featured'] );
        //jQuery('#kaitain-sticky-checkbox').prop('checked', postmetaFeatured['sticky'] );
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
    
function kaitain_update_columnist_meta_box($post_id) {
    // if (!isset($_POST['kaitain_columnist_box_nonce'])) {
    //     return;
    // }

    // if (!wp_verify_nonce($_POST['kaitain_columnist_box_nonce'], 'kaitain_columnist_box_data')) {
    //     return;
    // }
    
    // if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    //     return; 
    // }

    // if (!current_user_can('edit_post', $post_id)) {
    //     return;
    // }


    // if (isset($_POST['make_columnist']) && $_POST['make_columnist'] != '' ) {
    //     $make_columnist = $_POST['make_columnist'];
    //     update_post_meta( $post_id, 'kaitiain_columnist_list', $make_columnist );  
    // }
}

add_action('save_post', 'kaitain_update_columnist_meta_box');

?>