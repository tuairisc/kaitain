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
		'style' => 'list', 'html' => true, 'exclude' => '', 'include' => '',
				
	);
	$exclude_users = get_option('kaitain_verboten_users');

	$args = array(
        'orderby' => 'name', 'order' => 'ASC', 'number' => '',
		'exclude' => $exclude_users, 'include' => '',
    //    'meta_key' => 'columnists',
    //    'meta_compare' => 'EXISTS'
	);

	$args = wp_parse_args( $args, $defaults );

	$return = '';
	$buff = '';

	$query_args = wp_array_slice_assoc( $args, array( 'orderby', 'order', 'number', 'exclude', 'include', 
	
	//	'meta_key', 'meta_compare', 'meta_value'

	) );
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

get_footer('columnist');

?>
