<?php

/**
 * Sidebar Article Template
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
    'article--sidebar', 'vspace--full'
);

?>

<article <?php post_class($post_classes); ?> id="sidebar-article-<?php the_id(); ?>">
    <a class="flex--asym-quarter-auto <?php printf($trim['hover']['text']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
        <div class="thumbnail article--sidebar__thumbnail--small">
            <?php post_image_html(get_the_ID(), 'tc_post_sidebar', true); ?>
            <div class="archive-trim-bottom <?php printf($trim['reg']['background']); ?>"></div>
        </div>
        <div class="post-content article__postcontent">
            <header class="article--sidebar__header">
                <h5 class="title article--sidebar__title">
                    <?php the_title(); ?>
                </h5>
                <span class="post-date article__postmeta">
                    <time datetime="<?php the_time('Y-m-d H:i'); ?>"><?php the_post_date_strftime(); ?></time>
                </span>
            </header>
        </div>
    </a>
</article>
