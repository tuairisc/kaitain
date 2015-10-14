<?php

/**
 * Sidebar
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

?>

<div class="main__sidebar sidebar noprint" id="main__sidebar">
    <?php if (is_active_sidebar('widgets-sidebar-top')) : ?>
        <div class="sidebar__widgets">
            <?php dynamic_sidebar('widgets-sidebar-top'); ?>
        </div>
    <?php endif; ?>
    
    <?php // AdRotate groups 3, 4 and 5
    if (function_exists('adrotate_group')) : ?>
        <div class="sidebar__widgets adverts--sidebar" id="adverts--sidebar">
            <?php 

            printf('%s', adrotate_group(3));
            printf('%s', adrotate_group(4));
            printf('%s', adrotate_group(5));

            ?>
        </div>
    <?php endif; ?>

    <?php if (is_active_sidebar('widgets-sidebar-bottom')) : ?>
        <div class="sidebar__widgets">
            <?php dynamic_sidebar('widgets-sidebar-bottom'); ?>
        </div>
    <?php endif; ?>
</div>
