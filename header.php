<?php 
/**
 * Site Header
 * -----------
 * @category   PHP Script
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
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
            <div id="header-logo">
                <a href="<?php printf(home_url()); ?>" title="<?php bloginfo('description'); ?>"></a>
            </div>

            <nav id="menu">
                <ul id="section-primary"><?php primary_section_menu(); ?></ul>
                <ul class="<?php printf(SECTION_TRIM_BACKGROUND); ?>" id="section-secondary"><?php secondary_section_menu(); ?></ul>
            </nav>
        </div>
        
        <?php // AdRotate group 1
        if (function_exists('adrotate_group')) {
            printf('%s', adrotate_group(1));
        } ?>

        <div id="main" role="main">
            <div class="section-trim trim-top"></div>
            <div id="main-interior">