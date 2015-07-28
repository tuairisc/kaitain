'use strict';

objectFit.polyfill({
    selector: 'img.cover-fit', 
    fittype: 'cover', 
    disableCrossDomain: 'false' 
});

jQuery('a.submenu-toggle').click(function() {
    jQuery(this).toggleClass('open');
    jQuery('#secondary').toggleClass('open');
});

console.log('asdadaad');
