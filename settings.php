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
 * Essential is a clean and customizable theme.
 *
 * @package     theme_essentialbe
 * @copyright   2016 Gareth J Barnard
 * @copyright   2015 Gareth J Barnard
 * @copyright   2014 Gareth J Barnard, David Bezemer
 * @copyright   2013 Julian Ridden
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;
$settings = null; // Unsets the default $settings object initialised by Moodle.

// Create own category and define pages.
$ADMIN->add('themes', new admin_category('theme_essentialbe', 'Essential Business'));

// Generic settings.
$essentialbesettingsgeneric = new admin_settingpage('theme_essentialbe_generic', get_string('genericsettings', 'theme_essentialbe'));
// Initialise individual settings only if admin pages require them.
if ($ADMIN->fulltree) {
    global $CFG;
    if (file_exists("{$CFG->dirroot}/theme/essentialbe/essentialbe_admin_setting_configselect.php")) {
        require_once($CFG->dirroot . '/theme/essentialbe/essentialbe_admin_setting_configselect.php');
        require_once($CFG->dirroot . '/theme/essentialbe/essentialbe_admin_setting_configinteger.php');
    } else if (!empty($CFG->themedir) && file_exists("{$CFG->themedir}/essentialbe/essentialbe_admin_setting_configselect.php")) {
        require_once($CFG->themedir . '/essentialbe/essentialbe_admin_setting_configselect.php');
        require_once($CFG->themedir . '/essentialbe/essentialbe_admin_setting_configinteger.php');
    }

    $sponsor = new moodle_url('http://moodle.org/user/profile.php?id=442195');
    $sponsor = html_writer::link($sponsor, get_string('paypal_click', 'theme_essentialbe'), array('target' => '_blank'));

    $flattr = new moodle_url('https://flattr.com/profile/gjb2048');
    $flattr = html_writer::link($flattr, get_string('flattr_click', 'theme_essentialbe'), array('target' => '_blank'));

    $essentialbesettingsgeneric->add(new admin_setting_heading('theme_essentialbe_generalsponsor',
        get_string('sponsor_title', 'theme_essentialbe'),
        get_string('sponsor_desc', 'theme_essentialbe') . get_string('paypal_desc', 'theme_essentialbe',
            array('url' => $sponsor)).get_string('flattr_desc', 'theme_essentialbe',
            array('url' => $flattr)).get_string('sponsor_desc2', 'theme_essentialbe')));

    $essentialbesettingsgeneric->add(new admin_setting_heading('theme_essentialbe_generalheading',
        get_string('generalheadingsub', 'theme_essentialbe'),
        format_text(get_string('generalheadingdesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    // Page background image.
    $name = 'theme_essentialbe/pagebackground';
    $title = get_string('pagebackground', 'theme_essentialbe');
    $description = get_string('pagebackgrounddesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'pagebackground');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsgeneric->add($setting);

    // Background style.
    $name = 'theme_essentialbe/pagebackgroundstyle';
    $title = get_string('pagebackgroundstyle', 'theme_essentialbe');
    $description = get_string('pagebackgroundstyledesc', 'theme_essentialbe');
    $default = 'fixed';
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default,
        array(
            'fixed' => get_string('stylefixed', 'theme_essentialbe'),
            'tiled' => get_string('styletiled', 'theme_essentialbe'),
            'stretch' => get_string('stylestretch', 'theme_essentialbe')
        )
    );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsgeneric->add($setting);

    // Fixed or variable width.
    $name = 'theme_essentialbe/pagewidth';
    $title = get_string('pagewidth', 'theme_essentialbe');
    $description = get_string('pagewidthdesc', 'theme_essentialbe');
    $default = 1200;
    $choices = array(
        960 => get_string('fixedwidthnarrow', 'theme_essentialbe'),
        1200 => get_string('fixedwidthnormal', 'theme_essentialbe'),
        1400 => get_string('fixedwidthwide', 'theme_essentialbe'),
        100 => get_string('variablewidth', 'theme_essentialbe'));
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsgeneric->add($setting);

    // Page top blocks per row.
    $name = 'theme_essentialbe/pagetopblocksperrow';
    $title = get_string('pagetopblocksperrow', 'theme_essentialbe');
    $default = 1;
    $lower = 1;
    $upper = 4;
    $description = get_string('pagetopblocksperrowdesc', 'theme_essentialbe',
        array('lower' => $lower, 'upper' => $upper));
    $setting = new essentialbe_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
    $essentialbesettingsgeneric->add($setting);

    // Page bottom blocks per row.
    $name = 'theme_essentialbe/pagebottomblocksperrow';
    $title = get_string('pagebottomblocksperrow', 'theme_essentialbe');
    $default = 4;
    $lower = 1;
    $upper = 4;
    $description = get_string('pagebottomblocksperrowdesc', 'theme_essentialbe',
        array('lower' => $lower, 'upper' => $upper));
    $setting = new essentialbe_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
    $essentialbesettingsgeneric->add($setting);

    // Custom favicon.
    $name = 'theme_essentialbe/favicon';
    $title = get_string('favicon', 'theme_essentialbe');
    $description = get_string('favicondesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsgeneric->add($setting);

    // Custom CSS file.
    $name = 'theme_essentialbe/customcss';
    $title = get_string('customcss', 'theme_essentialbe');
    $description = get_string('customcssdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsgeneric->add($setting);

    $readme = new moodle_url('/theme/essentialbe/README.txt');
    $readme = html_writer::link($readme, get_string('readme_click', 'theme_essentialbe'), array('target' => '_blank'));

    $essentialbesettingsgeneric->add(new admin_setting_heading('theme_essentialbe_generalreadme',
        get_string('readme_title', 'theme_essentialbe'), get_string('readme_desc', 'theme_essentialbe', array('url' => $readme))));
}
$ADMIN->add('theme_essentialbe', $essentialbesettingsgeneric);

// Feature settings.
$essentialbesettingsfeature = new admin_settingpage('theme_essentialbe_feature', get_string('featureheading', 'theme_essentialbe'));
if ($ADMIN->fulltree) {
    global $CFG;
    if (file_exists("{$CFG->dirroot}/theme/essentialbe/essentialbe_admin_setting_configinteger.php")) {
        require_once($CFG->dirroot . '/theme/essentialbe/essentialbe_admin_setting_configinteger.php');
    } else if (!empty($CFG->themedir) && file_exists("{$CFG->themedir}/essentialbe/essentialbe_admin_setting_configinteger.php")) {
        require_once($CFG->themedir . '/essentialbe/essentialbe_admin_setting_configinteger.php');
    }

    $essentialbesettingsfeature->add(new admin_setting_heading('theme_essentialbe_feature',
        get_string('featureheadingsub', 'theme_essentialbe'),
        format_text(get_string('featuredesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    // Course content search.
    $name = 'theme_essentialbe/coursecontentsearch';
    $title = get_string('coursecontentsearch', 'theme_essentialbe');
    $description = get_string('coursecontentsearchdesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfeature->add($setting);

    // Custom scrollbars.
    $name = 'theme_essentialbe/customscrollbars';
    $title = get_string('customscrollbars', 'theme_essentialbe');
    $description = get_string('customscrollbarsdesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfeature->add($setting);

    // Fitvids.
    $name = 'theme_essentialbe/fitvids';
    $title = get_string('fitvids', 'theme_essentialbe');
    $description = get_string('fitvidsdesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfeature->add($setting);

    // Floating submit buttons.
    $name = 'theme_essentialbe/floatingsubmitbuttons';
    $title = get_string('floatingsubmitbuttons', 'theme_essentialbe');
    $description = get_string('floatingsubmitbuttonsdesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $essentialbesettingsfeature->add($setting);

    // Custom or standard layout.
    $name = 'theme_essentialbe/layout';
    $title = get_string('layout', 'theme_essentialbe');
    $description = get_string('layoutdesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfeature->add($setting);

    // Categories in the course breadcrumb.
    $name = 'theme_essentialbe/categoryincoursebreadcrumbfeature';
    $title = get_string('categoryincoursebreadcrumbfeature', 'theme_essentialbe');
    $description = get_string('categoryincoursebreadcrumbfeaturedesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $essentialbesettingsfeature->add($setting);

    // Return to section.
    $name = 'theme_essentialbe/returntosectionfeature';
    $title = get_string('returntosectionfeature', 'theme_essentialbe');
    $description = get_string('returntosectionfeaturedesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $essentialbesettingsfeature->add($setting);

    // Return to section name text limit.
    $name = 'theme_essentialbe/returntosectiontextlimitfeature';
    $title = get_string('returntosectiontextlimitfeature', 'theme_essentialbe');
    $default = 15;
    $lower = 5;
    $upper = 40;
    $description = get_string('returntosectiontextlimitfeaturedesc', 'theme_essentialbe',
        array('lower' => $lower, 'upper' => $upper));
    $setting = new essentialbe_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
    $essentialbesettingsfeature->add($setting);

    // Login background image.
    $name = 'theme_essentialbe/loginbackground';
    $title = get_string('loginbackground', 'theme_essentialbe');
    $description = get_string('loginbackgrounddesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginbackground');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfeature->add($setting);

    // Login background style.
    $name = 'theme_essentialbe/loginbackgroundstyle';
    $title = get_string('loginbackgroundstyle', 'theme_essentialbe');
    $description = get_string('loginbackgroundstyledesc', 'theme_essentialbe');
    $default = 'cover';
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default,
        array(
            'cover' => get_string('stylecover', 'theme_essentialbe'),
            'stretch' => get_string('stylestretch', 'theme_essentialbe')
        )
    );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfeature->add($setting);

        $opactitychoices = array(
            '0.0' => '0.0',
            '0.1' => '0.1',
            '0.2' => '0.2',
            '0.3' => '0.3',
            '0.4' => '0.4',
            '0.5' => '0.5',
            '0.6' => '0.6',
            '0.7' => '0.7',
            '0.8' => '0.8',
            '0.9' => '0.9',
            '1.0' => '1.0'
        );

        // Overridden course title text background opacity setting.
        $name = 'theme_essentialbe/loginbackgroundopacity';
        $title = get_string('loginbackgroundopacity', 'theme_essentialbe');
        $description = get_string('loginbackgroundopacitydesc', 'theme_essentialbe');
        $default = '0.8';
        $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $opactitychoices);
        $essentialbesettingsfeature->add($setting);

        $essentialbesettingsfeature->add(new admin_setting_heading('theme_essentialbe_featurereadme',
        get_string('readme_title', 'theme_essentialbe'), get_string('readme_desc', 'theme_essentialbe', array('url' => $readme))));
}
$ADMIN->add('theme_essentialbe', $essentialbesettingsfeature);

// Colour settings.
$essentialbesettingscolour = new admin_settingpage('theme_essentialbe_colour', get_string('colorheading', 'theme_essentialbe'));
if ($ADMIN->fulltree) {
    $essentialbesettingscolour->add(new admin_setting_heading('theme_essentialbe_colour',
        get_string('colorheadingsub', 'theme_essentialbe'),
        format_text(get_string('colordesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    // Main theme colour setting.
    $name = 'theme_essentialbe/themecolor';
    $title = get_string('themecolor', 'theme_essentialbe');
    $description = get_string('themecolordesc', 'theme_essentialbe');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Main theme text colour setting.
    $name = 'theme_essentialbe/themetextcolor';
    $title = get_string('themetextcolor', 'theme_essentialbe');
    $description = get_string('themetextcolordesc', 'theme_essentialbe');
    $default = '#217a94';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Main theme link colour setting.
    $name = 'theme_essentialbe/themeurlcolor';
    $title = get_string('themeurlcolor', 'theme_essentialbe');
    $description = get_string('themeurlcolordesc', 'theme_essentialbe');
    $default = '#943b21';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Main theme hover colour setting.
    $name = 'theme_essentialbe/themehovercolor';
    $title = get_string('themehovercolor', 'theme_essentialbe');
    $description = get_string('themehovercolordesc', 'theme_essentialbe');
    $default = '#6a2a18';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Icon colour setting.
    $name = 'theme_essentialbe/themeiconcolor';
    $title = get_string('themeiconcolor', 'theme_essentialbe');
    $description = get_string('themeiconcolordesc', 'theme_essentialbe');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Default button text colour setting.
    $name = 'theme_essentialbe/themedefaultbuttontextcolour';
    $title = get_string('themedefaultbuttontextcolour', 'theme_essentialbe');
    $description = get_string('themedefaultbuttontextcolourdesc', 'theme_essentialbe');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Default button text hover colour setting.
    $name = 'theme_essentialbe/themedefaultbuttontexthovercolour';
    $title = get_string('themedefaultbuttontexthovercolour', 'theme_essentialbe');
    $description = get_string('themedefaultbuttontexthovercolourdesc', 'theme_essentialbe');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Default button background colour setting.
    $name = 'theme_essentialbe/themedefaultbuttonbackgroundcolour';
    $title = get_string('themedefaultbuttonbackgroundcolour', 'theme_essentialbe');
    $description = get_string('themedefaultbuttonbackgroundcolourdesc', 'theme_essentialbe');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Default button background hover colour setting.
    $name = 'theme_essentialbe/themedefaultbuttonbackgroundhovercolour';
    $title = get_string('themedefaultbuttonbackgroundhovercolour', 'theme_essentialbe');
    $description = get_string('themedefaultbuttonbackgroundhovercolourdesc', 'theme_essentialbe');
    $default = '#3ad4ff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Navigation colour setting.
    $name = 'theme_essentialbe/themenavcolor';
    $title = get_string('themenavcolor', 'theme_essentialbe');
    $description = get_string('themenavcolordesc', 'theme_essentialbe');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Theme stripe text colour setting.
    $name = 'theme_essentialbe/themestripetextcolour';
    $title = get_string('themestripetextcolour', 'theme_essentialbe');
    $description = get_string('themestripetextcolourdesc', 'theme_essentialbe');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Theme stripe background colour setting.
    $name = 'theme_essentialbe/themestripebackgroundcolour';
    $title = get_string('themestripebackgroundcolour', 'theme_essentialbe');
    $description = get_string('themestripebackgroundcolourdesc', 'theme_essentialbe');
    $default = '#ff9a34';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Theme stripe url colour setting.
    $name = 'theme_essentialbe/themestripeurlcolour';
    $title = get_string('themestripeurlcolour', 'theme_essentialbe');
    $description = get_string('themestripeurlcolourdesc', 'theme_essentialbe');
    $default = '#25849f';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // This is the descriptor for the footer.
    $name = 'theme_essentialbe/footercolorinfo';
    $heading = get_string('footercolors', 'theme_essentialbe');
    $information = get_string('footercolorsdesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essentialbesettingscolour->add($setting);

    // Footer background colour setting.
    $name = 'theme_essentialbe/footercolor';
    $title = get_string('footercolor', 'theme_essentialbe');
    $description = get_string('footercolordesc', 'theme_essentialbe');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Footer text colour setting.
    $name = 'theme_essentialbe/footertextcolor';
    $title = get_string('footertextcolor', 'theme_essentialbe');
    $description = get_string('footertextcolordesc', 'theme_essentialbe');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Footer heading colour setting.
    $name = 'theme_essentialbe/footerheadingcolor';
    $title = get_string('footerheadingcolor', 'theme_essentialbe');
    $description = get_string('footerheadingcolordesc', 'theme_essentialbe');
    $default = '#cccccc';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Footer block background colour setting.
    $name = 'theme_essentialbe/footerblockbackgroundcolour';
    $title = get_string('footerblockbackgroundcolour', 'theme_essentialbe');
    $description = get_string('footerblockbackgroundcolourdesc', 'theme_essentialbe');
    $default = '#cccccc';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Footer block text colour setting.
    $name = 'theme_essentialbe/footerblocktextcolour';
    $title = get_string('footerblocktextcolour', 'theme_essentialbe');
    $description = get_string('footerblocktextcolourdesc', 'theme_essentialbe');
    $default = '#000000';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Footer block URL colour setting.
    $name = 'theme_essentialbe/footerblockurlcolour';
    $title = get_string('footerblockurlcolour', 'theme_essentialbe');
    $description = get_string('footerblockurlcolourdesc', 'theme_essentialbe');
    $default = '#000000';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Footer block URL hover colour setting.
    $name = 'theme_essentialbe/footerblockhovercolour';
    $title = get_string('footerblockhovercolour', 'theme_essentialbe');
    $description = get_string('footerblockhovercolourdesc', 'theme_essentialbe');
    $default = '#555555';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Footer seperator colour setting.
    $name = 'theme_essentialbe/footersepcolor';
    $title = get_string('footersepcolor', 'theme_essentialbe');
    $description = get_string('footersepcolordesc', 'theme_essentialbe');
    $default = '#313131';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Footer URL colour setting.
    $name = 'theme_essentialbe/footerurlcolor';
    $title = get_string('footerurlcolor', 'theme_essentialbe');
    $description = get_string('footerurlcolordesc', 'theme_essentialbe');
    $default = '#cccccc';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // Footer URL hover colour setting.
    $name = 'theme_essentialbe/footerhovercolor';
    $title = get_string('footerhovercolor', 'theme_essentialbe');
    $description = get_string('footerhovercolordesc', 'theme_essentialbe');
    $default = '#bbbbbb';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscolour->add($setting);

    // This is the descriptor for the user theme colours.
    $name = 'theme_essentialbe/alternativethemecolorsinfo';
    $heading = get_string('alternativethemecolors', 'theme_essentialbe');
    $information = get_string('alternativethemecolorsdesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essentialbesettingscolour->add($setting);

    $defaultalternativethemecolors = array('#a430d1', '#d15430', '#5dd130', '#006b94');
    $defaultalternativethemehovercolors = array('#9929c4', '#c44c29', '#53c429', '#4090af');
    $defaultalternativethemestripetextcolors = array('#bdfdb7', '#c3fdd0', '#9f5bfb', '#ff1ebd');
    $defaultalternativethemestripebackgroundcolors = array('#c1009f', '#bc2800', '#b4b2fd', '#0336b4');
    $defaultalternativethemestripeurlcolors = array('#bef500', '#30af67', '#ffe9a6', '#ffab00');

    foreach (range(1, 4) as $alternativethemenumber) {
        // Enables the user to select an alternative colours choice.
        $name = 'theme_essentialbe/enablealternativethemecolors' . $alternativethemenumber;
        $title = get_string('enablealternativethemecolors', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('enablealternativethemecolorsdesc', 'theme_essentialbe', $alternativethemenumber);
        $default = false;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // User theme colour name.
        $name = 'theme_essentialbe/alternativethemename' . $alternativethemenumber;
        $title = get_string('alternativethemename', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemenamedesc', 'theme_essentialbe', $alternativethemenumber);
        $default = get_string('alternativecolors', 'theme_essentialbe', $alternativethemenumber);
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // User theme colour setting.
        $name = 'theme_essentialbe/alternativethemecolor' . $alternativethemenumber;
        $title = get_string('alternativethemecolor', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemecolordesc', 'theme_essentialbe', $alternativethemenumber);
        $default = $defaultalternativethemecolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Alternative theme text colour setting.
        $name = 'theme_essentialbe/alternativethemetextcolor' . $alternativethemenumber;
        $title = get_string('alternativethemetextcolor', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemetextcolordesc', 'theme_essentialbe', $alternativethemenumber);
        $default = $defaultalternativethemecolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Alternative theme link colour setting.
        $name = 'theme_essentialbe/alternativethemeurlcolor' . $alternativethemenumber;
        $title = get_string('alternativethemeurlcolor', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemeurlcolordesc', 'theme_essentialbe', $alternativethemenumber);
        $default = $defaultalternativethemecolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Alternative theme link hover colour setting.
        $name = 'theme_essentialbe/alternativethemehovercolor' . $alternativethemenumber;
        $title = get_string('alternativethemehovercolor', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemehovercolordesc', 'theme_essentialbe', $alternativethemenumber);
        $default = $defaultalternativethemehovercolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Alternative theme default button text colour setting.
        $name = 'theme_essentialbe/alternativethemedefaultbuttontextcolour' . $alternativethemenumber;
        $title = get_string('alternativethemedefaultbuttontextcolour', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemedefaultbuttontextcolourdesc', 'theme_essentialbe', $alternativethemenumber);
        $default = '#ffffff';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Alternative theme default button text hover colour setting.
        $name = 'theme_essentialbe/alternativethemedefaultbuttontexthovercolour' . $alternativethemenumber;
        $title = get_string('alternativethemedefaultbuttontexthovercolour', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemedefaultbuttontexthovercolourdesc', 'theme_essentialbe',
            $alternativethemenumber);
        $default = '#ffffff';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Alternative theme default button background colour setting.
        $name = 'theme_essentialbe/alternativethemedefaultbuttonbackgroundcolour' . $alternativethemenumber;
        $title = get_string('alternativethemedefaultbuttonbackgroundcolour', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemedefaultbuttonbackgroundcolourdesc', 'theme_essentialbe', $alternativethemenumber);
        $default = '#30add1';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Alternative theme default button background hover colour setting.
        $name = 'theme_essentialbe/alternativethemedefbuttonbackgroundhvrcolour' . $alternativethemenumber;
        $title = get_string('alternativethemedefaultbuttonbackgroundhovercolour', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemedefaultbuttonbackgroundhovercolourdesc', 'theme_essentialbe',
            $alternativethemenumber);
        $default = '#3ad4ff';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Alternative theme icon colour setting.
        $name = 'theme_essentialbe/alternativethemeiconcolor' . $alternativethemenumber;
        $title = get_string('alternativethemeiconcolor', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemeiconcolordesc', 'theme_essentialbe', $alternativethemenumber);
        $default = $defaultalternativethemecolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Alternative theme nav colour setting.
        $name = 'theme_essentialbe/alternativethemenavcolor' . $alternativethemenumber;
        $title = get_string('alternativethemenavcolor', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemenavcolordesc', 'theme_essentialbe', $alternativethemenumber);
        $default = '#ffffff';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Alternative theme stripe text colour setting.
        $name = 'theme_essentialbe/alternativethemestripetextcolour' . $alternativethemenumber;
        $title = get_string('alternativethemestripetextcolour', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemestripetextcolourdesc', 'theme_essentialbe', $alternativethemenumber);
        $default = $defaultalternativethemestripetextcolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Alternative theme stripe background colour setting.
        $name = 'theme_essentialbe/alternativethemestripebackgroundcolour' . $alternativethemenumber;
        $title = get_string('alternativethemestripebackgroundcolour', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemestripebackgroundcolourdesc', 'theme_essentialbe', $alternativethemenumber);
        $default = $defaultalternativethemestripebackgroundcolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Theme stripe url colour setting.
        $name = 'theme_essentialbe/alternativethemestripeurlcolour' . $alternativethemenumber;
        $title = get_string('alternativethemestripeurlcolour', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemestripeurlcolourdesc', 'theme_essentialbe', $alternativethemenumber);
        $default = $defaultalternativethemestripeurlcolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Enrolled and not accessed course background colour.
        $name = 'theme_essentialbe/alternativethememycoursesorderenrolbackcolour'.$alternativethemenumber;
        $title = get_string('alternativethememycoursesorderenrolbackcolour', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethememycoursesorderenrolbackcolourdesc', 'theme_essentialbe', $alternativethemenumber);
        $default = '#a3ebff';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Footer background colour setting.
        $name = 'theme_essentialbe/alternativethemefootercolor' . $alternativethemenumber;
        $title = get_string('alternativethemefootercolor', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemefootercolordesc', 'theme_essentialbe', $alternativethemenumber);
        $default = '#30add1';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Footer text colour setting.
        $name = 'theme_essentialbe/alternativethemefootertextcolor' . $alternativethemenumber;
        $title = get_string('alternativethemefootertextcolor', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemefootertextcolordesc', 'theme_essentialbe', $alternativethemenumber);
        $default = '#ffffff';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Footer heading colour setting.
        $name = 'theme_essentialbe/alternativethemefooterheadingcolor' . $alternativethemenumber;
        $title = get_string('alternativethemefooterheadingcolor', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemefooterheadingcolordesc', 'theme_essentialbe', $alternativethemenumber);
        $default = '#cccccc';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Footer block background colour setting.
        $name = 'theme_essentialbe/alternativethemefooterblockbackgroundcolour' . $alternativethemenumber;
        $title = get_string('alternativethemefooterblockbackgroundcolour', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemefooterblockbackgroundcolourdesc', 'theme_essentialbe',
                $alternativethemenumber);
        $default = '#cccccc';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Footer block text colour setting.
        $name = 'theme_essentialbe/alternativethemefooterblocktextcolour' . $alternativethemenumber;
        $title = get_string('alternativethemefooterblocktextcolour', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemefooterblocktextcolourdesc', 'theme_essentialbe',
                $alternativethemenumber);
        $default = '#000000';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Footer block URL colour setting.
        $name = 'theme_essentialbe/alternativethemefooterblockurlcolour' . $alternativethemenumber;
        $title = get_string('alternativethemefooterblockurlcolour', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemefooterblockurlcolourdesc', 'theme_essentialbe', $alternativethemenumber);
        $default = '#000000';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Footer block URL hover colour setting.
        $name = 'theme_essentialbe/alternativethemefooterblockhovercolour' . $alternativethemenumber;
        $title = get_string('alternativethemefooterblockhovercolour', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemefooterblockhovercolourdesc', 'theme_essentialbe',
                $alternativethemenumber);
        $default = '#555555';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Footer seperator colour setting.
        $name = 'theme_essentialbe/alternativethemefootersepcolor' . $alternativethemenumber;
        $title = get_string('alternativethemefootersepcolor', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemefootersepcolordesc', 'theme_essentialbe', $alternativethemenumber);
        $default = '#313131';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Footer URL colour setting.
        $name = 'theme_essentialbe/alternativethemefooterurlcolor' . $alternativethemenumber;
        $title = get_string('alternativethemefooterurlcolor', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemefooterurlcolordesc', 'theme_essentialbe', $alternativethemenumber);
        $default = '#cccccc';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);

        // Footer URL hover colour setting.
        $name = 'theme_essentialbe/alternativethemefooterhovercolor' . $alternativethemenumber;
        $title = get_string('alternativethemefooterhovercolor', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemefooterhovercolordesc', 'theme_essentialbe', $alternativethemenumber);
        $default = '#bbbbbb';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscolour->add($setting);
    }

    $essentialbesettingscolour->add(new admin_setting_heading('theme_essentialbe_colourreadme',
        get_string('readme_title', 'theme_essentialbe'), get_string('readme_desc', 'theme_essentialbe', array('url' => $readme))));
}
$ADMIN->add('theme_essentialbe', $essentialbesettingscolour);

// Header settings.
$essentialbesettingsheader = new admin_settingpage('theme_essentialbe_header', get_string('headerheading', 'theme_essentialbe'));
if ($ADMIN->fulltree) {
    global $CFG;
    if (file_exists("{$CFG->dirroot}/theme/essentialbe/essentialbe_admin_setting_configtext.php")) {
        require_once($CFG->dirroot . '/theme/essentialbe/essentialbe_admin_setting_configinteger.php');
        require_once($CFG->dirroot . '/theme/essentialbe/essentialbe_admin_setting_configtext.php');
        require_once($CFG->dirroot . '/theme/essentialbe/essentialbe_admin_setting_configradio.php');
    } else if (!empty($CFG->themedir) && file_exists("{$CFG->themedir}/essentialbe/essentialbe_admin_setting_configtext.php")) {
        require_once($CFG->themedir . '/essentialbe/essentialbe_admin_setting_configinteger.php');
        require_once($CFG->themedir . '/essentialbe/essentialbe_admin_setting_configtext.php');
        require_once($CFG->themedir . '/essentialbe/essentialbe_admin_setting_configradio.php');
    }

    // New or old navbar.
    $name = 'theme_essentialbe/oldnavbar';
    $title = get_string('oldnavbar', 'theme_essentialbe');
    $description = get_string('oldnavbardesc', 'theme_essentialbe');
    $default = 0;
    $choices = array(
        0 => get_string('navbarabove', 'theme_essentialbe'),
        1 => get_string('navbarbelow', 'theme_essentialbe')
    );
    $images = array(
        0 => 'navbarabove',
        1 => 'navbarbelow'
    );
    $setting = new essentialbe_admin_setting_configradio($name, $title, $description, $default, $choices, false, $images);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Use the site icon if there is no logo.
    $name = 'theme_essentialbe/usesiteicon';
    $title = get_string('usesiteicon', 'theme_essentialbe');
    $description = get_string('usesiteicondesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Default Site icon setting.
    $name = 'theme_essentialbe/siteicon';
    $title = get_string('siteicon', 'theme_essentialbe');
    $description = get_string('siteicondesc', 'theme_essentialbe');
    $default = 'laptop';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $essentialbesettingsheader->add($setting);

    // Header title setting.
    $name = 'theme_essentialbe/headertitle';
    $title = get_string('headertitle', 'theme_essentialbe');
    $description = get_string('headertitledesc', 'theme_essentialbe');
    $default = '1';
    $choices = array(
        0 => get_string('notitle', 'theme_essentialbe'),
        1 => get_string('fullname', 'theme_essentialbe'),
        2 => get_string('shortname', 'theme_essentialbe'),
        3 => get_string('fullnamesummary', 'theme_essentialbe'),
        4 => get_string('shortnamesummary', 'theme_essentialbe')
    );
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Logo file setting.
    $name = 'theme_essentialbe/logo';
    $title = get_string('logo', 'theme_essentialbe');
    $description = get_string('logodesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Logo width setting.
    $name = 'theme_essentialbe/logowidth';
    $title = get_string('logowidth', 'theme_essentialbe');
    $description = get_string('logowidthdesc', 'theme_essentialbe');
    $default = '65px';
    $regex = '/\b(\d)(\d*)(px|em)\b/';
    $logodimerror = get_string('logodimerror', 'theme_essentialbe');
    $setting = new essentialbe_admin_setting_configtext($name, $title, $description, $default, $regex, $logodimerror);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Logo height setting.
    $name = 'theme_essentialbe/logoheight';
    $title = get_string('logoheight', 'theme_essentialbe');
    $description = get_string('logoheightdesc', 'theme_essentialbe');
    $default = '65px';
    $setting = new essentialbe_admin_setting_configtext($name, $title, $description, $default, $regex, $logodimerror);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Navbar title setting.
    $name = 'theme_essentialbe/navbartitle';
    $title = get_string('navbartitle', 'theme_essentialbe');
    $description = get_string('navbartitledesc', 'theme_essentialbe');
    $default = '2';
    $choices = array(
        0 => get_string('notitle', 'theme_essentialbe'),
        1 => get_string('fullname', 'theme_essentialbe'),
        2 => get_string('shortname', 'theme_essentialbe')
    );
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Header text colour setting.
    $name = 'theme_essentialbe/headertextcolor';
    $title = get_string('headertextcolor', 'theme_essentialbe');
    $description = get_string('headertextcolordesc', 'theme_essentialbe');
    $default = '#217a94';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Header background image.
    $name = 'theme_essentialbe/headerbackground';
    $title = get_string('headerbackground', 'theme_essentialbe');
    $description = get_string('headerbackgrounddesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'headerbackground');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Background style.
    $name = 'theme_essentialbe/headerbackgroundstyle';
    $title = get_string('headerbackgroundstyle', 'theme_essentialbe');
    $description = get_string('headerbackgroundstyledesc', 'theme_essentialbe');
    $default = 'tiled';
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default,
        array(
            'fixed' => get_string('stylefixed', 'theme_essentialbe'),
            'tiled' => get_string('styletiled', 'theme_essentialbe')
        )
    );
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Choose breadcrumbstyle.
    $name = 'theme_essentialbe/breadcrumbstyle';
    $title = get_string('breadcrumbstyle', 'theme_essentialbe');
    $description = get_string('breadcrumbstyledesc', 'theme_essentialbe');
    $default = 1;
    $choices = array(
        1 => get_string('breadcrumbstyled', 'theme_essentialbe'),
        4 => get_string('breadcrumbstylednocollapse', 'theme_essentialbe'),
        2 => get_string('breadcrumbsimple', 'theme_essentialbe'),
        3 => get_string('breadcrumbthin', 'theme_essentialbe'),
        0 => get_string('nobreadcrumb', 'theme_essentialbe')
    );
    $images = array(
        1 => 'breadcrumbstyled',
        4 => 'breadcrumbstylednocollapse',
        2 => 'breadcrumbsimple',
        3 => 'breadcrumbthin'
    );
    $setting = new essentialbe_admin_setting_configradio($name, $title, $description, $default, $choices, false, $images);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Header block.
    $name = 'theme_essentialbe/haveheaderblock';
    $title = get_string('haveheaderblock', 'theme_essentialbe');
    $description = get_string('haveheaderblockdesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $essentialbesettingsheader->add($setting);

    $name = 'theme_essentialbe/headerblocksperrow';
    $title = get_string('headerblocksperrow', 'theme_essentialbe');
    $default = 4;
    $lower = 1;
    $upper = 4;
    $description = get_string('headerblocksperrowdesc', 'theme_essentialbe',
        array('lower' => $lower, 'upper' => $upper));
    $setting = new essentialbe_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
    $essentialbesettingsheader->add($setting);

    // Course menu settings.
    $name = 'theme_essentialbe/mycoursesinfo';
    $heading = get_string('mycoursesinfo', 'theme_essentialbe');
    $information = get_string('mycoursesinfodesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essentialbesettingsheader->add($setting);

    // Toggle courses display in custommenu.
    $name = 'theme_essentialbe/displaymycourses';
    $title = get_string('displaymycourses', 'theme_essentialbe');
    $description = get_string('displaymycoursesdesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Toggle hidden courses display in custommenu.
    $name = 'theme_essentialbe/displayhiddenmycourses';
    $title = get_string('displayhiddenmycourses', 'theme_essentialbe');
    $description = get_string('displayhiddenmycoursesdesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    // No need for callback as CSS not changed.
    $essentialbesettingsheader->add($setting);

    // My courses order.
    $name = 'theme_essentialbe/mycoursesorder';
    $title = get_string('mycoursesorder', 'theme_essentialbe');
    $description = get_string('mycoursesorderdesc', 'theme_essentialbe');
    $default = 1;
    $choices = array(
        1 => get_string('mycoursesordersort', 'theme_essentialbe'),
        2 => get_string('mycoursesorderid', 'theme_essentialbe'),
        3 => get_string('mycoursesorderlast', 'theme_essentialbe')
    );
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    // No need for callback as CSS not changed.
    $essentialbesettingsheader->add($setting);

    // Course ID order.
    $name = 'theme_essentialbe/mycoursesorderidorder';
    $title = get_string('mycoursesorderidorder', 'theme_essentialbe');
    $description = get_string('mycoursesorderidorderdesc', 'theme_essentialbe');
    $default = 1;
    $choices = array(
        1 => get_string('mycoursesorderidasc', 'theme_essentialbe'),
        2 => get_string('mycoursesorderiddes', 'theme_essentialbe')
    );
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    // No need for callback as CSS not changed.
    $essentialbesettingsheader->add($setting);

    // Max courses.
    $name = 'theme_essentialbe/mycoursesmax';
    $title = get_string('mycoursesmax', 'theme_essentialbe');
    $default = 0;
    $lower = 0;
    $upper = 20;
    $description = get_string('mycoursesmaxdesc', 'theme_essentialbe',
        array('lower' => $lower, 'upper' => $upper));
    $setting = new essentialbe_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
    // No need for callback as CSS not changed.
    $essentialbesettingsheader->add($setting);

    // Set terminology for dropdown course list.
    $name = 'theme_essentialbe/mycoursetitle';
    $title = get_string('mycoursetitle', 'theme_essentialbe');
    $description = get_string('mycoursetitledesc', 'theme_essentialbe');
    $default = 'course';
    $choices = array(
        'course' => get_string('mycourses', 'theme_essentialbe'),
        'unit' => get_string('myunits', 'theme_essentialbe'),
        'class' => get_string('myclasses', 'theme_essentialbe'),
        'module' => get_string('mymodules', 'theme_essentialbe')
    );
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Enrolled and not accessed course background colour.
    $name = 'theme_essentialbe/mycoursesorderenrolbackcolour';
    $title = get_string('mycoursesorderenrolbackcolour', 'theme_essentialbe');
    $description = get_string('mycoursesorderenrolbackcolourdesc', 'theme_essentialbe');
    $default = '#a3ebff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // User menu settings.
    $name = 'theme_essentialbe/usermenu';
    $heading = get_string('usermenu', 'theme_essentialbe');
    $information = get_string('usermenudesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essentialbesettingsheader->add($setting);

    // Helplink type.
    $name = 'theme_essentialbe/helplinktype';
    $title = get_string('helplinktype', 'theme_essentialbe');
    $description = get_string('helplinktypedesc', 'theme_essentialbe');
    $default = 1;
    $choices = array(1 => get_string('email'),
        2 => get_string('url'),
        0 => get_string('none')
    );
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Helplink.
    $name = 'theme_essentialbe/helplink';
    $title = get_string('helplink', 'theme_essentialbe');
    $description = get_string('helplinkdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Editing menu settings.
    $name = 'theme_essentialbe/editingmenu';
    $heading = get_string('editingmenu', 'theme_essentialbe');
    $information = get_string('editingmenudesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essentialbesettingsheader->add($setting);

    $name = 'theme_essentialbe/displayeditingmenu';
    $title = get_string('displayeditingmenu', 'theme_essentialbe');
    $description = get_string('displayeditingmenudesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $essentialbesettingsheader->add($setting);

    $name = 'theme_essentialbe/hidedefaulteditingbutton';
    $title = get_string('hidedefaulteditingbutton', 'theme_essentialbe');
    $description = get_string('hidedefaulteditingbuttondesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $essentialbesettingsheader->add($setting);

    // Social network settings.
    $essentialbesettingsheader->add(new admin_setting_heading('theme_essentialbe_social',
        get_string('socialheadingsub', 'theme_essentialbe'),
        format_text(get_string('socialdesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    // Website URL setting.
    $name = 'theme_essentialbe/website';
    $title = get_string('websiteurl', 'theme_essentialbe');
    $description = get_string('websitedesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Facebook URL setting.
    $name = 'theme_essentialbe/facebook';
    $title = get_string('facebookurl', 'theme_essentialbe');
    $description = get_string('facebookdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Flickr URL setting.
    $name = 'theme_essentialbe/flickr';
    $title = get_string('flickrurl', 'theme_essentialbe');
    $description = get_string('flickrdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Twitter URL setting.
    $name = 'theme_essentialbe/twitter';
    $title = get_string('twitterurl', 'theme_essentialbe');
    $description = get_string('twitterdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Google+ URL setting.
    $name = 'theme_essentialbe/googleplus';
    $title = get_string('googleplusurl', 'theme_essentialbe');
    $description = get_string('googleplusdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // LinkedIn URL setting.
    $name = 'theme_essentialbe/linkedin';
    $title = get_string('linkedinurl', 'theme_essentialbe');
    $description = get_string('linkedindesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Pinterest URL setting.
    $name = 'theme_essentialbe/pinterest';
    $title = get_string('pinteresturl', 'theme_essentialbe');
    $description = get_string('pinterestdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Instagram URL setting.
    $name = 'theme_essentialbe/instagram';
    $title = get_string('instagramurl', 'theme_essentialbe');
    $description = get_string('instagramdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // YouTube URL setting.
    $name = 'theme_essentialbe/youtube';
    $title = get_string('youtubeurl', 'theme_essentialbe');
    $description = get_string('youtubedesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Skype URL setting.
    $name = 'theme_essentialbe/skype';
    $title = get_string('skypeuri', 'theme_essentialbe');
    $description = get_string('skypedesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // VKontakte URL setting.
    $name = 'theme_essentialbe/vk';
    $title = get_string('vkurl', 'theme_essentialbe');
    $description = get_string('vkdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Apps settings.
    $essentialbesettingsheader->add(new admin_setting_heading('theme_essentialbe_mobileapps',
        get_string('mobileappsheadingsub', 'theme_essentialbe'),
        format_text(get_string('mobileappsdesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    // Android App URL setting.
    $name = 'theme_essentialbe/android';
    $title = get_string('androidurl', 'theme_essentialbe');
    $description = get_string('androiddesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Windows App URL setting.
    $name = 'theme_essentialbe/windows';
    $title = get_string('windowsurl', 'theme_essentialbe');
    $description = get_string('windowsdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // Windows PhoneApp URL setting.
    $name = 'theme_essentialbe/winphone';
    $title = get_string('winphoneurl', 'theme_essentialbe');
    $description = get_string('winphonedesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // The iOS App URL setting.
    $name = 'theme_essentialbe/ios';
    $title = get_string('iosurl', 'theme_essentialbe');
    $description = get_string('iosdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // This is the descriptor for iOS icons.
    $name = 'theme_essentialbe/iosiconinfo';
    $heading = get_string('iosicon', 'theme_essentialbe');
    $information = get_string('iosicondesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essentialbesettingsheader->add($setting);

    // The iPhone icon.
    $name = 'theme_essentialbe/iphoneicon';
    $title = get_string('iphoneicon', 'theme_essentialbe');
    $description = get_string('iphoneicondesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'iphoneicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // The iPhone retina icon.
    $name = 'theme_essentialbe/iphoneretinaicon';
    $title = get_string('iphoneretinaicon', 'theme_essentialbe');
    $description = get_string('iphoneretinaicondesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'iphoneretinaicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // The iPad icon.
    $name = 'theme_essentialbe/ipadicon';
    $title = get_string('ipadicon', 'theme_essentialbe');
    $description = get_string('ipadicondesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'ipadicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    // The iPad retina icon.
    $name = 'theme_essentialbe/ipadretinaicon';
    $title = get_string('ipadretinaicon', 'theme_essentialbe');
    $description = get_string('ipadretinaicondesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'ipadretinaicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsheader->add($setting);

    $essentialbesettingsheader->add(new admin_setting_heading('theme_essentialbe_headerreadme',
        get_string('readme_title', 'theme_essentialbe'), get_string('readme_desc', 'theme_essentialbe', array('url' => $readme))));
}
$ADMIN->add('theme_essentialbe', $essentialbesettingsheader);

// Font settings.
$essentialbesettingsfont = new admin_settingpage('theme_essentialbe_font', get_string('fontsettings', 'theme_essentialbe'));
if ($ADMIN->fulltree) {
    // This is the descriptor for the font settings.
    $name = 'theme_essentialbe/fontheading';
    $heading = get_string('fontheadingsub', 'theme_essentialbe');
    $information = get_string('fontheadingdesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essentialbesettingsfont->add($setting);

    // Font selector.
    $gws = html_writer::link('//www.google.com/fonts', get_string('fonttypegoogle', 'theme_essentialbe'), array('target' => '_blank'));
    $name = 'theme_essentialbe/fontselect';
    $title = get_string('fontselect', 'theme_essentialbe');
    $description = get_string('fontselectdesc', 'theme_essentialbe', array('googlewebfonts' => $gws));
    $default = 1;
    $choices = array(
        1 => get_string('fonttypeuser', 'theme_essentialbe'),
        2 => get_string('fonttypegoogle', 'theme_essentialbe'),
        3 => get_string('fonttypecustom', 'theme_essentialbe')
    );
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfont->add($setting);

    // Heading font name.
    $name = 'theme_essentialbe/fontnameheading';
    $title = get_string('fontnameheading', 'theme_essentialbe');
    $description = get_string('fontnameheadingdesc', 'theme_essentialbe');
    $default = 'Verdana';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfont->add($setting);

    // Text font name.
    $name = 'theme_essentialbe/fontnamebody';
    $title = get_string('fontnamebody', 'theme_essentialbe');
    $description = get_string('fontnamebodydesc', 'theme_essentialbe');
    $default = 'Verdana';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfont->add($setting);

    if (get_config('theme_essentialbe', 'fontselect') === "2") {
        // Google font character sets.
        $name = 'theme_essentialbe/fontcharacterset';
        $title = get_string('fontcharacterset', 'theme_essentialbe');
        $description = get_string('fontcharactersetdesc', 'theme_essentialbe');
        $default = 'latin-ext';
        $setting = new admin_setting_configmulticheckbox($name, $title, $description, $default,
            array(
                'latin-ext' => get_string('fontcharactersetlatinext', 'theme_essentialbe'),
                'cyrillic' => get_string('fontcharactersetcyrillic', 'theme_essentialbe'),
                'cyrillic-ext' => get_string('fontcharactersetcyrillicext', 'theme_essentialbe'),
                'greek' => get_string('fontcharactersetgreek', 'theme_essentialbe'),
                'greek-ext' => get_string('fontcharactersetgreekext', 'theme_essentialbe'),
                'vietnamese' => get_string('fontcharactersetvietnamese', 'theme_essentialbe')
            )
        );
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfont->add($setting);
    } else if (get_config('theme_essentialbe', 'fontselect') === "3") {
        // This is the descriptor for the font files.
        $name = 'theme_essentialbe/fontfiles';
        $heading = get_string('fontfiles', 'theme_essentialbe');
        $information = get_string('fontfilesdesc', 'theme_essentialbe');
        $setting = new admin_setting_heading($name, $heading, $information);
        $essentialbesettingsfont->add($setting);

        // Heading fonts.
        // TTF font.
        $name = 'theme_essentialbe/fontfilettfheading';
        $title = get_string('fontfilettfheading', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilettfheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfont->add($setting);

        // OTF font.
        $name = 'theme_essentialbe/fontfileotfheading';
        $title = get_string('fontfileotfheading', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileotfheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfont->add($setting);

        // WOFF font.
        $name = 'theme_essentialbe/fontfilewoffheading';
        $title = get_string('fontfilewoffheading', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewoffheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfont->add($setting);

        // WOFF2 font.
        $name = 'theme_essentialbe/fontfilewofftwoheading';
        $title = get_string('fontfilewofftwoheading', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewofftwoheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfont->add($setting);

        // EOT font.
        $name = 'theme_essentialbe/fontfileeotheading';
        $title = get_string('fontfileeotheading', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileeotheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfont->add($setting);

        // SVG font.
        $name = 'theme_essentialbe/fontfilesvgheading';
        $title = get_string('fontfilesvgheading', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilesvgheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfont->add($setting);

        // Body fonts.
        // TTF font.
        $name = 'theme_essentialbe/fontfilettfbody';
        $title = get_string('fontfilettfbody', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilettfbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfont->add($setting);

        // OTF font.
        $name = 'theme_essentialbe/fontfileotfbody';
        $title = get_string('fontfileotfbody', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileotfbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfont->add($setting);

        // WOFF font.
        $name = 'theme_essentialbe/fontfilewoffbody';
        $title = get_string('fontfilewoffbody', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewoffbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfont->add($setting);

        // WOFF2 font.
        $name = 'theme_essentialbe/fontfilewofftwobody';
        $title = get_string('fontfilewofftwobody', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewofftwobody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfont->add($setting);

        // EOT font.
        $name = 'theme_essentialbe/fontfileeotbody';
        $title = get_string('fontfileeotbody', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileeotbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfont->add($setting);

        // SVG font.
        $name = 'theme_essentialbe/fontfilesvgbody';
        $title = get_string('fontfilesvgbody', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilesvgbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfont->add($setting);
    }

    $essentialbesettingsfont->add(new admin_setting_heading('theme_essentialbe_fontreadme',
        get_string('readme_title', 'theme_essentialbe'), get_string('readme_desc', 'theme_essentialbe', array('url' => $readme))));
}
$ADMIN->add('theme_essentialbe', $essentialbesettingsfont);

// Footer settings.
$essentialbesettingsfooter = new admin_settingpage('theme_essentialbe_footer', get_string('footerheading', 'theme_essentialbe'));
if ($ADMIN->fulltree) {
    // Copyright setting.
    $name = 'theme_essentialbe/copyright';
    $title = get_string('copyright', 'theme_essentialbe');
    $description = get_string('copyrightdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $essentialbesettingsfooter->add($setting);

    // Footnote setting.
    $name = 'theme_essentialbe/footnote';
    $title = get_string('footnote', 'theme_essentialbe');
    $description = get_string('footnotedesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfooter->add($setting);

    // Performance information display.
    $name = 'theme_essentialbe/perfinfo';
    $title = get_string('perfinfo', 'theme_essentialbe');
    $description = get_string('perfinfodesc', 'theme_essentialbe');
    $perfmax = get_string('perf_max', 'theme_essentialbe');
    $perfmin = get_string('perf_min', 'theme_essentialbe');
    $default = 'min';
    $choices = array('min' => $perfmin, 'max' => $perfmax);
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfooter->add($setting);

    $essentialbesettingsfooter->add(new admin_setting_heading('theme_essentialbe_footerreadme',
        get_string('readme_title', 'theme_essentialbe'), get_string('readme_desc', 'theme_essentialbe', array('url' => $readme))));
}
$ADMIN->add('theme_essentialbe', $essentialbesettingsfooter);

// Frontpage settings.
$essentialbesettingsfrontpage = new admin_settingpage('theme_essentialbe_frontpage', get_string('frontpageheading', 'theme_essentialbe'));
if ($ADMIN->fulltree) {

    $name = 'theme_essentialbe/courselistteachericon';
    $title = get_string('courselistteachericon', 'theme_essentialbe');
    $description = get_string('courselistteachericondesc', 'theme_essentialbe');
    $default = 'graduation-cap';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    $essentialbesettingsfrontpage->add(new admin_setting_heading('theme_essentialbe_frontcontent',
        get_string('frontcontentheading', 'theme_essentialbe'), ''));

    // Toggle frontpage content.
    $name = 'theme_essentialbe/togglefrontcontent';
    $title = get_string('frontcontent', 'theme_essentialbe');
    $description = get_string('frontcontentdesc', 'theme_essentialbe');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essentialbe');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_essentialbe');
    $displayafterlogin = get_string('displayafterlogin', 'theme_essentialbe');
    $dontdisplay = get_string('dontdisplay', 'theme_essentialbe');
    $default = 0;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    // Frontpage content.
    $name = 'theme_essentialbe/frontcontentarea';
    $title = get_string('frontcontentarea', 'theme_essentialbe');
    $description = get_string('frontcontentareadesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    $name = 'theme_essentialbe_frontpageblocksheading';
    $heading = get_string('frontpageblocksheading', 'theme_essentialbe');
    $information = '';
    $setting = new admin_setting_heading($name, $heading, $information);
    $essentialbesettingsfrontpage->add($setting);

    // Frontpage block alignment.
    $name = 'theme_essentialbe/frontpageblocks';
    $title = get_string('frontpageblocks', 'theme_essentialbe');
    $description = get_string('frontpageblocksdesc', 'theme_essentialbe');
    $before = get_string('beforecontent', 'theme_essentialbe');
    $after = get_string('aftercontent', 'theme_essentialbe');
    $default = 1;
    $choices = array(1 => $before, 0 => $after);
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    // Toggle frontpage home (was middle) blocks.
    $name = 'theme_essentialbe/frontpagemiddleblocks';
    $title = get_string('frontpagemiddleblocks', 'theme_essentialbe');
    $description = get_string('frontpagemiddleblocksdesc', 'theme_essentialbe');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essentialbe');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_essentialbe');
    $displayafterlogin = get_string('displayafterlogin', 'theme_essentialbe');
    $dontdisplay = get_string('dontdisplay', 'theme_essentialbe');
    $default = 0;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    // Home blocks per row.
    $name = 'theme_essentialbe/frontpagehomeblocksperrow';
    $title = get_string('frontpagehomeblocksperrow', 'theme_essentialbe');
    $default = 3;
    $lower = 1;
    $upper = 4;
    $description = get_string('frontpagehomeblocksperrowdesc', 'theme_essentialbe',
        array('lower' => $lower, 'upper' => $upper));
    $setting = new essentialbe_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
    $essentialbesettingsfrontpage->add($setting);

    // Toggle frontpage page top blocks.
    $name = 'theme_essentialbe/fppagetopblocks';
    $title = get_string('fppagetopblocks', 'theme_essentialbe');
    $description = get_string('fppagetopblocksdesc', 'theme_essentialbe');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essentialbe');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_essentialbe');
    $displayafterlogin = get_string('displayafterlogin', 'theme_essentialbe');
    $dontdisplay = get_string('dontdisplay', 'theme_essentialbe');
    $default = 3;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    // Marketing spot settings.
    $essentialbesettingsfrontpage->add(new admin_setting_heading('theme_essentialbe_marketing',
        get_string('marketingheading', 'theme_essentialbe'),
        format_text(get_string('marketingdesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    // Toggle marketing spots.
    $name = 'theme_essentialbe/togglemarketing';
    $title = get_string('togglemarketing', 'theme_essentialbe');
    $description = get_string('togglemarketingdesc', 'theme_essentialbe');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essentialbe');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_essentialbe');
    $displayafterlogin = get_string('displayafterlogin', 'theme_essentialbe');
    $dontdisplay = get_string('dontdisplay', 'theme_essentialbe');
    $default = 1;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    // Marketing spot height.
    $name = 'theme_essentialbe/marketingheight';
    $title = get_string('marketingheight', 'theme_essentialbe');
    $description = get_string('marketingheightdesc', 'theme_essentialbe');
    $default = 100;
    $choices = array();
    for ($mhit = 50; $mhit <= 500; $mhit = $mhit + 2) {
        $choices[$mhit] = $mhit;
    }
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $essentialbesettingsfrontpage->add($setting);

    // Marketing spot image height.
    $name = 'theme_essentialbe/marketingimageheight';
    $title = get_string('marketingimageheight', 'theme_essentialbe');
    $description = get_string('marketingimageheightdesc', 'theme_essentialbe');
    $default = 100;
    $choices = array(50 => '50', 100 => '100', 150 => '150', 200 => '200', 250 => '250', 300 => '300');
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $essentialbesettingsfrontpage->add($setting);

    foreach (range(1, 3) as $marketingspotnumber) {
        // This is the descriptor for Marketing Spot in $marketingspotnumber.
        $name = 'theme_essentialbe/marketing' . $marketingspotnumber . 'info';
        $heading = get_string('marketing' . $marketingspotnumber, 'theme_essentialbe');
        $information = get_string('marketinginfodesc', 'theme_essentialbe');
        $setting = new admin_setting_heading($name, $heading, $information);
        $essentialbesettingsfrontpage->add($setting);

        // Marketing spot.
        $name = 'theme_essentialbe/marketing' . $marketingspotnumber;
        $title = get_string('marketingtitle', 'theme_essentialbe');
        $description = get_string('marketingtitledesc', 'theme_essentialbe');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfrontpage->add($setting);

        $name = 'theme_essentialbe/marketing' . $marketingspotnumber . 'icon';
        $title = get_string('marketingicon', 'theme_essentialbe');
        $description = get_string('marketingicondesc', 'theme_essentialbe');
        $default = 'star';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfrontpage->add($setting);

        $name = 'theme_essentialbe/marketing' . $marketingspotnumber . 'image';
        $title = get_string('marketingimage', 'theme_essentialbe');
        $description = get_string('marketingimagedesc', 'theme_essentialbe');
        $setting = new admin_setting_configstoredfile($name, $title, $description,
                'marketing' . $marketingspotnumber . 'image');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfrontpage->add($setting);

        $name = 'theme_essentialbe/marketing' . $marketingspotnumber . 'content';
        $title = get_string('marketingcontent', 'theme_essentialbe');
        $description = get_string('marketingcontentdesc', 'theme_essentialbe');
        $default = '';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfrontpage->add($setting);

        $name = 'theme_essentialbe/marketing' . $marketingspotnumber . 'buttontext';
        $title = get_string('marketingbuttontext', 'theme_essentialbe');
        $description = get_string('marketingbuttontextdesc', 'theme_essentialbe');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfrontpage->add($setting);

        $name = 'theme_essentialbe/marketing' . $marketingspotnumber . 'buttonurl';
        $title = get_string('marketingbuttonurl', 'theme_essentialbe');
        $description = get_string('marketingbuttonurldesc', 'theme_essentialbe');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfrontpage->add($setting);

        $name = 'theme_essentialbe/marketing' . $marketingspotnumber . 'target';
        $title = get_string('marketingurltarget', 'theme_essentialbe');
        $description = get_string('marketingurltargetdesc', 'theme_essentialbe');
        $target1 = get_string('marketingurltargetself', 'theme_essentialbe');
        $target2 = get_string('marketingurltargetnew', 'theme_essentialbe');
        $target3 = get_string('marketingurltargetparent', 'theme_essentialbe');
        $default = '_blank';
        $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
        $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfrontpage->add($setting);
    }

    $name = 'theme_essentialbe/marketingsecondrow';
    $heading = get_string('marketingsecondrow', 'theme_essentialbe');
    $information = get_string('marketingsecondrowdesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essentialbesettingsfrontpage->add($setting);

    $marketingsecondrowstr = get_string('marketingsecondrowenable', 'theme_essentialbe');
    $setting = new admin_setting_configcheckbox('theme_essentialbe/marketingsecondrowenable', $marketingsecondrowstr, '', 0);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    foreach (range(4, 6) as $marketingspotnumber) {
        // This is the descriptor for Marketing Spot in $marketingspotnumber.
        $name = 'theme_essentialbe/marketing' . $marketingspotnumber . 'info';
        $heading = get_string('marketing' . $marketingspotnumber, 'theme_essentialbe');
        $information = get_string('marketinginfodesc', 'theme_essentialbe');
        $setting = new admin_setting_heading($name, $heading, $information);
        $essentialbesettingsfrontpage->add($setting);

        // Marketing spot.
        $name = 'theme_essentialbe/marketing' . $marketingspotnumber;
        $title = get_string('marketingtitle', 'theme_essentialbe');
        $description = get_string('marketingtitledesc', 'theme_essentialbe');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfrontpage->add($setting);

        $name = 'theme_essentialbe/marketing' . $marketingspotnumber . 'icon';
        $title = get_string('marketingicon', 'theme_essentialbe');
        $description = get_string('marketingicondesc', 'theme_essentialbe');
        $default = 'star';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfrontpage->add($setting);

        $name = 'theme_essentialbe/marketing' . $marketingspotnumber . 'image';
        $title = get_string('marketingimage', 'theme_essentialbe');
        $description = get_string('marketingimagedesc', 'theme_essentialbe');
        $setting = new admin_setting_configstoredfile($name, $title, $description,
                'marketing' . $marketingspotnumber . 'image');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfrontpage->add($setting);

        $name = 'theme_essentialbe/marketing' . $marketingspotnumber . 'content';
        $title = get_string('marketingcontent', 'theme_essentialbe');
        $description = get_string('marketingcontentdesc', 'theme_essentialbe');
        $default = '';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfrontpage->add($setting);

        $name = 'theme_essentialbe/marketing' . $marketingspotnumber . 'buttontext';
        $title = get_string('marketingbuttontext', 'theme_essentialbe');
        $description = get_string('marketingbuttontextdesc', 'theme_essentialbe');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfrontpage->add($setting);

        $name = 'theme_essentialbe/marketing' . $marketingspotnumber . 'buttonurl';
        $title = get_string('marketingbuttonurl', 'theme_essentialbe');
        $description = get_string('marketingbuttonurldesc', 'theme_essentialbe');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfrontpage->add($setting);

        $name = 'theme_essentialbe/marketing' . $marketingspotnumber . 'target';
        $title = get_string('marketingurltarget', 'theme_essentialbe');
        $description = get_string('marketingurltargetdesc', 'theme_essentialbe');
        $target1 = get_string('marketingurltargetself', 'theme_essentialbe');
        $target2 = get_string('marketingurltargetnew', 'theme_essentialbe');
        $target3 = get_string('marketingurltargetparent', 'theme_essentialbe');
        $default = '_blank';
        $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
        $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsfrontpage->add($setting);
    }

    // User alerts.
    $essentialbesettingsfrontpage->add(new admin_setting_heading('theme_essentialbe_alerts',
        get_string('alertsheadingsub', 'theme_essentialbe'),
        format_text(get_string('alertsdesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    $information = get_string('alertinfodesc', 'theme_essentialbe');

    // This is the descriptor for alert one.
    $name = 'theme_essentialbe/alert1info';
    $heading = get_string('alert1', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essentialbesettingsfrontpage->add($setting);

    // Enable alert.
    $name = 'theme_essentialbe/enable1alert';
    $title = get_string('enablealert', 'theme_essentialbe');
    $description = get_string('enablealertdesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    // Alert type.
    $name = 'theme_essentialbe/alert1type';
    $title = get_string('alerttype', 'theme_essentialbe');
    $description = get_string('alerttypedesc', 'theme_essentialbe');
    $alertinfo = get_string('alert_info', 'theme_essentialbe');
    $alertwarning = get_string('alert_warning', 'theme_essentialbe');
    $alertgeneral = get_string('alert_general', 'theme_essentialbe');
    $default = 'info';
    $choices = array('info' => $alertinfo, 'error' => $alertwarning, 'success' => $alertgeneral);
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    // Alert title.
    $name = 'theme_essentialbe/alert1title';
    $title = get_string('alerttitle', 'theme_essentialbe');
    $description = get_string('alerttitledesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    // Alert text.
    $name = 'theme_essentialbe/alert1text';
    $title = get_string('alerttext', 'theme_essentialbe');
    $description = get_string('alerttextdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    // This is the descriptor for alert two.
    $name = 'theme_essentialbe/alert2info';
    $heading = get_string('alert2', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essentialbesettingsfrontpage->add($setting);

    // Enable alert.
    $name = 'theme_essentialbe/enable2alert';
    $title = get_string('enablealert', 'theme_essentialbe');
    $description = get_string('enablealertdesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    // Alert type.
    $name = 'theme_essentialbe/alert2type';
    $title = get_string('alerttype', 'theme_essentialbe');
    $description = get_string('alerttypedesc', 'theme_essentialbe');
    $alertinfo = get_string('alert_info', 'theme_essentialbe');
    $alertwarning = get_string('alert_warning', 'theme_essentialbe');
    $alertgeneral = get_string('alert_general', 'theme_essentialbe');
    $default = 'info';
    $choices = array('info' => $alertinfo, 'error' => $alertwarning, 'success' => $alertgeneral);
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    // Alert title.
    $name = 'theme_essentialbe/alert2title';
    $title = get_string('alerttitle', 'theme_essentialbe');
    $description = get_string('alerttitledesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    // Alert text.
    $name = 'theme_essentialbe/alert2text';
    $title = get_string('alerttext', 'theme_essentialbe');
    $description = get_string('alerttextdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    // This is the descriptor for alert three.
    $name = 'theme_essentialbe/alert3info';
    $heading = get_string('alert3', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essentialbesettingsfrontpage->add($setting);

    // Enable alert.
    $name = 'theme_essentialbe/enable3alert';
    $title = get_string('enablealert', 'theme_essentialbe');
    $description = get_string('enablealertdesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    // Alert type.
    $name = 'theme_essentialbe/alert3type';
    $title = get_string('alerttype', 'theme_essentialbe');
    $description = get_string('alerttypedesc', 'theme_essentialbe');
    $alertinfo = get_string('alert_info', 'theme_essentialbe');
    $alertwarning = get_string('alert_warning', 'theme_essentialbe');
    $alertgeneral = get_string('alert_general', 'theme_essentialbe');
    $default = 'info';
    $choices = array('info' => $alertinfo, 'error' => $alertwarning, 'success' => $alertgeneral);
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    // Alert title.
    $name = 'theme_essentialbe/alert3title';
    $title = get_string('alerttitle', 'theme_essentialbe');
    $description = get_string('alerttitledesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    // Alert text.
    $name = 'theme_essentialbe/alert3text';
    $title = get_string('alerttext', 'theme_essentialbe');
    $description = get_string('alerttextdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsfrontpage->add($setting);

    $essentialbesettingsfrontpage->add(new admin_setting_heading('theme_essentialbe_frontpagereadme',
        get_string('readme_title', 'theme_essentialbe'), get_string('readme_desc', 'theme_essentialbe', array('url' => $readme))));
}
$ADMIN->add('theme_essentialbe', $essentialbesettingsfrontpage);

// Slideshow settings.
$essentialbesettingsslideshow = new admin_settingpage('theme_essentialbe_slideshow', get_string('slideshowheading', 'theme_essentialbe'));
if ($ADMIN->fulltree) {
    $essentialbesettingsslideshow->add(new admin_setting_heading('theme_essentialbe_slideshow',
        get_string('slideshowheadingsub', 'theme_essentialbe'),
        format_text(get_string('slideshowdesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    // Toggle slideshow.
    $name = 'theme_essentialbe/toggleslideshow';
    $title = get_string('toggleslideshow', 'theme_essentialbe');
    $description = get_string('toggleslideshowdesc', 'theme_essentialbe');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essentialbe');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_essentialbe');
    $displayafterlogin = get_string('displayafterlogin', 'theme_essentialbe');
    $dontdisplay = get_string('dontdisplay', 'theme_essentialbe');
    $default = 1;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsslideshow->add($setting);

    // Number of slides.
    $name = 'theme_essentialbe/numberofslides';
    $title = get_string('numberofslides', 'theme_essentialbe');
    $description = get_string('numberofslides_desc', 'theme_essentialbe');
    $default = 4;
    $choices = array(
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        6 => '6',
        7 => '7',
        8 => '8',
        9 => '9',
        10 => '10',
        11 => '11',
        12 => '12',
        13 => '13',
        14 => '14',
        15 => '15',
        16 => '16'
    );
    $essentialbesettingsslideshow->add(new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices));

    // Hide slideshow on phones.
    $name = 'theme_essentialbe/hideontablet';
    $title = get_string('hideontablet', 'theme_essentialbe');
    $description = get_string('hideontabletdesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsslideshow->add($setting);

    // Hide slideshow on tablet.
    $name = 'theme_essentialbe/hideonphone';
    $title = get_string('hideonphone', 'theme_essentialbe');
    $description = get_string('hideonphonedesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsslideshow->add($setting);

    // Slide interval.
    $name = 'theme_essentialbe/slideinterval';
    $title = get_string('slideinterval', 'theme_essentialbe');
    $description = get_string('slideintervaldesc', 'theme_essentialbe');
    $default = '5000';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsslideshow->add($setting);

    // Slide caption text colour setting.
    $name = 'theme_essentialbe/slidecaptiontextcolor';
    $title = get_string('slidecaptiontextcolor', 'theme_essentialbe');
    $description = get_string('slidecaptiontextcolordesc', 'theme_essentialbe');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsslideshow->add($setting);

    // Slide caption background colour setting.
    $name = 'theme_essentialbe/slidecaptionbackgroundcolor';
    $title = get_string('slidecaptionbackgroundcolor', 'theme_essentialbe');
    $description = get_string('slidecaptionbackgroundcolordesc', 'theme_essentialbe');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsslideshow->add($setting);

    // Show caption options.
    $name = 'theme_essentialbe/slidecaptionoptions';
    $title = get_string('slidecaptionoptions', 'theme_essentialbe');
    $description = get_string('slidecaptionoptionsdesc', 'theme_essentialbe');
    $default = 0;
    $choices = array(
        0 => get_string('slidecaptionbeside', 'theme_essentialbe'),
        1 => get_string('slidecaptionontop', 'theme_essentialbe'),
        2 => get_string('slidecaptionunderneath', 'theme_essentialbe')
    );
    $images = array(
        0 => 'beside',
        1 => 'on_top',
        2 => 'underneath'
    );
    $setting = new essentialbe_admin_setting_configradio($name, $title, $description, $default, $choices, false, $images);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsslideshow->add($setting);

    // Show caption centred.
    $name = 'theme_essentialbe/slidecaptioncentred';
    $title = get_string('slidecaptioncentred', 'theme_essentialbe');
    $description = get_string('slidecaptioncentreddesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsslideshow->add($setting);

    // Slide button colour setting.
    $name = 'theme_essentialbe/slidebuttoncolor';
    $title = get_string('slidebuttoncolor', 'theme_essentialbe');
    $description = get_string('slidebuttoncolordesc', 'theme_essentialbe');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsslideshow->add($setting);

    // Slide button hover colour setting.
    $name = 'theme_essentialbe/slidebuttonhovercolor';
    $title = get_string('slidebuttonhovercolor', 'theme_essentialbe');
    $description = get_string('slidebuttonhovercolordesc', 'theme_essentialbe');
    $default = '#217a94';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingsslideshow->add($setting);

    // This is the descriptor for the user theme slide colours.
    $name = 'theme_essentialbe/alternativethemeslidecolorsinfo';
    $heading = get_string('alternativethemeslidecolors', 'theme_essentialbe');
    $information = get_string('alternativethemeslidecolorsdesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $essentialbesettingsslideshow->add($setting);

    foreach (range(1, 4) as $alternativethemenumber) {
        // Alternative theme slide caption text colour setting.
        $name = 'theme_essentialbe/alternativethemeslidecaptiontextcolor' . $alternativethemenumber;
        $title = get_string('alternativethemeslidecaptiontextcolor', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemeslidecaptiontextcolordesc', 'theme_essentialbe',
                $alternativethemenumber);
        $default = '#ffffff';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsslideshow->add($setting);

        // Alternative theme slide caption background colour setting.
        $name = 'theme_essentialbe/alternativethemeslidecaptionbackgroundcolor' . $alternativethemenumber;
        $title = get_string('alternativethemeslidecaptionbackgroundcolor', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemeslidecaptionbackgroundcolordesc', 'theme_essentialbe',
                $alternativethemenumber);
        $default = $defaultalternativethemecolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsslideshow->add($setting);

        // Alternative theme slide button colour setting.
        $name = 'theme_essentialbe/alternativethemeslidebuttoncolor' . $alternativethemenumber;
        $title = get_string('alternativethemeslidebuttoncolor', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemeslidebuttoncolordesc', 'theme_essentialbe', $alternativethemenumber);
        $default = $defaultalternativethemecolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsslideshow->add($setting);

        // Alternative theme slide button hover colour setting.
        $name = 'theme_essentialbe/alternativethemeslidebuttonhovercolor' . $alternativethemenumber;
        $title = get_string('alternativethemeslidebuttonhovercolor', 'theme_essentialbe', $alternativethemenumber);
        $description = get_string('alternativethemeslidebuttonhovercolordesc', 'theme_essentialbe',
                $alternativethemenumber);
        $default = $defaultalternativethemehovercolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsslideshow->add($setting);
    }

    $numberofslides = get_config('theme_essentialbe', 'numberofslides');
    for ($i = 1; $i <= $numberofslides; $i++) {
        // This is the descriptor for the slide.
        $name = 'theme_essentialbe/slide'.$i.'info';
        $heading = get_string('slideno', 'theme_essentialbe', array('slide' => $i));
        $information = get_string('slidenodesc', 'theme_essentialbe', array('slide' => $i));
        $setting = new admin_setting_heading($name, $heading, $information);
        $essentialbesettingsslideshow->add($setting);

        // Title.
        $name = 'theme_essentialbe/slide'.$i;
        $title = get_string('slidetitle', 'theme_essentialbe');
        $description = get_string('slidetitledesc', 'theme_essentialbe');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsslideshow->add($setting);

        // Image.
        $name = 'theme_essentialbe/slide'.$i.'image';
        $title = get_string('slideimage', 'theme_essentialbe');
        $description = get_string('slideimagedesc', 'theme_essentialbe');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'slide'.$i.'image');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsslideshow->add($setting);

        // Caption text.
        $name = 'theme_essentialbe/slide'.$i.'caption';
        $title = get_string('slidecaption', 'theme_essentialbe');
        $description = get_string('slidecaptiondesc', 'theme_essentialbe');
        $default = '';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsslideshow->add($setting);

        // URL.
        $name = 'theme_essentialbe/slide'.$i.'url';
        $title = get_string('slideurl', 'theme_essentialbe');
        $description = get_string('slideurldesc', 'theme_essentialbe');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsslideshow->add($setting);

        // URL target.
        $name = 'theme_essentialbe/slide'.$i.'target';
        $title = get_string('slideurltarget', 'theme_essentialbe');
        $description = get_string('slideurltargetdesc', 'theme_essentialbe');
        $target1 = get_string('slideurltargetself', 'theme_essentialbe');
        $target2 = get_string('slideurltargetnew', 'theme_essentialbe');
        $target3 = get_string('slideurltargetparent', 'theme_essentialbe');
        $default = '_blank';
        $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
        $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingsslideshow->add($setting);
    }

    $essentialbesettingsslideshow->add(new admin_setting_heading('theme_essentialbe_slideshowreadme',
        get_string('readme_title', 'theme_essentialbe'), get_string('readme_desc', 'theme_essentialbe', array('url' => $readme))));
}
$ADMIN->add('theme_essentialbe', $essentialbesettingsslideshow);

// Category course title image settings.
$enablecategoryctics = get_config('theme_essentialbe', 'enablecategoryctics');
if ($enablecategoryctics) {
    $essentialbesettingscategoryctititle = get_string('categoryctiheadingcs', 'theme_essentialbe');
} else {
    $essentialbesettingscategoryctititle = get_string('categoryctiheading', 'theme_essentialbe');
}
$essentialbesettingscategorycti = new admin_settingpage('theme_essentialbe_categorycti', $essentialbesettingscategoryctititle);
if ($ADMIN->fulltree) {
    global $CFG;
    if (file_exists("{$CFG->dirroot}/theme/essentialbe/essentialbe_admin_setting_configinteger.php")) {
        require_once($CFG->dirroot . '/theme/essentialbe/essentialbe_admin_setting_configinteger.php');
    } else if (!empty($CFG->themedir) && file_exists("{$CFG->themedir}/essentialbe/essentialbe_admin_setting_configinteger.php")) {
        require_once($CFG->themedir . '/essentialbe/essentialbe_admin_setting_configinteger.php');
    }

    $essentialbesettingscategorycti->add(new admin_setting_heading('theme_essentialbe_categorycti',
        get_string('categoryctiheadingsub', 'theme_essentialbe'),
        format_text(get_string('categoryctidesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    // Category icons.
    $name = 'theme_essentialbe/enablecategorycti';
    $title = get_string('enablecategorycti', 'theme_essentialbe');
    $description = get_string('enablecategoryctidesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscategorycti->add($setting);

    // Category icons category setting pages.
    $name = 'theme_essentialbe/enablecategoryctics';
    $title = get_string('enablecategoryctics', 'theme_essentialbe');
    $description = get_string('enablecategorycticsdesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscategorycti->add($setting);

    // We only want to output category course title image options if the parent setting is enabled.
    if (get_config('theme_essentialbe', 'enablecategorycti')) {
        $essentialbesettingscategorycti->add(new admin_setting_heading('theme_essentialbe_categorycticourses',
            get_string('ctioverride', 'theme_essentialbe'), get_string('ctioverridedesc', 'theme_essentialbe')));

        // Overridden image height.
        $name = 'theme_essentialbe/ctioverrideheight';
        $title = get_string('ctioverrideheight', 'theme_essentialbe');
        $default = 200;
        $lower = 40;
        $upper = 400;
        $description = get_string('ctioverrideheightdesc', 'theme_essentialbe',
            array('lower' => $lower, 'upper' => $upper));
        $setting = new essentialbe_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
        $essentialbesettingscategorycti->add($setting);

        // Overridden course title text colour setting.
        $name = 'theme_essentialbe/ctioverridetextcolour';
        $title = get_string('ctioverridetextcolour', 'theme_essentialbe');
        $description = get_string('ctioverridetextcolourdesc', 'theme_essentialbe');
        $default = '#ffffff';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $essentialbesettingscategorycti->add($setting);

        // Overridden course title text background colour setting.
        $name = 'theme_essentialbe/ctioverridetextbackgroundcolour';
        $title = get_string('ctioverridetextbackgroundcolour', 'theme_essentialbe');
        $description = get_string('ctioverridetextbackgroundcolourdesc', 'theme_essentialbe');
        $default = '#c51230';
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $essentialbesettingscategorycti->add($setting);

        $opactitychoices = array(
            '0.0' => '0.0',
            '0.1' => '0.1',
            '0.2' => '0.2',
            '0.3' => '0.3',
            '0.4' => '0.4',
            '0.5' => '0.5',
            '0.6' => '0.6',
            '0.7' => '0.7',
            '0.8' => '0.8',
            '0.9' => '0.9',
            '1.0' => '1.0'
        );

        // Overridden course title text background opacity setting.
        $name = 'theme_essentialbe/ctioverridetextbackgroundopacity';
        $title = get_string('ctioverridetextbackgroundopacity', 'theme_essentialbe');
        $description = get_string('ctioverridetextbackgroundopacitydesc', 'theme_essentialbe');
        $default = '0.8';
        $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $opactitychoices);
        $essentialbesettingscategorycti->add($setting);
    }
}
$ADMIN->add('theme_essentialbe', $essentialbesettingscategorycti);

// We only want to output category course title image options if the parent setting is enabled.
if (get_config('theme_essentialbe', 'enablecategorycti')) {
    // Get all category IDs and their names.
    $coursecats = \theme_essentialbe\toolbox::get_categories_list();

    if (!$enablecategoryctics) {
        $essentialbesettingscategoryctimenu = $essentialbesettingscategorycti;
    }

    // Go through all categories and create the necessary settings.
    foreach ($coursecats as $key => $value) {
        if (($value->depth == 1) && ($enablecategoryctics)) {
            $essentialbesettingscategoryctimenu = new admin_settingpage('theme_essentialbe_categorycti_'.$value->id,
                get_string('categoryctiheadingcategory', 'theme_essentialbe', array('category' => $value->namechunks[0])));
        }

        if ($ADMIN->fulltree) {
            $namepath = join(' / ', $value->namechunks);
            // This is the descriptor for category course title image.
            $name = 'theme_essentialbe/categoryctiinfo'.$key;
            $heading = get_string('categoryctiinfo', 'theme_essentialbe', array('category' => $namepath));
            $information = get_string('categoryctiinfodesc', 'theme_essentialbe', array('category' => $namepath));
            $setting = new admin_setting_heading($name, $heading, $information);
            $essentialbesettingscategoryctimenu->add($setting);

            // Image.
            $name = 'theme_essentialbe/categoryct'.$key.'image';
            $title = get_string('categoryctimage', 'theme_essentialbe', array('category' => $namepath));
            $description = get_string('categoryctimagedesc', 'theme_essentialbe', array('category' => $namepath));
            $setting = new admin_setting_configstoredfile($name, $title, $description, 'categoryct'.$key.'image');
            $setting->set_updatedcallback('theme_reset_all_caches');
            $essentialbesettingscategoryctimenu->add($setting);

            // Image URL.
            $name = 'theme_essentialbe/categoryctimageurl'.$key;
            $title = get_string('categoryctimageurl', 'theme_essentialbe', array('category' => $namepath));
            $description = get_string('categoryctimageurldesc', 'theme_essentialbe', array('category' => $namepath));
            $default = '';
            $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $essentialbesettingscategoryctimenu->add($setting);

            // Image height.
            $name = 'theme_essentialbe/categorycti'.$key.'height';
            $title = get_string('categoryctiheight', 'theme_essentialbe', array('category' => $namepath));
            $default = 200;
            $lower = 40;
            $upper = 400;
            $description = get_string('categoryctiheightdesc', 'theme_essentialbe',
                array('category' => $namepath, 'lower' => $lower, 'upper' => $upper));
            $setting = new essentialbe_admin_setting_configinteger($name, $title, $description, $default, $lower, $upper);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $essentialbesettingscategoryctimenu->add($setting);

            // Category course title text colour setting.
            $name = 'theme_essentialbe/categorycti'.$key.'textcolour';
            $title = get_string('categoryctitextcolour', 'theme_essentialbe', array('category' => $namepath));
            $description = get_string('categoryctitextcolourdesc', 'theme_essentialbe', array('category' => $namepath));
            $default = '#000000';
            $previewconfig = null;
            $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $essentialbesettingscategoryctimenu->add($setting);

            // Category course title text background colour setting.
            $name = 'theme_essentialbe/categorycti'.$key.'textbackgroundcolour';
            $title = get_string('categoryctitextbackgroundcolour', 'theme_essentialbe', array('category' => $namepath));
            $description = get_string('categoryctitextbackgroundcolourdesc', 'theme_essentialbe', array('category' => $namepath));
            $default = '#ffffff';
            $previewconfig = null;
            $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $essentialbesettingscategoryctimenu->add($setting);

            // Category course title text background opacity setting.
            $name = 'theme_essentialbe/categorycti'.$key.'textbackgroundopactity';
            $title = get_string('categoryctitextbackgroundopacity', 'theme_essentialbe', array('category' => $namepath));
            $description = get_string('categoryctitextbackgroundopacitydesc', 'theme_essentialbe', array('category' => $namepath));
            $default = '0.8';
            $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $opactitychoices);
            $setting->set_updatedcallback('theme_reset_all_caches');
            $essentialbesettingscategoryctimenu->add($setting);
        }
        if (($value->depth == 1) && ($enablecategoryctics)) {
            $ADMIN->add('theme_essentialbe', $essentialbesettingscategoryctimenu);
        }
    }
}

// Category icon settings.
$essentialbesettingscategoryicon = new admin_settingpage('theme_essentialbe_categoryicon',
    get_string('categoryiconheading', 'theme_essentialbe'));
if ($ADMIN->fulltree) {
    $essentialbesettingscategoryicon->add(new admin_setting_heading('theme_essentialbe_categoryicon',
        get_string('categoryiconheadingsub', 'theme_essentialbe'),
        format_text(get_string('categoryicondesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    // Category icons.
    $name = 'theme_essentialbe/enablecategoryicon';
    $title = get_string('enablecategoryicon', 'theme_essentialbe');
    $description = get_string('enablecategoryicondesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $essentialbesettingscategoryicon->add($setting);

    // We only want to output category icon options if the parent setting is enabled.
    if (get_config('theme_essentialbe', 'enablecategoryicon')) {

        // Default icon selector.
        $name = 'theme_essentialbe/defaultcategoryicon';
        $title = get_string('defaultcategoryicon', 'theme_essentialbe');
        $description = get_string('defaultcategoryicondesc', 'theme_essentialbe');
        $default = 'folder-open';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscategoryicon->add($setting);

        // Category icons.
        $name = 'theme_essentialbe/enablecustomcategoryicon';
        $title = get_string('enablecustomcategoryicon', 'theme_essentialbe');
        $description = get_string('enablecustomcategoryicondesc', 'theme_essentialbe');
        $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $essentialbesettingscategoryicon->add($setting);

        if (get_config('theme_essentialbe', 'enablecustomcategoryicon')) {

            // This is the descriptor for custom category icons.
            $name = 'theme_essentialbe/categoryiconinfo';
            $heading = get_string('categoryiconinfo', 'theme_essentialbe');
            $information = get_string('categoryiconinfodesc', 'theme_essentialbe');
            $setting = new admin_setting_heading($name, $heading, $information);
            $essentialbesettingscategoryicon->add($setting);

            // Get the default category icon.
            $defaultcategoryicon = get_config('theme_essentialbe', 'defaultcategoryicon');
            if (empty($defaultcategoryicon)) {
                $defaultcategoryicon = 'folder-open';
            }

            // Get all category IDs and their names.
            $coursecats = \theme_essentialbe\toolbox::get_categories_list();

            // Go through all categories and create the necessary settings.
            foreach ($coursecats as $key => $value) {
                $namepath = join(' / ', $value->namechunks);
                // Category icons for each category.
                $name = 'theme_essentialbe/categoryicon';
                $title = $namepath;
                $description = get_string('categoryiconcategory', 'theme_essentialbe', array('category' => $namepath));
                $default = $defaultcategoryicon;
                $setting = new admin_setting_configtext($name . $key, $title, $description, $default);
                $setting->set_updatedcallback('theme_reset_all_caches');
                $essentialbesettingscategoryicon->add($setting);
            }
            unset($coursecats);
        }
    }

    $essentialbesettingscategoryicon->add(new admin_setting_heading('theme_essentialbe_categoryiconreadme',
        get_string('readme_title', 'theme_essentialbe'), get_string('readme_desc', 'theme_essentialbe', array('url' => $readme))));
}
$ADMIN->add('theme_essentialbe', $essentialbesettingscategoryicon);

// Analytics settings.
$essentialbesettingsanalytics = new admin_settingpage('theme_essentialbe_analytics', get_string('analytics', 'theme_essentialbe'));
if ($ADMIN->fulltree) {
    $essentialbesettingsanalytics->add(new admin_setting_heading('theme_essentialbe_analytics',
        get_string('analyticsheadingsub', 'theme_essentialbe'),
        format_text(get_string('analyticsdesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    $name = 'theme_essentialbe/analyticsenabled';
    $title = get_string('analyticsenabled', 'theme_essentialbe');
    $description = get_string('analyticsenableddesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $essentialbesettingsanalytics->add($setting);

    $name = 'theme_essentialbe/analytics';
    $title = get_string('analytics', 'theme_essentialbe');
    $description = get_string('analyticsdesc', 'theme_essentialbe');
    $guniversal = get_string('analyticsguniversal', 'theme_essentialbe');
    $piwik = get_string('analyticspiwik', 'theme_essentialbe');
    $default = 'piwik';
    $choices = array(
        'piwik' => $piwik,
        'guniversal' => $guniversal
    );
    $setting = new essentialbe_admin_setting_configselect($name, $title, $description, $default, $choices);
    $essentialbesettingsanalytics->add($setting);

    if (get_config('theme_essentialbe', 'analytics') === 'piwik') {
        $name = 'theme_essentialbe/analyticssiteid';
        $title = get_string('analyticssiteid', 'theme_essentialbe');
        $description = get_string('analyticssiteiddesc', 'theme_essentialbe');
        $default = '1';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $essentialbesettingsanalytics->add($setting);

        $name = 'theme_essentialbe/analyticsimagetrack';
        $title = get_string('analyticsimagetrack', 'theme_essentialbe');
        $description = get_string('analyticsimagetrackdesc', 'theme_essentialbe');
        $default = true;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
        $essentialbesettingsanalytics->add($setting);

        $name = 'theme_essentialbe/analyticssiteurl';
        $title = get_string('analyticssiteurl', 'theme_essentialbe');
        $description = get_string('analyticssiteurldesc', 'theme_essentialbe');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $essentialbesettingsanalytics->add($setting);

        $name = 'theme_essentialbe/analyticsuseuserid';
        $title = get_string('analyticsuseuserid', 'theme_essentialbe');
        $description = get_string('analyticsuseuseriddesc', 'theme_essentialbe');
        $default = false;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
        $essentialbesettingsanalytics->add($setting);
    } else if (get_config('theme_essentialbe', 'analytics') === 'guniversal') {
        $name = 'theme_essentialbe/analyticstrackingid';
        $title = get_string('analyticstrackingid', 'theme_essentialbe');
        $description = get_string('analyticstrackingiddesc', 'theme_essentialbe');
        $default = 'UA-XXXXXXXX-X';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $essentialbesettingsanalytics->add($setting);
    }

    $name = 'theme_essentialbe/analyticstrackadmin';
    $title = get_string('analyticstrackadmin', 'theme_essentialbe');
    $description = get_string('analyticstrackadmindesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $essentialbesettingsanalytics->add($setting);

    $name = 'theme_essentialbe/analyticscleanurl';
    $title = get_string('analyticscleanurl', 'theme_essentialbe');
    $description = get_string('analyticscleanurldesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $essentialbesettingsanalytics->add($setting);

    $essentialbesettingsanalytics->add(new admin_setting_heading('theme_essentialbe_analyticsreadme',
        get_string('readme_title', 'theme_essentialbe'), get_string('readme_desc', 'theme_essentialbe', array('url' => $readme))));
}
$ADMIN->add('theme_essentialbe', $essentialbesettingsanalytics);

// Style guide.
$essentialbesettingsstyleguide = new admin_settingpage('theme_essentialbe_styleguide', get_string('styleguide', 'theme_essentialbe'));
if ($ADMIN->fulltree) {
    if (file_exists("{$CFG->dirroot}/theme/essentialbe/essentialbe_admin_setting_styleguide.php")) {
        require_once($CFG->dirroot . '/theme/essentialbe/essentialbe_admin_setting_styleguide.php');
    } else if (!empty($CFG->themedir) && file_exists("{$CFG->themedir}/essentialbe/essentialbe_admin_setting_styleguide.php")) {
        require_once($CFG->themedir . '/essentialbe/essentialbe_admin_setting_styleguide.php');
    }
    $essentialbesettingsstyleguide->add(new essentialbe_admin_setting_styleguide('theme_essentialbe_styleguide',
        get_string('styleguidesub', 'theme_essentialbe'),
        get_string('styleguidedesc', 'theme_essentialbe',
            array(
                'origcodelicenseurl' => html_writer::link('http://www.apache.org/licenses/LICENSE-2.0', 'Apache License v2.0',
                    array('target' => '_blank')),
                'holderlicenseurl' => html_writer::link('https://github.com/imsky/holder#license', 'MIT',
                    array('target' => '_blank')),
                'thiscodelicenseurl' => html_writer::link('http://www.gnu.org/copyleft/gpl.html', 'GPLv3',
                    array('target' => '_blank')),
                'compatible' => html_writer::link('http://www.gnu.org/licenses/license-list.en.html#apache2', 'compatible',
                    array('target' => '_blank')),
                'contentlicenseurl' => html_writer::link('http://creativecommons.org/licenses/by/3.0/', 'CC BY 3.0',
                    array('target' => '_blank')),
                'globalsettings' => html_writer::link('http://getbootstrap.com/2.3.2/scaffolding.html#global', 'Global settings',
                    array('target' => '_blank'))
            )
        )
    ));
}
$ADMIN->add('theme_essentialbe', $essentialbesettingsstyleguide);
