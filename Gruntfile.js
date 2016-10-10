/**
 * Gruntfile for compiling theme_essentialbe .less files.
 *
 * This file configures tasks to be run by Grunt
 * http://gruntjs.com/ for the current theme.
 *
 *
 * Requirements:
 * -------------
 * nodejs, npm, grunt-cli.
 *
 * Installation:
 * -------------
 * node and npm: instructions at http://nodejs.org/
 *
 * grunt-cli: `[sudo] npm install -g grunt-cli`
 *
 * node dependencies: run `npm install` in the root directory.
 *
 *
 * Usage:
 * ------
 * Call tasks from the theme root directory. Default behaviour
 * (calling only `grunt`) is to run the watch task detailed below.
 *
 *
 * Porcelain tasks:
 * ----------------
 * The nice user interface intended for everyday use. Provide a
 * high level of automation and convenience for specific use-cases.
 *
 * grunt watch   Watch the less directory (and all subdirectories)
 *               for changes to *.less files then on detection
 *               run 'grunt compile'
 *
 *               Options:
 *
 *               --dirroot=<path>  Optional. Explicitly define the
 *                                 path to your Moodle root directory
 *                                 when your theme is not in the
 *                                 standard location.
 * grunt compile Run the .less files through the compiler, create the
 *               RTL version of the output, then run decache so that
 *               the results can be seen on the next page load.
 *
 * Options:
 *
 *               --dirroot=<path>  Optional. Explicitly define the
 *                                 path to your Moodle root directory
 *                                 when your theme is not in the
 *                                 standard location.
 *
 *               --build=<type>    Optional. 'p'(default) or 'd'. If 'p'
 *                                 then 'production' CSS files.  If 'd'
 *                                 then 'development' CSS files unminified
 *                                 and with source map to less files.
 *
 *               --urlprefix=<path> Optional. Explicitly define
 *                                  the path between the domain
 *                                  and the installation in the
 *                                  URL, i.e. /moodle27 being:
 *                                  --urlprefix=/moodle27
 *
 * Plumbing tasks & targets:
 * -------------------------
 * Lower level tasks encapsulating a specific piece of functionality
 * but usually only useful when called in combination with another.
 *
 * grunt less         Compile all less files.
 *
 * grunt decache      Clears the Moodle theme cache.
 *
 *                    Options:
 *
 *                    --dirroot=<path>  Optional. Explicitly define
 *                                      the path to your Moodle root
 *                                      directory when your theme is
 *                                      not in the standard location.
 *
 * grunt replace             Run all text replace tasks.
 *
 * grunt svg                 Change the colour of the SVGs in pix_core by
 *                           text replacing #999999 with a new hex colour.
 *                           Note this requires the SVGs to be #999999 to
 *                           start with or the replace will do nothing
 *                           so should usually be preceded by copying
 *                           a fresh set of the original SVGs.
 *
 *                           Options:
 *
 *                           --svgcolour=<hexcolour> Hex colour to use for SVGs
 *
 * grunt cssflip    Create essentialbe-rtl.css by flipping the direction styles
 *                  in essentialbe.css.  Ref: https://www.npmjs.org/package/css-flip
 *
 *
 * @package theme
 * @subpackage essentialbe
 * @author G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author Based on code originally written by Joby Harding, Bas Brands, David Scotson and many other contributors. 
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

module.exports = function(grunt) {

    // Import modules.
    var path = require('path');

    // Theme Bootstrap constants.
    var LESSDIR         = 'less',
        MOODLEURLPREFIX = grunt.option('urlprefix') || '',
        THEMEDIR        = path.basename(path.resolve('.'));

    // Production / development.
    var build = grunt.option('build') || 'd'; // Development for 'watch' task.

    if ((build != 'p') && (build != 'd')) {
        build = 'p';
        console.log('-build switch only accepts \'p\' for production or \'d\' for development,');
        console.log('e.g. -build=p or -build=d.  Defaulting to development.');
    }

    decachephp = '../../admin/cli/purge_caches.php';

    var svgcolour = grunt.option('svgcolour') || '#999999';

    grunt.initConfig({
        less: {
            essentialbe_p: {
                options: {
                    compress: true,
                    cleancss: false,
                    paths: "./less",
                    report: 'min',
                    sourceMap: false,
                },
                src: 'less/essentialbe.less',
                dest: 'style/essentialbe.css'
            },
            editor_p: {
                options: {
                    compress: true,
                    cleancss: false,
                    paths: "./less",
                    report: 'min',
                    sourceMap: false,
                },
                src: 'less/editor.less',
                dest: 'style/editor.css'
            },
            moodle_rtl_p: {
                options: {
                    compress: true,
                    cleancss: false,
                    paths: "./less",
                    report: 'min',
                    sourceMap: false,
                },
                src: 'less/moodle-rtl.less',
                dest: 'style/moodle-rtl.css'
            },
            essentialbe_pix_p: {
                options: {
                    compress: true,
                    cleancss: false,
                    paths: "./less",
                    report: 'min',
                    sourceMap: false,
                },
                src: 'less/essentialbe-pix.less',
                dest: 'style/essentialbe-pix.css'
            },
            fontawesome_p: {
                options: {
                    compress: true,
                    cleancss: false,
                    paths: "./less",
                    report: 'min',
                    sourceMap: false,
                },
                src: 'less/fontawesome.less',
                dest: 'style/fontawesome.css'
            },
            settings_p: {
                options: {
                    compress: true,
                    cleancss: false,
                    paths: "./less",
                    report: 'min',
                    sourceMap: false,
                },
                src: 'less/settings.less',
                dest: 'style/settings.css'
            },
            alternative_p: {
                options: {
                    compress: true,
                    cleancss: false,
                    paths: "./less",
                    report: 'min',
                    sourceMap: false,
                },
                src: 'less/alternative.less',
                dest: 'style/alternative.css'
            },
            essentialbe_d: { // Flipped.
                options: {
                    compress: false,
                    cleancss: false,
                    paths: "./less",
                    report: 'min',
                    sourceMap: true,
                    sourceMapRootpath: MOODLEURLPREFIX + '/theme/' + THEMEDIR,
                    sourceMapFilename: 'style/essentialbe.treasure.map'
                },
                src: 'less/essentialbe.less',
                dest: 'style/essentialbe.css'
            },
            editor_d: {
                options: {
                    compress: false,
                    cleancss: false,
                    paths: "./less",
                    report: 'min',
                    sourceMap: true,
                    sourceMapRootpath: MOODLEURLPREFIX + '/theme/' + THEMEDIR,
                    sourceMapFilename: 'style/editor.treasure.map'
                },
                src: 'less/editor.less',
                dest: 'style/editor.css'
            },
            moodle_rtl_d: {
                options: {
                    compress: false,
                    cleancss: false,
                    paths: "./less",
                    report: 'min',
                    sourceMap: true,
                    sourceMapRootpath: MOODLEURLPREFIX + '/theme/' + THEMEDIR,
                    sourceMapFilename: 'style/moodle-rtl.treasure.map'
                },
                src: 'less/moodle-rtl.less',
                dest: 'style/moodle-rtl.css'
            },
            essentialbe_pix_d: {
                options: {
                    compress: false,
                    cleancss: false,
                    paths: "./less",
                    report: 'min',
                    sourceMap: true,
                    sourceMapRootpath: MOODLEURLPREFIX + '/theme/' + THEMEDIR,
                    sourceMapFilename: 'style/essentialbe-pix.treasure.map'
                },
                src: 'less/essentialbe-pix.less',
                dest: 'style/essentialbe-pix.css'
            },
            fontawesome_d: {
                options: {
                    compress: false,
                    cleancss: false,
                    paths: "./less",
                    report: 'min',
                    sourceMap: true,
                    sourceMapRootpath: MOODLEURLPREFIX + '/theme/' + THEMEDIR,
                    sourceMapFilename: 'style/fontawesome.treasure.map'
                },
                src: 'less/fontawesome.less',
                dest: 'style/fontawesome.css'
            },
            settings_d: {
                options: {
                    compress: false,
                    cleancss: false,
                    paths: "./less",
                    report: 'min',
                    sourceMap: true,
                    sourceMapRootpath: MOODLEURLPREFIX + '/theme/' + THEMEDIR,
                    sourceMapFilename: 'style/settings.treasure.map'
                },
                src: 'less/settings.less',
                dest: 'style/settings.css'
            },
            alternative_d: {
                options: {
                    compress: false,
                    cleancss: false,
                    paths: "./less",
                    report: 'min',
                    sourceMap: true,
                    sourceMapRootpath: MOODLEURLPREFIX + '/theme/' + THEMEDIR,
                    sourceMapFilename: 'style/alternative.treasure.map'
                },
                src: 'less/alternative.less',
                dest: 'style/alternative.css'
            }
        },
        exec: {
            decache: {
                cmd: 'php "' + decachephp + '"',
                callback: function(error, stdout, stderror) {
                    // exec will output error messages
                    // just add one to confirm success.
                    if (!error) {
                        grunt.log.writeln("Moodle theme cache reset.");
                    }
                }
            }
        },
        watch: {
            // Watch for any changes to less files and compile.
            files: ["less/**/*.less"],
            tasks: ["compile"],
            options: {
                spawn: false
            }
        },
        cssflip: {
            rtl_p: {
                options: {
                    compress: true
                },
                src:  'style/essentialbe.css',
                dest: 'style/essentialbe-rtl.css'
            },
            rtl_d: {
                options: {
                    compress: false
                },
                src:  'style/essentialbe.css',
                dest: 'style/essentialbe-rtl.css'
            }
        },
        copy: {
            svg_core: {
                 expand: true,
                 cwd:  'pix_core_originals/',
                 src:  '**',
                 dest: 'pix_core/',
            },
            svg_plugins: {
                 expand: true,
                 cwd:  'pix_plugins_originals/',
                 src:  '**',
                 dest: 'pix_plugins/',
            }
        },
        replace: {
            svg_colours_core: {
                src: 'pix_core/**/*.svg',
                    overwrite: true,
                    replacements: [{
                        from: '#999999',
                        to: svgcolour
                    }]
            },
            svg_colours_plugins: {
                src: 'pix_plugins/**/*.svg',
                    overwrite: true,
                    replacements: [{
                        from: '#999999',
                        to: svgcolour
                    }]
            }
        },
        svgmin: {
            options: {
                plugins: [{
                    removeViewBox: false
                }, {
                    removeUselessStrokeAndFill: false
                }, {
                    convertPathData: { 
                        straightCurves: false
                   }
                }]
            },
            dist: {
                files: [{
                    expand: true,
                    cwd: 'pix_core',
                    src: ['**/*.svg'],
                    dest: 'pix_core/',
                    ext: '.svg'
                }, {
                    expand: true,
                    cwd: 'pix_plugins',
                    src: ['**/*.svg'],
                    dest: 'pix_plugins/',
                    ext: '.svg'
                }]
            }
        }
    });

    // Load contrib tasks.
    grunt.loadNpmTasks("grunt-contrib-less");
    grunt.loadNpmTasks("grunt-contrib-watch");
    grunt.loadNpmTasks("grunt-exec");
    grunt.loadNpmTasks("grunt-text-replace");
    grunt.loadNpmTasks("grunt-css-flip");
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-svgmin');

    // Register tasks.
    grunt.registerTask("default", ["watch"]);
    grunt.registerTask("decache", ["exec:decache"]);

    grunt.registerTask("css", ["less:essentialbe_"+build, "less:editor_"+build, "less:moodle_rtl_"+build, "less:settings_"+build, "less:essentialbe_pix_"+build, "less:fontawesome_"+build, "less:alternative_"+build]);
    grunt.registerTask("compile", ["css", "cssflip:rtl_"+build, "decache"]);
    grunt.registerTask("copy:svg", ["copy:svg_core", "copy:svg_plugins"]);
    grunt.registerTask("replace:svg_colours", ["replace:svg_colours_core", "replace:svg_colours_plugins"]);
    grunt.registerTask("svg", ["copy:svg", "replace:svg_colours", "svgmin"]);
};
