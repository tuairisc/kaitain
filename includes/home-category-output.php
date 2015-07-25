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
 * @param   int/array/string        $cats           Categor{y,ies}.
 * @param   int                     $numberposts    Number of posts to output.
 */

function category_widget_output($cats, $show_category_name = true, $numberposts = 4)  {
    global $post, $sections;
    $categories = array();
    $current_post = 0;

    // Resolve categories down to ID.
    if (is_int($cats) || is_string($cats)) {
        $categories[] = intval($cats);
    } else if (is_array($cats)) {
        $categories = $cats;
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
            $post_classes = implode(' ', get_post_class($current_post === 0 ? 'category-left' : '', get_the_ID()));
            $image_size = ($index === 0) ? 'medium' : 'thumbnail';

            // Articles on either side have the same HTML, but different classes.
            printf('<article class="%s" id="%s">', $post_classes, get_the_ID());
            printf('<div class="%s">', 'category-article-image');

            printf('<a href="%s" title="%s" rel="bookmark"><img class="%s" src="%s" alt="%s" /></a>',
                get_the_permalink(),
                the_title_attribute('echo=0'),
                'cover-fit',
                get_post_image(get_the_ID(), $image_size),
                the_title_attribute('echo=0')
            );

            // End category-article-image
            printf('</div>');

            printf('<p class="%s %s"><a class="%s" href="%s" title="%s" rel="bookmark">%s</a></p>',
                'category-article-title',
                ($index === 0) ? $section_background : $section_hover,
                ($index !== 0) ? $section_hover : '',
                get_the_permalink(),
                the_title_attribute('echo=0'),
                get_the_title()
            );

            printf('</article>');

            if ($current_post === 0) {
                printf('<div class="category-right">');
            }

            $current_post++;
        }
        
        $current_post = 0;    
        printf('</div></div></div>');
    }

    wp_reset_postdata();
}

?>
