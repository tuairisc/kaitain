<?php

/**
 * Site Pagination Link
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/sheepie
 *
 * This file is part of Tuairisc.ie.
 * 
 * Tuairisc.ie is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Tuairisc.ie is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Tuairisc.ie. If not, see <http://www.gnu.org/licenses/>.
 */

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$next = $paged + 1; 
$previous = $paged - 1;

?>

<hr>
<hr>

<nav id="pagination">
    <p class="previous<?php echo (is_single()) ? '-post' : ''; ?>">
        <small>
            <?php if (is_single()) {
                next_post_link('%link', '&larr; %title', false);
            } else {
                previous_posts_link('&larr; Page ' . $previous);
            } ?>
        </small>
    </p>

    <p class="count">
        <small>
            <?php if (!is_single()) : ?>
                <span><?php archive_page_count(true); ?></span>
            <?php endif; ?>
        </small>
    </p>

    <p class="next<?php echo (is_single()) ? '-post' : ''; ?>">
        <small>
            <?php if (is_single()) {
                previous_post_link('%link', '%title &rarr;', false);
            } else {
                next_posts_link('Page ' . $next . ' &rarr;'); 
            } ?>
        </small>
    </p>
</nav>
