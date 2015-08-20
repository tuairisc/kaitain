<?php

/**
 * Archive Article
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 */

global $sections;

$trim = $sections->get_section_slug(get_the_category()[0]);

$trim = array(
    'text' => sprintf('section-%s-text-hover', $trim),
    'background' => sprintf('section-%s-background', $trim)
);

?>

<article <?php post_class('archive'); ?> id="archive-<?php the_id(); ?>">
    <a class="<?php printf($trim['text']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
        <div class="thumbnail">
            <?php post_image_html(get_the_ID(), 'tc_post_archive', true); ?>
            <div class="archive-trim-bottom <?php printf($trim['background']); ?>"></div>
        </div>
        <div class="post-content">
            <header>
                <h3 class="archive-title"><?php the_title(); ?></h3>
                <p><span class="post-date"><time datetime="<?php the_date('Y-m-d H:i'); ?>"><?php the_post_date_strftime(); ?></time></span></p>
            </header>
            <p class="post-excerpt"><small><?php printf(get_the_excerpt()); ?></small></p>
        </div>
    </a>
</article>
<hr>
