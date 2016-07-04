<?php

/**
 * Archive Article
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Kaitain
 * @author     Darren Kearney <info@educatedmachine.com>
 * @copyright  Copyright (c) 2016, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/kaitain/kaitain
 * @link       http://www.tuairisc.ie
 */

global $sections;
$trim = kaitain_section_css(get_the_category()[0]);

?>

<article <?php post_class('article-archivelead row'); ?> id="article--archive--<?php the_id(); ?>">
    <a class="article-archivelead-link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
        <div class="article-archivelead-content col-md-4">
            <header class="article-archivelead-header vspace--half">
                <h3 class="title article-archivelead-title text--bold vspace--quarter"><?php the_title(); ?></h3>
                <h4 class="article--lead__author">
                    <?php if (!kaitain_is_verboten_user( get_the_author_ID() )) : ?>
                        <a class="article--lead__author-link text--bold green-link--hover" href="<?php printf(get_author_posts_url($featured[0]->post_author)); ?>"><?php the_author_meta('display_name', get_the_author_ID()); ?></a>
                    <?php endif; ?>
                </h4>
                <h5 class="post-date"><time datetime="<?php the_date('Y-m-d H:i'); ?>"><?php the_post_date_strftime(); ?></time></h5>
            </header>
            <p class="post-excerpt article-archivelead-excerpt"><?php printf(get_the_excerpt()); ?></p>
        </div>
        <div class="col-md-8">
            <div class="thumbnail article-archivelead-thumbnail img-frame">
                <?php post_image_html(get_the_ID(), 'tc_post_archive', true); ?>
                <div class="archive-trim-bottom <?php printf($trim['bg']); ?>"></div>
            </div>
        </div>
    </a>
</article>
<hr>