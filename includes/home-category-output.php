<?php 

/**
 * Home Index Featured Categories
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 *
 * This file is part of Tuairisc.ie.
 *
 * Tuairisc.ie is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 *
 * Tuairisc.ie is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
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

function category_widget_output($widget_categories, $show_category_name = true, $numberposts = 4)  {
    global $post, $sections;
    $categories = array();

    // Resolve categories down to ID.
    if (is_int($widget_categories) || is_string($widget_categories)) {
        $categories[] = intval($widget_categories);
    } else if (is_array($widget_categories)) {
        $categories = $widget_categories;
    } else {
        return false;
    }

    /* Double loop:
     * 1. Loop each supplied category.
     * 2. For each category, output $numberposts posts.
     * 
     * Order of output is 1 left, $numberposts - 1 right.
     * Left post has an excerpt. */

    foreach($categories as $category) {
        $category_posts = get_posts(array(
            'numberposts' => $numberposts,
            'order' => 'DESC',
            'category' => $category
        ));

        $category = get_category($category);
        $section_slug = $sections->get_section_slug($category);

        $section_text = sprintf('section-%s-text', $section_slug);
        $section_hover = sprintf('section-%s-text-hover', $section_slug);
        $section_background = sprintf('section-%s-background', $section_slug);

        printf('<div class="%s">', 'category-widget');
        
        if ($show_category_name) {
            printf('<h2 class="widget-title"><a class="%s" title="%s" href="%s">%s</a></h2>', 
                $section_text,
                $category->cat_name,
                get_category_link($category),
                $category->cat_name
            );
        }

        printf('<div class="%s">', 'category-widget-display');

        foreach ($category_posts as $index => $post) { 
            setup_postdata($post);

            $image_size = ($index === 0) ? 'medium' : 'thumbnail';

            $classes = array(
                'article' => implode(' ', get_post_class($index === 0 ? 'category-left' : '', get_the_ID())),
                'paragraph' => ($index === 0) ? $section_background : '',
                'anchor' => $section_hover
            );

            category_article_output($post, $classes, $image_size);

            if ($index === 0) {
                printf('<div class="category-right">');
            }
        }

        printf('</div></div></div>');
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

function category_article_output($post, $classes, $image_size) {
    $post = get_post($post);

    if (!$post) {
        return;
    }

    ?> 

    <article class="<?php printf($classes['article']); ?>" id="<?php the_ID(); ?>">
        <a class="<?php printf($classes['anchor']); ?>" href="<?php the_permalink(); ?>" rel="bookmark">
            <div class="category-article-image">
                <img class="cover-fit" src="<?php the_post_image(get_the_ID(), $image_size); ?>" alt="<?php the_title_attribute(); ?>" />
            </div>
            <p class="category-article-title <?php printf($classes['paragraph']); ?>">
                <?php the_title(); ?>
            </p>
        </a>
    </article>

    <?php
}

?>
