<?php

/**
 * popular Article Template
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
    'article-popular', 'vspace--full', 'col-md-12', 'col-sm-12', 'col-xs-12'
);

$limit = 7; // words in title excerpt
?>

<article <?php post_class($post_classes); ?> id="article-popular-<?php the_id(); ?>">
    <a class="<?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
        <div class="thumbnail article-popular-thumbnail img-frame col-md-3 col-sm-4 col-xs-4">
            <?php post_image_html(get_the_ID(), 'tc_post_sidebar', true); ?>
            <!-- <div class="archive-trim-bottom <?php printf($trim['bg']); ?>"></div> -->
        </div>
        <div class="post-content article__postcontent col-md-9 col-sm-8 col-xs-8">
            <header class="article-popular-header <?php //printf($trim['bg']); ?>">
                <h5 class="title article-popular-title vspace--quarter">
                    <?php echo kaitain_excerpt(get_the_title(), $limit); ?>
                </h5>
                <h6 class="post-date article__postmeta">
                    <time datetime="<?php the_time('Y-m-d H:i'); ?>"><?php the_post_date_strftime(); ?></time>
                </h6>
            </header>
        </div>
    </a>
</article>
