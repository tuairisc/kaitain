'use strict';

var responsiveBreak = 768;

jQuery(function($) {
    function resizeFeaturePost() {
        // CSS for this box is a Byzantine mess that I could quite simply not 
        // untangle. The 'nuclear' option is this.
        var fpt = '.feature-post-text';
        var w = $(fpt).parent().width() - $(fpt).parent().find('img').first().outerWidth() - 15;
        $(fpt).css('width', w);
    }

    function mobileAdjust() {
        var wrap = '.menu-wrap';

        if(typeof window.orientation === 'undefined') {
            $(wrap).removeAttr('style');
         }

        if($(window).width() <= responsiveBreak) {
            $(wrap).addClass('mobile-menu');
        }
    }

    function scrollMenuToggle() {
        // Hide the menu until the window has scrolled past the first advert. 
        // TODO: This stands to be refined after a consultation with Ciaran.
        var menu = '#menu';

        if ($(window).width() < responsiveBreak && $(window).scrollTop() < $('.g-1').outerHeight() + 20) {
            $(menu).css({
                'top': $('.g-1').scrollHeight + 50,
                'display' : 'initial'
            });
        } else {
            // $(menu).css('top', 20);
        }
    }

    $(window).scroll(function() {
        // scrollMenuToggle();
    });

    // scrollMenuToggle();
    mobileAdjust();
    resizeFeaturePost();

    $('#toggle-main').click(function() {
        // By default #secondmenu would display on mobile devices until this 
        // function was called to hide its parent. It looked unsightly and 
        // reduced the ability of the user to immediately navigate the site. 
        // I changed its CSS to hide it until the function is called. 
        $('#secondmenu').show();

        $('.menu-wrap').toggle();
        $('.mobile-menu').toggleClass("active"); 
        return false;
    });

    $(window).resize(function() {
        mobileAdjust();
        resizeFeaturePost();
    });
});