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
 *
 * This file is part of Tuairisc.ie.
 * 
 * Tuairisc.ie is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Tuairisc.ie is distributed in the hope that it will be useful, but WITHOUT 
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Tuairisc.ie. If not, see <http://www.gnu.org/licenses/>.
 */

?>

<div id="sidebar">
    <div class="sidebar-container sidebar-widgets">
        <?php if (is_active_sidebar('widgets-sidebar')) {
            dynamic_sidebar('widgets-sidebar');
        } else {
            printf('<h3>%s</h3>', __('Add your sidebar widgets!', TTD));
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
