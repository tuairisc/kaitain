<?php
/**
 * Columnist Usermeta
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Kaitain
 * @author     Darren Kearney <info@educateducatedmachine.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/kaitain-theme
 * @link       http://www.tuairisc.ie
 */

// View columnist metadata in User list
function kaitain_add_extra_user_column($columns) {
    return array_merge( $columns, 
              array('kaitain_columnist' => __('List Columnist')) );
}
add_filter('manage_users_columns' , 'kaitain_add_extra_user_column');

function kaitain_new_modify_user_table_row( $val, $column_name, $user_id ) {

    if ($column_name == 'kaitain_columnist') {
    		$is_columnist = get_the_author_meta( 'kaitain_columnist', $user_id );
    		($is_columnist == 'yes' )? $status = "Yes" : $status = "No" ;
    		return $status; 
    }
}
add_filter( 'manage_users_custom_column', 'kaitain_new_modify_user_table_row', 10, 3 );


/**
 * Show custom user profile fields
 * @param  obj $user The user object.
 * @return void
 */
function kaitain_custom_user_profile_fields($user) {
	wp_nonce_field('kaitain_columnist_metadata_data', 'kaitain_columnist_metadata_nonce');
	$is_columnist = get_the_author_meta( 'kaitain_columnist', $user->ID );

	// Exit if not admin
	if (!current_user_can('edit_users')){
		return;
	}

	// Reset to no if not checked
	if ( $is_columnist != 'yes' ||  $is_columnist == '' ) {
	    $is_columnist = 'no';
	}
	?>

	<table class="form-table">
	<tr>
	    <th>    
	        <label for="kaitain_columnist"><?php _e('Columnist List'); ?>
	    </th>
	    <td>
	        <input type="checkbox" name="kaitain_columnist" id="kaitain_columnist"
	        <?php
		        if ( $is_columnist == 'yes' ) {
		            echo 'checked';
		        }
		    ?>/>
	        <?php _e('List user on Columnist page.'); ?>
	        </label>
	    </td>
	</tr>
	</table>
	<?php

}
add_action('show_user_profile', 'kaitain_custom_user_profile_fields');
add_action('edit_user_profile', 'kaitain_custom_user_profile_fields');

/**
 * Update Columnist Metadata
 * -----------------------------------------------------------------------------
 * Validation
 * 
 * @param   int      $user_id           User ID.
 */

function kaitain_save_extra_profile_fields( $user_id ) {
	if (!isset($_POST['kaitain_columnist_metadata_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['kaitain_columnist_metadata_nonce'], 'kaitain_columnist_metadata_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return; 
    }
    if (!current_user_can('edit_users')) {
        return;
    }
    if ( !current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }

    $is_columnist = (isset($_POST['kaitain_columnist']) && $_POST['kaitain_columnist'] === 'on');

    if ( ! empty($user_id) ){
    	// update author meta
	    update_user_meta( $user_id, 'kaitain_columnist', ( $is_columnist )? 'yes' : 'no' );
	    // update array of columnist
	    kaitain_update_columnist_group( $user_id, $is_columnist );
    }
}
add_action( 'personal_options_update', 'kaitain_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'kaitain_save_extra_profile_fields' );

/**
 * Update Columnist Group Option
 * -----------------------------------------------------------------------------
 * @param   int 	  		$user_id    	User ID
 * @param   bool            $add_to_group	Add or remove $user_id to Columnist Group
 * @return  array           $group			Array of all columnist group user IDs
 */

function kaitain_update_columnist_group($user_id, $add_to_group = true) {
	
	if ( kaitain_is_verboten_user($user_id) ){
		return false;
	}

	$group = get_option('kaitain_columnist_group');
	
	echo "########  ". gettype($group);

	if ($group == false || $group == '') {
		$group = array($user_id);
		add_option('kaitain_columnist_group', $group);
		return $group;
	}

	if ($add_to_group == true ) {
		if ( in_array($user_id, $group) ) {
			return $group;
		} else {
			array_push($group, $user_id);
		}
	} else if ($add_to_group == false) {
		$group = array_diff($group, $user_id);
	}

	update_option('kaitain_columnist_group', $group);
	return $group;
}

/**
 * Update Columnist Group Option
 * -----------------------------------------------------------------------------
 * @return  array           $group			Array of all columnist group user IDs
 */

function kaitain_get_columnist_group() {
	return get_option('kaitain_columnist_group');
}