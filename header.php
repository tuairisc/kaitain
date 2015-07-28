<?php

/**
 * Header
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

global $sections;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
 <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
    <title><?php wp_title('-', true, 'right'); ?></title>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php if (!is_404()) : ?>
        <div id="header">
            <div class="section-trim-background" id="brand">
                <nav class="left-nav" id="hamburger">
                    <ul>
                        <li class="button">
                            <a class="submenu-toggle" href="javascript:void(0)"></a>
                        </li>
                    </ul>
                </nav>
                <nav class="center-nav" id="home">
                    <a id="home" rel="home" href="<?php printf(home_url()); ?>"></a> 
                </nav>
                <nav class="right-nav" id="external">
                    <ul class="social">
                        <li class="button">
                            <a class="facebook" href="http://www.facebook.com"></a>
                        </li>
                        <li class="button">
                            <a class="twitter" href="http://www.twitter.com"></a>
                        </li>
                    </ul>
                </nav>
            </div>
            <nav id="sections-menu">
                <ul class="section-trim-background" id="secondary">
                    <?php $sections->sections_menu('secondary'); ?>
                </ul>
                <ul id="primary">
                    <?php $sections->sections_menu('primary'); ?>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
    <?php if (function_exists('adrotate_group')) {
        printf('%s', adrotate_group(1));
    } ?>
    <div id="main" role="main">
        <div id="content">
