<?php

/**
 * Front Page Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 */

$page_number = intval(get_query_var('paged'));
get_header();

/* 1. Big Lead Article.
 * 2. Second and third rows of articles.
 * 3. List of columnists.
 * 4. Category widgets.
 * Nuacht, Tuairmiocht, Sport, Cultur 
 * 5. Side-by-side category widgets for Saol, Greann, Pobal */

if (!$page_number) {
    if (is_active_sidebar('widgets-front-page')) {
        dynamic_sidebar('widgets-front-page');
    } else {
        printf('<h3>%s</h3>', __('Add your main front page widgets!', 'tuairisc'));
    }
} else {
    while (have_posts()) {
        the_post();
        partial('article', 'archive');
    }
}

partial('pagination');
get_footer();
?>
