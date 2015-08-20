<?php

/**
 * Search Results
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

global $wp_query;
get_header();

get_search_form();
echo $wp_query->found_posts;

if (have_posts()) {
    while (have_posts()) {
        the_post();
        get_template_part(PARTIAL_ARTICLES, 'archive');
    }
}

if ($wp_query->found_posts) {
    get_template_part(THEME_PARTIALS . '/pagination');
}

get_footer();
?>
