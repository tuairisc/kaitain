'use strict';

jQuery(function($) {
    $('#menu a').each(function() {
        if ($(this).siblings('ul').length > 0) {
            $(this).addClass('submenu-indicator');
        }
    });

    if (Modernizr.touch) {
        /* As well as containing a dropdown menu, the anchoring nav item might
         * itself contain a link to somewhere on the site. If the device is 
         * touch-capable, the first click will open the menu and the second follow
         * the hyperlink. */
        $('#menu a').click(function() {
            if (!$(this).hasClass('firstclick') && $(this).siblings('ul').length > 0 && $(this).siblings('ul').is(':visible')) {
                $(this).addClass('firstclick');
                return false;
            }
        });

        $('#menu li').mouseout(function() {
            $(this).find('a').removeClass('firstclick');
        });
    }
});