<?php

/**
 * Site Footer
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

global $sections;

?>

        </div><?php // End #content ?>
        <?php if (!is_404()) {
            get_sidebar(); 
        } ?>
        <?php if (!is_404()) : ?>
            <div class="tuairisc-strip trim-absolute trim-bottom"></div>
        <?php endif; ?>
    </div><?php // End #main ?>
    <?php if (function_exists('adrotate_group') && !is_404()) {
        printf(adrotate_group(1));
    } ?>
    <?php if (!is_404()) : ?>
        <div id="footer">
            <div class="menus">
                <div class="menu-columns">
                    <?php // Custom footer menu and section cavalcade. ?>
                    <?php wp_nav_menu(array(
                        'theme_location' => 'footer-site-links',
                        'container' => 'nav',
                    )); ?>
                    <?php $sections->section_cavalcade(); ?>
                </div>
                 <p id="copyright">©<?php printf(date('Y')); ?> <a rel="home" href="<?php printf(home_url()); ?>">Tuairisc Breo Teorantha</a>.</p>
             </div>
             <div id="foras">
                <p><small><?php _e('Le Cabhair ó', TTD); ?></small></p>
                <p><a rel="nofollow" target="_blank" href="http://www.gaeilge.ie/"><img src="<?php printf(THEME_URL . '/assets/images/brands/foras-white.svg'); ?>" alt="Foras na Gaeilge" /></a></p>
             </div>
        </div>
    <?php endif; ?>
    <?php wp_footer(); ?>
</body>
</html>
