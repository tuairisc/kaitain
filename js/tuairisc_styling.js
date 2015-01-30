'use strict';

/*
 * Tuairisc Menu
 * -------------
 */

jQuery(function($) {
    /*
     * Everything Else
     * ---------------
     */

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
});