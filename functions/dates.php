<?php

/**
 * Translate Dates to Irish
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
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

$irish_calendar_terms = array(
    'days' => array(
        'Monday' => 'Dé Luain',
        'Tuesday' => 'Dé Máirt',
        'Wednesday' => 'Dé Céadaoin',
        'Thursday' => 'Déardaoin',
        'Friday' => 'Dé hAoine',
        'Saturday' => 'Dé Sathairn',
        'Sunday' => 'Dé Domhnaigh'
    ),
    'months' => array(
        'January' => 'Eanáir',
        'February' => 'Feabhra',
        'March' => 'Márta',
        'April' => 'Aibreán',
        'May' => 'Bealtaine',
        'June' => 'Meitheamh',
        'July' => 'Iúil',
        'August' => 'Lúnasa',
        'September' => 'Meán Fómhair',
        'October' => 'Deireadh Fómhair',
        'November' => 'Samhain',
        'December' => 'Nollaig'
    )
);

/**
 * Translate Day to Irish
 * -----------------------------------------------------------------------------
 * The language of the date is set by the localization of the server. Catch
 * the date based on Tuairisc's preferred format and translate it to Irish.
 * 
 * @param   string      $day        The day in English.
 * @return  string                  The day in Irish.
 */

function translate_day_to_irish($day) {
    global $irish_calendar_terms;
    return $irish_calendar_terms['days'][$day];
}

/**
 * Translate Day to Irish
 * -----------------------------------------------------------------------------
 * The language of the date is set by the localization of the server. Catch
 * the date based on Tuairisc's preferred format and translate it to Irish.
 * 
 * @param   string      $month      The month in English.
 * @return  string                  The month in Irish.
 */

function translate_month_to_irish($month) {
    global $irish_calendar_terms;
    return $irish_calendar_terms['months'][$month];
}

/*
 * Translate Date to Irish 
 * -----------------------------------------------------------------------------
 * The language of the date is set by the localization of the server. Catch
 * the date based on Tuairisc's preferred format and translate it to Irish.
 *
 * @param   string      $the_date   The date in English.
 * @return  string      $the_date   The date in Irish.
 */

function translate_date_to_irish($the_date) {
    $english_month = '';
    $english_day = '';
    $irish_day = '';
    $irish_month = '';

    $day_regex = '/(,.*)/';
    $month_regex = '/(^.*, | [0-9].*$)/'; 

    $english_month = preg_replace($month_regex, '', $the_date);
    $english_day = preg_replace($day_regex, '', $the_date);

    $irish_day = translate_day_to_irish($english_day);
    $irish_month = translate_month_to_irish($english_month);

    $the_date = str_replace($english_day, $irish_day, $the_date);
    $the_date = str_replace($english_month, $irish_month, $the_date);
    return $the_date;
}

add_filter('get_the_date', 'translate_date_to_irish');
add_filter('get_comment_date', 'translate_date_to_irish');

?>
