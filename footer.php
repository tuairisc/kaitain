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
        <div class="trim-block noprint">
            <div class="stripe stripe__absolute-top"></div>
            <div class="adverts--banner" id="adverts--footer">
                <?php if (function_exists('adrotate_group') && !is_404()) {
                    printf(adrotate_group(2));
                } ?>
            </div>
        </div>

        <footer class="footer noprint" id="footer">

            <div class="footer__menus" id="footer__menus">

         
                <div class="footer__columns flex--four-col--nav vspace--full">
                    <div class="footer__site-links-1">
                        <?php // Custom footer menu ?>
                        <?php wp_nav_menu(array(
                             'theme_location' => 'footer-site-links-1',
                             'menu_class' => 'footer__site-links-1',
                             'container' => 'nav'
                        )); ?>
                    </div>

                    <div class="footer__site-links-2">
                    <?php // Custom footer menu and section cavalcade. ?>
                    <?php wp_nav_menu(array(
                        'theme_location' => 'footer-site-links-2',
                        'menu_class' => 'footer__site-links-2',
                        'container' => 'nav'
                    )); ?>
                    <?php /*
                    <?php $sections->section_cavalcade(); ?>
                     */ ?>
                    </div>
                </div>

                <?php wp_nav_menu(array(
                    // Output footer social menu.
                    'theme_location' => 'footer-external-social',
                    'menu_class' => 'footer__socialmenu',
                    'container' => false,
                    'container_class' => 'footer__social',
                    'container_id' => 'footer__social',
                    'link_before' => '<span class="footer__sociallink">',
                    'link_after' => '</span>'
                )); ?>

                <p class="footer__copyright">
                    ©<?php printf(date('Y')); ?> <a rel="home" href="<?php printf(home_url()); ?>">Tuairisc Bheo Teoranta</a>.
                </p>
            </div>

            <div class="footer__foras foras">
                <p class="foras__text text--small"><?php _e('Le Cabhair ó', 'kaitain'); ?></p>
                <p class="foras__brand">
                    <a class="foras__logo" rel="nofollow" target="_blank" href="http://www.gaeilge.ie/">
                        <img src="<?php printf(get_template_directory_uri() . '/assets/images/foras-white.svg'); ?>" alt="Foras na Gaeilge" />
                    </a>
                </p>
             </div>

        </footer>
    <?php endif; ?>
    <?php wp_footer(); ?>
</body>
</html>
