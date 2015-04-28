<?php 
/**
 * General Page Template
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
<article id="post-<?php the_ID(); ?>" <?php post_class('article-full'); ?>>

    <header>
        <h1><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'tuairisc' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
        <?php edit_post_link( __('Edit', 'tuairisc'), '<span>', '</span>'); ?>
    </header> 

    <div class="article-body">
        <?php the_content();

        wp_link_pages(array(
            'before' => '<div class="page-link"><span>' . __('Pages:', 'tuairisc') . '</span>', 
            'after' => '</div>'
        ));

        the_tags('<div class="tag-list"><strong>' . __('Tags:', 'tuairisc') . '</strong> ', ', ', '</div>'); ?>
     </div>
</article>