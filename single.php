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

$trim =  kaitain_current_section_css();
$section_cat = kaitain_current_section_category();

if (have_posts()) {
    while (have_posts()) {
        the_post();
        kaitain_partial('article', 'full');

        if (function_exists('rp_get_related')) {
            printf('<h4 class="%s"><a class="%s" href="%s">%s \'%s\'</a></h4>',
                'subtitle related-title',
                $trim['texthover'],
                get_category_link($section_cat->cat_ID),
                __('Léigh tuilleadh sa rannóg seo', 'kaitain'),
                $section_cat->cat_name
            );

            printf('<div class="%s">', 'related-articles flex--three-col--article vspace--double noprint');

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
            wp_reset_postdata();
        }

        comments_template();
    }
} else {
    kaitain_partial('article', 'missing');
}

get_footer();

?>
