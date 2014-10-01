<div id="post-<?php the_ID(); ?>" class="recent-post">

<?php if (has_post_thumbnail()) : ?>
    <div class="hero-image" style="background-image: url('<?php echo get_thumbnail_url(get_the_ID()); ?>'); ">
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"></a>
    </div>
<? endif; ?>

<?php $hero_post_class = (has_post_thumbnail()) ? 'hero-post' : '' ; ?>

<div class="post-content <?php echo $hero_post_class; ?>">  
    
    <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permalink to %s', 'wpzoom'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

    <div class="recent-meta">
        <?php if (option::get('display_category') == 'on') { ?><span><?php the_category(', '); ?></span><?php } ?>
        <?php if (option::get('display_date') == 'on') { ?><span><?php printf( __('%s at %s', 'wpzoom'),  get_the_date(), get_the_time()); ?></span><?php } ?>
        <?php if (option::get('display_comments') == 'on') { ?><br /><span><?php comments_popup_link( __('0 comments', 'wpzoom'), __('1 comment', 'wpzoom'), __('% comments', 'wpzoom'), '', __('Comments are Disabled', 'wpzoom')); ?></span><?php } ?>
         
        <?php edit_post_link( __('Edit', 'wpzoom'), '<span>', '</span>'); ?>
    </div><!-- /.post-meta -->  

    <div class="entry">
         
        <?php
            if ( option::get('display_content') == 'Full Content' ) {
                the_content( option::get('display_readmore') == 'on' ? __( 'Read More &#8250;', 'wpzoom' ) : '' );
            } elseif ( option::get('display_content') == 'Excerpt' ) {
                echo get_excerpt(245);
            }
        ?>

    </div><!-- /.entry -->
     
</div><!-- /.post-content -->

<?php $show_hero = false; ?>