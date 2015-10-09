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
    if (!$('#header-advert-block').is(':visible')) {
        // Ghetto AdbLock check.
    }

    /**
     * Linked Element Class Toggle
     * -------------------------------------------------------------------------
     */

    $.fn.link = function(args) {
        var defaults = {
            child: '',
            childClass: '',
            target: '',
            targetClass: '',
            linkedClass: '.linked-class-toggle',
            isTargetInput: false,
            toggled: false
        };

        var opts = {};

        function clickToggle(event, override) {
            if (typeof override !== 'boolean' && !opts.toggled) {
                // Hide all other linked elements.
                $(opts.linkedClass).not(this).trigger('click', false);
            }

            // opts.toggled can be overriden. Otherwise, just invert it.
            opts.toggled = (typeof override === 'boolean') ? override : !opts.toggled;

            $(opts.child).children(opts.child).toggleClass(opts.childClass, opts.toggled);
            $(opts.target).toggleClass(opts.targetClass, opts.toggled);

            if (opts.toggled && opts.isTargetInput) {
                $(opts.target).find('input').focus();
            }
        } 

        function closeOnEscape(event) {
            // Will /probably/ only work if target has tabindex set.
            if (event.keyCode === 27) {
                $(opts.button).trigger('click', false);
            }
        }

        opts = $.extend({}, defaults, args);
        opts.button = this;

        /* There is a class for all linked elements. On button click all are
         * hidden. */

        this.addClass(opts.linkedClass.substring(1))
            .on('click', clickToggle)
            .trigger('click', opts.toggled)

        // Trigger false on escape keyup and window resize.
        $(window).on('keyup', closeOnEscape);

        return this;
    }

    $('.navbutton--searchtoggle').link({
        child: '.navbutton__icon',
        childClass: 'close',
        target: '#bigsearch',
        targetClass: 'disp--shown',
        isTargetInput: true,
    });

    $('.navbutton--menutoggle').link({
        child: '.navbutton__icon',
        childClass: 'close',
        target: '#header__menu',
        targetClass: 'disp--shown',
        isTargetInput: false
    });
})(jQuery, window, document);

;(function(window, $) {
    function dingdong() {
        var a = $(window).scrollTop() + $('#header').height() - $('#main').offset().top;
        var b = 100;
        var c = 640;
        var d = 0;

        var nav = {
            menu: '#header__menu',
            button: '#menutoggle__nav'
        };

        var open = ($(window).width() > c && a > 0);

        if ($(window).width() > c) {
            if (a > 0) {
                $(nav.menu).slideUp(b);
                $(nav.button).slideDown(b);
            } else {
                $(nav.menu).slideDown(b);
                $(nav.button).slideUp(b);
            }

        } else if (!$(nav.menu).is(':visible')) {
            // Hidden for demo.
            // $(nav.menu).show();
            $(nav.button).show();
        }
    }

    $(window).on('scroll resize', dingdong);
})(window, jQuery);
