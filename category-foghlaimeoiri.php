<?php

/**
 * Category Archive
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

get_header();
global $cat;
$page_number = intval(get_query_var('paged'));
$meta_key = get_option('kaitain_featured_post_key');

if ( $opt_array = get_option('foghlaimeoiri_'.$cat.'_meta') ){
	$category_image = sanitize_text_field($opt_array['category_image']);
	?>

	<div class="foghlaimeoiri-image img-frame category-lead-image">
		<img src="<?php echo $category_image; ?>" class="" />
	</div>

	<?php
}

kaitain_education_section_pane('sraith-pictiur');
kaitain_education_section_pane('leamhthuiscinti');
kaitain_education_section_pane('fiseain');
kaitain_education_section_pane('crosfhocal');
kaitain_education_section_pane('mireanna-mearai');
kaitain_education_section_pane('ursceal-dfhoghlaimeoiri');

get_footer();

?>
