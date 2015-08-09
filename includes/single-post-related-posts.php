<?php

/**
 * Fetch Related Posts
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

global $post;
$category = get_the_category($post->ID); 
$related_count = 3;
$related_trans_name = 'single_post_related_' . $post->ID;

$range = array(
    'after' => get_the_date('Y-m-j') . ' -180 days',
    'before' => get_the_date('Y-m-j') . ' -7 days'
);

if (!($related = get_transient($related_trans_name))) {
    $related = get_posts(array(
        // The next two lines force the exclusion of private posts.
        'perm' => 'readable',
        'post_status' => 'publish',
        'cat' => $category[0]->cat_ID,
        'posts_per_page' => $related_count,
        'orderby' => 'rand',
        'order' => 'DESC',
        'post__not_in' => array($post->ID),
        'date_query' => array(
            'inclusive' => false,
            'after' => $range['after'],
            'before' => $range['before']
        )
    )); 

    set_transient($related_trans_name, $related, get_option('tuairisc_transient_timeout')); 
}

if (sizeof($related) < $related_count) {
    /*
     * Related Posts Filler
     * -------------------------------------------------------------------------
     * As you go farther back in time in the blog archives, there will be fewer
     * matching related posts. In that case, I would prefer to just grab any
     * random post from this period and add it to the original loop as a filler.
     */

    $missing = $related_count - sizeof($related);
    $excluded = array();

    foreach($related as $post) {
        // Add any found posts to the array of excluded images.
        $excluded[] = $post->ID;
    }

    $single_post_filler = get_posts(array(
        // The next two lines force the exclusion of private posts.
        'perm' => 'readable',
        'post_status' => 'publish',
        // Exclude already chosen posts.
        'post__not_in' => $excluded,
        'posts_per_page' => $filler_count,
        'orderby' => 'rand',
        'order' => 'DESC',
        'date_query' => array(
            'inclusive' => false,
            'after' => $range['after'],
            'before' => $range['before']
        )
    ));

    set_transient('single_post_filler', get_option('tuairisc_transient_timeout')); 
    $related = array_merge($single_post_related, $single_post_filler);
}

printf('<hr><div class="%s">', 'related-articles');

foreach ($related as $post) {
    setup_postdata($post);
    get_template_part(PARTIAL_ARTICLES, 'related');
}

printf('</div>');
wp_reset_postdata();

?>
