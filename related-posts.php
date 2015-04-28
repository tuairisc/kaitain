<?php 
/**
 * Related Posts Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 *
 * This file is part of Nuacht.
 * 
 * Nuacht is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Nuacht is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Nuacht. If not, see <http://www.gnu.org/licenses/>.
 */ 

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