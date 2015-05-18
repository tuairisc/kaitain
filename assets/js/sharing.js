/**
 * Sharing Popouts
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
 * Social Sharing Popouts
 * -----------------------------------------------------------------------------
 * Manage and size popout windows for included social sharing links.
 *
 * @param   event   click           Click event.
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

jQuery(sharing.link).click(function(click) {
    var type = jQuery(this).data('type');

    if (sharing.popouts.hasOwnProperty(type)) {
        var href = jQuery(this).attr('href');
        var name = 'target="_blank';
        var size = sharing.popouts[type];
        
        window.open(href, name, size);
        click.preventDefault();
    }
});