/**
 * Essential is a clean and customizable theme.
 *
 * @package     theme_essentialbe
 * @copyright   2016 Gareth J Barnard
 * @copyright   2015 Gareth J Barnard
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/* jshint ignore:start */
define(['jquery', 'core/log'], function($, log) {

    "use strict"; // jshint ;_;

    log.debug('Essential header AMD');

    return {
        init: function() {
            $(document).ready(function($) {
                if (($('#page-header .titlearea').length) && ($('#essentialbeicons').length)) {
                    var titlearea = $('#page-header .titlearea');
                    $('#essentialbeicons').on('hide', function() {
                        titlearea.fadeIn();
                    });
                    $('#essentialbeicons').on('show', function() {
                        titlearea.fadeOut();
                    });
                }
            });
            log.debug('Essential header AMD init');
        }
    }
});
/* jshint ignore:end */
