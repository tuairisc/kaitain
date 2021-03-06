<?php

/**
 * 404 Template
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

get_header(); ?>

<div id="error">
    <h1><?php _e('Earráid 404', 'kaitain'); ?></h1>
    <p><?php _e('Aistear amú – tada anseo. :&#40;', 'kaitain'); ?></p>
    <p><small><a class="green-link" href="<?php printf(site_url()); ?>"><?php _e('téigh abhaile', 'kaitain'); ?></a></small></p>
</div>

<?php get_footer(); ?>
