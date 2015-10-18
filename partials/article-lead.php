<?php

/**
 * Archive Lead Article
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
$author = get_the_author_meta('ID');
$trim = $sections->section_css_classes(get_the_category()[0]);

?>

<article <?php post_class('article--lead'); ?> id="article--lead--<?php the_id(); ?>">
    <a class="article--lead__link <?php printf($trim['hover']['text']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
        <div class="thumbnail article--lead__thumb">
            <?php post_image_html(get_the_ID(), 'tc_home_feature_lead', true); ?>
            <div class="archive-trim-bottom <?php printf($trim['reg']['background']); ?>"></div>
        </div>
        <h1 class="title article--lead__title"><?php the_title(); ?></h1>
    </a>
    <header class="article--lead__header vspace--half">
        <h4 class="article--lead__author">
            <?php if (!kaitain_is_verboten_user($author)) : ?>
                <a class="article--lead__author-link text--bold green-link--hover" href="<?php printf(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a>
                <?php endif; ?>
        </h4>
        <h5 class="post-meta article--lead__meta"><time datetime="<?php echo the_date('Y-m-d H:i'); ?>"><?php the_post_date_strftime(); ?></time></h5>
    </header>
    <p class="post-excerpt article--lead__excerpt"><?php printf(get_the_excerpt()); ?></p>
</article>
<hr>
