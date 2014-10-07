		<?php if ( is_active_sidebar( 'footer-full' ) ) { ?>
			<div class="full-widget-area clearfix">
				 
				<?php dynamic_sidebar('Footer (full-width)'); ?>
				 
			</div>  <div class="clear"></div>
		<?php } ?>

	</div><!-- /.content-wrap -->

    <!-- AdRotate header banner. Height of 125px -->
    <?php echo adrotate_group(3); ?>

	<div id="footer">
 
		<?php if ( is_active_sidebar( 'footer_1'  ) ||  is_active_sidebar( 'footer_2'  )  ||  is_active_sidebar( 'footer_3'  ) ||  is_active_sidebar( 'footer_4'  ) ) : ?>
			<div class="widget-area">
		<?php endif; ?>
				
			<div class="column">
				<?php dynamic_sidebar('Footer (column 1)'); ?>
			</div><!-- / .column -->
			
			<div class="column">
				<?php dynamic_sidebar('Footer (column 2)'); ?>
			</div><!-- / .column -->
			
			<div class="column">
				<?php dynamic_sidebar('Footer (column 3)'); ?>
			</div><!-- / .column -->

			<div class="column last">
				<?php dynamic_sidebar('Footer (column 4)'); ?>
			</div><!-- / .column -->

		<?php if ( is_active_sidebar( 'footer_1'  ) ||  is_active_sidebar( 'footer_2'  )  ||  is_active_sidebar( 'footer_3'  )  ||  is_active_sidebar( 'footer_4'  ) ) : ?>
				<div class="clear"></div>
	        </div><!-- /.widget-area-->		
	    <?php endif; ?>
	    <div class="clear"></div>
	 

 
		<div class="copyright">
			 
			<?php _e('', 'wpzoom'); ?> &copy; <?php echo date("Y",time()); ?> <?php _e('Tuairisc Bheo Teoranta', 'wpzoom'); ?>.
			
			<div class="right">
				
			</div>

			<div class="clear"></div>
		 		
		</div><!-- /.copyright -->
	</div>

	 
</div><!-- /.inner-wrap -->


<?php if ( $paged < 2 && is_home() ) { ?>
<script type="text/javascript">

<?php if (option::get('featured_enable') == 'on' ) {  /* Main Slider */ ?>
jQuery(document).ready(function() {

	if ( jQuery('.slides li').length > 0 ) {

		jQuery('#slides').flexslider({
			controlNav: false,
			directionNav: true,
			animationLoop: true,
			animation: 'fade',
			useCSS: true,
			smoothHeight: false,
			touch: true,
	 		slideshow: <?php echo option::get('featured_rotate') == 'on' ? 'true' : 'false'; ?>,
			<?php if ( option::get('featured_rotate') == 'on' ) echo 'slideshowSpeed: ' . option::get('featured_interval') . ','; ?>
			pauseOnAction: true,
			animationSpeed: 10,
			start: function(slider){
				jQuery('#slider_nav .item').hover(function(){
					var id = getPostIdClass(this);
					if ( id <= 0 ) return;

					var index = slider.slides.index( slider.slides.filter('.' + id) );

					slider.direction = (index > slider.currentSlide) ? 'next' : 'prev';
					slider.flexAnimate(index, slider.pauseOnAction);
				});
			},
			before: function(slider){
				var id = getPostIdClass( slider.slides.eq(slider.animatingTo) );
				if ( id <= 0 ) return;

				jQuery('#slider_nav .item').removeClass('current');
				jQuery('#slider_nav .item.' + id).addClass('current');

				if ( jQuery('#slider_nav .row').length > 1 ) {
					var navSlider = jQuery('#slider_nav').data('flexslider'),
					    currPage = navSlider.slides.index( navSlider.slides.find('.item.' + id).parent('.row') );
					navSlider.direction = (currPage > navSlider.currentSlide) ? 'next' : 'prev';
					navSlider.flexAnimate(currPage, navSlider.pauseOnAction);
				}
			}
		});

		jQuery('#slider_nav .item').wrapInChunks('<div class="row" />', 5);

		jQuery('#slider_nav').flexslider({
			selector: '.tiles > .row',
	  		direction:'vertical',
			controlNav: true,
			directionNav: false,
			animationLoop: false,
			animation: 'slide',
			useCSS: true,
			smoothHeight: false,
			touch: false,
			slideshow: false,
			pauseOnAction: true,
			animationSpeed: 10
		});

	}
});
<?php } ?>

</script>
<?php } ?>


<?php wp_footer(); ?> 

<?php
wp_reset_query();
if (is_single()) { ?><script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script><?php } // Google Plus button
?>
 
<!-- JavaScript for size of AdRotate advertisements. -->
<script src="<?php echo get_template_directory_uri() . '/tuairisc_adrotate.js'; ?>"></script>

<script src="<?php echo get_template_directory_uri() . '/tuairisc_share_popout.js'; ?>"></script>
</body>
</html>