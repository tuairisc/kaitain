<?php

/**
 * Single Article Content
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 *
 * This file is part of Tuairisc.ie.
 * 
 * Tuairisc.ie is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Tuairisc.ie is distributed in the hope that it will be useful, but WITHOUT 
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Tuairisc.ie. If not, see <http://www.gnu.org/licenses/>.
 */

$author = get_the_author_meta('ID');
$hidden_users = get_option('tuairisc_hidden_users');
$avatar = get_avatar($author);

?>

<article <?php post_class('full'); ?> id="article-<?php the_ID(); ?>">
    <header>
        <h1 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <p class="post-excerpt"><?php printf(get_the_excerpt()); ?></p>
        <div class="author-meta">
            <?php if (!in_array($author, $hidden_users)) : ?>
                <?php printf('<div class="%s" style="%s"><a title="%s" href="%s"></a></div>',
                    'photo',
                    sprintf('background-image: url(%s);', $avatar),
                    get_the_author_meta('display_name'),
                    get_author_posts_url($author)
                ); ?>
            <?php endif; ?>
            <div class="author-info">
                <span class="author-link"><a class="green-link-hover" href="<?php printf(get_author_posts_url($author)); ?>"><?php the_author_meta('display_name'); ?></a></span>
                <br />
                <span class="post-date"><time datetime="<?php the_date('Y-m-d H:i'); ?>"><?php the_post_date_strftime(); ?></time></span>
                <br />
                <span><?php edit_post_link(__('edit post', TTD), '', ''); ?></span>
            </div>
        </div>
    </header>
    <?php get_share_links(); ?>
    <div class="post-content">
        <?php the_content(__('Read the rest of this post &raquo;', TTD)); ?>
    </div>
</article>
