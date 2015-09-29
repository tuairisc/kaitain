<?php

/**
 * Search Form
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

global $wp_query;

$query = get_search_query();
$action = esc_url(home_url('/'));
$total = $wp_query->found_posts;

$result = $total === 1 ? 'torthaí' : 'tordagh';

?>

<form role="search" class="searchform vspace-half" id="searchform" method="get" action="<?php printf($action); ?>" autocomplete="off">
    <fieldset>
        <input class="searchform-input" id="searchform-input" name="s" placeholder="<?php _e('curdaigh', 'kaitain'); ?>" type="text" required="required" value="<?php printf($query); ?>">
    </fieldset>
</form>
<div class="clearfix search-results-meta">
    <span class="total meta left-float"><?php printf('%d %s', $total, $result); ?></span>
    <span class="total meta right-float">
        <?php _e('Saghas:', 'sheepie'); ?>

        <a class="searchform-link green-link searchform-order-oldest" href="<?php arc_search_url('asc'); ?>"><?php _e('sine', 'kaitain'); ?></a> |
        <a class="searchform-link green-link searchform-order-newest" href="<?php arc_search_url('desc'); ?>"><?php _e('is nua', 'kaitain'); ?></a>
    </span>
</div>
<hr>
