<?php

/**
 * Search Results
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

global $wp_query;
get_header();
get_search_form();

// code for advanced search options
// option: find all posts for searched author name
// if (!isset($_GET['as-p'])){

if (have_posts()) {
    while (have_posts()) {
        the_post();
       kaitain_partial('article', 'archive');
    }
} else {
   kaitain_partial('article', 'missing');
}

if ($wp_query->found_posts) {
    kaitain_partial('pagination', 'site');
}

// }

get_footer();

?>
