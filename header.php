<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php wp_title( '|', true, 'right' ); ?></title>

    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
    <link href='http://fonts.googleapis.com/css?family=Bitter:400,700,400italic|Merriweather:400,700|Source+Sans+Pro:400,600' rel='stylesheet' type='text/css'>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />    
    <?php wp_head(); ?>
    <?php if ( (is_home()) && option::get('featured_enable') == 'on' ) { ui::js("flexslider"); } ?>
</head>
<body <?php body_class() ?>>
    <div class="inner-wrap">

    <?php // AdRotate group 1 ?>
    <?php echo adrotate_group(1); ?>

        <header id="header">

            <div id="logo">
                <?php if (!option::get('misc_logo_path')) { echo "<h1>"; } ?>

                <a href="<?php echo home_url(); ?>" title="<?php bloginfo('description'); ?>">
                    <?php if (!option::get('misc_logo_path')) { bloginfo('name'); } else { ?>
                        <img src="<?php echo ui::logo(); ?>" alt="<?php bloginfo('name'); ?>" />
                    <?php } ?>
                </a>

                <?php if (!option::get('misc_logo_path')) { echo "</h1>"; } ?>
            </div><!-- / #logo -->


            <?php if (option::get('ad_head_select') == 'on') { ?>
                <div class="adv">

                    <?php if ( option::get('ad_head_code') <> "") {
                        echo stripslashes(option::get('ad_head_code'));
                    } else { ?>
                        <a href="<?php echo option::get('banner_top_url'); ?>"><img src="<?php echo option::get('banner_top'); ?>" alt="<?php echo option::get('banner_top_alt'); ?>" /></a>
                    <?php } ?>

                </div><!-- /.adv --> <div class="clear"></div>
            <?php } ?>

            <?php if (option::get('searchform_enable') == 'on') { ?>
                <div class="search_form">
                    <?php get_search_form(); ?>
                </div>
            <?php } ?>

            <ul class="mshare">
                <li><a class="rss" href="<?php bloginfo('rss2_url'); ?>" target="_blank" title="RSS 2.0 Feed"></a></li>
                <li><a class="facebook" href="https://www.facebook.com/tuairisc.ie" target="_blank" title="Facebook"></a></li>
                <li><a class="twitter" href="https://twitter.com/tuairiscnuacht" target="_blank" title="Twitter"></a></li>
                <li><a class="youtube" href="https://www.youtube.com/user/tuairiscnuacht" target="_blank" title="YouTube"></a></li>
            </ul>

            <div class="clear"></div>

            <div id="menu">

                <?php if ( is_active_sidebar( 'header' ) ) { ?>
                    <div id="navsocial">

                        <?php dynamic_sidebar('Header Social Icons'); ?>

                     </div>
                 <?php } ?>

                <a class="btn_menu" id="toggle-main" href="#"></a>

                 <div class="menu-wrap">
                    <?php if (has_nav_menu( 'primary' )) {
                        wp_nav_menu(array(
                        'container' => 'menu',
                        'container_class' => '',
                        'menu_class' => 'dropdown',
                        'menu_id' => 'secondmenu',
                        'sort_column' => 'menu_order',
                        'theme_location' => 'primary'
                        ));
                    }
                    else
                        {
                            echo '<p class="dropdown notice">Please set your Main navigation menu on the <strong><a href="'.get_admin_url().'nav-menus.php">Appearance > Menus</a></strong> page.</p>';
                        }
                    ?>

                </div>




            <div class="clear"></div>
            </div><!-- /#menu -->

    </header>

    <div class="content-wrap">