<?php

/**
 * Archive Article
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

global $sections;
$trim = kaitain_section_css(get_the_category()[0]);

?>

<article <?php post_class('article-archive row'); ?> id="article--archive--<?php the_id(); ?>">
    <a class="article-archive-link <?php printf($trim['texthover']); ?> " rel="bookmark" href="<?php the_permalink(); ?>">
        <div class="col-md-4">
            <div class="thumbnail article-archive-thumbnail img-frame">
                <?php post_image_html(get_the_ID(), 'tc_post_archive', true); ?>
            </div>
            <div class="archive-trim-bottom <?php printf($trim['bg']); ?>"></div>
        </div>
        <div class="article-archive-content col-md-8">
            <header class="article-archive-header vspace--half">
                <h3 class="title article-archive-title text--bold vspace--quarter"><?php the_title(); ?></h3>
                <h4 class="article--lead__author">
                    <?php if (!kaitain_is_verboten_user( get_the_author_ID() )) : ?>
                        <a class="article--lead__author-link text--bold green-link--hover" href="<?php printf(get_author_posts_url($featured[0]->post_author, get_the_author_meta( 'user_nicename' ) )); ?>"><?php the_author_meta('display_name', get_the_author_ID()); ?></a>
                    <?php endif; ?>
                </h4>
                <h5 class="post-date"><time datetime="<?php the_date('Y-m-d H:i'); ?>"><?php printf("%s", get_the_time('l, F j Y')); ?></time></h5>
            </header>
            <p class="post-excerpt article-archive-excerpt"><?php printf(get_the_excerpt()); ?></p>
        </div>
    </a>
</article>
<hr>
