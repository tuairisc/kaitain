/* global $:false */

jQuery(window).ready(function($) {
    /*
     * AdRotate Fallback
     * -----------------
     * If an advertisement errors or otherwise fails to display, replce it with
     * a fallback. If the fallback fails, remove the advert entirely. 
     */
    'use strict';

    var fallback = {
        /* 
         * Fallback Attributes
         * -------------------
         * Target link and images related to the fallback advertisement.
         */
        identifier: 'fallback',
        id: 0,
        title: 'Tuairisc',
        link: '//' + window.location.hostname + '/glac-fograi-linn/',
        image: {
            mobile: '//' + window.location.hostname + '/wp-content/uploads/tuairisc_fallback_mobile_.gif', 
            desktop: '//' + window.location.hostname + '/wp-content/uploads/tuairisc_fallback_desktop_.gif'
        },
        classes: {
            dynamic: 'g-dyn',
            tuairisc: 'tuairisc-advert',
            desktop: 'desktop',
            mobile: 'mobile'
        }
    };

    function fallbackAdvert(classes) {
        /*
         * Fallback Advert
         * ---------------
         * Generate HTML for the fallback advert.
         */

        var advert = '', fallbackImage = '';
        // Monsensical number that be used for an advert, to avoid false impressions.
        classes[1] = 'a-0000000';

        advert += '<div id="' + fallback.identifier + '-' + fallback.id + '" '; 
        advert += 'class="' + fallback.identifier + ' ';

        $.each(classes,function(i, v) {
            advert += v;
            advert += (i < classes.length - 1) ? ' ' : '';
        });

        advert += '">';
        // Advert anchor.
        advert += '<a class="' + fallback.classes.tuairisc + '" href="' + fallback.link + '" target="_blank" title="' + fallback.title + '">';
        // Advert image.
        advert += '<img class="' + fallback.classes.desktop + '" src="' + fallback.image.desktop + '" alt="' + fallback.title + '" />';
        advert += '<img class="' + fallback.classes.mobile + '" src="' + fallback.image.mobile + '" alt="' + fallback.title + '" />';
        // Close anchor, parent and child div.
        advert += '</a></div>';

        return advert;
    }

    function replaceAdvert(advert) {
        var classes = $(advert).parent().attr('class').split(' '),
            display = $(advert).parent().css('display');

        $(advert).parent().replaceWith(fallbackAdvert(classes));
        /* New advertisement should inherit the display of the old, in case it is
         * is a dyngroup. */
        $(fallback.identifier + '-' + fallback.id++).hide();
    }

    $('.' + fallback.classes.tuairisc).children('img').each(function() {
        /* 1. Replace advert with fallback if it doesn't exist.
         * 2. Remove entire advert if fallback fails to load.
         * 3. This should cause a cascade which will remove every advert if 
         *    Everything Goes Wrong.

         *    TODO:
         * 4. Log failure details to the console if the viewer is logged in.
         * 5. Display errors on the page. */

        $(this).bind('error', function(error) {
            var $advert = $(this).parent();

            // TODO
            console.log(error, $advert);

            if (!$advert.hasClass('fallback')) {
                replaceAdvert($advert); 
            } else {
                // If the fallback fails, all is lost.
                $advert.remove();
            }
        });
    });
});