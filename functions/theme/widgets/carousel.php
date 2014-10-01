<?php

/*------------------------------------------*/
/* WPZOOM: Carousel Slider                  */
/*------------------------------------------*/
 
class Wpzoom_Carousel_Slider extends WP_Widget {
	
	function Wpzoom_Carousel_Slider() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'carousel-slider', 'description' => 'A list of posts, optionally filtered by category, in a carousel slider.' );

		/* Widget control settings. */
		$control_ops = array( 'id_base' => 'wpzoom-carousel-slider' );

		/* Create the widget. */
		$this->WP_Widget( 'wpzoom-carousel-slider', 'WPZOOM: Carousel Slider', $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {

		extract( $args );

		/* User-selected settings. */
		$title 			= apply_filters('widget_title', $instance['title'] );
		$show_count = $instance['show_count'];
		$show_date = $instance['show_date'] ? true : false;
		$show_cats = $instance['show_cats'] ? true : false;
 		$type = $instance['type'];
 		$category = $instance['category'];
		$slugs = $instance['slugs'];
		
		if ($type == 'tag')
		  {
			$postsq = $slugs;
		  }
		  elseif ($type == 'cat')
		  {
			$postsq = implode(', ', (array) $category); 
			$firstcategory = get_category($instance['category'][0]);
			if ($firstcategory) {
				$category_link = get_category_link($firstcategory);
			}

		  }


		/* Before widget (defined by themes). */
		echo $before_widget;
		
		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		
		?>

		<div id="carousel-<?php echo $this->get_field_id('id'); ?>">
		
		<?php $sq = new WP_Query( array( $type => $postsq, 'showposts' => $show_count, 'orderby' => 'date', 'order' => 'DESC' ) );?>

 		<?php 
		
	   	if ( $sq->have_posts() ) : while( $sq->have_posts() ) : $sq->the_post(); global $post; 
   
			echo '<div class="item">';
				get_the_image( array( 'size' => 'carousel',  'width' => 200, 'height' => 130, 'before' => '<span class="thumb">', 'after' => '</span>' ) ); 
				?>
				<h4><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4><!--<?php
				if ( $show_date ) { ?><span class="date"><?php echo get_the_date(); ?></span>--><?php }
				if ( $show_cats ) { ?><span class="cat-meta"><?php the_category(' '); ?></span><?php }
			echo '</div>';
 			endwhile; 
			endif;
			
			//Reset query_posts
			wp_reset_query();

		?></div>
  		<div class="clear"></div>
  		<a class="prev" id="navi-prev-<?php echo $this->get_field_id('id'); ?>" href="#"></a>
     	<a class="next" id="navi-next-<?php echo $this->get_field_id('id'); ?>" href="#"></a>

 		<div class="fredsel_pagination" id="navi-<?php echo $this->get_field_id('id'); ?>"></div>
  		 
		<script type="text/javascript">
			jQuery(document).ready(function() {
		 
 				jQuery('#carousel-<?php echo $this->get_field_id('id'); ?>').carouFredSel({
					auto: false,
					circular: true,
					responsive: true,
 				    infinite: true,
  					height: "auto",
 					prev	: {	
						button	: "#navi-prev-<?php echo $this->get_field_id('id'); ?>",
						key		: "left"
					},
					next	: { 
						button	: "#navi-next-<?php echo $this->get_field_id('id'); ?>",
						key		: "right"
					},
					align: "center",
  					items : {
  						width: 200,
   						visible : {
							min: 1,
							max: 5,
						}
					}
				});	
 
			});
		</script><?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['show_count'] = $new_instance['show_count'];
		$instance['show_date'] = $new_instance['show_date'];
		$instance['show_cats'] = $new_instance['show_cats'];
 		$instance['type'] = $new_instance['type'];
 		$instance['category'] = $new_instance['category'];
		$instance['slugs'] = $new_instance['slugs'];
		$instance['posts'] = $new_instance['posts'];

		return $instance;
	}
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Carousel', 'show_count' => 10, 'show_date' => 'on', 'show_cats' => 'on', 'type' => 'cat', 'category' => '', 'slugs' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label><br />
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" type="text" class="widefat" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show_count' ); ?>">Show:</label>
			<input id="<?php echo $this->get_field_id( 'show_count' ); ?>" name="<?php echo $this->get_field_name( 'show_count' ); ?>" value="<?php echo $instance['show_count']; ?>" type="text" size="2" /> posts
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_date'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>">Show Date</label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show_cats'], 'on' ); ?> id="<?php echo $this->get_field_id( 'show_cats' ); ?>" name="<?php echo $this->get_field_name( 'show_cats' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_cats' ); ?>">Show Category</label>
		</p>

 		<p>
			<label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Posts marked by:', 'wpzoom'); ?></label>
			<select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" style="width:90%;">
			<option value="cat"<?php if ($instance['type'] == 'cat') { echo ' selected="selected"';} ?>>Categories</option>
			<option value="tag"<?php if ($instance['type'] == 'tag') { echo ' selected="selected"';} ?>>Tag(s)</option>
			</select>
		</p>
		
		
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category (if selected above):', 'wpzoom'); ?></label>
			<?php 
			$activeoptions = $instance['category'];
			if (!$activeoptions)
			{
				$activeoptions = array();
			}
			?>

			<select multiple="true" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>[]" style="width:90%; height: 100px;">

			<?php
				$cats = get_categories('hide_empty=0');

				foreach ($cats as $cat) {
				$option = '<option value="'.$cat->term_id;
				if ( in_array($cat->term_id,$activeoptions)) { $option .='" selected="selected'; }
				$option .= '">';
				$option .= $cat->cat_name;
				$option .= ' ('.$cat->category_count.')';
				$option .= '</option>';
				echo $option;
				}
			?>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'slugs' ); ?>"><?php _e('Tag slugs (if selected above, separated by comma ","):', 'wpzoom'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'slugs' ); ?>" name="<?php echo $this->get_field_name( 'slugs' ); ?>" value="<?php echo $instance['slugs']; ?>" />
		</p>

		<?php
	}
}

function wpzoom_register_cs_widget() {
	register_widget('Wpzoom_Carousel_Slider');
}
add_action('widgets_init', 'wpzoom_register_cs_widget');