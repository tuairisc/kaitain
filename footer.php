<?php
/**
 * Site Footer
 * -----------
 * @category   PHP Script
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 */
?>

            </div> <?php // End #main-interior ?>
        <div class="section-trim trim-bottom"></div>
    </div> <?php // End #main ?>

    <?php // AdRotate group 3
    if (function_exists('adrotate_group')) {
        printf('%s', adrotate_group(2));
    } ?>

</div><?php // End #site ?>

<div id="footer" role="footer">
    <div class="section-trim trim-top"></div>
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