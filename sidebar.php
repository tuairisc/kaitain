<?php
/**
 * Sidebar Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 *
 * This file is part of Nuacht.
 * 
 * Nuacht is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Nuacht is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Nuacht. If not, see <http://www.gnu.org/licenses/>.
 */
?>

<div id="sidebar">
    <?php if (function_exists('dynamic_sidebar')) { 
        dynamic_sidebar('Sidebar');
    }
    
    // AdRotate groups 2, 4 and 5 
    if (function_exists('adrotate_group')) {
        printf('<div class="sidebar-adverts">');
        printf('%s', adrotate_group(3));
        printf('%s', adrotate_group(4));
        printf('%s', adrotate_group(5));
        printf('</div>');
    } ?>
</div> 