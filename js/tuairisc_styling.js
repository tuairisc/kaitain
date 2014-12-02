'use strict'

function resizeFpt() {
    // CSS for this box is a Byzantine mess that I could quite simply not untangle.
    // The 'nuclear' option is this.
    var fpt = '.feature-post-text';
    var w = jQuery(fpt).parent().width() - jQuery(fpt).parent().find('img').first().outerWidth() - 15;
    jQuery(fpt).css('width', w);
}

jQuery(function() {
    resizeFpt();
});

jQuery(window).resize(function() {
    resizeFpt();
});