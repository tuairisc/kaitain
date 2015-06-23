<?php

/**
 * Front Page Template
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

get_header();

$fallback_i18n = 'ga_IE';
$test_format = '%A, %B, %e %Y';

function get_the_date_i18n($format = '%A, %B %e %Y', $post_id = null, $locale = null) {
    if (is_null($format)) {
        return;
    }

    if (is_null($locale)) {
        global $fallback_i18n;
        $locale = $fallback_i18n;
    }

    if (is_null($post_id)) {
        global $id;
        $post_id = $id;
    }

    $locale = array(
        // Try to match common variants of the locale.
        $locale,
        $locale . '.utf8',
        $locale . '@euro',
        $locale . '@euro.utf8'
    );

    $time = get_the_date('U', $post_id);

    // @link http://stackoverflow.com/a/19351555/1433400
    setlocale(LC_ALL, '');
    setlocale(LC_ALL, $locale[0], $locale[1], $locale[2], $locale[3]);

    return strftime($format, $time);
}

printf('%s', get_the_date_i18n($test_format, 20671));

/* 1. Big Lead Article.
 * 2. Second and third rows of articles.
 * 3. List of columnists.
 * 4. Category widgets.
 * Nuacht, Tuairmiocht, Sport, Cultur 
 * 5. Side-by-side category widgets for Saol, Greann, Pobal */

if (is_active_sidebar('widgets-front-page-main')) {
    dynamic_sidebar('widgets-front-page-main');
} else {
    printf('<h3>%s</h3>', __('Add your main front page widgets FFS!', TTD));
}

if (is_active_sidebar('widgets-front-page-footer')) {
    dynamic_sidebar('widgets-front-page-footer');
} else {
    printf('<h3>%s</h3>', __('Add your front page footer widgets FFS!', TTD));
}

get_footer();
?>
