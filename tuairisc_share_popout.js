// Pop out Facebook and Twitter sharing links when they are clicked. 
'use strict';

var sizeArray = [
    '',
    'width=500,height=380',
    'width=450,height=257',
];

$('.post-wrapper .mshare a').click(function(e) {
    var rel = parseInt($(this).attr('rel'));

    if (rel == 1 || rel == 2) {
        var href = $(this).attr('href');
        var name = 'target="_blank';
        var size = sizeArray[rel];

        window.open(href, name, size);
        e.preventDefault();
    }
});