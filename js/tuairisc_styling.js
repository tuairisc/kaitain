'use strict';

jQuery(function($) {
    function resizeFeaturePost() {
        // CSS for this box was a Byzantine mess. I wasn't able to consistently
        // set its style with CSS alone. 
        var fpt = '.feature-post-text';
        var w = $(fpt).parent().width() - $(fpt).parent().find('img').first().outerWidth() - 15;
        $(fpt).css('width', w);
    }

    resizeFeaturePost();

    $(window).resize(function() {
        resizeFeaturePost();
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