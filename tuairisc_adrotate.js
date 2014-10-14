'use strict';
// Blame mark@bhalash.com for this.
// AdRotate injects its stock CSS on page load.
// This injection cannot be disabled AFAIK without editing the plugin.
// See here: https://www.adrotateplugin.com/support/forums/topic/deactivate-css/

// Gazeti changes layout at 770px window width.
var responsiveBreak = 770;
// The class of the actual advert within each group.
var advert = '.tuairisc-advert';

var suffix = { 
    // Suffix denotes respective desktop and mobile versions.
    mobile  : '_mobile_', 
    desktop : '_desktop_'
}

// Banner advert groups.
var bannerGroups = [
    '.g-1',
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
    url = url.replace(/^url\(["']?/, '').replace(/["']?\)$/, '');
    return url;
}

function addUrl(url) {
    // addUrl adds url(..) to a background-image attribute.
    // in:  http://domain.com/path-to-image.png
    // out: url(http://domain.com/path-to-image.png)
    url = url.replace(/^/,'url(');
    url = url.replace(/$/,')');
    return url;
}

function isResponsiveAdvert(url) {
    // If the URL contains '_mobile_' or '_desktop_' it is assumed to be 
    // part of a responsive advert.
    if (url.indexOf(suffix.desktop) > -1 || url.indexOf(suffix.mobile) > -1)
        return true;

    return false;
}

function suffixToMobile(url) {
    // Chnages '_desktop_' to '_mobile_'.
    if (isResponsiveAdvert(url))
        return url.replace(suffix.desktop, suffix.mobile);

    return null;
}

function suffixToDesktop(url) {
    // Chnages '_mobile_' to '_desktop_'.
    if (isResponsiveAdvert(url))
        return url.replace(suffix.mobile, suffix.desktop);

    return null;
}

function setSuffix(url) {
    // Swap suffix between mobile and desktop.
    return (isSmallScreen()) ? suffixToMobile(url) : suffixToDesktop(url);
}

function getBackgroundImg(obj) {
    // Return background-image from advert as parsed URL.
    var url = $(obj).css('background-image');
    url = stripUrl(url);
    return url;
}

function isSmallScreen(url) {
    // Simple responsive width check based on switchpoint of WPZOOM Gazeti theme.
    // Testing. Expect it to break.
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
    // if ($(window).height() > $(window).width())
        return true;

    return false;
}

function checkImageExists(url, successCallback, failCallback) {
    // Check if the image exists on the server and execute supplied callbacks.
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
    // Set image or set fallback image.
    img = img || function() {
        img = 'fallback_url.jpg';
        img = setSuffix(img);
    }

    var temp = new Image();
    temp.src = img;

    $(temp).load(function() {
        var w = temp.width;
        var h = temp.height;

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
    // Nag Ciaran for fallback images. 
    $(obj).find(advert).each(function() {
        var curAdvert = $(this);
        var img = getBackgroundImg(this);
        img = setSuffix(img);

        checkImageExists(img, function() {
            // Set image and resize banner if image exists.
            setBannerImage(curAdvert, img);
        }, function() {
            // Set banner to fallback size if image is missing.
            setBannerImage(curAdvert);
        });
    });
}

function resizeSidebarAdvert(obj) {
    // Elements with display: none set report a width of 0. 
    // Capture width of first sidebar advert container and set all widths to that.
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