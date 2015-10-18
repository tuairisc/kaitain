<?php

/**
 * Comment Pagination Links
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Kaitain
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/kaitain-theme
 */

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$next = $paged + 1; 
$previous = $paged - 1; 

?>

<nav class="pagination pagination--comments" id="pagination--comment">
    <p class="pagination__previous pagination__previous-comment text--small">
        <?php previous_comments_link(__('&larr; Siar', 'kaitain')); ?>
    </p>
    <p class="pagination__count text--small">
        <?php get_comment_pages_count(); ?></small>
    </p>
    <p class="pagination__next pagination__next-comment text-small">
        <?php next_comments_link(__('Lean ar Aghaidh &rarr;', 'kaitain')); ?>
    </p>
</nav>
