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
})(jQuery, window, document);
