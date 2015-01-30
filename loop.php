<div id="recent-posts" class="clearfix">
    <?php while (have_posts()) : the_post(); ?>    
        <article id="post-<?php the_ID(); ?>" class="self-clear recent-post">
            <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>

            <?php if ($wp_query->current_post == 0 && $paged == 1) : ?>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="hero-image" style="background-image: url('<?php echo get_thumbnail_url(); ?>'); ">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"></a>
                    </div>
                <?php endif; ?>
                <div class="post-content <?php echo hero_post_class(); ?>">  

            <?php else : ?>

                    <?php if (is_columnist_article() && has_local_avatar()) : ?>
                        <div class="post-image" style="background-image: url('<?php echo get_avatar_url(get_the_author_meta('ID'), 200); ?>');">
                    <?php elseif (option::get('index_thumb') == 'on') : ?>
                        <div class="post-image" style="background-image: url('<?php echo get_thumbnail_url(); ?>'); ">
                    <?php else : ?>
                        <div class="post-image-fallback">
                    <?php endif; ?>

                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"></a>
                        </div>

                    <div class="post-content">

            <?php endif; ?> 

                <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( '%s', 'wpzoom'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                <?php if (!default_author()) : ?>
                    <h3><?php echo get_the_author(); ?></h3>
                <?php endif; ?>

                <div class="recent-meta">
                    <span><?php the_date(); ?></span>
                    <?php edit_post_link( __('Edit', 'wpzoom'), '<span>', '</span>'); ?>
                </div> 
                <div class="entry">                     
                    <?php the_excerpt(); ?>
                </div>
            </div>
        </article>
    <?php endwhile; ?>
</div>
<?php get_template_part('pagination'); ?>
<?php wp_reset_query(); ?>