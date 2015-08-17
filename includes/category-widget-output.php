<?php 

/**
 * Home Index Featured Categories
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 *
 * This file is part of Tuairisc.ie.
 *
 * Tuairisc.ie is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * Tuairisc.ie is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Tuairisc.ie. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Category Widget Output
 * -----------------------------------------------------------------------------
 * Output the one-left-three right output of the category widget. This is in a 
 * separate function as it also used in archives.
 * 
 * @param   int/array/string    $widget_categories  Categor{y,ies}.
 * @param   int                 $numberposts        Number of posts to output.
 */

function category_widget_output($cats, $show_name = true, $count = 5) {
    global $post, $sections;
    $trans_name = 'category_posts_';
    $categories = array();

    // Resolve categories down to ID.
    if (is_int($cats) || is_string($cats)) {
        $categories[] = intval($cats);
    } else if (!is_array($cats)) {
        return;
    }

    /* Double loop:
     * 1. Loop each supplied category.
     * 2. For each category, output $count posts.
     * 
     * Order of output is 1 left, $count - 1 right.
     * Left post has an excerpt. */

    foreach($categories as $category) {
        $category = get_category($category);

        if (!$category) {
            continue;
        }

        $cat_trans_name = $trans_name . $category->slug;

        if (!($category_posts = get_transient($cat_trans_name))) {
            $category_posts = get_posts(array(
                'numberposts' => $count,
                'order' => 'DESC',
                'category' => $category->cat_ID
            ));

            set_transient($cat_trans_name, $category_posts, get_option('tuairisc_transient_timeout')); 
        }

        // Fetch section trim colours.
        $trim = $sections->get_section_slug($category);

        $trim = array(
            // Section trim class information.
            'slug' => $trim,
            'text' => sprintf('section-%s-text', $trim),
            'hover' => sprintf('section-%s-text-hover', $trim),
            'background' => sprintf('section-%s-background', $trim)
        );

        printf('<div class="%s">', 'category-widget');
        
        if ($show_name) {
            // Category name, and link to category.
            printf('<h2 class="%s %s"><a title="%s" href="%s">%s</a></h2>', 
                $trim['text'],
                'widget-title',
                $category->cat_name,
                get_category_link($category),
                $category->cat_name
            );
        }

        printf('<div class="%s">', 'category-widget-display');

        foreach ($category_posts as $index => $post) { 
            $classes = '';
            setup_postdata($post);

            // "Side" posts only need athumbnail size image.
            if ($index === 0) {
                $image_size = 'tc_home_category_lead';
            } else {
                $image_size = 'tc_home_category_small';
            }

            // First post has a different layout, in a different position.
            if ($index === 0) {
                $classes = 'category-left';
            }

            $classes = get_post_class($classes, get_the_ID());
            $classes = implode(' ', $classes);

            $classes = array(
                'article' => $classes,
                'paragraph' => ($index === 0) ? $trim['background']: '',
                'anchor' => $trim['hover']
            );

            category_article_output($classes, $image_size);

            if ($index === 0) {
                printf('<div class="category-right">');
            }
        }

        printf('</div></div></div>');
        printf('<hr>');
    }

    wp_reset_postdata();
}

/**
 * Category Article Output
 * -----------------------------------------------------------------------------
 * Articles on either side of the widget have the same HTML, but different
 * classes. I separated this for my sanity.
 *
 * @param   int/object      $post           The post object.
 * @param   array           $classes        Classes for article elements.
 * @param   string          $image_size     Thumbnail image size.
 */

function category_article_output($classes, $image_size) {
    ?> 

    <article class="<?php printf($classes['article']); ?>" id="<?php the_ID(); ?>">
        <a class="<?php printf($classes['anchor']); ?>" href="<?php the_permalink(); ?>" rel="bookmark">
            <div class="thumbnail">
            <?php post_image_html(get_the_ID(), $image_size, true); ?>
            </div>
            <p class="category-article-title <?php printf($classes['paragraph']); ?>">
                <?php the_title(); ?>
            </p>
        </a>
    </article>

    <?php
}

?>
