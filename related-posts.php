<?php $category = get_the_category();
 
     $exclude = get_option( 'sticky_posts' );
    $exclude[] = $post->ID;

    $loop = new WP_Query( 
        array( 
            'post__not_in' => $exclude,
            'posts_per_page' => 3,
            'cat' => $category[0]->term_id
            ) );

    $m = 0;
    if ( $loop->have_posts() ) :
?>
    <div class="related_posts">
        <h3 class="title"><?php _e('Tuilleadh','wpzoom');?> <?php echo $category[0]->cat_name; ?></h3>

        <ul>

            <?php  
            
            $exclude = get_option( 'sticky_posts' );
            $exclude[] = $post->ID;

            $loop = new WP_Query( 
                array( 
                    'post__not_in' => $exclude,
                    'posts_per_page' => 3,
                    'cat' => $category[0]->term_id
                    ) );

            $m = 0;
            
            while ( $loop->have_posts() ) : $loop->the_post(); $m++;
            ?>

            <li id="post-<?php the_ID(); ?>" class="post-grid<?php if (($m % 3) == 0) {echo ' post-last';} ?>">

                <?php
                get_the_image( array( 'size' => 'related', 'width' => 230, 'height' => 150 ) );
                ?>
                 
                <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'wpzoom' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title_attribute(); ?></a>
                <span class="date"><?php echo get_the_date(); ?></span>
                
                 
            </li><!-- end #post-<?php the_ID(); ?> -->
            
            <?php endwhile; ?>
            
        </ul><!-- end .posts -->
            
        <div class="cleaner">&nbsp;</div>
    </div>
<?php endif; ?>
<?php wp_reset_query(); ?>