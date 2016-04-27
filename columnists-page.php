<?php

/**
 * Columnist Page
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



wp_list_authors('show_fullname=1&optioncount=1&orderby=post_count&order=DESC&number=3'); 



// Make a query to db for authors
	global $wpdb;

	$defaults = array(
        'orderby' => 'name', 'order' => 'ASC', 'number' => '',
		'optioncount' => false, 'exclude_admin' => true,
		'show_fullname' => false, 'hide_empty' => true,
		'feed' => '', 'feed_image' => '', 'feed_type' => '', 'echo' => true,
		'style' => 'list', 'html' => true, 'exclude' => '', 'include' => ''
	);

	$args = wp_parse_args( $args, $defaults );

	$return = '';

	$query_args = wp_array_slice_assoc( $args, array( 'orderby', 'order', 'number', 'exclude', 'include' ) );
	$query_args['fields'] = 'id';
	$authors = get_users( $query_args );

	$author_count = array();
	foreach ( (array) $wpdb->get_results( "SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE " .get_private_posts_cap_sql( 'post' ) . " GROUP BY post_author" ) as $row ) {
		$author_count[$row->post_author] = $row->count;
	}

	// echo "";
	// echo "#####    Author Count:    #####     ";
	// echo "";
	// print_r($author_count);


	// echo "";
	// echo "    -=-=-=-=-  Authors  -=-=-=-=-    ";
	// echo "";
	// print_r($authors);



	// get_users() test

	// $user_args = array(
	// 	'fields' => array('id','display_name'),
	// );
	
	// $blogusers = get_users( $user_args );
	// foreach ( $blogusers as $user ) {
	// 	echo '<span>' . esc_html( $user->display_name ) . '</span> ';
	// }

	echo "";
	echo "4:   ";
	$author_obj = get_user_by('id', '4');
	print_r($author_obj->user_email . '  ' . $author_obj->user_login);

	echo "";
	echo "37:   ";
	$author_obj = get_user_by('id', '37');
	print_r($author_obj->user_nicename . '  ' . $author_obj->user_login);

	echo "";
	echo "";

	foreach ( $authors as $author_id ) {
		//kaitain_partial('article', 'columnist');

			$author = get_userdata( $author_id );

			kaitain_avatar_background_html(
				$author->ID,
				'medium', 
				'columnist-avatar'
			);

			if ( $args['exclude_admin'] && 'admin' == $author->display_name ) {
			    continue;
			}

			$posts = isset( $author_count[$author->ID] ) ? $author_count[$author->ID] : 0;

			if ( ! $posts && $args['hide_empty'] ) {
			    continue;
			}

			if ( $args['show_fullname'] && $author->first_name && $author->last_name ) {
			    $name = "$author->first_name $author->last_name";
			} else {
			    $name = $author->display_name;
			}

			if ( ! $args['html'] ) {
			    $return .= $name . ', ';

			    continue; // No need to go further to process HTML.
			}

			if ( 'list' == $args['style'] ) {
			    $return .= '<li>';
			}

			$link = '<a href="' . get_author_posts_url( $author->ID, $author->user_nicename ) . '" title="' . esc_attr( sprintf(__("Posts by %s"), $author->display_name) ) . '">' . $name . '</a>';


			if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
			    $link .= ' ';
			    if ( empty( $args['feed_image'] ) ) {
			        $link .= '(';
			    }

			    $link .= '<a href="' . get_author_feed_link( $author->ID, $args['feed_type'] ) . '"';

			    $alt = '';
			    if ( ! empty( $args['feed'] ) ) {
			         $alt = ' alt="' . esc_attr( $args['feed'] ) . '"';
			         $name = $args['feed'];
			    }

			    $link .= '>';

			    if ( ! empty( $args['feed_image'] ) ) {
			         $link .= '<img src="' . esc_url( $args['feed_image'] ) . '" style="border: none;"' . $alt . ' />';
			    } else {
			         $link .= $name;
			    }

			    $link .= '</a>';

			    if ( empty( $args['feed_image'] ) ) {
			         $link .= ')';
			    }
			}

			if ( $args['optioncount'] ) {
			    $link .= ' ('. $posts . ')';
			}

			$return .= $link;
			$return .= ( 'list' == $args['style'] ) ? '</li>' : ', ';
	}
	$return = rtrim( $return, ', ' );

	if ( ! $args['echo'] ) {
	     return $return;
	}
	echo $return;





// for each author in authors list use the article-columnist template
// if (have_posts()) {
//     while (have_posts()) {
//     	the_post();
//     	kaitain_partial('article', 'columnist');
//     }
// }

//partial('pagination', 'site');
get_footer();

?>
