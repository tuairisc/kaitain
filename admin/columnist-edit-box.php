<?php

/**
 * Columnist Meta Box
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Kaitain
 * @author     Darren Kearney <info@educatedmachine.com>
 * @copyright  Copyright (c) 2016, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/kaitain/kaitain
 * @link       http://www.tuairisc.ie
 */

/**
 * Add Columnist Meta Box
 * -----------------------------------------------------------------------------
 */

function kaitain_columnist_meta_box() {

    global $post;
    
    if(!empty($post)) {
        $pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);

        if ( $pageTemplate == 'columnist-page.php' ) {       
            add_meta_box(
                'kaitain_columnist_meta',
                __('Columnist List', 'kaitain'),
                'kaitain_columnist_box_content',
                'page'
            );
        }
    }
}
add_action('add_meta_boxes', 'kaitain_columnist_meta_box');

/**
 * Add Post Editor Meta Box
 * -----------------------------------------------------------------------------
 * @param   object      $post           Post object.
 */

function kaitain_columnist_box_content($post) {
    global $wpdb;

    wp_nonce_field('kaitain_columnist_box_data', 'kaitain_columnist_box_nonce');
    
    // get saved settings
    $columnist_list = get_post_meta($post->ID, 'kaitain_columnist_list', true);
    if ( empty($columnist_list) && function_exists('kaitain_get_columnist_list') ){
        $columnist_list = kaitain_get_columnist_list();
    }

    // Debug code
    // highlight_string( '<?php '. var_export($columnist_list, true));

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
        foreach ( $authors as $author_id) {
            $author = get_userdata( $author_id );
            ?>
             <li>
                <fieldset>
                    <input id="kaitain-columnist-checkbox-<?php echo $author_id;?>" name="make_columnist[<?php echo $author_id;?>]" type="checkbox" <?php if ( in_array( $author_id, $columnist_list ) ) echo "checked"; ?>>
                    <label for="kaitain-columnist-checkbox-<?php echo $author_id;?>">
                        <?php echo $author->first_name.' '.$author->last_name.' ('.$author->user_nicename.')'; ?>
                    </label>
                </fieldset>
            </li> 
        <?php } ?>
    </ul>
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
    if (!isset($_POST['kaitain_columnist_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['kaitain_columnist_box_nonce'], 'kaitain_columnist_box_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return; 
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['make_columnist']) && $_POST['make_columnist'] != '' ) {
        // If the checkbox is checked (returns 'on') put the ID into an array
        $columnist_list = array_keys($_POST['make_columnist'], 'on');

        update_post_meta( $post_id, 'kaitain_columnist_list', $columnist_list ); 
        update_option('kaitain_columnist_group', $columnist_list);
    }
}

add_action('save_post', 'kaitain_update_columnist_meta_box');

?>