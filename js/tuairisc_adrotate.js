/* global $:false */

jQuery(window).ready(function($) {
    'use strict';

    var ads = {
        group: '.g',
        groups: {
            banner: [ '.g-1', '.g-3' ],
            sidebar: [ '.g-2', '.g-4', '.g-.5' ]
        },
        tuairisc: '.tuairisc-advert',
        type: {
            dynamic: '.g-dyn',
            single: '.g-single'
        }, 
        suffix: {
            desktop: '_desktop_',
            mobile:  '_mobile_'
        }
    };

    var fallback = {
        link: '//' + window.location.hostname + '/catnip.bhalash.com/glac-fograi-linn/',
        identifier: 'fallback',
        title: 'Tuairisc',
        image: {
            mobile: '//' + window.location.hostname + '/wp-content/uploads/tuairisc_fallback_mobile_.gif', 
            desktop: '//' + window.location.hostname + '/wp-content/uploads/tuairisc_fallback_desktop_.gif'
        },
        classes: {
            dynamic: 'g-dyn',
            tuairisc: 'tuairisc-advert'
        }
    };

    function fallbackAdvert(classes) {
        /*
         * Fallback Advert
         * ---------------
         * Generate fallback advert on occasions where it is required within a 
         * group.
         */

        // Advert wrapper div and repalcement image.
        var advert = '', fallbackImage = '';
        classes[1] = 'a-0000000';

        if ($('html').hasClass('mobile')) {
            fallbackImage = fallback.image.mobile;
        } else {
            fallbackImage = fallback.image.desktop;
        }

        // Add type.
        advert += '<div class="' + fallback.identifier + ' ';

        $.each(classes,function(i, v) {
            advert += v;
            advert += (i < classes.length - 1) ? ' ' : '';
        });

        advert += '">';
        // Advert child div.
        advert += '<div class="' + fallback.classes.tuairisc + '">';
        // Advert anchor.
        advert += '<a href="' + fallback.link + '" target="_blank" title="' + fallback.title + '">';
        // Advert image.
        advert += '<img src="' + fallbackImage + '" alt="' + fallback.title + '" />';
        // Close anchor, parent and child div.
        advert += '</a></div></div>';

        return advert;
    }

    function replaceAdvert(advert) {
        var classes = $(advert).parent().attr('class').split(' '),
            display = $(advert).parent().css('display');

        $(advert).parent().replaceWith(fallbackAdvert(classes));
        $(advert).parent().hide();
    }

    function logReplacement(advert, error) {
        // TODO
        console.log(advert, error); 
    }

    $(ads.tuairisc).each(function() {
        /* 1. Replace advert with fallback if it doesn't exist.
         * 2. Remove entire advert if fallback fails to load.
         * 3. This should cause a cascade which will remove every advert if 
         *    Everything Goes Wrong. */
        var $advert = $(this),
            $image = $(this).find('img');

        $image.bind('error', function(error) {
            if (!$advert.hasClass('fallback')) {
                replaceAdvert($advert); 
                logReplacement($advert, error);
            } else {
                // If the fallback fails, all is lost.
                $advert.remove();
            }
        });
    });

    $.each(ads.groups.banner, function(k, v) {
        $(v).children('div').each(function() {
            var $advert = $(this),
                $image = $(this).find('img'),
                $src = $image.attr('src');

            $image.bind('load', function() {
                if ($src.indexOf(ads.suffix.mobile) == -1 && $src.indexOf(ads.suffix.desktop) == -1) {
                    replaceAdvert($advert);
                } else if ($('html').hasClass('mobile') && $src.indexOf(ads.suffix.mobile) === -1) {
                    $image.attr('src', $src.replace(new RegExp(ads.suffix.desktop, 'g'), ads.suffix.mobile));
                } else if (!$('html').hasClass('mobile') && $src.indexOf(ads.suffix.desktop) === -1) {
                    $image.attr('src', $src.replace(new RegExp(ads.suffix.mobile, 'g'), ads.suffix.desktop));
                }
            });
        });
    });
});