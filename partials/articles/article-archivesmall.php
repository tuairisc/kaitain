<?php

/**
 * Featured Small Article
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

$section_slug = $sections->get_section_slug(get_the_category()[0]);
$section_hover = sprintf('section-%s-text-hover', $section_slug);
$section_background = sprintf('section-%s-background', $section_slug);

?>

<article <?php post_class('archive-small'); ?> id="archive-small-<?php the_id(); ?>">
    <a class="<?php printf($section_hover); ?>" rel="bookmark" href="<?php the_permalink(); ?>">
        <div class="thumbnail">
            <img class="cover-fit" src="<?php the_post_image(get_the_ID(), 'thumbnail'); ?>" alt="<?php the_title_attribute(); ?>" />
            <div class="archive-trim-bottom <?php printf($section_background); ?>"></div>
        </div>
        <header>
            <h5><?php the_title(); ?></h5>
        </header>
    </a>
</article>
