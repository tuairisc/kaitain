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

$irish_calendar_terms = array(
    'days' => array(
        'Dé Luain', 'Dé Máirt', 'Dé Céadaoin', 'Déardaoin', 'Dé hAoine', 
        'Dé Sathairn', 'Dé Domhnaigh'
    ),
    'months' => array(
        'Eanáir', 'Feabhra', 'Márta', 'Aibreán', 'Bealtaine', 'Meitheamh',
        'Iúil', 'Lúnasa', 'Meán Fómhair', 'Deireadh Fómhair', 'Samhain', 
        'Nollaig'
    )
);

function translate_day_to_irish($day) {
    /**
     * Translate Day to Irish
     * ----------------------
     * The language of the date is set by the localization of the server. Catch
     * the date based on Tuairisc's preferred format and translate it to Irish.
     * 
     * @param {string} $day The day in English.
     * @return {string} $day The day in Irish.
     */

    global $irish_calendar_terms;

    switch ($day) {
        case 'Monday': $day = $irish_calendar_terms['days'][0]; break;
        case 'Tuesday': $day = $irish_calendar_terms['days'][1]; break;
        case 'Wednesday': $day = $irish_calendar_terms['days'][2]; break;
        case 'Thursday': $day = $irish_calendar_terms['days'][3]; break;
        case 'Friday': $day = $irish_calendar_terms['days'][4]; break;
        case 'Saturday': $day = $irish_calendar_terms['days'][5]; break;
        case 'Sunday': $day = $irish_calendar_terms['days'][6]; break;
    }

    return $day;
}

function translate_month_to_irish($month) {
    /**
     * Translate Day to Irish
     * ----------------------
     * The language of the date is set by the localization of the server. Catch
     * the date based on Tuairisc's preferred format and translate it to Irish.
     * 
     * @param {string} $month The month in English.
     * @return {string} $month The month in Irish.
     */

    global $irish_calendar_terms;

    switch ($month) {
        case 'January': $month = $irish_calendar_terms['months'][0]; break;
        case 'February': $month = $irish_calendar_terms['months'][1]; break;
        case 'March': $month = $irish_calendar_terms['months'][2]; break;
        case 'April': $month = $irish_calendar_terms['months'][3]; break;
        case 'May': $month = $irish_calendar_terms['months'][4]; break;
        case 'June': $month = $irish_calendar_terms['months'][5]; break;
        case 'July': $month = $irish_calendar_terms['months'][6]; break;
        case 'August': $month = $irish_calendar_terms['months'][7]; break;
        case 'September': $month = $irish_calendar_terms['months'][8]; break;
        case 'October': $month = $irish_calendar_terms['months'][9]; break;
        case 'November': $month = $irish_calendar_terms['months'][10]; break;
        case 'December': $month = $irish_calendar_terms['months'][11]; break;
    }

    return $month;
}

function translate_date_to_irish($the_date) {
    /**
     * Translate Date to Irish 
     * -----------------------
     * The language of the date is set by the localization of the server. Catch
     * the date based on Tuairisc's preferred format and translate it to Irish.
     *
     * @param {string} $the_date
     * @return {string} $the_date
     */

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