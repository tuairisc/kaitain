<?php get_header(); ?>
<?php $template = get_post_meta($post->ID, 'wpzoom_post_template', true); ?>

<div id="main"<?php if ($template == 'full') {echo " class=\"full-width\"";} ?>>
	
	<div id="content">

		<?php while (have_posts()) : the_post(); ?>
 
			<div class="post-wrapper">
	 
	 			<div class="post-heading">
                    
                    <div class="title">
                        <h1><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpzoom' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
                    </div>

                    <?php the_excerpt(); ?>

                    <?php $user_id = get_the_author_meta('ID'); ?>

                    <div class="post-meta">
                        <?php if (has_local_avatar($user_id)) : ?>
                            <div class="post-author-avatar" style="background-image: url('<?php echo get_avatar_url($user_id, 200); ?>');"></div>
                        <?php endif; ?>
                        <div class="post-meta-text">
                            <?php if (option::get('post_date') == 'on' || option::get('post_author') == 'on') { ?>
                                <?php if (option::get('post_author') == 'on') { ?><span class="meta-author"><?php the_author_posts_link(); ?></span><?php } ?>
                                <?php if (option::get('post_date') == 'on') { ?><?php echo get_the_date(); ?><?php } ?>
                            <?php } ?>
                        </div><!-- /.post-meta-text -->

                        <ul class="tuairisc-share">
                            <li>
                                <a class="email" href="mailto:?subject=Check out '<?php the_title(); ?>' on <?php bloginfo('name'); ?>&amp;body=<?php the_permalink(); ?>" target="_blank"  title="Share '<?php the_title(); ?>' via email"></a>
                            </li>
                            <li>
                                <a title="Share '<?php the_title(); ?>' via email" class="facebook" href="javascript:void(0)"></a>
                            </li>
                            <li>
                                <a class="twitter" href="https://twitter.com/share?text=<?php the_title(); ?> via @tuairiscnuacht" data-related="twitterdev" data-size="large" data-count="none" target="_blank"></a>
                            </li>
                        </ul>
                    </div><!-- /.post-meta -->  
				</div>
				
				<div class="clear"></div>
				    
				<div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
					 
					<div class="entry">
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