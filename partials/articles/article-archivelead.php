<?php

/**
 * Archive Lead Article
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 *
 * This file is part of Tuairisc.ie.
 * 
 * Tuairisc.ie is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Tuairisc.ie is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Tuairisc.ie. If not, see <http://www.gnu.org/licenses/>.
 */

add_image_size('archive_lead', 700, 325, array('center', 'center'));

?>

<article <?php post_class('archive-lead'); ?> id="<?php the_id(); ?>">
    <div class="thumbnail">
        <a rel="bookmark" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><img src="<?php the_post_image(); ?>" /></a>
    </div>
    <header>
        <h1 class="title">
            <a rel="bookmark" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
        </h1>
        <h3 class="attribution">
            <a href=""><?php the_author(); ?></a>
        </h3>
        <span class="meta">
            <?php the_date_strftime(); ?>
        </span>
    </header>
    <p>
        <?php the_excerpt(); ?>
    </p>
</article>
