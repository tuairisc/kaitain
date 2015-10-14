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
    // Initalize linked state toggles.
    $('.navrow__button--search').link({
        child: '.navrow__icon',
        childClass: 'close',
        target: '#bigsearch',
        targetClass: 'disp--shown',
        isTargetInput: true,
    });

    $('.navrow__button--menu').link({
        child: '.navrow__icon',
        childClass: 'close',
        target: '#header__menu',
        targetClass: 'disp--shown',
        isTargetInput: false
    });

    $.fn.scrollHide = function(args) {
        // TODO FIXME
        //
        var defaults = {
            // How far up above the scroll point should you go to avoid
            // flickering?
            toleranceUp: 100,
            toleranceDown: 0,
            // Window width size below which to stop.
            stopBelow: 0,
            // Class to toggle.
            toggleClass: '',
            // Point to trigger.
            triggerAt: '',
            // Add the height of this element when determining trigger.
            addHeight: true,
            element: this
        }

        var opts = {};

        function toggle(event) {
            var hasClass = $(opts.element).hasClass(opts.toggleClass);
            var scrollTop = $(window).scrollTop() + opts.toleranceDown;
            var trigger = $(opts.triggerAt).offset().top;

            if ($(window).width() <= opts.stopAt && hasClass) {
                $(opts.element).trigerClass(opts.toggleClass, false);
            } else if (hasClass && scrollTop < trigger) {
                $(opts.element).toggleClass(opts.toggleClass, false);
            } else if (scrollTop >= trigger) {
                $(opts.element).toggleClass(opts.toggleClass, true);
            }
        }

        opts = $.extend({}, defaults, args);
        $(window).on('scroll resize', toggle);
        this.trigger('scroll');
    }

    $('#header__menu').scrollHide({
        toleranceDown: $('#header__menu').height(),
        triggerAt: '#main',
        toggleClass: 'scroll--up',
        stopBelow: 640,
    });

    $('#menutoggle__nav').scrollHide({
        toleranceDown: $('#header__menu').height(),
        triggerAt: '#main',
        toggleClass: 'scroll--up',
        stopBelow: 640,
    });

})(jQuery, window, document);
