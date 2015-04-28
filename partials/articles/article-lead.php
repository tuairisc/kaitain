<?php
/**
 * Lead Article Template 
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 *
 * This file is part of Nuacht.
 * 
 * Nuacht is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Nuacht is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Nuacht. If not, see <http://www.gnu.org/licenses/>.
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('lead'); ?>>
    <header>
        <?php if (has_post_thumbnail()) : ?>
            <div class="article-thumb" style="background-image: url('<?php printf(get_thumbnail_url()); ?>'); ">
                <?php printf('<a href="%s" title="%s"></a>', get_the_permalink(), the_title_attribute('echo=0')); ?>
            </div>
        <?php endif; ?>
        <?php printf('<h2 class="title"><a href="%s" rel="bookmark" title="%s">%s</a></h2>',
            get_the_permalink(),
            the_title_attribute('echo=0'),
            get_the_title()
        );

        if (!is_default_author()) { 
            printf(
                '<h6 class="article-author"><a href="%s" rel="author" title="Posts by %t">%s</a></h6>',
                get_author_posts_url(get_the_author_meta('ID')),
                get_the_author_meta('display_name'),
                get_the_author_meta('display_name')
            );
        }

        printf('<span class="header-date">%s</span>', get_the_date()); ?>
    </header>

    <div class="article-body">
        <div class="excerpt">
            <?php the_excerpt(); ?>
        </div>
    </div>
</article>
