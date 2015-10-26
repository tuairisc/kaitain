<?php

/**
 * Archive Article
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
$trim = kaitain_section_css(get_the_category()[0]);

?>

<article <?php post_class('article--archive'); ?> id="article--archive--<?php the_id(); ?>">
    <a class="article--archive__link flex--two-col--div <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
        <div class="thumbnail article--archive__thumbnail">
            <?php post_image_html(get_the_ID(), 'tc_post_archive', true); ?>
            <div class="archive-trim-bottom <?php printf($trim['bg']); ?>"></div>
        </div>
        <div class="article--archive__content">
            <header class="article--archive__header vspace--half">
                <h3 class="title article--artchive__title text--bold vspace--quarter"><?php the_title(); ?></h3>
                <h5 class="post-date"><time datetime="<?php the_date('Y-m-d H:i'); ?>"><?php the_post_date_strftime(); ?></time></h5>
            </header>
            <p class="post-excerpt article--archive__excerpt"><?php printf(get_the_excerpt()); ?></p>
        </div>
    </a>
</article>
<hr>
