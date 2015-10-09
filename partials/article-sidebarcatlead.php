<?php

/**
 * Sidebar Category Lead Article Template
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

global $sections;
$trim = $sections->section_css_classes(get_the_category()[0]);

$post_classes = array(
    'side-cat-article-lead', 'vspace'
);

?>

<article <?php post_class($post_classes); ?> id="side-cat-lead-article-<?php the_id(); ?>">
    <a class="<?php printf($trim['hover']['text']); ?>" href="<?php the_permalink(); ?>">
        <div class="thumbnail side-cat-article-lead-thumb vspace-half">
            <?php the_post_thumbnail('tc_sidebar_category', array(
                'class' => 'sidebar-category-lead-thumbnail'
            )); ?>
        </div>
        <h5 class="title side-cat-article-title side-cat-lr-padding">
            <?php the_title(); ?>
        </h5>
    </a>
</article>
