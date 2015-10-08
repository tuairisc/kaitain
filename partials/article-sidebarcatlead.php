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

$trim = $sections->get_section_slug(get_the_category()[0]);

$trim = array(
    'text' => sprintf('section-%s-text-hover', $trim),
    'background' => sprintf('section-%s-background', $trim)
);

?>

<article <?php post_class('side-cat-article-lead'); ?> id="side-cat-lead-article-<?php the_id(); ?>">
    <a class="<?php printf($trim['text']); ?>" href="<?php the_permalink(); ?>">
        <div class="thumbnail side-cat-article-lead-thumb">
            <?php the_post_thumbnail('tc_sidebar_category', array(
                'class' => 'sidebar-category-lead-thumbnail'
            )); ?>
        </div>
        <h5 class="title side-cat-article-title">
            <?php the_title(); ?>
        </h5>
    </a>
</article>
