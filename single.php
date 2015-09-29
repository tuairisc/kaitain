<?php

/**
 * Single Article
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Kaitain
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/kaitain-theme
 * @link       http://www.tuairisc.ie
 */

get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
       kaitain_partial('article', 'full');

        if (function_exists('rp_get_related')) {
            printf('<div class="%s">', 'related-articles-wrapper');

            printf('<h4 class="%s">%s</h4>',
                'subtitle related-title',
                __('Léigh tuilleadh sa rannóg seo', 'kaitain')
            );

            printf('<div class="%s">', 'related-articles flex-three-cols-article');

            $related = rp_get_related(array(
                'range' => array(
                    'after' => date('Y-m-j') . '-21 days',
                    'before' => date('Y-m-j')
                ),
                'cache' => true
            ));

            foreach ($related as $post) {
                setup_postdata($post);
                kaitain_partial('article', 'related');
            }

            printf('</div>');
            printf('</div>');
            wp_reset_postdata();
        }

        comments_template();
    }
} else {
   kaitain_partial('article', 'missing');
}

get_footer();

?>
