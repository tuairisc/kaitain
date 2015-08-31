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

?>

<article <?php post_class('full'); ?> id="article-<?php the_ID(); ?>">
    <header>
        <h1 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <?php if (!is_page()) : ?>
            <p class="post-excerpt"><?php printf(get_the_excerpt()); ?></p>
            <div class="author-meta">
                <div class="avatar">
                    <?php kaitain_avatar_background_html($author, 'tc_post_avatar', 'author-photo'); ?>
                </div>
                <div class="author-info">
                    <span class="author-link"><a class="green-link-hover" href="<?php printf(get_author_posts_url($author)); ?>"><?php the_author_meta('display_name'); ?></a></span>
                    <br />
                    <span class="post-date"><time datetime="<?php the_date('Y-m-d H:i'); ?>"><?php the_post_date_strftime(); ?></time></span>
                    <br />
                    <span><?php edit_post_link(__('edit post', 'kaitain'), '', ''); ?></span>
                </div>
            </div>
        <?php endif; ?>
    </header>
    <?php if (!is_page()) {
        get_share_links(); 
    } ?>
    <div class="post-content">
        <?php the_content(__('Read the rest of this post &raquo;', 'kaitain')); ?>
    </div>

    <?php wp_link_pages(array(
        'before' => sprintf('<p class="%s">%s', 'page-links', __('Leathanach: ', 'kaitain')),
        'after' => '</p>'
    )); ?>

</article>
