<?php

/**
 * Theme Image Sizes
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

$crop = array('center', 'center');

// Home featured posts.
add_image_size('tc_home_feature_lead', 385, 290, $crop);
add_image_size('tc_home_feature_small', 192, 125, $crop);

// Home authot widget.
add_image_size('tc_home_author', 180, 151, $crop);

// Sidebar widget post.
add_image_size('tc_post_sidebar', 70, 40, $crop);

// Category archive.
add_image_size('tc_post_archive', 390, 170, $crop);

// Single post related post.
add_image_size('tc_post_related', 252, 170, $crop);

// Comment author and post author avatar.
add_image_size('tc_post_avatar', 70, 70, $crop);

// Sidebar featured category widget.
add_image_size('tc_sidebar_category', 250, 140, $crop);

// Main column category widget.
add_image_size('tc_home_category_lead', 390, 200, $crop);
add_image_size('tc_home_category_small', 110, 60, $crop);
