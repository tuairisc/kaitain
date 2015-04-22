'use strict';

jQuery(function($) {
    /**
     * Site Navigation Menu
     * --------------------
     */

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

    var sizes = [
        // Email
        '',
        // Facebook
        'width=450,height=257',
        // Google
        'width=500,height=300',
        // Twitter
        'width=470,height=260',
        // Pinterest
        'width=756,height=320',
        // Reddit
        '',
        // Tumblr
        'width=470,height=470',
    ]; 

    /**
     * Header Size
     * -----------
     * Temporary / TODO / FIXME
     */

    $('#site').css('padding-top', $('#header').outerHeight());

    /**
     * Social Sharing Popouts
     * ----------------------
     */

    $('article .sharing a').click(function(click) {
        // .sharing sharing links.
        var rel = parseInt($(this).data('rel'));

        if (sizes[rel] != '' && rel > 0) {
            var href = $(this).attr('href');
            var name = 'target="_blank';
            var size = sizes[rel];

            window.open(href, name, size);
            click.preventDefault();
        }
    });

    $('.newsletter a').click(function(click) {
        // Signup for the Tuairisc mailing list.
        var href = $(this).attr('href');
        var name = 'target="_blank';
        window.open(href,name,'width=400,height=630');
        click.preventDefault();
    });
});