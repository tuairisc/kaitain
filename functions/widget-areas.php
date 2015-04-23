<?php 
/**
 * Register Theme Widget Areas
 * ---------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 */
 
register_sidebar(array(
    'name'=>'Sidebar',
    'id' => 'sidebar',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '<div class="clear"></div></div>',
    'before_title' => '<h6 class="title">',
    'after_title' => '</h6>',
));

register_sidebar(array(
    'name'=>'Header Social Icons',
    'id' => 'header',
    'description' => 'Place here Tuairisc Social Widget',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '<div class="clear"></div></div>',
    'before_title' => '<h6 class="title">',
    'after_title' => '</h6>',
));

/**
 * Homepage
 * --------
 */ 

register_sidebar(array(
    'name'=>'Homepage (full-width)',
    'id' => 'home-main',
    'description' => 'Widget area for: "Tuairisc Tabbed Categories"',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget' => '<div class="clear">&nbsp;</div></div>',
    'before_title' => '<h6 class="title">',
    'after_title' => '</h6>',
));

register_sidebar(array(
    'name'=>'Homepage (3 columns)',
    'id' => 'home-columns',
    'description' => 'Widget area for: "Tuairisc Featured Category" widgets.',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget' => '<div class="clear">&nbsp;</div></div>',
    'before_title' => '<h6 class="title">',
    'after_title' => '</h6>',
));

/**
 * Footer
 * ------
 */ 

register_sidebar(array(
    'name'=>'Footer (full-width)',
    'id' => 'footer-full',
    'description' => 'Widget area for: "Tuairisc Carousel" widget.',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget' => '<div class="clear">&nbsp;</div></div>',
    'before_title' => '<h6 class="title">',
    'after_title' => '</h6>',
));

 
register_sidebar(array(
    'name'=>'Footer (column 1)',
    'id' => 'footer_1',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget' => '<div class="clear"></div></div>',
    'before_title' => '<h6 class="title">',
    'after_title' => '</h6>',
));

register_sidebar(array(
    'name'=>'Footer (column 2)',
    'id' => 'footer_2',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget' => '<div class="clear"></div></div>',
    'before_title' => '<h6 class="title">',
    'after_title' => '</h6>',
));

register_sidebar(array(
    'name'=>'Footer (column 3)',
    'id' => 'footer_3',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget' => '<div class="clear"></div></div>',
    'before_title' => '<h6 class="title">',
    'after_title' => '</h6>',
));

register_sidebar(array(
    'name'=>'Footer (column 4)',
    'id' => 'footer_4',
    'before_widget' => '<div class="widget %2$s" id="%1$s">',
    'after_widget' => '<div class="clear"></div></div>',
    'before_title' => '<h6 class="title">',
    'after_title' => '</h6>',
));

?>