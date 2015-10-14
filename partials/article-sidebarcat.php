<?php

/**
 * Sidebar Category Article Template
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

$post_classes = array(
    'article--sidebar article--sidebar--lead', 'article--sidebar__padding', 'vspace--full'
);

?>

<article <?php post_class($post_classes); ?> id="article--sidebar--<?php the_id(); ?>">
    <h5 class="title article--sidebar__title">
        <a class="<?php printf($trim['hover']['text']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </h5>
</article>
