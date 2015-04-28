<?php
/**
 * Home Page Top Featured Posts
 * -----------------------------------------------------------------------------
 * @author     Mark Grealish <mark@bhalash.com>
 * @link       http://www.bhalash.com
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    1.2
 * @link       http://www.tuairisc.ie
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
 * 
 * This script generates the code for the top/featured articles on the Tuairisc
 * home page.
 */ 

$query = new WP_Query(array(
    'post__not_in' => get_option('sticky_posts'),
    'posts_per_page' => 9,
    'paged' => 0,
    'meta_key' => 'wpzoom_is_featured',
    'meta_value' => 1
));

if ($query->have_posts()) {
    printf('<div class="tuairisc-featured">');

    while ($query->have_posts()) {
        $query->the_post();
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        if ($query->current_post == 0 && $paged == 1) {
            // Call lead article.
            get_template_part('/partials/articles/article', 'lead');

        } else {

            if ($query->current_post == 1) {
                printf('<div class="tuairisc-featured-row">');
            }

            // Call secondary article.
            get_template_part('/partials/articles/article', 'featured');

            if ($query->current_post == 8) {
                printf('</div>');
            }

        }
    }

    printf('</div>');
} ?>