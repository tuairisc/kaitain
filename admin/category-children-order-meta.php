<?php
/**
 * Category Children Order Meta
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
 * Add Category Children Order Meta Input
 * -----------------------------------------------------------------------------
 * @param   object      $tag           Tag object.
 */

// Add field to edit category screen
function kaitain_edit_children_order_meta_form($term_obj){	
	//	debug code
	//highlight_string('<?php '.var_export($term_obj, true) );

	// clear values.
	$children_order_meta = array();

	// Clean tag id
	$id = sanitize_text_field($term_obj->term_id);

	if ( $opt_array = get_option( $id.'_meta') ){
		$children_order_meta = $opt_array['children_order_meta'];
		$use_display_order = $opt_array['use_display_order'];
	} else {
		$children_order_meta = array();
		$use_display_order = false;
	}
	//	debug code
	//highlight_string('<?php '.var_export(get_option( $id.'_meta'), true) );
	?>

	<tr class="form-field">
		<th scope="row"><label for="use_display_order" ><?php _e('Enable / Disable Custom Display Order'); ?></label>
		</th>
		<td>
			<input id="use_display_order" type="checkbox" name="use_display_order" />
	    	<label for="use_display_order" ><?php _e('Check to enable Custom Display Order'); ?></label>
		</td>
	</tr>
	<script type="text/javascript">
        jQuery('#use_display_order').prop('checked', <?php printf('%s', $use_display_order ? 'true' : 'false'); ?> );
    </script>
	<!-- Category children order meta -->
	<tr class="form-field">
		<th scope="row"><label for="kaitain_children_order_meta"><?php _e('Custom display order for child categories on category page') ?></label>
		</th>
		<td class="row">
			<fieldset id="kaitain_children_order_meta">
				<?php
				 $children_categories = get_categories(array(
			        'parent' => $term_obj->term_id,
			        'orderby' => 'name',
			        'order' => 'ASC'
			    ));
				if ( !empty($children_categories) ) {
					 // for each child category, display a number input that uses the same name[]
					
					foreach ($children_categories as $child) {
						?>
						<input id="kaitain_children_order_meta_<?php echo $child->cat_ID; ?>" type="number" name="children_order_meta[<?php echo $child->cat_ID; ?>]" value="<?php
							$output = ( $children_order_meta[$child->cat_ID] )?: '-1';
					    	echo intval( $output );
					    ?>" style="width:15%;" />
					    <label for="kaitain_children_order_meta_<?php echo $child->cat_ID; ?>" style="width: 75%;"><?php echo $child->name; ?></label>
					    <br />
					<?php
					}
				}
				?>
				<p class="description"><?php _e('The number set beside the child category will control the order that child gets displayed on the category page. The lowest is displayed first, then the next and so on. To remove sub-category from display set to -1 (or any negative number).') ?>
				</p>
			</fieldset>
		</td>
	</tr>

<?php
}
add_action('category_edit_form_fields','kaitain_edit_children_order_meta_form');

/**
 * Update Category Children Order Meta Option
 * -----------------------------------------------------------------------------
 * Validate and update.
 * 
 * @param   int     $term_id        Term id.
 * @param   int     $tt_id         	Term taxonomy id.
 *
 */

function kaitain_create_update_children_order_meta($term_id,$tt_id){

	$use_display_order = (isset($_POST['use_display_order']) && $_POST['use_display_order'] === 'on');
	$update['use_display_order'] = $use_display_order;


	function input_validation($value) {
		// if value not negative use it, otherwise set it to -1
		if ( $value == absint( $value ) ) {
			return $value;
		} else {
			return '-1';
		}
	}

	// takes key = cat ID, value = display order
	if ( isset($_POST['children_order_meta']) ) {

		$input = array_map( 'input_validation', $_POST['children_order_meta'] );

		if ( is_array( $input ) ) {

			// $input = array_filter($input, function ($v, $k) {
			// 	// returns true when both key and value are integers 
			// 	return is_int($k) && is_int($v);
			// }, ARRAY_FILTER_USE_BOTH);

			// sort array keys by value (display order);
			asort( $input );

			// reset values to ascending display order
			$i = 1;
			$ordered_input = array();
			foreach ( $input as $k => $v ) {
			 	if ( $v != '-1' ){
			 		$ordered_input[$k] = $i;
			 		$i++;
			 	}
			}
			unset($i);

			$update['children_order_meta'] = $ordered_input;
		}

	}


	// Update to wp_options (could also use wp_termmeta, those as yet there is more docs + methods for wp_options)
	if ( isset($update) )
		update_option( $term_id.'_meta' , $update );

}
add_action('created_category','kaitain_create_update_children_order_meta',10,2);
add_action('edit_category','kaitain_create_update_children_order_meta',10,2);
