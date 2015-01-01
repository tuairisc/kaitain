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

jQuery('.post-wrapper .mshare a, .msv a').click(function(click) {
    // .mshare sharing links.
    var rel = parseInt(jQuery(this).data('rel'));

    if (sizeArray[rel] != '' && rel > 0) {
        var href = jQuery(this).attr('href');
        var name = 'target="_blank';
        var size = sizeArray[rel];

        window.open(href, name, size);
        click.preventDefault();
    }
});

jQuery('.newsletter a').click(function(click) {
    // Signup for the Tuairisc mailing list.
    var href = jQuery(this).attr('href');
    var name = 'target="_blank';
    window.open(href,name,'width=400,height=630');
    click.preventDefault();
});