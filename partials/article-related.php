<?php

/**
 * Related Article Single Post
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

?>

<article <?php post_class('related'); ?> id="related-<?php the_ID(); ?>">
    <a class="<?php printf($trim['hover']['text']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
        <div class="thumbnail">
            <?php post_image_html(get_the_ID(), 'tc_post_related', true); ?>
            <div class="archive-trim-bottom <?php printf($trim['reg']['background']); ?>"></div>
        </div>
        <header>
            <?php the_title('<h5 class="title">', '</h5>'); ?>
            <?php if (!is_page()) : ?>
                <span class="post-date"><time datetime="<?php the_date('Y-m-d H:i'); ?>"><?php the_post_date_strftime(); ?></time></span>
            <?php endif; ?>
        </header>
    </a>
</article>
