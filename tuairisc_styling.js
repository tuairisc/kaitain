'use strict'

function resizeFpt() {
    // CSS for this box is a Byzantine mess that I could quite simply not untangle.
    // The 'nuclear' option is this.
    var fpt = '.feature-post-text';
    var w = $(fpt).parent().width() - $(fpt).parent().find('img').first().outerWidth() - 15;
    $(fpt).css('width', w);
}

$(function() {
    resizeFpt();
});

$(window).resize(function() {
    resizeFpt();
});