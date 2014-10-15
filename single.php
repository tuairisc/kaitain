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

                    <div class="post-meta">
                        <?php if (has_local_avatar()) : ?>
                            <div class="avatar" style="background-image: url('<?php echo get_avatar_url(135); ?>');"></div>
                        <?php endif; ?>
                        <div class="post-meta-text">
                            <?php if (option::get('post_date') == 'on' || option::get('post_author') == 'on') { ?>
                                <?php if (option::get('post_author') == 'on') { ?><span class="meta-author"><?php the_author_posts_link(); ?></span><?php } ?>
                                <?php if (option::get('post_date') == 'on') { ?><?php echo get_the_date() . ' at ' . get_the_time(); ?><?php } ?>
                            <?php } ?>
                            <?php edit_post_link( __('Edit', 'wpzoom'), '<span>', '</span>'); ?>
                        </div><!-- /.post-meta-text -->

                        <ul class="tuairisc-share">
                            <?php $site   = urlencode(get_bloginfo('name')); ?>
                            <?php $url    = urlencode(get_the_permalink()); ?> 
                            <?php $title  = urlencode(get_the_title()); ?>
                            <?php $twuser = urlencode(' ó @tuairiscnuacht'); ?>

                            <li><a class="email" href="mailto:?subject=<?php echo $title; ?>&amp;body=<?php echo $url; ?>" rel="0" target="_blank"  title="Email '<?php the_title(); ?>'"></a></li>
                            <li><a class="facebook" href="https://www.facebook.com/sharer.php?u=<?php echo $url ?>" target="_blank" rel="1" title="Share '<?php the_title(); ?>' on Facebook"></a></li>
                            <li><a class="twitter" href="https://twitter.com/share?text=<?php echo $title . $twuser; ?>&url=<?php echo $url; ?>" rel="2" target="_blank" title="Tweet about '<?php the_title(); ?>"></a></li>
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