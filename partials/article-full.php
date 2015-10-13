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
$hidden_users = get_option('kaitain_hidden_users');

$post_classes = array(
    'article--full', 'vspace--full'
);

?>

<article <?php post_class($post_classes); ?> id="article-<?php the_ID(); ?>">
    <header class="article--full__header">
        <h1 class="title article--full__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <?php if (!is_page()) : ?>
            <p class="post-excerpt article--full__excerpt"><?php printf(get_the_excerpt()); ?></p>
            <div class="post-meta article--full__postmeta">
                <div class="author-meta">
                    <div class="author-meta__avatar">
                        <?php kaitain_avatar_background_html($author, 'tc_post_avatar', 'author-photo'); ?>
                    </div>
                    <div class="author-meta__info">
                        <a class="author-meta__link green-link--hover" href="<?php printf(get_author_posts_url($author)); ?>"><strong><span><?php the_author_meta('display_name'); ?></strong></span></a>
                        <br />
                        <span class="post-date"><time datetime="<?php the_date('Y-m-d H:i'); ?>"><?php the_post_date_strftime(); ?></time></span>
                        <br />
                        <span><?php edit_post_link(__('edit post', 'kaitain'), '', ''); ?></span>
                    </div>
                </div>
                <?php if (!is_page()) {
                    kaitain_share_links(); 
                } ?>
            </div>
        <?php endif; ?>
    </header>
    <div class="post-content article--full__content">
        <?php the_content(__('Read the rest of this post &raquo;', 'kaitain')); ?>
    </div>

    <?php wp_link_pages(array(
        'before' => sprintf('<p class="%s">%s', 'page-links', __('Leathanach: ', 'kaitain')),
        'after' => '</p>'
    )); ?>

</article>
