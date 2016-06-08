<?php

/**
 * Front Page Template
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

$page_number = intval(get_query_var('paged'));
get_header('post');
$placeholder = __('curdaigh', 'kaitain');

/* 1. Big Lead Article.
 * 2. Second and third rows of articles.
 * 3. List of columnists.
 * 4. Category widgets.
 * Nuacht, Tuairmiocht, Sport, Cultur 
 * 5. Side-by-side category widgets for Saol, Greann, Pobal */

?>

 <div class="trim-block noprint">
            <div class="advert-block adverts--banner" id="adverts--sidebar">

                <?php if (is_active_sidebar('ad-top')) : ?>
                    <div class="sidebar__widgets">
                        <?php dynamic_sidebar('ad-top'); ?>
                    </div>
                <?php endif; ?>
                
            </div>
            <div class="stripe stripe__absolute-bottom top-trim"></div>
        </div>
        <div class="section--current--bg noprint" style="display:none;" id="bigsearch" data-bind="visible: state.search()">
            <form class="bigsearch-form" id="bigsearch-form" method="get" action="<?php printf($action); ?>" autocomplete="off" novalidate>
                <fieldset form="bigsearch-form">
                    <input class="bigsearch-input" name="s" placeholder="<?php printf($placeholder); ?>" type="search" required="required" data-bind="hasFocus: state.search()">
                </fieldset>
            </form>
            <button class="navrow__button navrow__button--search" id="searchtoggle__search" type="button" data-bind="click: showSearch">
                <span class="navrow__icon search" data-bind="css: { close: state.search() }"></span>
            </button>
        </div>
            <main class="main "id="main">
<?php
if (!$page_number) {

    if (is_active_sidebar('widgets-front-page-top')) {
        dynamic_sidebar('widgets-front-page-top');
    }
?>

<div class="main__content" id="main__content">
    <?php

    if (is_active_sidebar('widgets-front-page')) {
        dynamic_sidebar('widgets-front-page');
    } else {
        printf('<p class="%s">%s</p>', 
            'no-widgets',
            __('Add your front page widgets!', 'kaitain')
        );
    }
} else {
    while (have_posts()) {
        the_post();
        kaitain_partial('article', 'archive');
    }
}

//kaitain_partial('pagination', 'site');
get_footer();

?>
