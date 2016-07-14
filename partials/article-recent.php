<?php

/**
 * Recent Article Template
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
    'article-recent', 'vspace--full'
);

?>

<article <?php post_class($post_classes); ?> id="article-recent-<?php the_id(); ?>">
    <a class="<?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
        <div class="archive-trim-top <?php printf($trim['bg']); ?>"></div>
        <div class="thumbnail article-recent-thumbnail img-frame col-sm-12 col-xs-4">
            <?php post_image_html(get_the_ID(), 'tc_post_sidebar', true); ?>
        </div>
        <div class="post-content article__postcontent col-sm-12 col-xs-8 <?php printf($trim['bg']); ?>">
            <header class="article-recent-header">
                <h5 class="title article-recent-title vspace--quarter">
                    <?php echo kaitain_excerpt( get_the_title(), 15 ); ?>
                </h5>
                <h6 class="post-date article__postmeta">
                    <time datetime="<?php the_time('Y-m-d H:i'); ?>"><?php printf("%s ag %s", get_the_time('l, F j Y'), get_the_time('g:i a')); ?></time>
                </h6>
            </header>
        </div>
    </a>
</article>
