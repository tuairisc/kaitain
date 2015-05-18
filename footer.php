<?php
/**
 * Site Footer
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

        </div> <?php // End #main-interior ?>
        <div class="trim trim-absolute section-trim-background trim-bottom"></div>
    </div> <?php // End #main ?>

    <?php // AdRotate group 3
    if (function_exists('adrotate_group')) {
        printf('%s', adrotate_group(2));
    } ?>
</div><?php // End #site ?>

<div id="footer" role="footer">
    <!-- <div class="trim section-trim-background trim-top"></div> -->
    <?php if (is_active_sidebar('footer_1') || is_active_sidebar('footer_2') || is_active_sidebar('footer_3') || is_active_sidebar('footer_4')) : ?>
        <div class="widget-area">
            <?php dynamic_sidebar('Footer (column 1)'); ?>
            <?php dynamic_sidebar('Footer (column 2)'); ?>
            <?php dynamic_sidebar('Footer (column 3)'); ?>
            <?php dynamic_sidebar('Footer (column 4)'); ?>
        </div>
    <?php endif; ?>
    <div class="copyright">
        <p>&copy; <?php printf(date("Y", time())); ?> <?php _e('Tuairisc Bheo Teoranta', 'tuairisc'); ?>.</p>
    </div>
</div>
<?php wp_footer(); ?>
</body>
</html>