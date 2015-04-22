<?php 
$category = get_the_category();
$exclude = get_option('sticky_posts');
$exclude[] = $post->ID;

$related_query = new WP_Query(array( 
    'post__not_in' => $exclude,
    'posts_per_page' => 3,
    'cat' => $category[0]->term_id
));

$m = 0;

if ($related_query->have_posts()) : ?>
    <div id="related">
        <h6 class="title">
            <?php _e('Léigh tuilleadh sa rannóg seo','tuairisc');?>
        </h6>
        <div class="related-posts">

            <?php while ($related_query->have_posts()) :
                $related_query->the_post(); 
                $m++;
                ?>

                <article id="post-<?php the_ID(); ?>" class="post-grid<?php printf('%s', ($m % 3 === 0) ? ' post-last' : ''); ?>">

                    <?php get_the_image(array(
                        'size' => 'related', 
                        'width' => 260,
                        'height' => 150
                    )); ?>

                    <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tuairisc' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title_attribute(); ?></a>
                    <span class="date"><?php printf(get_the_date()); ?></span>

                </article>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif;

wp_reset_query(); ?>