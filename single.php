<?php

/**
 * Single Article
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 */

get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
        partial('article', 'full');

        printf('<div class="%s">', 'related-articles-wrapper');

        printf('<h4 class="%s">%s</h4>',
            'subtitle related-title',
            __('Léigh tuilleadh sa rannóg seo', 'tuairisc')
        );

        printf('<div class="%s">', 'related-articles');

        foreach (get_related() as $post) {
            setup_postdata($post);
            partial('article', 'related');
        }

        printf('</div>');
        printf('</div>');

        wp_reset_postdata();
        comments_template();
    }
} else {
    partial('article', 'missing');
}

get_footer();

?>
