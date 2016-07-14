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

$trim = kaitain_section_css(get_the_category()[0]);

$post_classes = array(
    'article--sidebar', 'vspace--full', 'col-xs-12'
);
?>
<article <?php post_class($post_classes); ?> id="article--sidebar--<?php the_id(); ?>">
    <a class="<?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
        <div class="thumbnail img-frame col-xs-4 col-sm-4 col-md-3">
            <?php post_image_html(get_the_ID(), 'tc_post_sidebar', true); ?>
            <div class="archive-trim-bottom <?php printf($trim['bg']); ?>"></div>
        </div>
        <div class="post-content article__postcontent col-xs-8 col-sm-8 col-md-9">
            <header class="article--sidebar__header">
                <h5 class="title article--sidebar__title vspace--quarter">
                    <?php the_title(); ?>
                </h5>
                <h6 class="post-date article__postmeta">
                    <time datetime="<?php the_time('Y-m-d H:i'); ?>"><?php printf("%s ag %s", get_the_time('l, F j Y'), get_the_time('g:i a')); ?></time>
                </h6>
            </header>
        </div>
    </a>
</article>