<?php

/**
 * Template Name: Columnist Page
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Kaitain
 * @author     Darren Kearney <info@educatedmachine.com>
 * @copyright  Copyright (c) 2016, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/kaitain/kaitain
 * @link       http://www.tuairisc.ie
 */

get_header();

/**
 *	Search form for Columnists
 *-----------------------------------------------------------------------------
 */

// Add search form
$columnist_list = kaitain_get_columnist_list();

// If a search is done at this page then do the search on authors
if (isset($_GET['c'])) {
    $author_search_query = esc_attr($_GET['c']);
    $args = array(
            'search'         => '*'.$author_search_query.'*',
            'search_columns' => array( 'display_name', 'user_nicename' )
    );
    $author_query = new WP_User_Query( $args );

    //$total = count($author_query->results);
    $total = 0;
    foreach ( $author_query->results as $author ) {
        $author_id = $author->ID;
        if ( in_array( $author_id, $columnist_list) ) {
            $total++;
        }
    }
    $result = $total === 1 ? 'torthaí' : 'tordagh'; ?>
    <div class="searchform vspace--full" id="searchform">
        <form class="searchform__form vspace--half" id="searchform__form" method="get" action="/authors/" autocomplete="off">
            <fieldset>
                <input class="searchform__input" id="searchform__input" name="c" placeholder="<?php _e('Cuardaigh údar', 'kaitain'); ?>" type="text" value="<?php echo $author_search_query; ?>">
            </fieldset>
        </form>

        <div class="searchform__meta">
            <span class="searchform__meta--left float--left"><?php printf('%d %s', $total, $result); ?></span>
            <span class="searchform__meta--right float--right">
                <?php _e('Saghas:', 'kaitain'); ?>
                <a class="green-link searchform__order--oldest" href="<?php arc_search_url('asc'); ?>"><?php _e('sine', 'kaitain'); ?></a> |
                <a class="green-link searchform__order--newest" href="<?php arc_search_url('desc'); ?>"><?php _e('is nua', 'kaitain'); ?></a>
            </span>    
        </div>
    </div>
    <hr>
	<?php
} else if (!isset($_GET['c']) || $_GET['c'] == '') {
	?>
	<div class="searchform vspace--full" id="searchform">
        <form class="searchform__form vspace--half" id="searchform__form" method="get" action="/authors/" autocomplete="off">
            <fieldset>
                <input class="searchform__input" id="searchform__input" name="c" placeholder="<?php _e('
Cuardaigh údar', 'kaitain'); ?>" type="text" value="">
            </fieldset>
        </form>
    </div>
    <hr>  
	<?php
}

/**
 *  Display Found Columnists
 *-----------------------------------------------------------------------------
 */
if (isset($_GET['c']) || $_GET['c'] != '') {
    $trim = kaitain_section_css(get_the_category()[0]);
    $row_count = 1;
    $return = '';
    $buff = '';
    $buff .= "<div class=\"columnist-container\">";

    $authors = $author_query;

    foreach ( $author_query->results as $author ) {
        $author_id = $author->ID;
        // Only display authors who are in the columnist_list 
        if ( in_array( $author_id, $columnist_list) ) {
            $name = "<span class=\"name\">$author->first_name $author->last_name</span>";

            $avatar =   kaitain_avatar_background_html(
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

            $buff .=    "<div class=\"columnist\">";
            // Columnist name and link to author page
            $buff .=    $author_link;
            
            $author_posts_args = array(
                'author'    => $author_id,
                'order'     => 'DESC',
                'orderby'   => 'date'   
            );

            $author_posts = get_posts( $author_posts_args );

            if($author_posts) {

                $trim = kaitain_section_css(get_the_category($author_posts[0]->ID)[0]);
                $class = $trim['texthover'];
                $buff .=    "<h3 class=\"recent-post $class \"><a href=\"".get_permalink($author_posts[0]->ID)."\">".$author_posts[0]->post_title."</a></h3>";
            }
            $buff .=    "</div>";
        }
    }

    $buff .=    "</div>"; // columnist-container div
    $buff = rtrim( $buff, ', ' );
    echo $buff;


} else if (!isset($_GET['c']) || $_GET['c'] == '' ) {

    /**
     *  Normal Query for All columnists
     *-------------------------------------------------------------------------
     */

	// Make a query to db for authors
	global $wpdb;

	$defaults = array(
	    'orderby' => 'name', 'order' => 'ASC', 'number' => '',
		'optioncount' => false, 'exclude_admin' => true,
		'show_fullname' => false, 'hide_empty' => true,
		'feed' => '', 'feed_image' => '', 'feed_type' => '', 'echo' => true,
		'style' => 'list', 'html' => true, 'exclude' => '', 'include' => '',
				
	);

    // Include and exclude arguments cannot be used together in the same query
    // Use the exclude_users array of id's for custom searches.
    // when displaying results check the kaitain_columnist_list postmeta
	$exclude_users = get_option('kaitain_verboten_users');

	if (!empty($search)) {
		$args = array(
	        'orderby' => 'name', 'order' => 'ASC', 'number' => '',
			'exclude' => $exclude_users, 'include' => '',			
			'display_name' => $search
		);	
	} else {
		$args = array(
	        'orderby' => 'name', 'order' => 'ASC', 'number' => '',
			'exclude' => '', 'include' => $columnist_list,
		);	
	}

	$args = wp_parse_args( $args, $defaults );

	$query_args = wp_array_slice_assoc( $args, array( 'orderby', 'order', 'number', 'exclude', 'include', 
	//	'meta_key', 'meta_compare', 'meta_value'
	) );
	$query_args['fields'] = 'id';

	// Get authors
	$authors = get_users( $query_args );

    /**
     *  Display results
     *-------------------------------------------------------------------------
     */
	$trim = kaitain_section_css(get_the_category()[0]);
	$row_count = 1;
	$return = '';
	$buff = '';
	$buff .= "<div class=\"columnist-container\">";

	foreach ( $authors as $author_id ) {
        // Only display authors who are in the columnist_list 
        if ( in_array( $author_id, $columnist_list) ):
            $author = get_userdata( $author_id );
            $name = "<span class=\"name\">$author->first_name $author->last_name</span>";

            $avatar =   kaitain_avatar_background_html(
                            $author->ID,
                            'medium', 
                            'columnist-avatar',
                            false
                        );

            $author_link = sprintf(
                '<a href="%1$s" title="%2$s" rel="author">%3$s %4$s</a>',
                esc_url( get_author_posts_url( $author_id, $author->user_nicename ) ),
                esc_attr( sprintf( __( 'Articles by %s' ), $name ) ),
                $avatar,
                $name
            );

            $buff .=    "<div class=\"columnist\">";
            // Columnist name and link to author page
            $buff .=    $author_link;
            
            $author_posts_args = array(
                'author'    => $author_id,
                'order'     => 'DESC',
                'orderby'   => 'date'   
            );

            $author_posts = get_posts( $author_posts_args );

            if( $author_posts ) {

                $trim = kaitain_section_css(get_the_category($author_posts[0]->ID)[0]);
                $class = $trim['texthover'];
                $buff .=    "<h3 class=\"recent-post $class \"><a href=\"".get_permalink($author_posts[0]->ID)."\">".$author_posts[0]->post_title."</a></h3>";
            }
            $buff .=    "</div>";
        endif;
	}

	$buff .= 	"</div>"; // columnist-container div
	$buff = rtrim( $buff, ', ' );
	echo $buff;

} else {
	_e('No authors found', 'kaitain');
}

get_footer('columnist');
?>
