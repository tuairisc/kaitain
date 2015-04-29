/**
 * The Glorious Tuairisc JavaScript Functions
 * -----------------------------------------------------------------------------
 * @category   JavaScript File
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 *
 * This file is part of Nuacht.
 * 
 * Nuacht is free software: you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software 
 * Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Nuacht is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along with 
 * Nuacht. If not, see <http://www.gnu.org/licenses/>.
 */

 /* global jQuery:false */

/**
 * Variables
 * -----------------------------------------------------------------------------
 */

var sharing = {
    link: 'a.sharing-link',
    popouts : {
        facebook: 'width=450,height=257',
        google: 'width=500,height=300',
        twitter: 'width=470,height=260',
        pinterest: 'width=756,height=320',
        tumblr: 'width=470,height=470',
        newsletter: 'width=400,height=630'
    }
};

var header = {
    container: '#header',
    logo: '#header-logo'
};

/**
 * Functions
 * -----------------------------------------------------------------------------
 */

var scrollHeader = function() {
    var headerHeight = jQuery(header.logo).outerHeight();
    var scrollTop = jQuery(window).scrollTop();

    scrollTop = (scrollTop > headerHeight) ? headerHeight : scrollTop;
    jQuery(header.container).css('top', -scrollTop);
};

function popoutSharer(object, clickEvent) {
    var type = jQuery(object).data('type');

    if (sharing.popouts.hasOwnProperty(type)) {
        var href = jQuery(object).attr('href');
        var name = 'target="_blank';
        var size = sharing.popouts[type];
        
        window.open(href, name, size);
        clickEvent.preventDefault();
    }
}

/**
 * Site Navigation Menu
 * -----------------------------------------------------------------------------
 */

jQuery('#site').css('padding-top', jQuery(header.container).outerHeight());
jQuery(window).on('scroll', scrollHeader);

/**
 * Social Sharing Popouts
 * -----------------------------------------------------------------------------
 */

jQuery(sharing.link).click(function(click) {
    popoutSharer(this, click);
});