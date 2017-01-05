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

/* Default globals */
global $CFG, $PAGE, $USER, $SITE, $COURSE;

/* Group Body */
$bodyclasses = array();

if (theme_essentialbe_get_setting('enablealternativethemecolors1') ||
    theme_essentialbe_get_setting('enablealternativethemecolors2') ||
    theme_essentialbe_get_setting('enablealternativethemecolors3')
) {
    $colourswitcher = true;
    theme_essentialbe_check_colours_switch();
    theme_essentialbe_initialise_colourswitcher($PAGE);
    $bodyclasses[]  = 'essentialbe-colours-' . theme_essentialbe_get_colours();
} else {
    $colourswitcher = false;
}

switch (theme_essentialbe_get_setting('pagewidth')) {
    case 100:
        $bodyclasses[] = 'pagewidthvariable';
        break;
    case 960:
        $bodyclasses[] = 'pagewidthnarrow';
        break;
    case 1200:
        $bodyclasses[] = 'pagewidthnormal';
        break;
    case 1400:
        $bodyclasses[] = 'pagewidthwide';
        break;
}
if (!empty($CFG->custommenuitems)) {
    $bodyclasses[] = 'custommenuitems';
}
if (theme_essentialbe_get_setting('enablecategoryicon')) {
    $bodyclasses[] = 'categoryicons';
}

if (($PAGE->pagelayout == 'course') && (get_config('core', 'modeditingmenu'))) {
    $bodyclasses[] = 'modeditingmenu';
}

$regionbsid = 'region-bs-main-and-pre';
$left = true;
if (right_to_left()) {
    $regionbsid = 'region-bs-main-and-pre';
    $left = false;
}

$fontselect = theme_essentialbe_get_setting('fontselect');
$fontcharacterset = '&subset=latin';
if(theme_essentialbe_get_setting('fontcharacterset')) {
    $fontcharacterset = '&subset=latin,'.theme_essentialbe_get_setting('fontcharacterset');
}
$headingfont = urlencode(theme_essentialbe_get_setting('fontnameheading'));
$bodyfont = urlencode(theme_essentialbe_get_setting('fontnamebody'));


/* Group Header */
$hassocialnetworks = (
    theme_essentialbe_get_setting('facebook') ||
    theme_essentialbe_get_setting('twitter') ||
    theme_essentialbe_get_setting('googleplus') ||
    theme_essentialbe_get_setting('linkedin') ||
    theme_essentialbe_get_setting('youtube') ||
    theme_essentialbe_get_setting('flickr') ||
    theme_essentialbe_get_setting('vk') ||
    theme_essentialbe_get_setting('pinterest') ||
    theme_essentialbe_get_setting('instagram') ||
    theme_essentialbe_get_setting('skype') ||
    theme_essentialbe_get_setting('website')
);
$hasmobileapps = (theme_essentialbe_get_setting('ios') ||
    theme_essentialbe_get_setting('android')
);

$logoclass = 'ecol12';
if ($hassocialnetworks || $hasmobileapps) {
    $logoclass = 'ecol8';
}

$oldnavbar = theme_essentialbe_get_setting('oldnavbar');
$haslogo = theme_essentialbe_get_setting('logo');

/* Group Content */
$hasboringlayout = theme_essentialbe_get_setting('layout');

/* Group Report Page Title */
function essentialbe_report_page_has_title() {
    global $PAGE;
    $hastitle = true;

    switch ($PAGE->pagetype) {
        case 'grade-report-overview-index':
            $hastitle = false;
            break;
        default: break;
    }

    return $hastitle;
}

/* Group Page Footer Region */
function essentialbe_has_footer_region() {
    global $PAGE;
    $hasregion = false;

    switch ($PAGE->pagetype) {
        case 'mod-quiz-edit':
            $hasregion = true;
            break;
        default: break;
    }

    return $hasregion;
}

/* Group Footer */
$hascopyright = theme_essentialbe_get_setting('copyright', true);
$hasfootnote = theme_essentialbe_get_setting('footnote', 'format_text');

/* Group Breadcrumb */
$breadcrumbstyle = theme_essentialbe_get_setting('breadcrumbstyle');
