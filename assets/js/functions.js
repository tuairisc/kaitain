/**
 * Template JS Functions
 * -----------------------------------------------------------------------------
 * @category   JavaScript
 * @package    Kaitain
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/kaitain-theme
 * @link       http://www.tuairisc.ie
 */

;(function($, window, document) {
    $.fn.linkedToggle = function(target, input) {
        var $target = $(target);
        var $input = $(input);

        var toggle = function(event) {
            $(this).toggleClass('close');
            $target.attr('tabindex', 2).toggleClass('show').find('input').focus();
        }

        this.on('click', toggle);
        return this;
    }

    $('.bigsearch-toggle').linkedToggle('#bigsearch', '.bigsearch-input');
})(jQuery, window, document);
