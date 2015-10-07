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

?>

<article <?php post_class('sidebar-article'); ?> id="sidebar-<?php the_id(); ?>">
    <a class="sidebar-link green-link-hover" rel="bookmark" href="<?php the_permalink(); ?>">
        <div class="thumbnail sidebar-thumbnail">
            <?php post_image_html(get_the_ID(), 'tc_post_sidebar', true); ?>
        </div>
        <div class="post-content sidebar-content">
            <header class="sidebar-header">
                <h5 class="title sidebar-article-title"><?php the_title(); ?></h5>
            </header>
        </div>
    </a>
</article>
