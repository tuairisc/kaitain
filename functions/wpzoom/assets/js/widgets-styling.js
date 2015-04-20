/**
 * Add Widget Styling Class
 * ------------------------
 * Add extra class to theme widgets for styling purposes.
 * 
 * @category   WordPress File
 * @package    Tuairisc.ie Theme
 * @author     Mark Grealish <mark@bhalash.com>
 * @copyright  2014-2015 Mark Grealish
 * @license    https://www.gnu.org/copyleft/gpl.html The GNU General Public License v3.0
 * @version    2.0
 * @link       https://github.com/bhalash/tuairisc.ie
 */

jQuery(function(e){var t={regex:/wpzoom/,type:".widget",newType:"wpz_widget_style"}
e(t.type).each(function(p,n){var r=e(n),w=r.prop("id")
t.regex.text(w)&&r.addClass(t.newType)})})