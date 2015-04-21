<?php

/**
 * Home Page Top Featured Posts
 * ----------------------------
 * This script generates the code for the top/featured articles on the Tuairisc
 * home page.
 * 
 * @category   WordPress File
 * @package    Tuairisc.ie Gazeti Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    1.0
 * @link       https://github.com/bhalash/tuairisc.ie
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