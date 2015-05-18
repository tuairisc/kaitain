<?php 
/**
 * Site Header
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
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" /> 
    <?php setup_sections(); ?>
    <?php social_meta(); ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div id="site">
        <div id="header" role="header">
            <div class="<?php printf(SECTION_TRIM_BACKGROUND); ?>" id="header-logo">
                <a id="brand" href="<?php printf(home_url()); ?>" title="<?php bloginfo('description'); ?>"></a>
                <a class="header-button" id="header-menu-button" href="javascript:void(0)" role="buton"></a>
                <a class="header-button" id="header-search-button" href="javascript:void(0)" role="buton"></a>
                <a class="header-button" id="header-social-button" href="javascript:void(0)" role="buton"></a>
            </div>
            <nav id="menu">
                <ul id="section-primary"><?php primary_section_menu(); ?></ul>
            </nav>
        </div>
        
        <?php // AdRotate group 1
        if (function_exists('adrotate_group')) {
            printf('%s', adrotate_group(1));
        } ?>

        <?php if (WP_DEBUG && is_user_logged_in() && 2 < 1) : ?>
            <pre class="debug"><?php printf(has_local_avatar(311) ? 'true' : 'false'); ?></pre>
        <?php endif; ?>

        <div id="main" role="main">
            <div class="trim trim-absolute <?php printf(SECTION_TRIM_BACKGROUND); ?> trim-top"></div>
            <div id="main-interior">