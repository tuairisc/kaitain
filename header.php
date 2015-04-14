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
<body <?php body_class(); ?>>
    <div class="inner-wrap">

        <?php // AdRotate group 1
        if (function_exists('adrotate_group')) {
            printf('%s', adrotate_group(1));
        } ?>

        <div id="header">
            <div id="logo">
                <?php if (!option::get('misc_logo_path')) echo "<h1>"; ?>
                    <a href="<?php echo home_url(); ?>" title="<?php bloginfo('description'); ?>">
                        <?php if (!option::get('misc_logo_path')) : ?>
                            <?php bloginfo('name'); ?>
                        <?php else : ?>
                            <img id="site-logo" src="<?php echo ui::logo(); ?>" alt="<?php bloginfo('name'); ?>" />
                        <?php endif; ?>
                    </a>
                <?php if (!option::get('misc_logo_path')) echo "</h1>"; ?>
            </div>

            <div class="share-search">
                <?php if (option::get('searchform_enable') == 'on') : ?>
                    <div class="search_form">
                        <?php get_search_form(); ?>
                    </div>
                <?php endif; ?>

                <ul class="mshare">
                    <li><a class="rss" href="<?php bloginfo('rss2_url'); ?>" target="_blank" title="RSS 2.0 Feed"></a></li>
                    <li><a class="facebook" href="https://www.facebook.com/tuairisc.ie" target="_blank" title="Facebook"></a></li>
                    <li><a class="twitter" href="https://twitter.com/tuairiscnuacht" target="_blank" title="Twitter"></a></li>
                    <li><a class="youtube" href="https://www.youtube.com/user/tuairiscnuacht" target="_blank" title="YouTube"></a></li>
                </ul>
            </div>
        </div>
        <nav id="menu-container">
            <?php if (has_nav_menu('primary')) {
                wp_nav_menu(array(
                    'menu_id' => 'menu',
                    'sort_column' => 'menu_order',
                    'theme_location' => 'primary'
                ));
            } else {
                echo '<p class="dropdown notice">Please set your Main navigation menu on the <strong><a href="'.get_admin_url().'nav-menus.php">Appearance > Menus</a></strong> page.</p>';
            } ?>
        </nav>
    <div class="content-wrap">