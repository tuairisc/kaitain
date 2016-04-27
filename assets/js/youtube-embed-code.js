// Used in edit post
/*
jQuery(document).ready(
	function(){
		// Set the dimensions of the iframe
		width = 300;
		height = 180;

		// select the input field
		input = jQuery("#acf-field-youtube_embed_code");

		parse = function (){ 
			parsed = jQuery.parseHTML(input.val());
			jQuery(parsed[0]).attr('height', height);
			jQuery(parsed[0]).attr('width', width);
			input.attr('value', parsed[0].outerHTML);
			console.log(input);
		};

		input.on('focus', parse);

	}
);





width = jQuery(".article--category__thumb").css("width");
height = jQuery(".article--category__thumb").css("height");

iframeArr = jQuery(".article--category__thumb iframe");
iframeArr.each(function(iframe) {
	iframe.attr( "width", width );
	iframe.attr( "height", height );
});


i = 0;
width = 100;
iframeArr = jQuery(".article--category__thumb iframe");
iframeArr.each( function( index ){
  console.log(i);
  jQuery(iframeArr[index]).css( 'width' );
  console.log('css ' +jQuery(iframeArr[index]).css( 'width' ));
  jQuery(iframeArr[index]).attr( 'width', 200 );
  console.log('attr ' + jQuery(iframeArr[index]).attr( 'width' ));
  jQuery(iframeArr[index]).attr( 'width', width );
  i++;
});
*/