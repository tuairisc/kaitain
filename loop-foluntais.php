<div id="foluntais-listings">
    <?php while (have_posts()) : the_post(); ?>    
        <article id="post-<?php the_ID(); ?>" class="recent-foluntais">

            <div class="left">
                <span style="background-color: <?php echo foluntais_category_color(); ?>"><?php echo foluntais_category_name(); ?></span>
                <?php if (option::get('index_thumb') == 'on') : ?> 
                    <?php get_the_image( array( 'size' => 'loop', 'width' => option::get('thumb_width'), 'height' => option::get('thumb_height'), 'before' => '<div class="post-thumb">', 'after' => '</div>' ) ); ?>
                <?php endif; ?>
            </div>

            <div class="right">
                <div class="content">    
                    <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permalink to %s','wpzoom'); ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                    <?php if (!default_author()) : ?>
                        <h3><?php echo get_the_author(); ?></h3>
                    <?php endif; ?>

                    <div class="recent-meta">
                        <?php if (option::get('display_category') == 'on') : ?>
                            <span><?php the_category(', '); ?></span>
                        <?php endif; ?>

                        <?php if (option::get('display_date') == 'on') : ?>
                            <span><?php printf( __('%s', 'wpzoom'),  get_the_date()); ?></span>
                        <?php endif; ?>

                        <?php edit_post_link( __('Edit', 'wpzoom'), '<span>', '</span>'); ?>
                    </div>

                    <div class="entry">                     
                        <?php if ( option::get('display_content') == 'Full Content' ) : ?>
                            <?php the_content( option::get('display_readmore') == 'on' ? __( 'Read More &#8250;', 'wpzoom' ) : '' ); ?>
                        <?php elseif ( option::get('display_content') == 'Excerpt' ) :  ?>
                            <?php the_excerpt(); ?>
                            <a href="<?php the_permalink() ?>" class="read-more">Léigh tuilleadh</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </article>
    <?php endwhile; ?>
</div>
<?php get_template_part('pagination'); ?>
<?php wp_reset_query(); ?>