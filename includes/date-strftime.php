<?php 

/**
 * Get Date Using System Locale Files
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

add_option('tc_date_fallback_locale', 'ga_IE','', true);
add_option('tc_date_strftime_format', '%A, %B %e %Y','', true);

/**
 * Get strftime Date
 * -----------------------------------------------------------------------------
 * This function mirrors get_the_date(), except it uses strftiime(), and any 
 * localization supported by your system.
 * 
 * @param   string      $date        The date.
 * @param   string      $locale      Locale to be used. Must be present.
 * @param   string      $format      Format to use for the date.
 * @return  string                   Date in desired locale.
 * 
 * @link https://secure.php.net/manual/en/function.strftime.php
 * @link http://www.bhalash.com/archives/13544804637  
 */

function get_the_date_strftime($date = null, $format = null, $locale = null) {
    $date = mysql2date('U', $date);

    if (!$locale) {
        $locale = get_option('tc_date_fallback_locale');
    }

    if (!$format) {
        $format = get_option('tc_date_strftime_format');
    }

    // @link http://stackoverflow.com/a/19351555/1433400
    setlocale(LC_ALL, '');

    // Try to match common variants of the locale.
    setlocale(LC_ALL,
        $locale,
        $locale . '.utf8',
        $locale . '@euro',
        $locale . '@euro.utf8'
    );

    return strftime($format, $date);
}

/*
 * Print Date using System Locale
 * -----------------------------------------------------------------------------
 * @param   string      $date        The date.
 * @param   string      $locale      Locale to be used. Must be present.
 * @param   string      $format      Format to use for the date.
 */

function the_date_strftime($format = null, $post = null, $locale = null) {
    printf(get_the_date_strftime($format, $post, $locale));
}

/**
 * Get Post Date through System Locale
 * -----------------------------------------------------------------------------
 * @param   int/object  $post        The post.
 * @return  string                   The date.
 */

function get_post_date_strftime($post = null) {
    if (!($post = get_post($post))) {
        global $post;
    }

    return get_the_date_strftime($post->post_date);
}

/**
 * Print Post Date through System Locale
 * -----------------------------------------------------------------------------
 * @param   int/object  $post        The post.
 */

function the_post_date_strftime($post = null) {
    printf(get_post_date_strftime($post));
}

/**
 * Get Comment Date through System Locale
 * -----------------------------------------------------------------------------
 * @param   int/object  $comment       The comment.
 * @return  string                   The date.
 */

function get_comment_date_strftime($comment = null) {
    if (!($comment = get_comment($comment))) {
        global $coment;
    }

    return get_the_date_strftime($comment->comment_date);
}

/**
 * Print Comment Date through System Locale
 * -----------------------------------------------------------------------------
 * @param   int/object  $comment       The comment.
 */

function the_comment_date_strftime($comment = null) {
    printf(get_comment_date_strftime($comment));
}

?>
