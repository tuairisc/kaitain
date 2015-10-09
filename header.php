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
            <div class="section--current-bg navrow" id="header__navrow">
                <?php // Empty until I have something better. ?>
                <nav class="navrow__left text--left">
                    <button class="navbutton navbutton--menutoggle navbutton__menu" id="menutoggle__nav" type="button">
                        <span class="navbutton__icon menu"></span>
                    </button>
                </nav>

                <nav class="navrow__middle" id="home-link">
                    <a id="home" rel="home" href="<?php printf(home_url()); ?>"></a> 
                </nav>

                <nav class="navrow__right text--center">                    
                    <button class="navbutton navbutton--searchtoggle float--right" id="searchtoggle__nav" type="button">
                        <span class="navbutton__icon search"></span>
                    </button>
                </nav>
            </div>
            <nav class="header-menu" id="header__menu">
                <?php // Section header-menu. See section-manager.php ?>
                <ul class="header-menu__menu" id="menu__main"><?php $sections->sections_menu('primary'); ?></ul>
                <ul class="header-menu__menu disp__hide" id="menu__secondary"><?php $sections->sections_menu('secondary', array('box-shadow-hover')); ?></ul>
            </nav>
        </header>
        <div class="trim-block">
            <div class="advert-block banner-advert-block" id="header-advert-block">
                <?php if (function_exists('adrotate_group')) {
                    printf(adrotate_group(1));
                } ?>
            </div>
            <div class="stripe stripe__absolute-bottom"></div>
        </div>
        <div class="section--current-bg disp disp--hidden" id="bigsearch">
            <form class="bigsearch-form" id="bigsearch-form" method="get" action="<?php printf($action); ?>" autocomplete="off" novalidate>
                <fieldset form="bigsearch-form">
                    <input class="bigsearch-input" name="s" placeholder="<?php printf($placeholder); ?>" type="search" required="required">
                </fieldset>
            </form>
            <button class="navbutton navbutton--searchtoggle" id="searchtoggle__search" type="button">
                <span class="navbutton__icon search"></span>
            </button>
        </div>
    <?php endif; ?>
    <main id="main">
        <div id="content">
