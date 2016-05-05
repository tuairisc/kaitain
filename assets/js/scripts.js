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

        self.menuFocusClass = 'navmenu--focused';

        self.state = {
            // Search, menu and menu button states.
            search: ko.observable(initialState),
            menu: ko.observable(true),
            menuButton: ko.observable(false),
            oldWidth: false
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

            if (self.state.menu()) {
                // Add tolerance in order to prevent janky flickering.
                top -= $('#header').height();
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
         * Toggle Focused Menu on Hover or Tap 
         * ---------------------------------------------------------------------
         */

        self.setFocusMenu = function(data, event) {
            var $parent = $(event.target.parentNode);
            if (event.type === 'touchstart' && $parent.hasClass(self.menuFocusClass)) {
                // Proceed with click if submenu was selected.
                 return true; 
            }
             
            if (!$parent.hasClass('sub-menu')) {
                // adds class to current item and removes the class from siblings
                $parent.addClass(self.menuFocusClass).siblings().removeClass(self.menuFocusClass);
            }
        } 

        self.removeFocusMenu = function(data, event) {
            
            console.log("Don't Leave");
            
            var $parent = $(event.target.parentNode);

	    if($parent.hasClass(self.menuFocusClass)) {
		$parent.removeClass(self.menuFocusClass);
		}
            
            // remove focus class
            if ($parent.hasClass('sub-menu')) {
                $parent.removeClass(self.menuFocusClass).siblings().removeClass(self.menuFocusClass);            
            }

        }

        /**
         * Window Size Toggle Control
         * ---------------------------------------------------------------------
         * If below break, menu button displays and scrolling hevaiour is set to
         * just hide menu on scroll. Else inverts this behaviour.
         */

        self.sizeToggle = function() {
            var $width = $(window).width();

            // if ($width != self.state.oldWidth && $width <= self.breaks.width) {
            if ($width >= self.breaks.width) {
                $(window).on('scroll', self.scrolltoggle).trigger('scroll');
            } else {
                // iOS vertically changes the viewport on a constant basis. This
                // catpure, and the evaluations above, ensure that:
                // 1. This only triggers once, on load.
                // 2. Subsequently only triggers if their is a horizontal resize.
                //    The vertical component is managed by the scroll function.
                self.state.menuButton(true);
                self.state.menu(false);
                self.state.oldWidth = $width;
            }
        };

        // Attach and trigger resize handler.
        $(window).on('resize', self.sizeToggle).trigger('resize');
    };

    ko.applyBindings(new navViewController(false));

    /**
     * Hides the site logo when the Search Button is clicked
     */
    home = $('#home');
    searchButton = document.getElementById('search-button');
    //searchButtonChild = document.getElementById('searchtoggle__nav').getElementsByClassName('search')[0];
    //searchButton = document.getElementsByClassName('navrow__right')[0];

    searchButton.addEventListener("click", function(ev){
        console.log('click');
        console.log(ev);
        home.toggleClass('transparent');
    });

    menuItems = document.querySelectorAll('.menu-items');
    for (i=0;i<menuItems.length;i++) {
        menuItems[i].addEventListener("mouseout", function() {
            console.log("MOUSE OUT!");
        });
    }


})(jQuery, window, document);

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-55288923-1', 'auto');
ga('send', 'pageview');
