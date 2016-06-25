<?php

/**
 * Search Form for Columnist Page
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Kaitain
 * @author     Darren Kearney <info@educatedmachine.com>
 * @copyright  Copyright (c) 2016, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/kaitain-theme
 * @link       http://www.tuairisc.ie
 */

/*
    This file is used by columnist-page.php for the search form.
    The query object set here is used there. Be careful!
*/

// If a search is done at this page then do the search on authors
if (isset($_GET['c'])) {
    $author_search_query = esc_attr($_GET['c']);
    $args = array(
            'search'         => $author_search_query,
            'search_columns' => array( 'display_name', 'user_nicename' )
    );
    $author_query = new WP_User_Query( $args );
    $total = count($author_query->results);
    $result = $total === 1 ? 'torthaí' : 'tordagh';
}
?>
    <div class="searchform vspace--full" id="searchform">
        <form class="searchform__form vspace--half" id="searchform__form" method="get" action="/authors/" autocomplete="off">
            <fieldset>
                <input class="searchform__input" id="searchform__input" name="c" placeholder="<?php _e('curdaigh', 'kaitain'); ?>" type="text" value="<?php echo $author_search_query; ?>">
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
    <ul>
        <?php
        if ( ! empty( $author_query->results ) ) {
            foreach ( $author_query->results as $author ) {
                echo '<li>' . $author->display_name . '</li>';
            }
        } else {
            _e('No authors found', 'kaitain');
        }
        ?>
    </ul>
<?php


echo "<pre>";
var_dump($author_query);
echo "</pre>";
// function kaitain_columnist_search() {
//     if (isset($_GET['c'])) {
//         $author_search_query = esc_attr($_GET['c']);
//         $exclude_users = get_option('kaitain_verboten_users');

//         $args = array(
//                 'search'         => $author_search_query,
//                 'search_columns' => array( 'display_name', 'user_nicename' ),
//                 //'exclude' => $exclude_users,
//                 //'include' => ''

//         );
//         $author_query = new WP_User_Query( $args );
//         return $author_query;
//     } else {
//         return false;
//     }
// }

///////////////////////////////////////////////////////////////////////////////
//  Display Columnists
///////////////////////////////////////////////////////////////////////////////
if (isset($_GET['c']) || $_GET['c'] != '') {
    $trim = kaitain_section_css(get_the_category()[0]);
    $row_count = 1;
    $return = '';
    $buff = '';
    $buff .= "<div class=\"columnist-container\">";


    $authors = $author_query;
    foreach ( $author_query->results as $author ) {
        $author_id = $author->ID;
        //$author = get_userdata( $author_id );
    //  $link = "<a href=\"$author->\"></a>";
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
        // Avatar
        
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
            //print_r($authors_posts);
            // print top post title
            //$buff .= "<a href=\"".get_permalink($author_posts[0]->ID)."\">".$author_posts[0]->post_title."</a>";
            $buff .=    "<h3 class=\"recent-post $class \"><a href=\"".get_permalink($author_posts[0]->ID)."\">".$author_posts[0]->post_title."</a></h3>";
        }
        //$buff .=  "<h3 class=\"recent-post\"><a href=\"#\">Title of recent post by this author here that links to that post</a></h3>";
        $buff .=    "</div>";
        

        //the_author_posts_link();

        /*
        if ($row_count % 6 === 0 && $row_count !== 0){
            $buff .= "</div>";
            $buff .= "<div class=\"columnist-row\">";
        }

        $row_count++;
        */
    }

    $buff .=    "</div>"; // columnist-container div
    $buff = rtrim( $buff, ', ' );
    echo $buff;

    $author_count = array();
    foreach ( (array) $wpdb->get_results( "SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE " .get_private_posts_cap_sql( 'post' ) . " GROUP BY post_author" ) as $row ) {
        $author_count[$row->post_author] = $row->count;
    }
}