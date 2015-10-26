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

$trim = kaitain_section_css(get_the_category()[0]);

$post_classes = array(
    'article--small', 'vspace--half'
);

?>

<article <?php post_class($post_classes); ?> id="article--small--<?php the_id(); ?>">
    <a class="article--small__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
        <div class="thumbnail article--small__thumb vspace--half">
            <?php post_image_html(get_the_ID(), 'tc_home_feature_small', true); ?>
            <div class="archive-trim-bottom <?php printf($trim['bg']); ?>"></div>
        </div>
        <h5 class="title article--small__title"><?php the_title(); ?></h5>
    </a>
</article>
