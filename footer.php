<?php

/**
 * Site Footer
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

global $sections;

?>

        </div><?php // End #content ?>
        <?php if (!is_404()) {
            get_sidebar(); 
        } ?>
    </main><?php // End #main ?>
    <?php if (!is_404()) : ?>
        <div class="trim-block">
            <div class="advert-block">
                <div class="tuairisc-strip trim-absolute trim-top"></div>
                <?php if (function_exists('adrotate_group') && !is_404()) {
                    printf(adrotate_group(2));
                } ?>
            </div>
        </div>
        <footer id="footer">
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
                <p><small><?php _e('Le Cabhair ó', 'kaitain'); ?></small></p>
                <p><a rel="nofollow" target="_blank" href="http://www.gaeilge.ie/"><img src="<?php printf(get_template_directory_uri() . '/assets/images/brands/foras-white.svg'); ?>" alt="Foras na Gaeilge" /></a></p>
             </div>
        </footer>
    <?php endif; ?>
    <?php wp_footer(); ?>
</body>
</html>
