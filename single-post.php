<?php

/**
 * Template Name: Full Width Article with Featured Image
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Kaitain
 * @author     Darren Kearney <info@educatedmachine.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/kaitain-theme
 * @link       http://www.tuairisc.ie
 */

get_header('post');

$trim =  kaitain_current_section_css();
$section_cat = kaitain_current_section_category();

if (have_posts()) {
    while (have_posts()) {
        the_post();

        // checks post for fullwidth image postmeta existance
        if ( has_post_thumbnail() && get_post_meta( $post->ID, 'kaitain_is_fullwidth_feature_image', true ) == 1 ) {
            // use the full featured image partial to render the post
            kaitain_partial('article', 'full-featured-image');
        } else {
            ?>
        <div class="trim-block noprint trim-block-banner">
            <div class="advert-block adverts--banner" id="adverts--sidebar">
                <?php if (function_exists('adrotate_group')) {
                    printf(adrotate_group(1));
                } ?>
            </div>
            <div class="stripe stripe__absolute-bottom top-trim"></div>
        </div>
        <div class="section--current--bg noprint" style="display:none;" id="bigsearch" data-bind="visible: state.search(), css: { showSearch: state.search() }">
            <form class="bigsearch-form" id="bigsearch-form" method="get" action="<?php printf($action); ?>" autocomplete="off" novalidate>
                <fieldset form="bigsearch-form">
                    <input class="bigsearch-input" name="s" placeholder="<?php printf($placeholder); ?>" type="search" required="required" data-bind="hasFocus: state.search(), css: { showSearch: state.search() }">
                </fieldset>
            </form>
            <button class="navrow__button navrow__button--search" id="searchtoggle__search" type="button" data-bind="click: showSearch">
                <span class="navrow__icon search" data-bind="css: { close: state.search() }"></span>
            </button>
        </div>
            <main class="main "id="main">
                <div class="main__content" id="main__content">
            <?php
            kaitain_partial('article', 'full');
        }

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
