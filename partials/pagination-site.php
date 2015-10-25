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

t?>

<nav class="pagination pagination--site" id="pagination--site">
    <p class="pagination__previous pagination__previous-page text--small">
        <?php previous_posts_link(__('&larr; Siar', 'kaitain')); ?>
    </p>
    <?php if (function_exists('arc_query_has_pages') && arc_query_has_pages()) : ?>
        <p class="pagination__count text--small">
            <span><?php arc_archive_page_count(true, 'Leathnach %s de %s'); ?></span>
        </p>
    <?php endif; ?>
    <p class="pagination__next pagination__next-page text--small">
        <?php next_posts_link(__('Lean ar Aghaidh &rarr;', 'kaitain'));  ?>
    </p>
</nav>
