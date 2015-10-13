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
    'article--sidebar article--sidebar--lead', 'vspace--full',
);

$link_classes = array(
    $trim['hover']['text'],
    'article--sidebar__link'
);

?>

<article <?php post_class($post_classes); ?> id="article--sidebar--lead-<?php the_id(); ?>">
    <a class="<?php printf(implode(' ', $link_classes)); ?>" href="<?php the_permalink(); ?>">
        <div class="article--sidebar__thumbnail thumbnail vspace--half">
            <?php the_post_thumbnail('tc_sidebar_category', array(
                'class' => 'sidebar__thumbnail'
            )); ?>
        </div>
        <h5 class="title article--sidebar__title article--sidebar__padding">
            <?php the_title(); ?>
        </h5>
    </a>
</article>
