<?php

/**
 * Template Name: Columnist Page
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


// Make a query to db for authors
	global $wpdb;


	$defaults = array(
        'orderby' => 'name', 'order' => 'ASC', 'number' => '',
		'optioncount' => false, 'exclude_admin' => true,
		'show_fullname' => false, 'hide_empty' => true,
		'feed' => '', 'feed_image' => '', 'feed_type' => '', 'echo' => true,
		'style' => 'list', 'html' => true, 'exclude' => '', 'include' => ''
	);
	$exclude_users = get_option('kaitain_verboten_users');

	$args = array(
        'orderby' => 'name', 'order' => 'ASC', 'number' => '',
		'exclude' => $exclude_users, 'include' => ''
	);

	$args = wp_parse_args( $args, $defaults );

	$return = '';
	$buff = '';

	$query_args = wp_array_slice_assoc( $args, array( 'orderby', 'order', 'number', 'exclude', 'include' ) );
	$query_args['fields'] = 'id';
	$authors = get_users( $query_args );

	// Trim colors based on sections
	$trim = kaitain_section_css(get_the_category()[0]);


	$row_count = 1;

	$buff .= "<div class=\"columnist-container\">";
	//$buff .= "<div class=\"columnist-row\">";
	// 

	foreach ( $authors as $author_id ) {



		$author = get_userdata( $author_id );
//			$link = "<a href=\"$author->\"></a>";
		$name = "<span class=\"name\">$author->first_name $author->last_name</span>";

		$avatar = 	kaitain_avatar_background_html(
						$author->ID,
						'medium', 
						'columnist-avatar',
						false
					);

		$author_link = sprintf(
	        '<a href="%1$s" title="%2$s" rel="author">%3$s %4$s</a>',
	        esc_url( get_author_posts_url( $author_id, $author->nicename ) ),
	        esc_attr( sprintf( __( 'Articles by %s' ), $name ) ),
	        $avatar,
	        $name
    	);

		
		$buff .= 	"<div class=\"columnist\">";
		// Avatar
		
		// Columnist name and link to author page
		$buff .= 	$author_link;
		

		$author_posts_args = array(
			'author'	=> $author_id,
			'order'		=> 'DESC',
			'orderby'	=> 'date'	
		);

		$author_posts = get_posts( $author_posts_args );

		if($author_posts) {

			$trim = kaitain_section_css(get_the_category($author_posts[0]->ID)[0]);
			$class = $trim['texthover'];
			//print_r($authors_posts);
			// print top post title
			//$buff .= "<a href=\"".get_permalink($author_posts[0]->ID)."\">".$author_posts[0]->post_title."</a>";
			$buff .=	"<h3 class=\"recent-post $class \"><a href=\"".get_permalink($author_posts[0]->ID)."\">".$author_posts[0]->post_title."</a></h3>";
		}
		//$buff .=	"<h3 class=\"recent-post\"><a href=\"#\">Title of recent post by this author here that links to that post</a></h3>";
		$buff .= 	"</div>";
		

		//the_author_posts_link();

/*
		if ($row_count % 6 === 0 && $row_count !== 0){
			$buff .= "</div>";
			$buff .= "<div class=\"columnist-row\">";
		}

		$row_count++;
*/
	}

	$buff .= 	"</div>"; // columnist-container div
	$buff = rtrim( $buff, ', ' );
	echo $buff;



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


	// foreach ( $authors as $author_id ) {
	// 	//kaitain_partial('article', 'columnist');

	// 		$author = get_userdata( $author_id );

	// 		kaitain_avatar_background_html(
	// 			$author->ID,
	// 			'medium', 
	// 			'columnist-avatar'
	// 		);

	// 		if ( $args['exclude_admin'] && 'admin' == $author->display_name ) {
	// 		    continue;
	// 		}

	// 		$posts = isset( $author_count[$author->ID] ) ? $author_count[$author->ID] : 0;

	// 		if ( ! $posts && $args['hide_empty'] ) {
	// 		    continue;
	// 		}

	// 		if ( $args['show_fullname'] && $author->first_name && $author->last_name ) {
	// 		    $name = "$author->first_name $author->last_name";
	// 		} else {
	// 		    $name = $author->display_name;
	// 		}

	// 		if ( ! $args['html'] ) {
	// 		    $return .= $name . ', ';

	// 		    continue; // No need to go further to process HTML.
	// 		}

	// 		if ( 'list' == $args['style'] ) {
	// 		    $return .= '<li>';
	// 		}

	// 		$link = '<a href="' . get_author_posts_url( $author->ID, $author->user_nicename ) . '" title="' . esc_attr( sprintf(__("Posts by %s"), $author->display_name) ) . '">' . $name . '</a>';


	// 		if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
	// 		    $link .= ' ';
	// 		    if ( empty( $args['feed_image'] ) ) {
	// 		        $link .= '(';
	// 		    }

	// 		    $link .= '<a href="' . get_author_feed_link( $author->ID, $args['feed_type'] ) . '"';

	// 		    $alt = '';
	// 		    if ( ! empty( $args['feed'] ) ) {
	// 		         $alt = ' alt="' . esc_attr( $args['feed'] ) . '"';
	// 		         $name = $args['feed'];
	// 		    }

	// 		    $link .= '>';

	// 		    if ( ! empty( $args['feed_image'] ) ) {
	// 		         $link .= '<img src="' . esc_url( $args['feed_image'] ) . '" style="border: none;"' . $alt . ' />';
	// 		    } else {
	// 		         $link .= $name;
	// 		    }

	// 		    $link .= '</a>';

	// 		    if ( empty( $args['feed_image'] ) ) {
	// 		         $link .= ')';
	// 		    }
	// 		}

	// 		if ( $args['optioncount'] ) {
	// 		    $link .= ' ('. $posts . ')';
	// 		}

	// 		$return .= $link;
	// 		$return .= ( 'list' == $args['style'] ) ? '</li>' : ', ';
	// }
	// $return = rtrim( $return, ', ' );

	// if ( ! $args['echo'] ) {
	//      return $return;
	// }
	// echo $return;





// for each author in authors list use the article-columnist template
// if (have_posts()) {
//     while (have_posts()) {
//     	the_post();
//     	kaitain_partial('article', 'columnist');
//     }
// }

//partial('pagination', 'site');
get_footer('columnist');

?>
