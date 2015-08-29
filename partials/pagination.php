<?php

/**
 * Site Pagination Link
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 */

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$next = $paged + 1; 
$previous = $paged - 1;

?>

<nav id="pagination">
    <div class="previous">
        <h3>
            <?php if (is_single()) {
                next_post_link('%link', '&larr; %title', false);
            } else {
                previous_posts_link(__('&larr; Siar', 'tuairisc'));
            } ?>
        </h3>
    </div>
    <div class="count">
        <?php if (query_has_pages() && (!is_single() && !is_home() || is_home() && $paged > 1)) : ?>
            <h3><span><?php archive_page_count(true); ?></span></h3>
        <?php endif; ?>
    </div>
    <div class="next">
        <h3>
            <?php if (is_single()) {
                previous_post_link('%link', '%title &rarr;', false);
            } else {
                next_posts_link(__('Lean ar Aghaidh &rarr;', 'tuairisc')); 
            } ?>
        </h3>
    </div>
</nav>
