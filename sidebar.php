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
	<?php if (!is_front_page() && is_active_sidebar('ad-sidebar-1')) : ?>
        <div class="sidebar__widgets">
            <?php dynamic_sidebar('ad-sidebar-1'); ?>
        </div>
    <?php endif; ?>
	<?php if (is_active_sidebar('ad-sidebar-2')) : ?>
        <div class="sidebar__widgets">
            <?php dynamic_sidebar('ad-sidebar-2'); ?>
        </div>
    <?php endif; ?>
    	<?php if (is_active_sidebar('ad-sidebar-3')) : ?>
        <div class="sidebar__widgets">
            <?php dynamic_sidebar('ad-sidebar-3'); ?>
        </div>
    <?php endif; ?>
    <?php if (is_active_sidebar('widgets-sidebar')) : ?>
        <div class="sidebar__widgets">
            <?php dynamic_sidebar('widgets-sidebar'); ?>
        </div>
    <?php endif; ?>
</div>
