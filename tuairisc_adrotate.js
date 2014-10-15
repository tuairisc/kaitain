'use strict';
// Blame mark@bhalash.com for this.

// Gazeti changes layout at 770px window width.
var responsiveBreak = 770;
// The class of the actual advert within each group.
var advert = '.tuairisc-advert';

// Fallback media if an advert is missing an appropriate image.
var fallback = {
    image : 'TODO',
    href  : 'http://tuairisc.ie/glac-forgai-linn',
    title : 'TODO',
}

// Suffix denotes respective desktop and mobile versions.
var suffix = { 
    desktop : '_desktop_',
    mobile  : '_mobile_'
}

// Banner advert groups.
var bannerGroups = [
    // Header
    '.g-1',
    // Footer
    '.g-3'
];

// Sidebar advert groups.
var sidebarGroups = [
    '.g-2',
    '.g-4',
    '.g-5'
];

function stripUrl(url) {
    // stirpUrl strips url(..) from a background-image attribute.
    // in:  url(http://domain.com/path-to-image.png)
    // out: http://domain.com/path-to-image.png
    return url.replace(/^url\(["']?/, '').replace(/["']?\)$/, '');
}

function addUrl(url) {
    // addUrl adds url(..) to a background-image attribute.
    // in:  http://domain.com/path-to-image.png
    // out: url(http://domain.com/path-to-image.png)
    return url.replace(/^/,'url(').replace(/$/,')');
}

function isResponsiveAdvert(url) {
    // If the URL contains '_mobile_' or '_desktop_' it is assumed to be 
    // part of a responsive advert.
    if (url.indexOf(suffix.desktop) > -1 || url.indexOf(suffix.mobile) > -1)
        return true;

    return false;
}

function isSmallScreen(url) {
    /* Responsive check based on whether a known mobile browser is given in the
     * user agent string. Testing. Expect it to break. */
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
    // if ($(window).height() > $(window).width())
        return true;

    return false;
}

function suffixToMobile(url) {
    // Chnages '_desktop_' to '_mobile_'.
    return url.replace(suffix.desktop, suffix.mobile);
}

function suffixToDesktop(url) {
    // Chnages '_mobile_' to '_desktop_'.
    return url.replace(suffix.mobile, suffix.desktop);
}

function setSuffix(url) {
    // Swap suffix between mobile and desktop.
    return (isSmallScreen()) ? suffixToMobile(url) : suffixToDesktop(url);
}

function getBackgroundImg(obj) {
    // Return background-image from advert as parsed URL.
    return stripUrl($(obj).css('background-image'));
}

function checkImageExists(url, successCallback, failCallback) {
    /* Check if the image exists on the server by fetching its head with Ajax,
     * and then execute supplied callbacks. Fallback behaviour is to log 'found'
     * or 'not found' via console. */
    successCallback = successCallback || function() {
        console.log('Success: ' + url + ' found');
    }

    failCallback = failCallback || function () {
        console.log('Error: ' + url + ' not found');
    }

    $.ajax({
        url : url,
        type: 'HEAD',
        dataType: 'image',
        success: function() {
            successCallback();
        }, 
        error: function() {
            failCallback();
        }
    });
}

function setBannerImage(obj, img) {
    /* Banner images display either a scaling banner or a sidebar-style widget 
     * if the device is a smartphone. setBannerImage handles the setting. If no 
     * image is input then the fallback.image is used instead. */
    img = img || setSuffix(fallback.image);

    var temp = new Image();
    temp.src = img;

    $(temp).load(function() {
        var w = temp.width;
        var h = temp.height;

        // Shrink to parent.
        if (w >= $(obj).closest('.g').width()) {
            w = $(obj).closest('.g').width();
        }

        $(obj).css({
            'width'  : w + 'px',
            'height' : h + 'px',
            'background-image' : addUrl(img)
        });
    });
}

function resizeBannerAdvert(obj) {
    /* resizeBannerAdvert handles the logic behind setting background image. 
     * Parse the background image to a URL, check if it exists and set it if so.
     * If no image can be found, then the advert is broken and placeholder text 
     * is inserted into the advert instead. */
    $(obj).find(advert).each(function() {
        var curAdvert = $(this);
        var img = getBackgroundImg(this);
        img = setSuffix(img);

        checkImageExists(img, function() {
            // Set image and resize banner if image exists.
            setBannerImage(curAdvert, img);
        }, function() {
            // Set banner to fallback size if image is missing.
            $(curAdvert).children('a').attr({
                'href'  : fallback.href,
                'title' : fallback.title,
            });

            setBannerImage(curAdvert);
        });
    });
}

function resizeSidebarAdvert(obj) {
    /* Elements with display: none set report a width of 0. 
     * Capture width of first sidebar advert container and set all widths to 
     * that. */
    var w = $(obj).width();

    $(obj).find(advert).each(function() {
        $(this).css({
            'width'  : w + 'px',
            'height' : w + 'px'
        });
    });
}

$(function() { 
    $.each(bannerGroups,function(i,v) {
        resizeBannerAdvert(v);
    });

    $.each(sidebarGroups,function(i,v) {
        resizeSidebarAdvert(v);
    });
});

$(window).resize(function() {
    $.each(bannerGroups,function(i,v) {
        resizeBannerAdvert(v);
    });

    $.each(sidebarGroups, function(i,v) {
        resizeSidebarAdvert(v);
    });
});