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

<article <?php post_class('sidebar-lead-article'); ?> id="sidebar-<?php the_id(); ?>">
<h5 class="title sidebar-category-subtitle <?php printf($trim['text']); ?>">
        <a href="<?php the_permalink(); ?>">
            <div class="thumbnail sidebar-lead-thumbnail">
                <?php the_post_thumbnail('tc_sidebar_category', array(
                    'class' => 'sidebar-category-thumbnail'
                )); ?>
            </div>
            <?php the_title(); ?>
        </a>
    </h5>
</article>
