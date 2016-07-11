<?php
/**
 * Category Image Edit - Foghlaimeoiri
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
 * Add Category Image Input
 * -----------------------------------------------------------------------------
 * @param   object      $tag           Tag object.
 */

// Add field to edit category screen
function kaitain_edit_foghlaimeoiri_form($term_obj){	

	if ( $term_obj->slug == 'foghlaimeoiri' ) {

		// clear values.
		$category_image = 'http://';

		// Clean tag id
		$id = sanitize_text_field($_GET['tag_ID']);

		if ( $opt_array = get_option('foghlaimeoiri_'.$id.'_meta') ){
			$category_image = sanitize_text_field($opt_array['category_image']);
		}

		// Enqueue wordpress scripts for media library & uploader
		wp_enqueue_media();
		?>
		<!-- Category image -->
		<tr class="form-field">
			<th scope="row"><label for="upload_image"><?php _e('Foghlaimeoiri Image') ?></label>
			</th>
			<td>
			    <input id="upload_image" type="text" size="36" name="category_image" value="<?php echo $category_image;?>" /> 
			    <input id="upload_image_button" class="button" type="button" value="Upload Image" />
			    <br />
			    <label for="upload_image">Enter a URL or upload an image</label>
			</td>
		</tr>
		<script type="text/javascript">

			jQuery(document).ready(function($){

			    var custom_uploader;

			    $('#upload_image_button').click(function(e) {

			        e.preventDefault();

			        //If the uploader object has already been created, reopen the dialog
			        if (custom_uploader) {
			            custom_uploader.open();
			            return;
			        }

			        //Extend the wp.media object
			        custom_uploader = wp.media.frames.file_frame = wp.media({
			            title: 'Choose <?php echo $tag_object->name; ?> Image',
			            button: {
			                text: 'Choose <?php echo $tag_object->name; ?> Image'
			            },
			            multiple: false
			        });

			        //When a file is selected, grab the URL and set it as the text field's value
			        custom_uploader.on('select', function() {
			            console.log(custom_uploader.state().get('selection').toJSON());
			            attachment = custom_uploader.state().get('selection').first().toJSON();
			            $('#upload_image').val(attachment.url);
			        });

			        //Open the uploader dialog
			        custom_uploader.open();
			    });
			});

		</script>
	<?php
	}
}
add_action('category_edit_form_fields','kaitain_edit_foghlaimeoiri_form');
/**
 * Update Category TermMeta
 * -----------------------------------------------------------------------------
 * Validate and update.
 * 
 * @param   int     $term_id        Term id.
 * @param   int     $tt_id         	Term taxonomy id.
 *
 */

function kaitain_create_update_foghlaimeoiri($term_id,$tt_id){

	$term_obj = get_term($term_id);

	if ( $term_obj->slug == 'foghlaimeoiri' ) {
	// if term_id = foghlaimeoiri category
	//if ( $term_id == 187 ) {
		// Grab your field names in $_POST, sanatize and put wherever you want
		if ( isset($_POST['category_image']) )
			$update['category_image'] = sanitize_text_field($_POST['category_image']);

		if ( isset($update) )
			update_option( 'foghlaimeoiri_'.$term_id.'_meta' , $update );
	}
}
add_action('created_category','kaitain_create_update_foghlaimeoiri',10,2);
add_action('edit_category','kaitain_create_update_foghlaimeoiri',10,2);


// function kaitain_add_foghlaimeoiri_fields(){
// 	// This code is used by the Add New Category form on the Posts > Categories admin menu
// }
// add_action('category_add_form_fields','kaitain_add_foghlaimeoiri_fields');