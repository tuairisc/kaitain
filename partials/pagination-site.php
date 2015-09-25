<?php

/**
 * Site Pagination Link
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Kaitain
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/kaitain-theme
 */

$pages = (get_query_var('pages')) ? get_query_var('pages') : 1;
$next = $pages + 1; 
$previous = $pages - 1; 

?>

<nav class="pagination" id="site-pagination">
    <p class="pagination-previous previous-page">
        <small><?php previous_posts_link(__('&larr; Siar', 'kaitain')); ?></small>
    </p>
    <?php if (function_exists('arc_query_has_pages') && arc_query_has_pages()) : ?>
        <p class="pagination-count">
            <small><span><?php arc_archive_page_count('Leathnach %s de %s', true); ?></span></small>
        </p>
    <?php endif; ?>
    <p class="pagination-next next-page">
        <small><?php next_posts_link(__('Lean ar Aghaidh &rarr;', 'kaitain'));  ?></small>
    </p>
</nav>
