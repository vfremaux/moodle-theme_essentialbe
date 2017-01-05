YUI.add('moodle-theme_essentialbe-coloursswitcher', function (Y) {

// Available color schemes.
    var SCHEMES = ['default', 'alternative1', 'alternative2', 'alternative3'];

    /**
     * Essential theme colours switcher class.
     * Initialise this class by calling M.theme_essentialbe.init
     */
    var ColoursSwitcher = function () {
        ColoursSwitcher.superclass.constructor.apply(this, arguments);
    };
    ColoursSwitcher.prototype = {
        /**
         * Constructor for this class
         * @param {object} config
         */
        initializer: function (config) {
            var i, s;
            // Attach events to the links to change colours scheme so we can do it with
            // JavaScript without refreshing the page.
            for (i in SCHEMES) {
                s = SCHEMES[i];
                // Check if this is the current colour.
                if (Y.one(document.body).hasClass('essentialbe-colours-' + s)) {
                    this.set('scheme', s);
                }
                Y.all(config.div + ' .colours-' + s).each(function (node) {
                    node.ancestor().on('click', this.setScheme, this, s);
                }, this);
            }
        },
        /**
         * Sets the colour being used for the essentialbe theme
         * @param {Y.Event} e The event that fired
         * @param {string} colours The new colours scheme
         */
        setScheme: function (e, scheme) {
            // Prevent the event from refreshing the page.
            e.preventDefault();
            // Switch over the CSS classes on the body.
            var prefix = 'essentialbe-colours-';
            Y.one(document.body).replaceClass(prefix + this.get('scheme'), prefix + scheme);
            // Update the current colour.
            this.set('scheme', scheme);
            // Store the users selection (Uses AJAX to save to the database).
            M.util.set_user_preference('theme_essentialbe_colours', scheme);
        }
    };
// Make the colours switcher a fully fledged YUI module.
    Y.extend(ColoursSwitcher, Y.Base, ColoursSwitcher.prototype, {
        NAME: 'Essential theme colours scheme switcher',
        ATTRS: {
            scheme: {
                value: 'default'
            }
        }
    });
// Our Essential theme namespace
    M.theme_essentialbe = M.theme_essentialbe || {};
// Initialisation function for the colours scheme switcher
    M.theme_essentialbe.initColoursSwitcher = function (cfg) {
        return new ColoursSwitcher(cfg);
    }

}, '@VERSION@', {requires: ['base', 'node']});
