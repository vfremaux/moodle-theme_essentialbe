<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This is built using the bootstrapbase template to allow for new theme's using
 * Moodle's new Bootstrap theme engine
 *
 * @package     theme_essentialbe
 * @copyright   2013 Julian Ridden
 * @copyright   2014 Gareth J Barnard, David Bezemer
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$THEME->name = 'essentialbe';

// The only thing you need to change in this file when copying it to
// create a new theme is the name above. You also need to change the name
// in version.php and lang/en/theme_essentialbe.php as well.

$THEME->doctype = 'html5';
$THEME->yuicssmodules = array();
$THEME->parents = array();

$THEME->sheets[] = 'moodle-rtl';
$THEME->sheets[] = 'essentialbe-pix';
$THEME->sheets[] = 'settings';
$THEME->sheets[] = 'fontawesome';

if ((get_config('theme_essentialbe', 'enablealternativethemecolors1')) ||
    (get_config('theme_essentialbe', 'enablealternativethemecolors2')) ||
    (get_config('theme_essentialbe', 'enablealternativethemecolors3'))
) {
    $THEME->sheets[] = 'alternative';
}

$THEME->supportscssoptimisation = false;

if (floatval($CFG->version) >= 2013111803.02) { // 2.6.3+ (Build: 20140522) which has MDL-43995 integrated into it.
    $THEME->enable_dock = true;
    $THEME->javascripts_footer[] = 'dock';
}

$THEME->editor_sheets = array('editor');

$THEME->sheets[] = 'customlabels';
$THEME->sheets[] = 'edunaobe';
$THEME->sheets[] = 'custom';

$THEME->plugins_exclude_sheets = array('mod' => array('quiz'));

$addregions = array();
if (get_config('theme_essentialbe', 'frontpagemiddleblocks') > 0) {
    $addregions = array('home-left', 'home-middle', 'home-right');
}


$THEME->layouts = array(
    // Most backwards compatible layout without the blocks - this is the layout used by default.
    'base' => array(
        'file' => 'columns1.php',
        'regions' => array('footer-left', 'footer-middle', 'footer-right'),
        'defaultregion' => '',
    ),
    // Front page.
    'frontpage' => array(
        'file' => 'frontpage.php',
        'regions' => array_merge(array('side-pre', 'footer-left', 'footer-middle', 'footer-right', 'hidden-dock'), $addregions),
        'defaultregion' => 'side-pre',
    ),
    // Standard layout with blocks, this is recommended for most pages with general information.
    'standard' => array(
        'file' => 'columns2.php',
        'regions' => array('side-pre', 'footer-left', 'footer-middle', 'footer-right'),
        'defaultregion' => 'side-pre',
    ),
    // Standard layout with blocks, this is recommended for most pages with general information.
    'message-index' => array(
        'file' => 'columns2.php',
        'regions' => array('side-pre', 'footer-left', 'footer-middle', 'footer-right'),
        'defaultregion' => 'side-pre',
    ),
    // Main course page.
    'course' => array(
        'file' => 'columns3.php',
        'regions' => array('side-pre', 'side-post', 'footer-left', 'footer-middle', 'footer-right'),
        'defaultregion' => 'side-post',
    ),
    'coursecategory' => array(
        'file' => 'columns2.php',
        'regions' => array('side-pre', 'footer-left', 'footer-middle', 'footer-right'),
        'defaultregion' => 'side-pre',
    ),
    // part of course, typical for modules - default page layout if $cm specified in require_login().
    'incourse' => array(
        'file' => 'columns2.php',
        'regions' => array('side-pre', 'footer-left', 'footer-middle', 'footer-right'),
        'defaultregion' => 'side-pre',
    ),
    // Server administration scripts.
    'admin' => array(
        'file' => 'admin.php',
        'regions' => array('side-pre', 'footer-left', 'footer-middle', 'footer-right'),
        'defaultregion' => 'side-pre',
    ),
    // My dashboard page.
    'mydashboard' => array(
        'file' => 'columns3.php',
        'regions' => array('side-pre', 'side-post', 'footer-left', 'footer-middle', 'footer-right'),
        'defaultregion' => 'side-post',
    ),
    // My public page.
    'mypublic' => array(
        'file' => 'columns3.php',
        'regions' => array('side-pre', 'side-post', 'footer-left', 'footer-middle', 'footer-right'),
        'defaultregion' => 'side-post',
    ),
    'login' => array(
        'file' => 'login.php',
        'regions' => array('footer-left', 'footer-middle', 'footer-right'),
        'defaultregion' => '',
    ),

    // Pages that appear in pop-up windows - no navigation, no blocks, no header.
    'popup' => array(
        'file' => 'popup.php',
        'regions' => array(),
        'options' => array('nofooter' => true, 'nonavbar' => true),
    ),
    // No blocks and minimal footer - used for legacy frame layouts only!
    'frametop' => array(
        'file' => 'columns1.php',
        'regions' => array('footer-left', 'footer-middle', 'footer-right'),
        'defaultregion' => 'footer-right',
        'options' => array('nofooter' => true, 'nocoursefooter' => true),
    ),
    // Embeded pages, like iframe/object embeded in moodleform - it needs as much space as possible.
    'embedded' => array(
        'file' => 'embedded.php',
        'regions' => array(),
        'defaultregion' => '',
    ),
    // Used during upgrade and install, and for the 'This site is undergoing maintenance' message.
    // This must not have any blocks, links, or API calls that would lead to database or cache interaction.
    // Please be extremely careful if you are modifying this layout.
    'maintenance' => array(
        'file' => 'maintenance.php',
        'regions' => array(),
        'defaultregion' => '',
    ),
    // Should display the content and basic headers only.
    'print' => array(
        'file' => 'columns1.php',
        'regions' => array('footer-left', 'footer-middle', 'footer-right'),
        'defaultregion' => '',
        'options' => array('nofooter' => true),
    ),
    // The pagelayout used when a redirection is occuring.
    'redirect' => array(
        'file' => 'redirect.php',
        'regions' => array(),
        'defaultregion' => '',
    ),
    // The pagelayout used for reports.
    'report' => array(
        'file' => 'report.php',
        'regions' => array('side-pre', 'footer-left', 'footer-middle', 'footer-right'),
        'defaultregion' => 'side-pre',
    ),
    // The pagelayout used for safebrowser and securewindow.
    'secure' => array(
        'file' => 'secure.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-pre'
    ),
    'format_page' => array(
        'file' => 'page.php',
        'regions' => array('side-pre', 'main', 'side-post'),
        'defaultregion' => 'side-post', // avoid putting in main, or standard course will fail showing the new block menu 
        'options' => array('langmenu' => true)
    ),

    'format_page_action' => array(
        'file' => 'page.php',
        'regions' => array(),
        'options' => array('langmenu' => true, 'noblocks' => true),
    ),
);

$THEME->javascripts_footer[] = 'coloursswitcher';

$THEME->rendererfactory = 'theme_overridden_renderer_factory';
$THEME->csspostprocess = 'theme_essentialbe_process_css';