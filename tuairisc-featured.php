<?php
$query_featured = new WP_Query(array(
    'post__not_in' => get_option('sticky_posts'),
    'posts_per_page' => 5,
    'paged' => 0,
    'meta_key' => 'wpzoom_is_featured',
    'meta_value' => 1
));
?>

<?php // Stolen, adapted and simplified from loop.php ?>
<?php if ($query_featured->have_posts()) :
    while ($query_featured->have_posts()) :
        $query_featured->the_post();
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>  

        <?php if ($query_featured->current_post == 0 && $paged == 1) : ?>
            <article class="featured-main self-clear recent-post" id="post-<?php the_ID(); ?>">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="hero-image" style="background-image: url('<?php echo get_thumbnail_url(); ?>'); ">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"></a>
                    </div>
                <?php endif; ?>

                <div class="post-content <?php echo (has_post_thumbnail()) ? 'hero-post' : ''; ?>">
                    <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permalink to %s', 'wpzoom'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                    <?php echo (!default_author()) ? '<h3>' . get_the_author() . '</h3>' : ''; ?>

                    <div class="recent-meta">
                        <?php if (option::get('display_date') == 'on') : ?>
                            <span><?php the_date(); ?></span>
                        <?php endif; ?>
                        <?php edit_post_link( __('Edit', 'wpzoom'), '<span>', '</span>'); ?>
                    </div> 

                    <div class="entry">                     
                        <?php if ( option::get('display_content') == 'Full Content' ) : ?>
                            <?php the_content( option::get('display_readmore') == 'on' ? __( 'Read More &#8250;', 'wpzoom' ) : '' ); ?>
                        <?php elseif ( option::get('display_content') == 'Excerpt' ) :  ?>
                            <?php the_excerpt(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <div class="featured-row self-clear">
                <div class="row self-clear">
        <?php else : ?>
            <?php if ($query_featured->current_post == 3) : ?>
                </div>
                <div class="row self-clear">
            <?php endif; ?>

            <article id="post-<?php the_ID(); ?>">
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" style="background-image: url('<?php echo get_thumbnail_url(get_the_ID(), 'medium'); ?>');"></a>
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <h5><?php the_title(); ?></h5>
                </a>
            </article>

        <?php endif; ?>
    <?php endwhile; ?>
            </div>
        </div>
<?php endif; ?>