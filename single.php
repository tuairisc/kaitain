<?php get_header(); ?>
<?php $template = get_post_meta($post->ID, 'wpzoom_post_template', true); ?>

<div id="main"<?php if ($template == 'full') : echo ' class="full-width"'; endif; ?>>
    <div id="content">
        <?php while (have_posts()) : the_post(); ?>
            <?php // Requested by Sean. Incrementing post counter. ?>
            <?php increment_view_counter(); ?>

            <article class="post-wrapper">
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
                                <?php if (option::get('post_author') == 'on' && !default_author()) { ?><span class="meta-author"><?php the_author_posts_link(); ?></span><?php } ?>
                                <?php if (option::get('post_date') == 'on') { ?><?php echo get_the_date() . ' ag ' . get_the_time(); ?><?php } ?>
                            <?php } ?>
                            <?php edit_post_link( __('Edit', 'wpzoom'), '<span>', '</span>'); ?>
                        </div><!-- /.post-meta-text -->
                        <?php // Social sharing links. ?>
                        <?php include 'mshare.php'; ?>
                    </div><!-- /.post-meta -->  
                </div> 
                <div class="clear"></div>
                <div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
                    <div class="entry">
                        <?php the_content(); ?>
                        <?php include 'mshare.php'; ?>
                        <div class="clear"></div>
                        <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'wpzoom' ) . '</span>', 'after' => '</div>' ) ); ?>
                        <div class="clear"></div>                     
                        <?php if ( option::get('post_tags') == 'on' ) : ?>
                            <?php the_tags( '<div class="tag-list"><strong>' . __('Tags:', 'wpzoom') . '</strong> ', ', ', '</div>' ); ?>
                        <?php endif; ?>
                     </div><!-- / .entry -->
                    <div class="clear"></div>
                </div><!-- #post-<?php the_ID(); ?> -->
            </article>

            <?php if (option::get('post_related') == 'on') : ?>
                <?php get_template_part('related-posts'); ?>
            <?php endif; ?>

            <?php if (option::get('post_comments') == 'on') : ?>
                <?php comments_template(); ?>
            <?php endif; ?>
            
        <?php endwhile; ?>
    </div><!-- /#content -->

    <?php if ($template != 'full') : ?> 
        <?php get_sidebar(); ?>
    <?php else : ?>
        <div class="clear"></div>
    <?php endif; ?>
 
</div><!-- /#main -->
<?php get_footer(); ?>