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

            opts.toggled = (typeof override === 'boolean') ? override : !opts.toggled;

            $(opts.child).toggleClass(opts.childClass, opts.toggled);
            $(opts.target).toggleClass(opts.targetClass, opts.toggled);

            if (opts.toggled && opts.isTargetInput) {
                $(opts.target).find('input').focus();
            }

            return;
        } 

        function closeOnEscape(event) {
            if (event.keyCode === 27) {
                $(opts.button).trigger('click', false);
            }
        }

        opts = $.extend({}, defaults, args);
        opts.button = this;

        if (!$(opts.linkedClass).length) {
            $(window).on('keyup', closeOnEscape);
        }

        this.addClass(opts.linkedClass.substring(1))
            .on('click', clickToggle);

        return this;
    }

    $('.searchtoggle').link({
        child: '.searchtoggle-icon',
        childClass: 'close',
        target: '#bigsearch',
        targetClass: 'show',
        isTargetInput: true
    });
})(jQuery, window, document);
