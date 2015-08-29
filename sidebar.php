<?php

/**
 * Sidebar
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 */

?>

<div id="sidebar">
    <div class="sidebar-container sidebar-widgets">
        <?php if (is_active_sidebar('widgets-sidebar')) {
            dynamic_sidebar('widgets-sidebar');
        } else {
            printf('<h3>%s</h3>', __('Add your sidebar widgets!', 'tuairisc'));
        } ?>
    </div>
    
    <?php // AdRotate groups 3, 4 and 5
    if (function_exists('adrotate_group')) : ?>
        <div class="sidebar-container sidebar-adverts">
            <?php 

            printf('%s', adrotate_group(3));
            printf('%s', adrotate_group(4));
            printf('%s', adrotate_group(5));

            ?>
        </div>
    <?php endif; ?>
</div>
