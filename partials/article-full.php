<?php

/**
 * Single Article Content
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

$author = get_the_author_meta('ID');

$post_classes = array(
    'article--full', 'vspace--full'
);

?>

<article <?php post_class($post_classes); ?> id="article--full--<?php the_ID(); ?>">
    <header class="article--full__header">
        <?php // Article title ?>
        <h1 class="title article--full__title"><a class="green-link--hover" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

        <?php if (!is_page()) : ?>
            <p class="article--full__excerpt"><?php printf(get_the_excerpt()); ?></p>
            <div class="article--full__postmeta">

                <div class="article--full__author">
                    <?php if (!kaitain_is_verboten_user($author)) : ?>
                        <?php // Author photograph. ?>
                        <div class="article--full__avatar">
                            <?php kaitain_avatar_background_html($author, 'tc_post_avatar', 'author-photo'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="article--full__author-info">
                        <?php if (!kaitain_is_verboten_user($author)) : ?>
                            <?php // Author name, if not verboten. ?>
                            <h5 class="author--meta__name">
                                <a class="author-meta__link green-link--hover text--bold" href="<?php printf(get_author_posts_url($author)); ?>">
                                    <?php the_author_meta('display_name'); ?>
                                </a>
                            </h5>
                        <?php endif; ?>

                        <?php // Post date. ?>
                        <h5 class="post-date article--full__date">
                            <time datetime="<?php the_date('Y-m-d H:i'); ?>"><?php the_post_date_strftime(); ?></time>
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
