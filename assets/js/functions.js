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
    /**
     * Search and Menu Display Controller
     * -------------------------------------------------------------------------
     *  This controls the responsive and display states of the site header
     *  navigation menu and searchform. 
     *
     *  @param  bool        initialState        Initial state (show or hide).
     */

    var navViewController = function(initialState) {
        var self = this;

        self.breaks = {
            // Pixel width breakpoint for scrolling behaviour to end.
            width: 640
        };

        self.state = {
            // Search, menu and menu button states.
            search: ko.observable(initialState),
            menu: ko.observable(true),
            menuButton: ko.observable(false)
        };

        /**
         * Toggle Search State
         * ---------------------------------------------------------------------
         */

        self.showSearch = function() {
            // Toggle search, true/false. Used on menu buttons.
            self.state.search(!self.state.search());
        };

        /**
         * Toggle Menu State
         * ---------------------------------------------------------------------
         */

        self.showMenu = function() {
            // Toggle menu, true/false. Used on menu buttons.
            self.state.menu(!self.state.menu());
        };

        /**
         * Hide Menu and Search on Keyup
         * ---------------------------------------------------------------------
         *  Hide search and menu navigations when escape is pressed.
         */

        self.keyupHide = function(data, event) {
            if (event.keyCode === 27) {
                self.state.search(false);
                self.state.menu(false);
            }
        };

        /**
         * Hide Menu on Window Scroll
         * ---------------------------------------------------------------------
         *  This is separate to the conditional scroll below, which includes a 
         *  toggle on the menu button state.
         */

        self.onscrollHide = function() {
            self.state.menu(false);
        };

        /**
         * Window Scroll Toggle Control
         * ---------------------------------------------------------------------
         */

        self.scrollToggle = function() {
            // Control the state of the menu and button on scroll.

            var top = $(window).scrollTop();
            var main = $('#main').offset().top;

            if (!self.state.menu()) {
                // Add tolerance in order to prevent janky flickering.
                top += $('#header').height();
            }

            // If below break, hide menu and show menu button.
            // Else inverts this behaviour.

            if (top >= main && self.state.menu()) {
                self.state.menu(false);
                self.state.menuButton(true);
            } else if (top < main && !self.state.menu()) {
                self.state.menu(true);
                self.state.menuButton(false);
            }
        };

        /**
         *
         * Window Size Toggle Control
         * ---------------------------------------------------------------------
         */

        self.sizeToggle = function() {
            // If below break, menu button displays and scrolling hevaiour
            // is set to just hide menu on scroll.
            // Else inverts this behaviour.
            //
            if ($(window).width() <= self.breaks.width) {
                self.state.menuButton(true);
                self.state.menu(false);

                $(window).off('scroll', self.scrollToggle);
                $(window).on('scroll', self.onscrollHide);
            } else {
                $(window)
                    .off('scroll', self.onscrollHide)
                    .on('scroll', self.scrollToggle)
                    .trigger('scroll');
            }
        };

        // Attach and trigger resize handler.
        $(window).on('resize', self.sizeToggle).trigger('resize');
    };

    ko.applyBindings(new navViewController(false));
})(jQuery, window, document);
