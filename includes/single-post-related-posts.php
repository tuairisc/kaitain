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
$filler_trans_name = 'single_post_filler_' . $post->ID;

$range = array(
    'after' => date('Y-m-j') . ' -14 days',
    'before' => date('Y-m-j') . ' -7 days'
);

$related = get_transient($related_trans_name);

if (!$related || empty($related) || WP_DEBUG) {
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
            'inclusive' => true,
            'after' => $range['after'],
            'before' => $range['before']
        )
    )); 

    set_transient($related_trans_name, $related, get_option('tuairisc_transient_timeout')); 
}

if (($missing = $related_count - sizeof($related)) > 0) {
    /*
     * Related Posts Filler
     * -------------------------------------------------------------------------
     * As you go farther back in time in the blog archives, there will be fewer
     * matching related posts. In that case, I would prefer to just grab any
     * random post from this period and add it to the original loop as a filler.
     */

    $excluded = array();

    foreach($related as $post) {
        // Add any found posts to the array of excluded images.
        $excluded[] = $post->ID;
    }

    $filler = get_transient($filler_trans_name);
    
    if (!$filler || empty($filler) || WP_DEBUG) {
        $filler = array(
            // The next two lines force the exclusion of private posts.
            'perm' => 'readable',
            'post_status' => 'publish',
            // Exclude already chosen posts.
            'post__not_in' => $excluded,
            'posts_per_page' => $missing,
            'orderby' => 'rand',
            'order' => 'DESC',
        );
        
        if (!WP_DEBUG) {
            // Test server's copy of posts are way out of date.
            $filler['date_query'] = array(
                'inclusive' => true,
                'after' => $range['after'],
                'before' => $range['before']
            );
        }

        $filler = get_posts($filler);

        set_transient($filler_trans_name, $filler, get_option('tuairisc_transient_timeout')); 
    }

    $related = array_merge($related, $filler);
}

printf('<hr><div class="%s">', 'related-articles');

foreach ($related as $post) {
    setup_postdata($post);
    get_template_part(PARTIAL_ARTICLES, 'related');
}

printf('</div>');
wp_reset_postdata();

?>
