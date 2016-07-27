<?php

/**
 * Template Name: Foluntais Archive
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Kaitain
 * @author     Darren Kearney <info@educatedmachine.com>
 * @copyright  Copyright (c) 2016, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/tuairisc/kaitain
 * @link       http://www.tuairisc.ie
 */

get_header();


$args = array(
	'post_type' => 'foluntais', // enter your custom post type
	'orderby' => 'date',
	'order' => 'DESC',
	'posts_per_page'=> '12',  // overrides posts per page in theme settings
);
$query = new WP_Query( $args );

if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
        $query->the_post();
    	kaitain_partial('archive', 'foluntais');
    }
}

kaitain_partial('pagination', 'site');
get_footer();

?>
