/* global $:false */

jQuery(function($) {
    'use strict';

    var ads = {
        group: '.g',
        bannerGroups: [ '.g-1', '.g-3' ],
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

    $.fn.extend({
        loaded: function() {
            // Check if image exists.
            console.log($(this).error());
            return true;
        }
    });

    function fallbackAdvert(classes) {
        /*
         * Fallback Advert
         * ---------------
         * Generate fallback advert on occasions where it is required within a 
         * group.
         */

        var fallback = {
            link: '//' + window.location.hostname + '/catnip.bhalash.com/glac-fograi-linn/',
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

        // Advert wrapper div and repalcement image.
        var advert = '<div class="', fallbackImage = '';

        if ($('html').hasClass('mobile')) {
            fallbackImage = fallback.image.mobile;
        } else {
            fallbackImage = fallback.image.desktop;
        }

        $.each(classes,function(i, v) {
            advert += v + ' ';
        });

        // Add type.
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
        var classes = $(advert).attr('class').split(' ');
        console.log(classes);
        $(advert).replaceWith(fallbackAdvert(classes));
    }

    $.each(ads.bannerGroups, function(i, v) {
        $(v).children('div').each(function() {
            var $advert = $(this);
            var $image = $(this).find('img');
            var src = $image.attr('src');

            // $image.error(function() {
            //     replaceAdvert($advert);
            // }).;

            $image.bind('error', function() {
                replaceAdvert($advert);
            })

            // if (src.indexOf(ads.suffix.mobile) === -1 && src.indexOf(ads.suffix.desktop) === -1) {
            //     // Replace advert entirely if it doesn't have either appropriate suffix.
            //     replaceAdvert($advert);
            // } else if ($('html').hasClass('mobile') && src.indexOf(ads.suffix.mobile) === -1) {
            //     // Swap desktop image for mobile. 
            //     // If replacement image does not exist, repalce advert.
            // } else if (!$('html').hasClass('mobile') && src.indexOf(ads.suffix.desktop) === -1) {
            //     // Swap mobile image for desktop.
            //     // If replacement image does not exist, repalce advert.
            // } else {
            //     // Test if image as-is exists, and if necessary, replace advert.
            //     // If image does not exist, replace advert.
            // }
        });
    });
});