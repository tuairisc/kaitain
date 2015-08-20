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
 */

global $sections;

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php printf(get_option('blog_charset')); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<title><?php wp_title('-', true, 'right'); ?></title>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php if (!is_404()) : ?>
        <?php // Disabled on 404 pages. ?>
        <div id="header">
            <div class="section-trim-background" id="brand">
                <?php // Empty until I have something better. ?>
                <nav class="left-nav" id="hamburger"></nav>
                <nav class="center-nav" id="home-link">
                    <a id="home" rel="home" href="<?php printf(home_url()); ?>"></a> 
                </nav>
                <?php wp_nav_menu(array(
                    // Output header nav menu.
                    'theme_location' => 'top-external-social',
                    'menu_class' => 'social',
                    'container' => 'nav',
                    'container_class' => 'right-nav',
                    'container_id' => 'external'
                )); ?>
            </div>
            <nav id="sections-menu">
                <?php // Section menus. See section-manager.php ?>
                <ul id="primary"><?php $sections->sections_menu('primary'); ?></ul>
                <ul id="secondary"><?php $sections->sections_menu('secondary'); ?></ul>
            </nav>
        </div>
    <?php endif; ?>
    <div class="advert-block">
        <?php if (function_exists('adrotate_group') && !is_404()) {
            printf(adrotate_group(1));
        } ?>
        <div class="tuairisc-strip trim-absolute trim-bottom"></div>
    </div>
    <div id="main" role="main">
        <div id="content">
