<?php

/**
 * Single Article Content
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

$author = get_the_author_meta('ID');
$placeholder = __('Cuardaigh', 'kaitain');
$post_classes = array(
    'article--full', 'vspace--full', 'article-full-featured-image'
);

$caption = get_field('featured-image-caption');


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

<?php // Article title ?>
    <h1 class="title article--full__title col-xs-12"><a class="green-link--hover" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
    <?php if (!is_page()) { ?>
        <p class="article--full__excerpt col-xs-12"><?php printf(get_the_excerpt()); ?></p>
    <?php } ?>
    <?php // Featured image ?>
    <div class="thumbnail article--lead__thumb img-frame vspace--full">
        <?php post_image_html(get_the_ID(), 'full', true); ?>
        <div class="archive-trim-bottom <?php printf($trim['bg']); ?>"></div>
    </div>
    <?php
    if ( $caption ) { ?>
        <div class="col-xs-12 caption vspace--full">
            <p>
                <?php echo esc_html($caption); ?>
            </p>
        </div>
    <?php 
    }
    ?>

        <div class="main__content" id="main__content">

            <article <?php post_class($post_classes); ?> id="article--full--<?php the_ID(); ?>">
                <header class="article--full__header">

                    <?php if (!is_page()) : ?>
                        <div class="article--full__postmeta">

                            <div class="article--full__author">
                                <?php                             
                                // check that the avatar isn't the fallback avatar from the WP Avatar plugin that serves a fallback avatar
                                $avatar = get_avatar($author);
                                $has_avatar = ( strpos( $avatar, 'fallback-avatar' ) == false );

                                 if ( !kaitain_is_verboten_user($author) && $has_avatar  && !is_singular('foluntais')) : ?>
                                    <?php // Author photograph. ?>
                                    <div class="article--full__avatar">
                                        <?php 
                                        kaitain_avatar_background_html($author, 'tc_post_avatar', 'author-photo'); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="article--full__author-info">
                                    <?php if (!kaitain_is_verboten_user($author) && !is_singular('foluntais')) : ?>
                                        <?php // Author name, if not verboten. ?>
                                        <h5 class="author--meta__name">
                                            <a class="author-meta__link green-link--hover text--bold" href="<?php printf(get_author_posts_url($author)); ?>">
                                                <?php the_author_meta('display_name'); ?>
                                            </a>
                                        </h5>
                                    <?php endif; ?>

                                    <?php // Post date. ?>
                                    <h5 class="post-date article--full__date">
                                        <time datetime="<?php the_date('Y-m-d H:i'); ?>"><?php 
                                        printf("%s ag %s", get_the_time('l, F j Y'), get_the_time('g:i a'));
                                        ?></time>
                                    </h5>

                                    <?php // Edit post link. ?>
                                    <?php if (is_user_logged_in()) : ?>
                                        <h5 class="article--full__edit-link">
                                            <?php edit_post_link(__('edit post', 'kaitain'), '', ''); ?>
                                        </h5>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if (!is_page()) {
                                // Social sharing links.
                                kaitain_share_links(); 
                            } ?>

                        </div>
                    <?php endif; ?>
                </header>
                <div class="article--full__content">
                    <?php the_content(__('Read the rest of this post &raquo;', 'kaitain')); ?>
                </div>

                <?php wp_link_pages(array(
                    // For paginated posts.
                    'before' => sprintf('<p class="%s">%s', 'page-links', __('Leathanach: ', 'kaitain')),
                    'after' => '</p>'
                )); ?>
            </article>