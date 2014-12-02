'use strict';

var sizeArray = [
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

jQuery('.post-wrapper .mshare a, .msv a').click(function(e) {
    var rel = parseInt(jQuery(this).data('rel'));

    if (sizeArray[rel] != '' && rel > 0) {
        var href = jQuery(this).attr('href');
        var name = 'target="_blank';
        var size = sizeArray[rel];

        window.open(href, name, size);
        e.preventDefault();
    }
});