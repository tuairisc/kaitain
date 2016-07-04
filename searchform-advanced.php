<?php

/**
 * Search Form
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

global $wp_query;

$query = get_search_query();
$action = esc_url(home_url('/'));


if ( !isset($_GET['as-p']) ){
    $total = $wp_query->found_posts;
}

// make custom GET request for advanced actions
$authorsearch = home_url('/authors/');
// $authorsearch = $authorsearch.'?c=';
$advanced_action = esc_url(home_url('/'));

$result = $total === 1 ? 'torthaí' : 'tordagh';

if (isset($_GET['as-p'])){
    
    // search for authors (exclude forbidden users)
    $author_search = esc_attr($_GET['as-p']);
    $exclude = get_option('kaitain_verboten_users');
    if (!is_array($exclude)){
        $exclude = array();
    } 

    $args = array(
            'search'         => '*'.$author_search.'*',
            'search_columns' => array( 'display_name', 'user_nicename' ),
            'exclude'        => $exclude
    );
    $author_query = new WP_User_Query( $args );

    // add found author-ids into array
    $found_authors = array();
    foreach ($author_query->results as $author) {
        array_push($found_authors, $author->ID);
    }
    // advanced search all posts by specific authors
    $as_authors_posts_query = new WP_Query( array( 'author__in' => $found_authors ) );

    $total = $as_authors_posts_query->found_posts;
}

?>

<div class="searchform vspace--full" id="searchform">
    <form class="searchform__form vspace--half" id="searchform__form" method="get" action="<?php printf($action); ?>" autocomplete="off">
        <fieldset>
            <input class="searchform__input" id="searchform__input" name="s" placeholder="<?php _e('curdaigh', 'kaitain'); ?>" type="text" required="required" value="<?php printf($query); ?>">
        </fieldset>
    </form>
    <div class="searchform__meta">
        <span class="searchform__meta--left float--left"><?php printf('%d %s', $total, $result); ?></span>
        <span class="searchform__meta--right float--right">
            <?php _e('Saghas:', 'kaitain'); ?>
            <a class="green-link searchform__order--oldest" href="<?php arc_search_url('asc'); ?>"><?php _e('sine', 'kaitain'); ?></a> |
            <a class="green-link searchform__order--newest" href="<?php arc_search_url('desc'); ?>"><?php _e('is nua', 'kaitain'); ?></a><br>
            <span class="advanced-search float--right">
                <button class="btn" href="#" data-bind="click: showSearchOptions"><?php _e('Cuardach níos mó', 'kaitain'); ?></button>
            </span>
        </span>
    </div>
    <div class="advanced-search-options" data-bind="css: { 'show-search-option': state.searchOptions() }">
        <form id="as-authors" name="as-authors" method="get" action="<?php printf($authorsearch); ?>">
            <ul>
                <li class="advanced-search-option">
                    <label for="search-authors"><?php _e('Cuardach ar colúnaí', 'kaitain'); ?></label><br>
                    <input id="search-authors" type="text" name="c" value="" placeholder="Iontráil ainm an colúnaí" maxlength="144" />
                    <button class="btn navrow__button navrow__button--search" type="submit" name="advanced-search" id="advanced-search-submit" value="authors"><span class="navrow__icon search" title="Curdaigh"></span></button>
                </li>
            </ul>
        </form>
        <form id="as-authorsposts" name="as-authorposts" method="get" action="<?php echo $action; ?>">
            <ul>
                <li class="advanced-search-option">
                    <label for="search-posts-by-authors"><?php _e('Earraí chuardaigh ag colúnaithe mheaitseáil', 'kaitain'); ?></label><br>
                    <input id="search-posts-by-authors" type="text" name="as-p" value="" placeholder="Iontráil ainm an colúnaí" maxlength="144" />
                    <button class="btn navrow__button navrow__button--search" type="submit" name="s" id="" value=""><span class="navrow__icon search" title="Curdaigh"></span></button>
                </li>
            </ul>
        </form>
    </div>
</div>
<hr>
<?php
if (isset($_GET['as-p'])){
    
    if ( $as_authors_posts_query->have_posts() ) {
        while ($as_authors_posts_query->have_posts() ) {
           $as_authors_posts_query->the_post();
           kaitain_partial('article', 'archive');
        }
    } else {
       kaitain_partial('article', 'missing');
    }

    if ($as_authors_posts_query->found_posts) {
        kaitain_partial('pagination', 'site');
    }
}