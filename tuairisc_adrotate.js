'use strict';
// Blame mark@bhalash.com for this.
// AdRotate injects its stock CSS on page load.
// This injection cannot be disabled AFAIK without editing the plugin.
// See here: https://www.adrotateplugin.com/support/forums/topic/deactivate-css/

// Gazeti changes layout at 770px window width.
var mobileBreak = 770;

// Sidebar ID
var sidebar = '#sidebar';
var content = '#content';

// Unique string in image name. 
var imgSuffix = { 
    mobile  : '_mobile_', 
    desktop : '_desktop_'
}

var adGroups = {
    header  : '.g-1',
    sidebar : '.g-col',
    footer  : '.g-3'    
}

function swapAdvertImage(obj) {
    // Swap mobile and desktop image sizes. 
    $(obj).find('img').each(function() {
        var img = $(this).attr('src');

        if ($(window).width() > mobileBreak)
            if (img.indexOf(imgSuffix.desktop) == -1)
                img = img.replace(imgSuffix.mobile, imgSuffix.desktop);  

        
        if ($(window).width() <= mobileBreak)
            if (img.indexOf(imgSuffix.mobile) == -1)
                img = img.replace(imgSuffix.desktop, imgSuffix.mobile);

        $(this).attr('src', img);
    });
}

function resizeAdvert(obj) {
    // Overwrite AdRotate CSS. Size anchor element to child image before centering it.
    $(obj).find('img').each(function() {
        var a = $(this).width();
        var b = $(obj).width();
        var c = b * 0.5 - a * 0.5; 

        // The margin will be negative if the banner image is greater than the width
        // of the parent container. 
        if (c < 0) 
            c = 0;

        $(this).css('margin-left', c  + 'px');

        if ($(this).css('display') == 'none')
            $(this).toggle();
    });
}

$(function() {
    $(adGroups.sidebar).parent().css('width', '100%');

    $.each(adGroups, function(k,v) {
        // Determine which image needs to be loaded before it is shown.
        swapAdvertImage(v);
    });
});

$(window).load(function() {
    // Media has to load before you can resize it.
    $.each(adGroups, function(k,v) {
        resizeAdvert(v);
    });
});

$(window).resize(function() {
    $.each(adGroups, function(k,v) {
        swapAdvertImage(v);
        resizeAdvert(v);
    });
});