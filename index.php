<?php get_header(); ?>

<div id="main" role="main">

	<?php if (is_home() && $paged < 2 && option::get('featured_enable') == 'on' && option::get('featured_full') == 'on' )  { get_template_part('wpzoom-slider'); } ?>

	<div id="content">

		<?php if (is_home() && $paged < 2 && option::get('featured_enable') == 'on' && option::get('featured_full') == 'off' )  { get_template_part('wpzoom-slider'); } ?>

		<?php if(is_home() && $paged < 2) { ?>
			<div class="home_widgets">
				<?php dynamic_sidebar('home-main') ?>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>

			<div class="home_widgets three-columns">
				<?php dynamic_sidebar('home-columns') ?>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		<?php } ?>


		<?php if ( $paged > 1 || option::get('recent_posts') == 'on') { ?>

		<div class="archiveposts">

			<h3 class="title"><?php echo option::get('recent_title'); ?></h3>

	 		<?php
				global $query_string; // required

				/* Exclude categories from Recent Posts */
				if (option::get('recent_part_exclude') != 'off') {
					if (count(option::get('recent_part_exclude'))){
						$exclude_cats = implode(",-", (array) option::get('recent_part_exclude'));
						$exclude_cats = '-' . $exclude_cats;
						$args['cat'] = $exclude_cats;
					}
				}

				/* Exclude featured posts from Recent Posts */
				if (option::get('hide_featured') == 'on') {

					$featured_posts = new WP_Query(
						array(
							'post__not_in' => get_option( 'sticky_posts' ),
							'posts_per_page' => option::get('featured_number'),
							'meta_key' => 'wpzoom_is_featured',
							'meta_value' => 1
							) );

					$postIDs = array();
					while ($featured_posts->have_posts()) {
						$featured_posts->the_post();
						global $post;
						$postIDs[] = $post->ID;
					}
					$args['post__not_in'] = $postIDs;
				}

				$args['paged'] = $paged;
				if (count($args) >= 1) {
					query_posts($args);
				}
				?>

			<?php get_template_part('loop'); ?>

 		</div> <!-- /.archiveposts -->

		<?php } ?>

	</div><!-- /#content -->

	<?php get_sidebar(); ?>

</div><!-- /#main -->

<?php get_footer(); ?>