// Pop out Facebook and Twitter sharing links when they are clicked. 
'use strict';

var sizeArray = [
    '',
    'width=500,height=380',
    'width=450,height=257',
];

$('.post-meta .mshare a').click(function(e) {
    var hrefClass = $(this).attr('class');

    if (hrefClass == 'facebook' | hrefClass == 'twitter') {
        var href = $(this).attr('href');
        var name = 'target="_blank';
        var size = sizeArray[$(this).attr('rel')];

        window.open(href, name, size);
        e.preventDefault();
    }
});