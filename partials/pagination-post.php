<?php

/**
 * Next/Previous Post Pagination Link
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Kaitain
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    3.0
 * @link       https://github.com/bhalash/kaitain-theme
 */

?>

<nav class="pagination" id="post-pagination">
    <p class="pagination-previous previous-post">
        <small><?php next_post_link('%link', '&larr; %title', false); ?></small>
    </p>
    <p class="pagination-next next-post">
        <small><?php previous_post_link('%link', '%title &rarr;', false); ?></small>
    </p>
</nav>
