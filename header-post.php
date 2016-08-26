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
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, minimum-scale=1, user-scalable=yes">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55288923-1', 'auto');
  ga('send', 'pageview');
</script>
<?php wp_head(); ?>
</head>

<body <?php 
if ( is_single() && get_post_meta( $post->ID, 'kaitain_is_fullwidth_feature_image', true ) == 1 ) {
    $body_class = body_class('post-featured-image fullwidth-featured-image');
} else if ( is_single() && get_post_meta( $post->ID, 'kaitain_is_fullwidth_feature_image', true ) != 1 ) {
    $body_class = body_class('post-featured-image');
} else {
    $body_class = body_class();
} ?> data-bind="event: { keyup: keyupHide }">
    <?php if (!is_404()) : ?>
        <?php // Disabled on 404 pages. ?>
        <header class="noprint" id="header">
            <div class="section--current-bg flex--three-col--nav navrow" id="header__navrow" data-bind="css: { showSearch: state.search() }">
                <?php // Empty until I have something better. ?>
                <nav class="navrow__left text--left">
                    <button class="navrow__button navrow__button--menu conceal" id="menutoggle__nav" type="button" data-bind="click: showMenu, css: { 'navrow__button--menu--display': state.menuButton() }">
                        <span class="navrow__icon menu" data-bind="css: { close: state.menuButton() && state.menu() }"></span>
                    </button>
                </nav>

                <nav class="navrow__middle" id="home-link">
                    <a class="navrow__home-link" id="home" rel="home" data-bind="css: { hideLogo: state.search() }" href="<?php printf(home_url()); ?>"></a> 
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
    <?php endif; ?>
