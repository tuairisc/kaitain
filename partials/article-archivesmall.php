<?php

/**
 * Featured Small Article
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

$section_slug = $sections->get_section_slug(get_the_category()[0]);
$section_hover = sprintf('section-%s-text-hover', $section_slug);
$section_background = sprintf('section-%s-background', $section_slug);

?>

<article <?php post_class('archive-small'); ?> id="archive-small-<?php the_id(); ?>">
    <a class="article-small-link <?php printf($section_hover); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
        <div class="thumbnail">
            <?php post_image_html(get_the_ID(), 'tc_home_feature_small', true); ?>
            <div class="archive-trim-bottom <?php printf($section_background); ?>"></div>
        </div>
        <header>
            <h5 class="title archive-small-title"><?php the_title(); ?></h5>
        </header>
    </a>
</article>
