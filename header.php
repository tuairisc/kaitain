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
<body <?php body_class(); ?> data-bind="event: { keyup: keyupHide }">
    <?php if (!is_404()) : ?>
        <?php // Disabled on 404 pages. ?>
        <header class="noprint" id="header">
            <div class="section--current-bg flex--three-col--nav navrow" id="header__navrow">
                <?php // Empty until I have something better. ?>
                <nav class="navrow__left text--left">
                    <button class="navrow__button navrow__button--menu conceal" id="menutoggle__nav" type="button" data-bind="click: showMenu, css: { 'navrow__button--menu--display': state.menuButton() }">
                        <span class="navrow__icon menu" data-bind="css: { close: state.menuButton() && state.menu() }"></span>
                    </button>
                </nav>

                <nav class="navrow__middle" id="home-link">
                    <a class="navrow__home-link" id="home" rel="home" href="<?php printf(home_url()); ?>"></a> 
                </nav>

                <nav class="navrow__right text--center">                    
                    <button class="navrow__button navrow__button--search float--right" id="searchtoggle__nav" type="button" data-bind="click: showSearch">
                        <span class="navrow__icon search" data-bind="css: { close: state.search() }"></span>
                    </button>
                </nav>
            </div>

            <nav class="navmenu conceal" id="header__menu" data-bind="css: { 'navmenu--display': state.menu() }">
                <?php wp_nav_menu(array(
                    'theme_location' => 'header-section-navigation',
                    'menu_class' => 'navmenu__menu',
                    'menu_id' => 'navmenu__menu',
                    'container' => false,
                    'walker' => new Kaitain_Walker()
                )); ?>
            </nav>

        </header>
        <div class="trim-block noprint">
            <div class="advert-block adverts--banner" id="adverts--sidebar">
                <?php if (function_exists('adrotate_group')) {
                    printf(adrotate_group(1));
                } ?>
            </div>
            <div class="stripe stripe__absolute-bottom"></div>
        </div>
        <div class="section--current--bg noprint" style="display:none;" id="bigsearch" data-bind="visible: state.search()">
            <form class="bigsearch-form" id="bigsearch-form" method="get" action="<?php printf($action); ?>" autocomplete="off" novalidate>
                <fieldset form="bigsearch-form">
                    <input class="bigsearch-input" name="s" placeholder="<?php printf($placeholder); ?>" type="search" required="required" data-bind="hasFocus: state.search()">
                </fieldset>
            </form>
            <button class="navrow__button navrow__button--search" id="searchtoggle__search" type="button" data-bind="click: showSearch">
                <span class="navrow__icon search" data-bind="css: { close: state.search() }"></span>
            </button>
        </div>
    <?php endif; ?>
    <main class="main "id="main">
        <div class="main__content" id="main__content">
