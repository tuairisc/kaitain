<?php get_header(); ?>
<?php $template = get_post_meta($post->ID, 'wpzoom_post_template', true); ?>

<div id="main"<?php if ($template == 'full') {echo " class=\"full-width\"";} ?>>
	
	<div id="content">

		<?php while (have_posts()) : the_post(); ?>
 
			<div class="post-wrapper">
	 
	 			<div class="post-heading">

                    <?php $user_id = get_the_author_meta('ID'); ?>

                        <?php if (has_local_avatar($user_id)) : ?>
                            <div class="post-meta" style="background-image: url('<?php echo get_avatar_url($user_id, 200); ?>'); height:100px;">
                        <?php else : ?>
                            <div class="post-meta"> 
                            <?php if (option::get('post_date') == 'on' || option::get('post_author') == 'on') { ?>
                                <?php if (option::get('post_date') == 'on') { ?><?php echo get_the_date(); ?><?php } ?>
                                <?php if (option::get('post_author') == 'on') { ?><span class="meta-author"><?php _e('by', 'wpzoom'); ?> <?php the_author_posts_link(); ?></span><?php } ?>
                                <?php edit_post_link( __('Edit', 'wpzoom'), '', ''); ?> 
                            <?php } ?>
                        <?php endif; ?>
                    </div><!-- /.post-meta -->  
                    
                    <div class="title">
                        <h1><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpzoom' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
                    </div>

                    <?php if (has_local_avatar($user_id)) : ?>
                        <div class="post-meta-alt">
                            <?php if (option::get('post_date') == 'on' || option::get('post_author') == 'on') { ?>
                                <?php if (option::get('post_date') == 'on') { ?><?php echo get_the_date(); ?><?php } ?>
                                <?php if (option::get('post_author') == 'on') { ?><span class="meta-author"><?php _e('by', 'wpzoom'); ?> <?php the_author_posts_link(); ?></span><?php } ?>
                                <?php edit_post_link( __('Edit', 'wpzoom'), '', ''); ?> 
                            <?php } ?>
                        </div>
                    <?php endif; ?>
				</div>
				
				<div class="clear"></div>
				    
				<div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
					 
					<div class="entry">
                        <?php the_excerpt(); ?>
						<?php the_content(); ?>
						<div class="clear"></div>
						
						<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'wpzoom' ) . '</span>', 'after' => '</div>' ) ); ?>
						<div class="clear"></div>
 						
						<?php if ( option::get('post_tags') == 'on' ) { the_tags( '<div class="tag-list"><strong>' . __('Tags:', 'wpzoom') . '</strong> ', ', ', '</div>' ); } ?>

						<?php if (option::get('post_share') == 'on') { ?>
				 
							<div class="share_box">
								<h3><?php _e('Share this post', 'wpzoom'); ?></h3>
								<div class="share_btn"><a href="http://twitter.com/share" data-url="<?php the_permalink() ?>" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>
								<div class="share_btn"><iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=1000&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:80px; height:21px;" allowTransparency="true"></iframe></div>
								<div class="share_btn"><g:plusone size="medium"></g:plusone></div>
								<div class="clear"></div>
							</div> 
							 
						<?php } ?>
				
 					</div><!-- / .entry -->
					<div class="clear"></div>
				 
				</div><!-- #post-<?php the_ID(); ?> -->

			</div>
 

		 	<?php if (option::get('post_related') == 'on') {
				get_template_part('related-posts');
 			} ?>


		 
			<?php if (option::get('post_comments') == 'on') { 
				comments_template();
				} ?>
			
		<?php endwhile; ?>

	</div><!-- /#content -->
	
	
	<?php if ($template != 'full') { 
		get_sidebar(); 
	} else { echo "<div class=\"clear\"></div>"; } ?>
 
</div><!-- /#main -->
<?php get_footer(); ?> 