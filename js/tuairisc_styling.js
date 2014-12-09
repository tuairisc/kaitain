'use strict';

var responsiveBreak = 768;
var isMenuOpen = false;

var menu = {
    'container' : '#menu',
    'toggle'    : '.menu-toggle',
    'wrap'      : '.menu-wrap',
    'mobile'    : '.mobile-menu',
    'dropdown'  : '.dropdown'
};

jQuery(function($) {
    function resizeFeaturePost() {
        // CSS for this box was a Byzantine mess. I wasn't able to consistently
        // set its style with CSS alone. 
        var fpt = '.feature-post-text';
        var w = $(fpt).parent().width() - $(fpt).parent().find('img').first().outerWidth() - 15;
        $(fpt).css('width', w);
    }

    function menuStyleToggle() {
        // Toggle the main navigation menu bewenen the mobile and desktop 
        // states.

        if (typeof window.orientation === 'undefined') {
            $(menu.wrap).removeAttr('style');
        }

        if ($(window).width() <= responsiveBreak) {
            $(menu.wrap).addClass('mobile-menu');
        }
    }

    function openMenu() {
        if ($(window).width() < responsiveBreak) {
            $(menu.wrap).show();
            $(menu.mobile).addClass('active');

            $(menu.toggle).css({
                'background-color' : '#fff',
                'background-image' : 'url("http://catnip.bhalash.com/wp-content/themes/gazeti/images/menu_button_grey.svg")',
            });

            isMenuOpen = true;
        }
    }

    function closeMenu() {
        if ($(window).width() < responsiveBreak) {
            $(menu.wrap).hide();
            $(menu.mobile).removeClass('active'); 

            $(menu.toggle).css({
                'background-color' : '#555',
                'background-image' : 'url("http://catnip.bhalash.com/wp-content/themes/gazeti/images/menu_button_white.svg")',
            });

            isMenuOpen = false;
        }
    }

    menuStyleToggle();
    resizeFeaturePost();

    /* Menu Opening and Closing
     * ------------------------ */

    $(window).click(function() {
        closeMenu();
    });

    $(menu.container).click(function(e) {
        e.stopPropagation();
    });

    /* Toggle the appearance of the menu at mobile sizes. */

    $(menu.toggle).click(function() {
        /* Dropdown is hidden on page load. */
        $(menu.dropdown).show();

        (isMenuOpen) ? closeMenu() : openMenu();
    });

    /* Close the menu on window scroll or resize. */

    $(window).scroll(function() {
        closeMenu();
    });

    $(window).resize(function() {
        closeMenu();
        menuStyleToggle();
        resizeFeaturePost();
    });

    // $('a').click(function() {
    //     // Debug.
    //     console.warn('You disabled hyperlinks for debug purposes, doofus!');
    //     return false;
    // });
});