// Pop out window for Twitter and Facebook sharing links.
'use strict';

var facebookSpecs = [
    'width=500',
    'height=380',
];

var twitterSpecs = [
    'width=450',
    'height=257',
];

$('.post-meta .tuairisc-share a').click(function() {
    var anchorClass = $(this).attr('class');

    if (anchorClass == 'facebook' || anchorClass == 'twitter') {
        var href     = $(this).attr('href');
        var name     = '_blank';
        var replace  = false;

        var specs = (anchorClass == 'facebook') ? facebookSpecs : twitterSpecs;
        window.open(href, name, specs, replace);
    }
});