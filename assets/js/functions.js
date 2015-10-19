/**
 * Template JS Functions
 * -----------------------------------------------------------------------------
 * @category   JavaScript
 * @package    Kaitain
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  Copyright (c) 2014-2015, Tuairisc Bheo Teo
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU GPL v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/kaitain-theme
 * @link       http://www.tuairisc.ie
 */

;(function($, window, document) {
    /**
     * Knockout Search State Directive
     * -------------------------------------------------------------------------
     */

    var searchDisplay = function(initialState) {
        var self = this;

        self.searchOpen = ko.observable(initialState);

        self.toggleSearch = function() {
            self.searchOpen(!self.searchOpen());
        }
    };

    ko.applyBindings(new searchDisplay(false));
})(jQuery, window, document);
