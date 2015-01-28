<?php
$query = new WP_Query(array(
    'post__not_in' => get_option('sticky_posts'),
    'posts_per_page' => 9,
    'paged' => 0,
    'meta_key' => 'wpzoom_is_featured',
    'meta_value' => 1
));
?>

<?php // Stolen, adapted and simplified from loop.php ?>
<?php if ($query->have_posts()) : ?>
    <div class="tuairisc-featured">

    <?php while ($query->have_posts()) :
        $query->the_post();
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>  

        <?php if ($query->current_post == 0 && $paged == 1) : ?>
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

        <?php else : ?>

            <?php if ($query->current_post % 4 == 1) : ?>
                <div class="tuairisc-featured-row">
            <?php endif; ?>

            <?php if ($query->current_post % 2 == 1) : ?>
                <div class="tuairisc-featured-block">
            <?php endif; ?>

            <article id="post-<?php the_ID(); ?>">
                <div class="tuairisc-featured-thumb" style="background-image: url('<?php echo get_thumbnail_url(get_the_ID(), 'medium'); ?>');">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"> </a>
                </div>
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                    <h5><?php the_title(); ?></h5>
                </a>
            </article>

            <?php if ($query->current_post % 2 == 0) : ?>
                </div>
            <?php endif; ?>

            <?php if ($query->current_post % 4 == 0) : ?>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    <?php endwhile; ?>
    </div>
<?php endif; ?>