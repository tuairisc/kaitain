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
 */

$crop = array('center', 'center');

// Home featured posts.
add_image_size('tc_home_feature_lead', 790, 385, $crop);
add_image_size('tc_home_feature_small', 190, 125, $crop);

// Home authot widget.
add_image_size('tc_home_author', 180, 150, $crop);

// Sidebar widget post.
add_image_size('tc_post_sidebar', 70, 45, $crop);

// Category archive.
add_image_size('tc_post_archive', 390, 170, $crop);

// Single post related post.
add_image_size('tc_post_related', 255, 170, $crop);

// Comment author and post author avatar.
add_image_size('tc_post_avatar', 70, 70, $crop);

// Sidebar featured category widget.
add_image_size('tc_sidebar_category', 250, 140, $crop);

// Main column category widget.
add_image_size('tc_home_category_lead', 390, 200, $crop);
add_image_size('tc_home_category_small', 110, 60, $crop);
