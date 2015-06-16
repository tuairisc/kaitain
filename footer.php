<?php

/**
 * Site Footer
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 *
 * This file is part of Tuairisc.ie.
 * 
 * Tuairisc.ie is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Tuairisc.ie is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Tuairisc.ie. If not, see <http://www.gnu.org/licenses/>.
 */

?>

        </div><?php // End #content ?>
        <?php get_sidebar(); ?>
    </div><?php // End #main ?>
    <div id="footer">
        <?php for ($i = 1; $i <= 4; $i++) {
           if (is_active_sidebar('widgets-footer-' . $i)) {
                 dynamic_footer('widgets-footer-' . $i);
             } else {
                 printf('<h3>%s</h3>', __("Add widgets to footer #$i FFS!", TTD));
             }
         } ?>
    </div>
    <?php wp_footer(); ?>
</body>
</html>
