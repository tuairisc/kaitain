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
$placeholder = __('curdaigh', 'kaitain');

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
        <header id="header">
            <div class="section-trim-background" id="navrow">
                <?php // Empty until I have something better. ?>
                <nav class="left-nav">
                    <button class="menutoggle navbutton" id="nav-menutoggle" type="button">
                        <span class="nav-buttonicon menutoggle-icon menu"></span>
                    </button>
                </nav>

                <nav class="center-nav" id="home-link">
                    <a id="home" rel="home" href="<?php printf(home_url()); ?>"></a> 
                </nav>

                <nav class="right-nav">                    
                    <button class="navbutton searchtoggle" id="nav-searchtoggle" type="button">
                        <span class="nav-buttonicon searchtoggle-icon search"></span>
                    </button>
                </nav>
            </div>
            <nav id="navbar-sections-menu">
                <?php // Section menus. See section-manager.php ?>
                <div class="primary-menu-container menu-container">
                    <ul class="sections-primary"><?php $sections->sections_menu('primary'); ?></ul>
                </div>
                <div class="secondary-menu-container menu-container section-background-active">
                    <ul class="sections-secondary"><?php $sections->sections_menu('secondary', array('box-shadow-hover')); ?></ul>
                </div> 
            </nav>
        </header>
        <div class="trim-block">
            <div class="advert-block banner-advert-block" id="header-advert-block">
                <?php if (function_exists('adrotate_group')) {
                    printf(adrotate_group(1));
                } ?>
            </div>
            <div class="tuairisc-strip trim-absolute trim-bottom"></div>
        </div>
        <div class="section-trim-background" id="bigsearch">
            <form class="bigsearch-form" id="bigsearch-form" method="get" action="<?php printf($action); ?>" autocomplete="off" novalidate>
                <fieldset form="bigsearch-form">
                    <input class="bigsearch-input" name="s" placeholder="<?php printf($placeholder); ?>" type="search" required="required">
                </fieldset>
            </form>
            <button class="navbutton searchtoggle" id="search-searchtoggle" type="button">
                <span class="nav-buttonicon searchtoggle-icon search"></span>
            </button>
        </div>
    <?php endif; ?>
    <main id="main">
        <div id="content">
