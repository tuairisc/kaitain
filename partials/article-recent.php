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

// $post_classes = array(
//     'article-recent', 'vspace--full', 'col-md-3', 'col-sm-3', 'col-xs-6' 
// );

$post_classes = array(
    'article-recent', 'vspace--full'
);

?>

<article <?php post_class($post_classes); ?> id="article-recent-<?php the_id(); ?>">
    <a class="<?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
        <div class="thumbnail article-recent-thumbnail img-frame">
            <?php post_image_html(get_the_ID(), 'tc_post_sidebar', true); ?>
            <div class="archive-trim-bottom <?php printf($trim['bg']); ?>"></div>
        </div>
        <div class="post-content article__postcontent">
            <header class="article-recent-header <?php printf($trim['bg']); ?>">
                <h5 class="title article-recent-title vspace--quarter">
                    <?php the_title(); ?>
                </h5>
                <h6 class="post-date article__postmeta">
                    <time datetime="<?php the_time('Y-m-d H:i'); ?>"><?php the_post_date_strftime(); ?></time>
                </h6>
            </header>
        </div>
    </a>
</article>
