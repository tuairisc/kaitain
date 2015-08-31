<?php 

/**
 * Get Date Using System Locale Files
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
