<?php

/**
 * Sidebar Article Template
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

$trim = kaitain_section_css(get_the_category()[0]);

$post_classes = array(
    'widget-gallery-article', 'col-xs-12'
);
$character_limit = 120;
?>
<article <?php post_class($post_classes); ?> id="article--gallery--<?php the_id(); ?>">
    <a class="article-gallery-link <?php printf( $trim['texthover'] ); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
        <!-- <div class="section-trim <?php printf( $trim['bg'] ); ?>"></div> -->
        <div class="thumbnail article-gallery-thumb img-frame col-xs-12 col-sm-12 col-md-12 ">
            <?php post_image_html( get_the_ID(), 'tc_home_category_lead', true ); ?>
        </div>
        <div class="title-container col-xs-12 col-sm-12 col-md-12">
            <h5 class="title article--small__title"><?php printf( kaitain_excerpt( get_the_title(), $character_limit )); ?></h5>
        </div>
    </a>
</article>