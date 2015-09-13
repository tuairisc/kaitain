<?php

/**
 * Header
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

global $sections;
$action = esc_url(home_url('/'));

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php printf(get_option('blog_charset')); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php if (!is_404()) : ?>
        <?php // Disabled on 404 pages. ?>
        <div id="header">
            <div class="section-trim-background" id="navrow">
                <?php // Empty until I have something better. ?>
                <nav class="left-nav"></nav>

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
            <?php if (1 > 2) : ?>
                <nav id="sections-menu">
                    <?php // Section menus. See section-manager.php ?>
                    <ul id="primary"><?php $sections->sections_menu('primary'); ?></ul>
                    <ul id="secondary"><?php $sections->sections_menu('secondary'); ?></ul>
                </nav>
            <?php endif; ?>
        </div>
        <div class="advert-block">
            <?php if (function_exists('adrotate_group')) {
                printf(adrotate_group(1));
            } ?>
            <div class="tuairisc-strip trim-absolute trim-bottom"></div>
        </div>
        <div class="section-trim-background" id="bigsearch">
            <form role="search" class="bigsearch-form" method="get" action="<?php printf($action); ?>" autocomplete="off">
                <fieldset>
                    <input class="bigsearch-input" name="s" placeholder="<?php _e('cuardaigh', 'sheepie'); ?>" type="search" required="required">
                </fieldset>
            </form>
        </div>
    <?php endif; ?>
    <div id="main" role="main">
        <div id="content">
