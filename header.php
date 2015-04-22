<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />    
    <?php social_meta(); ?>
    <?php wp_head(); ?>
    <?php if ((is_home()) && option::get('featured_enable') == 'on' ) { ui::js("flexslider"); } ?>
</head>
<body <?php body_class(); ?>>
    <div id="site">
        <div id="header" role="header">
            <div id="header-logo">
                <?php if (!option::get('misc_logo_path')) : ?>
                    <h1>
                        <a href="<?php printf(home_url()); ?>" title="<?php bloginfo('description'); ?>" alt="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a>
                    </h1>
                <?php else : ?>
                    <a href="<?php printf(home_url()); ?>" title="<?php bloginfo('description'); ?>" style="background-image: url(<?php printf(ui::logo()); ?>);" alt="<?php bloginfo('name'); ?>"></a>
                <?php endif; ?>
            </div>
            <nav id="menu">
                <?php if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'menu_id' => 'primary-menu',
                        'sort_column' => 'menu_order',
                        'theme_location' => 'primary'
                    ));
                } else { ?>
                    <p class="dropdown notice">
                        Please set your Main navigation menu on the <strong><a href="printf('%s', get_admin_url() . 'nav-menus.php'); ?>">Appearance > Menus</a></strong> page.
                    </p>
                <?php } ?>
                <ul class="testing" id="secondary-menu">
                    <li><a href="/category/sport/cluichi-gaelacha/">Cluichí Gaelacha</a></li>
                    <li><a href="/category/sport/eile/">Eile</a></li>
                    <li><a href="/category/sport/sacar/">Sacar</a></li>
                    <li><a href="/category/sport/rugbai/">Rugbai</a></li>
                    <li><a href="/category/sport/iomaint/">Iomáint</a></li>
                </ul>
            </nav>
        </div>
        
        <?php // AdRotate group 1
        if (function_exists('adrotate_group')) {
            printf('%s', adrotate_group(1));
        } ?>

        <div id="main" role="main">
            <div id="main-interior">