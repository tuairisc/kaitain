<div id="recent-posts" class="clearfix">

<?php $show_hero = true; ?>

<?php while (have_posts()) : the_post();?>
    <?php if ($show_hero) : ?>
        <?php include(locate_template('hero.php')); ?>
    <?php else : ?>
    	<div id="post-<?php the_ID(); ?>" class="recent-post">

            <?php if (is_columnist_article() && has_local_avatar()) : ?>
                <div class="post-thumb">
                    <div class="avatar" style="background-image: url('<?php echo get_avatar_url(200); ?>');"></div>
                </div>
            <?php else : ?>
        		<?php if (option::get('index_thumb') == 'on') { 
         			get_the_image( array( 'size' => 'loop', 'width' => option::get('thumb_width'), 'height' => option::get('thumb_height'), 'before' => '<div class="post-thumb">', 'after' => '</div>' ) );
         		} ?>
            <?php endif; ?>
    		
    		<div class="post-content">	
    			
      			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permalink to %s', 'wpzoom'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                <h3><?php echo get_the_author(); ?></h3>
     			<div class="recent-meta">
    				<?php if (option::get('display_category') == 'on') { ?><span><?php the_category(', '); ?></span><?php } ?>
    				<?php if (option::get('display_date') == 'on') { ?><span><?php printf( __('%s', 'wpzoom'),  get_the_date()); ?></span><?php } ?>
                    <?php if (option::get('display_comments') == 'on') { ?><br /><span><?php comments_popup_link( __('', 'wpzoom'), __('trácht amháin', 'wpzoom'), __('% nótaí tráchta', 'wpzoom'), '', __('tá fóram na dtráchtanna dúnta.', 'wpzoom')); ?></span><?php } ?>
    				<?php edit_post_link( __('Edit', 'wpzoom'), '<span>', '</span>'); ?>
    			</div><!-- /.post-meta -->	
     
     			<div class="entry">
    				 
    				<?php
    					if ( option::get('display_content') == 'Full Content' ) {
    						the_content( option::get('display_readmore') == 'on' ? __( 'Read More &#8250;', 'wpzoom' ) : '' );
    					} elseif ( option::get('display_content') == 'Excerpt' ) {
                            the_excerpt();
     					}
    				?>
     
    			</div><!-- /.entry -->
    			 
    		</div><!-- /.post-content -->
        <?php endif; ?>
	
		<div class="clear"></div>

	</div><!-- #post-<?php the_ID(); ?> -->

<?php endwhile; ?>
</div>
<?php get_template_part( 'pagination'); ?>
<?php wp_reset_query(); ?>