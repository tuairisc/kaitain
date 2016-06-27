<?php

/**
 * Search Form
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

$query = get_search_query();
$action = esc_url(home_url('/'));
$total = $wp_query->found_posts;

// make custom GET request for advanced actions
$authorsearch = home_url('/authors/');
$authorsearch = $authorsearch.'?c='.$query;
$advanced_action = esc_url(home_url('/'));

$result = $total === 1 ? 'torthaí' : 'tordagh';




function kaitain_search_all_posts_by_authors() {

    // kaitain_verboten_users (get_option)
    


    // Display posts from multiple authors:
    // $query = new WP_Query( array( 'author__in' => array( 2, 6 ) ) );



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
                <button href="#" data-bind="click: showSearchOptions"><?php _e('Cuardach níos mó', 'kaitain'); ?></button>
            </span>
        </span>
    </div>

     <form class="advanced-search-options" id="advanced-search-form" name="advanced_search_form" method="get" action="<?php printf($advanced_action); ?>"  data-bind="css: { 'show-search-option': state.searchOptions() }">
        <ul>
            <li class="advanced-search-option">
                <input id="search-authors" type="radio" name="advanced-search-options" value="search_authors" />
                <label for="search-authors"><?php _e('Cuardach ar colúnaí', 'kaitain'); ?></label>
                <input id="get-search-authors" type="hidden" name="c" value="<?php echo $query; ?>" />
            </li>
            <li class="advanced-search-option">
                <input id="search-posts-by-authors" type="radio" name="advanced-search-options" value="search_posts_by_authors" />
                <label for="search-posts-by-authors"><?php _e('
Earraí chuardaigh ag colúnaithe mheaitseáil', 'kaitain'); ?></label>
            </li>
        </ul>
        <button class="button" type="submit" name="advanced-search" id="advanced-search-submit" value="curdaigh">Curdaigh</button>
         <script type="text/javascript">
            var searchAuthors = document.getElementById('search-authors');
            var searchTerm = document.getElementById('searchform__input').value;
            var home = "<?php echo $action; ?>";
            var authorSearch = "<?php echo $action."?c=" ?>" + searchTerm;
            var advancedFormAction = document.getElementById('advanced-search-form').action;
            document.getElementById('advanced-search-submit').addEventListener('click', advancedSearch());
            var action = '';
            function advancedSearch(e) {
                e.preventDefault();
                
                searchTerm = document.getElementById('searchform__input').value;
                
                if (searchAuthors.checked){
                    // home + "authors/?c=" + searchTerm;
                    action = home + "authors/?c=" + searchTerm;
                    advancedFormAction = action;
                    //advancedFormAction = "authors/?c=" + searchTerm;

                    document.getElementById('get-search-authors').value = searchTerm;

                    //e.submit;
                    e.submit;
                    //location.assign(action);
                }

                // document.getElementById('advanced-search-form').action = action;
                //location.assign(action);
            }

            searchAuthors.addEventListener('click', function(e){
                
                if (searchAuthors.checked) {
                    searchTerm = document.getElementById('searchform__input').value;
                    action = "<?php echo $action."authors/?c=" ?>" + searchTerm;
                    advancedFormAction = action;
                    document.getElementById('get-search-authors').value = searchTerm;
                }
            });
        </script>
    </form>

</div>
<hr>