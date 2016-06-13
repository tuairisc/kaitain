//Used in edit post

jQuery(document).ready(
	function(){
		// Set the dimensions of the iframe
		width = 300;
		height = 180;

		// select the input field
		input = jQuery("#acf-field-youtube_embed_code");

		parse = function (){ 
			parsed = jQuery.parseHTML(input.val());
			// jQuery(parsed[0]).attr('height', height);
			// jQuery(parsed[0]).attr('width', width);
			jQuery(parsed[0]).attr('style', "width: 100% !important; height:100% !important;");
			input.attr('value', parsed[0].outerHTML);
			console.log(input);
		};

		input.on('focus', parse);

	}
);


jQuery(document).ready(
	function(){
		jQuery("iframe").attr('style', "width: 100% !important; height:100% !important;");	
	}
);
