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

/* 1. Big Lead Article.
 * 2. Second and third rows of articles.
 * 3. List of columnists.
 * 4. Category widgets.
 * Nuacht, Tuairmiocht, Sport, Cultur 
 * 5. Side-by-side category widgets for Saol, Greann, Pobal */

?>

 <div class="trim-block noprint">
            <div class="advert-block adverts--banner" id="adverts--sidebar">
                <?php if (function_exists('adrotate_group')) {
                    printf(adrotate_group(1));
                } ?>
            </div>
            <div class="stripe stripe__absolute-bottom"></div>
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

    ?>
                <div class="featured-top-row-1">
                    <div class="featured-top-70">
                        <article <?php post_class('article--lead'); ?> id="article--lead--<?php the_id(); ?>">
                            <a class="article--lead__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
                                <div class="thumbnail article--lead__thumb">
                                    <div class="archive-trim-bottom <?php printf($trim['bg']); ?>"></div>
                                    <?php post_image_html(get_the_ID(), 'tc_home_feature_lead', true); ?>
                                </div>
                                <!--<h1 class="title article--lead__title"><?php the_title(); ?></h1>-->
                            </a>
                           <!--  <header class="article--lead__header vspace--half">
                                <h4 class="article--lead__author">
                                    <?php if (!kaitain_is_verboten_user($author)) : ?>
                                        <a class="article--lead__author-link text--bold green-link--hover" href="<?php printf(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a>
                                        <?php endif; ?>
                                </h4>
                                <h5 class="post-meta article--lead__meta"><time datetime="<?php echo the_date('Y-m-d H:i'); ?>"><?php the_post_date_strftime(); ?></time></h5>
                            </header> 
                            <p class="post-excerpt article--lead__excerpt"><?php printf(get_the_excerpt()); ?></p>-->
                        </article>
                        
                    </div>

                    <div class="featured-top-30">
                        <div class="featured-side-100">
                            <article class="article--small vspace--half" id="article--small--<?php the_id(); ?>">
                                <a class="article--small__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
                                    <div class="thumbnail article--small__thumb vspace--half">
                                    <div class="archive-trim-bottom <?php printf($trim['bg']); ?>"></div>
                                        <?php post_image_html(get_the_ID(), 'tc_home_feature_small featured-post-image-inner', true); ?>
                                    </div>
                                    <h5 class="title article--small__title"><?php the_title(); ?></h5>
                                </a>
                            </article>
                        </div>
                        <div class="featured-top-30-bottom">
                            <div class="featured-side-50 gutter-half-right">
                                <article class="article--small" id="article--small--<?php the_id(); ?>">
                                    <a class="article--small__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
                                        <div class="thumbnail article--small__thumb">
                                        <div class="archive-trim-bottom <?php printf($trim['bg']); ?>"></div>
                                            <?php post_image_html(get_the_ID(), 'tc_home_feature_small featured-post-image-inner', true); ?>
                                        </div>
                                        <!-- <h5 class="title article--small__title"><?php the_title(); ?></h5> -->
                                    </a>
                                </article>
                            </div>
                            <div class="featured-side-50 gutter-half-left">
                                <article class="article--small" id="article--small--<?php the_id(); ?>">
                                    <a class="article--small__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
                                        <div class="thumbnail article--small__thumb">
                                        <div class="archive-trim-bottom <?php printf($trim['bg']); ?>"></div>
                                            <?php post_image_html(get_the_ID(), 'tc_home_feature_small featured-post-image-inner', true); ?>
                                        </div>
                                        <!-- <h5 class="title article--small__title"><?php the_title(); ?></h5> -->
                                    </a>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>



                <?php
                /* Top article's title and excerpt. Here and not above due to styling requirements*/
                ?>
                <div class="featured-top-row-2">
                    <div class="featured-top-70">
                        <h1 class="title article--lead__title"><?php the_title(); ?></h1>    
                        <header class="article--lead__header vspace--half">
                            <h4 class="article--lead__author">
                                <?php if (!kaitain_is_verboten_user($author)) : ?>
                                    <a class="article--lead__author-link text--bold green-link--hover" href="<?php printf(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a>
                                    <?php endif; ?>
                            </h4>
                            <h5 class="post-meta article--lead__meta"><time datetime="<?php echo the_date('Y-m-d H:i'); ?>"><?php the_post_date_strftime(); ?></time></h5>
                        </header>
                        <p class="post-excerpt article--lead__excerpt"><?php the_excerpt(); ?></p>
                        <!-- <hr> -->
                    </div>
                    <div class="featured-top-row-2-30">
                            <article class="featured-side-50 gutter-half-right " style="margin-left: 0; margin-top: 8px;">
                                <h6 class="title article--small__title"><?php the_title(); ?></h6>
                            </article>

                            <article class="featured-side-50 gutter-half-left" style="margin-left: 0; margin-top: 8px;">
                                <h6 class="title article--small__title"><?php the_title(); ?></h6>
                            </article>
                    </div>
                    <?php
                    //   _
                    //  [_]#####
                    //  The following is the one-third width square thumbnail with 2/3 text to the right
                    //
                    ?>
                    <div class="featured-top-33-container">
                        <div class="featured-top-33-inner-container">
                            <article class="article--small vspace--half" id="article--small--<?php the_id(); ?>">
                                <a class="article--small__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
                                    <div class="archive-trim-bottom <?php printf($trim['bg']); ?>"></div>
                                    <div class="thumbnail article--small__thumb vspace--half">
                                        <?php post_image_html(get_the_ID(), 'tc_home_feature_small', true); ?>
                                    </div>
                                    <h6 class="title article--small__title"><?php the_title(); ?></h6>
                                </a>
                            </article>
                        </div>
                    </div>
                </div>


                <div class="featured-main-area">
                    <?php
                    //
                    // Row
                    //
                    ?>
                    <div class="featured-row">

                        <?php
                        // 50 %
                        ?>
                        <div class="featured-50 gutter-half-right">
                            <article class="article--small vspace--half" id="article--small--<?php the_id(); ?>">
                                <a class="article--small__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
                                    <div class="thumbnail article--small__thumb vspace--half">
                                        <div class="archive-trim-bottom <?php printf($trim['bg']); ?>"></div>
                                        <?php post_image_html(get_the_ID(), 'tc_home_feature_small', true); ?>
                                    </div>
                                    <h5 class="title article--small__title"><?php the_title(); ?></h5>
                                </a>
                            </article>
                        </div>
                        <?php
                        // 25 %
                        ?>
                        <div class="featured-25 gutter-half-left">
                            <article class="article--small vspace--half" id="article--small--<?php the_id(); ?>">
                                <a class="article--small__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
                                    <div class="thumbnail article--small__thumb vspace--half">
                                    <div class="archive-trim-bottom <?php printf($trim['bg']); ?>"></div>
                                        <?php post_image_html(get_the_ID(), 'tc_home_feature_small', true); ?>
                                    </div>
                                    <h5 class="title article--small__title"><?php the_title(); ?></h5>
                                </a>
                            </article>
                        </div>
                        <?php
                        // 25 %
                        ?>
                        <div class="featured-25 gutter-half-left">
                            <article class="article--small vspace--half" id="article--small--<?php the_id(); ?>">
                                <a class="article--small__link <?php printf($trim['texthover']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
                                    <div class="thumbnail article--small__thumb vspace--half">
                                    <div class="archive-trim-bottom <?php printf($trim['bg']); ?>"></div>
                                        <?php post_image_html(get_the_ID(), 'tc_home_feature_small', true); ?>
                                    </div>
                                    <h5 class="title article--small__title"><?php the_title(); ?></h5>
                                </a>
                            </article>
                        </div>
                    </div>
                </div>
                

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

kaitain_partial('pagination', 'site');
get_footer();

?>
