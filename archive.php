<?php

/**
 * Archive Template
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

get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
    	kaitain_partial('article', 'archive');
    }
}

partial('pagination', 'site');
get_footer();

?>
