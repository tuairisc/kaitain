'use strict';
// Blame mark@bhalash.com for this.
// AdRotate injects its stock CSS on page load.
// This injection cannot be disabled AFAIK without editing the plugin.
// See here: https://www.adrotateplugin.com/support/forums/topic/deactivate-css/

// Gazeti changes layout at 770px window width.
var responsiveBreak = 770;

function stripUrl(url) {
    // stirpUrl strips url(..) from a background-image attribute.
    // in:  url(http://domain.com/path-to-image.png)
    // out: http://domain.com/path-to-image.png
    return url.replace(/^url\(|\)$/g, '');
}

function addUrl(url) {
    // addUrl adds url(..) to a background-image attribute.
    // in:  http://domain.com/path-to-image.png
    // out: url(http://domain.com/path-to-image.png)
    url = url.replace(/^/,'url(');
    url = url.replace(/$/,')');
    return url;
}

function checkServer(url, cb_one, cb_two) {
    $.ajax({
        url: url,
        type: 'HEAD',
        dataType: 'image',
        success:function() {
            cb_one();
        }, error:function() {
            cb_two();
        }
    });
}

function swapImage(img) {
    // Swap mobile and desktop image sizes. 
    var src = $(img).attr('src');
    var newSrc = src;

    var suffix = { 
        // Suffix denotes respective desktop and mobile versions.
        mobile  : '_mobile_', 
        desktop : '_desktop_'
    }

    if (src.indexOf(suffix.desktop) > -1 || src.indexOf(suffix.mobile) > -1) {
        if ($(window).width() > responsiveBreak) {
            if (src.indexOf(suffix.mobile) > -1)
                newSrc = src.replace(suffix.mobile, suffix.desktop);  
        }

        if ($(window).width() <= responsiveBreak) {
            if (src.indexOf(suffix.desktop) > -1)
                newSrc = src.replace(suffix.desktop, suffix.mobile);
        }
    }

    return $(img).attr('src', newSrc);
}

function resizeBanner(obj) {
    $(obj).each(function() {
        var advert = $(this);
        var src = stripUrl($(advert).css('background-image'));

        var img = new Image(); 
        $(img).attr('src', src);

        $(img).load(function() {
            var w = img.width;
            var h = img.height; 

            if (w > $(advert).closest('.g').width())
                w = $(advert).closest('.g').width() * 0.98;

            $(advert).css({
                'width' : w + 'px',
                'height' : h + 'px',
            });

            $(advert).css('background-image', addUrl($(this).attr('src')));
        });
    });
}

$(function() {
    resizeBanner('.tuairisc-advert');
});

$(window).resize(function() {
    resizeBanner('.tuairisc-advert');
});