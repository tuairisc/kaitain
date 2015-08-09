<?php

/**
 * Related Articles
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

global $sections;

$trim = $sections->get_section_slug(get_the_category()[0]);

$trim = array(
    'text' => sprintf('section-%s-text-hover', $trim),
    'background' => sprintf('section-%s-background', $trim)
);

?>

<article <?php post_class('related'); ?> id="related-<?php the_ID(); ?>">
    <a class="<?php printf($trim['text']); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
        <div class="thumbnail">
            <img class="cover-fit" src="<?php the_post_image(get_the_ID(), 'large'); ?>" alt="<?php the_title_attribute(); ?>" />
            <div class="archive-trim-bottom <?php printf($trim['background']); ?>"></div>
        </div>
        <header>
            <h5 class="title"><?php the_title(); ?></h5>
            <?php if (!is_page()) : ?>
                <span class="post-date"><small><time datetime="<?php echo the_date('Y-m-d H:i'); ?>"><?php the_date_strftime(); ?></time></small></span>
            <?php endif; ?>
        </header>
        <?php if (is_user_logged_in()) : ?>
            <footer>
                <p><small><?php edit_post_link(__('edit post', TTD), ' ', ''); ?></small></p>
            </footer>
        <?php endif; ?>
    </a>
</article>
