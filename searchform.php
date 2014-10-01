<form method="get" id="searchform" action="<?php echo home_url(); ?>/">
	<fieldset>
		<input type="text" onblur="if (this.value == '') {this.value = '<?php _e('Cuardaigh', 'wpzoom') ?>';}" onfocus="if (this.value == '<?php _e('Cuardaigh', 'wpzoom') ?>') {this.value = '';}" value="<?php _e('Cuardaigh', 'wpzoom') ?>" name="s" id="s" /><input type="submit" id="searchsubmit" value="<?php _e('Cuardaigh', 'wpzoom') ?>" />
	</fieldset>
</form>