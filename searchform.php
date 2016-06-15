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

<div class="searchform vspace--full" id="searchform">
    <form class="searchform__form vspace--half" id="searchform__form" method="get" action="<?php printf($action); ?>" autocomplete="off">
        <fieldset>
            <input class="searchform__input" id="searchform__input" name="s" placeholder="<?php _e('curdaigh', 'kaitain'); ?>" type="text" required="required" value="<?php printf($query); ?>">
        </fieldset>
    </form>
    <div class="searchform__meta">
        <span class="searchform__meta--left float--left"><?php printf('%d %s', $total, $result); ?></span>
        <span class="searchform__meta--right float--right">
            <?php _e('Saghas:', 'sheepie'); ?>
            <a class="green-link searchform__order--oldest" href="<?php arc_search_url('asc'); ?>"><?php _e('sine', 'kaitain'); ?></a> |
            <a class="green-link searchform__order--newest" href="<?php arc_search_url('desc'); ?>"><?php _e('is nua', 'kaitain'); ?></a>
        </span>
    </div>
</div>
<hr>

<!--<script>
  // (function() {
  //   var cx = '012959999249218190569:fkka7wrxu5w';
  //   var gcse = document.createElement('script');
  //   gcse.type = 'text/javascript';
  //   gcse.async = true;
  //   gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
  //   var s = document.getElementsByTagName('script')[0];
  //   s.parentNode.insertBefore(gcse, s);
  // })();
</script>
<gcse:search></gcse:search> -->