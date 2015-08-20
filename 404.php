<?php

/**
 * 404 Template
 * -----------------------------------------------------------------------------
 * @category   PHP Script
 * @package    Tuairisc.ie
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 * @link       http://www.tuairisc.ie
 */

get_header(); ?>

<div id="error">
    <h1><?php _e('Earráid 404', TTD); ?></h1>
    <p><?php _e('Aistear amú – tada anseo. :(', TTD); ?></p>
    <p><small><a class="green-link" href="<?php printf(site_url()); ?>"><?php _e('téigh abhaile', TTD); ?></a></small></p>
</div>

<?php get_footer(); ?>
