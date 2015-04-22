<?php
/**
 * Register Theme Menus
 * --------------------
 * @category   PHP Script
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 */

function register_theme_menus() {
    register_nav_menus(array(
        'primary' => __('Header Menu'),
    ));
}

add_action('after_setup_theme', 'register_theme_menus');
?>