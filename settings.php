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

$settings = null;

$displaybeforelogin = get_string('displaybeforelogin', 'theme_essentialbe');
$displayafterlogin = get_string('displayafterlogin', 'theme_essentialbe');

$systemcontext = context_system::instance();

defined('MOODLE_INTERNAL') || die;

if (is_dir($CFG->dirroot.'/local/adminsettings')) {
    // Integration driven code 
    require_once($CFG->dirroot.'/local/adminsettings/lib.php');
    list($hasconfig, $hassiteconfig, $capability) = local_adminsettings_access();
} else {
    // Standard Moodle code
    $capability = 'moodle/site:config';
    $hasconfig = $hassiteconfig = has_capability($capability, context_system::instance());
}

$canconfigure = false;
if ($hassiteconfig) {
    $ADMIN->add('themes', new admin_category('theme_essentialbe', 'Essential Pro Edunao'));
    $canconfigure = true;
} elseif (has_capability('theme/essentialbe:configure', $systemcontext))  {
    if (!has_capability('moodle/site:config', $systemcontext)) {
        $ADMIN->add('root', new admin_category('themes', get_string('themes')));
    }
    $ADMIN->add('themes', new admin_category('theme_essentialbe', 'Essential Pro Edunao'));
    $canconfigure = true;
}

if ($canconfigure) {
    /* Generic Settings */
    $temp = new admin_settingpage('theme_essentialbe_generic', get_string('genericsettings', 'theme_essentialbe'));

    $donate = new moodle_url('http://moodle.org/user/profile.php?id=442195');
    $donate = html_writer::link($donate, get_string('paypal_click', 'theme_essentialbe'), array('target' => '_blank'));

    $flattr = new moodle_url('https://flattr.com/profile/gjb2048');
    $flattr = html_writer::link($flattr, get_string('flattr_click', 'theme_essentialbe'), array('target' => '_blank'));

    $temp->add(new admin_setting_heading('theme_essentialbe_generaldonate', get_string('donate_title', 'theme_essentialbe'),
        get_string('donate_desc', 'theme_essentialbe').get_string('paypal_desc', 'theme_essentialbe', array('url' => $donate)).get_string('flattr_desc', 'theme_essentialbe', array('url' => $flattr)).get_string('donate_desc2', 'theme_essentialbe')));

    $temp->add(new admin_setting_heading('theme_essentialbe_generalheading', get_string('generalheadingsub', 'theme_essentialbe'),
        format_text(get_string('generalheadingdesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    // Background Image.
    $name = 'theme_essentialbe/pagebackground';
    $title = get_string('pagebackground', 'theme_essentialbe');
    $description = get_string('pagebackgrounddesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'pagebackground');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Background Image.
    $name = 'theme_essentialbe/pagebackgroundstyle';
    $title = get_string('pagebackgroundstyle', 'theme_essentialbe');
    $description = get_string('pagebackgroundstyledesc', 'theme_essentialbe');
    $default = 'fixed';
    $setting = new admin_setting_configselect($name, $title, $description, $default, array(
        'fixed' => get_string('backgroundstylefixed', 'theme_essentialbe'),
        'tiled' => get_string('backgroundstyletiled', 'theme_essentialbe'),
        'stretch' => get_string('backgroundstylestretch', 'theme_essentialbe'),
    ));
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Fixed or Variable Width.
    $name = 'theme_essentialbe/pagewidth';
    $title = get_string('pagewidth', 'theme_essentialbe');
    $description = get_string('pagewidthdesc', 'theme_essentialbe');
    $default = 1200;
    $choices = array(960 => get_string('fixedwidthnarrow', 'theme_essentialbe'),
        1200 => get_string('fixedwidthnormal', 'theme_essentialbe'),
        1400 => get_string('fixedwidthwide', 'theme_essentialbe'),
        100 => get_string('variablewidth', 'theme_essentialbe'));
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Custom or standard layout.
    $name = 'theme_essentialbe/layout';
    $title = get_string('layout', 'theme_essentialbe');
    $description = get_string('layoutdesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // New or old navbar.
    $name = 'theme_essentialbe/oldnavbar';
    $title = get_string('oldnavbar', 'theme_essentialbe');
    $description = get_string('oldnavbardesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Choose breadcrumbstyle
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
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Fitvids.
    $name = 'theme_essentialbe/fitvids';
    $title = get_string('fitvids', 'theme_essentialbe');
    $description = get_string('fitvidsdesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Custom CSS file.
    $name = 'theme_essentialbe/customcss';
    $title = get_string('customcss', 'theme_essentialbe');
    $description = get_string('customcssdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $readme = new moodle_url('/theme/essentialbe/README.txt');
    $readme = html_writer::link($readme, get_string('readme_click', 'theme_essentialbe'), array('target' => '_blank'));

    $temp->add(new admin_setting_heading('theme_essentialbe_generalreadme', get_string('readme_title', 'theme_essentialbe'),
        get_string('readme_desc', 'theme_essentialbe', array('url' => $readme))));

    $ADMIN->add('theme_essentialbe', $temp);


    /* Colour Settings */
    $temp = new admin_settingpage('theme_essentialbe_color', get_string('colorheading', 'theme_essentialbe'));
    $temp->add(new admin_setting_heading('theme_essentialbe_color', get_string('colorheadingsub', 'theme_essentialbe'),
        format_text(get_string('colordesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    // Main theme colour setting.
    $name = 'theme_essentialbe/themecolor';
    $title = get_string('themecolor', 'theme_essentialbe');
    $description = get_string('themecolordesc', 'theme_essentialbe');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Main theme text colour setting.
    $name = 'theme_essentialbe/themetextcolor';
    $title = get_string('themetextcolor', 'theme_essentialbe');
    $description = get_string('themetextcolordesc', 'theme_essentialbe');
    $default = '#217a94';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Main theme link colour setting.
    $name = 'theme_essentialbe/themeurlcolor';
    $title = get_string('themeurlcolor', 'theme_essentialbe');
    $description = get_string('themeurlcolordesc', 'theme_essentialbe');
    $default = '#943b21';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Main theme Hover colour setting.
    $name = 'theme_essentialbe/themehovercolor';
    $title = get_string('themehovercolor', 'theme_essentialbe');
    $description = get_string('themehovercolordesc', 'theme_essentialbe');
    $default = '#6a2a18';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Icon colour setting.
    $name = 'theme_essentialbe/themeiconcolor';
    $title = get_string('themeiconcolor', 'theme_essentialbe');
    $description = get_string('themeiconcolordesc', 'theme_essentialbe');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Navigation colour setting.
    $name = 'theme_essentialbe/themenavcolor';
    $title = get_string('themenavcolor', 'theme_essentialbe');
    $description = get_string('themenavcolordesc', 'theme_essentialbe');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for the Footer
    $name = 'theme_essentialbe/footercolorinfo';
    $heading = get_string('footercolors', 'theme_essentialbe');
    $information = get_string('footercolorsdesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Footer background colour setting.
    $name = 'theme_essentialbe/footercolor';
    $title = get_string('footercolor', 'theme_essentialbe');
    $description = get_string('footercolordesc', 'theme_essentialbe');
    $default = '#555555';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Footer text colour setting.
    $name = 'theme_essentialbe/footertextcolor';
    $title = get_string('footertextcolor', 'theme_essentialbe');
    $description = get_string('footertextcolordesc', 'theme_essentialbe');
    $default = '#bbbbbb';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Footer Block Heading colour setting.
    $name = 'theme_essentialbe/footerheadingcolor';
    $title = get_string('footerheadingcolor', 'theme_essentialbe');
    $description = get_string('footerheadingcolordesc', 'theme_essentialbe');
    $default = '#cccccc';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Footer Seperator colour setting.
    $name = 'theme_essentialbe/footersepcolor';
    $title = get_string('footersepcolor', 'theme_essentialbe');
    $description = get_string('footersepcolordesc', 'theme_essentialbe');
    $default = '#313131';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Footer URL colour setting.
    $name = 'theme_essentialbe/footerurlcolor';
    $title = get_string('footerurlcolor', 'theme_essentialbe');
    $description = get_string('footerurlcolordesc', 'theme_essentialbe');
    $default = '#217a94';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Footer URL hover colour setting.
    $name = 'theme_essentialbe/footerhovercolor';
    $title = get_string('footerhovercolor', 'theme_essentialbe');
    $description = get_string('footerhovercolordesc', 'theme_essentialbe');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $ADMIN->add('theme_essentialbe', $temp);

    /* Header Settings */
    $temp = new admin_settingpage('theme_essentialbe_header', get_string('headerheading', 'theme_essentialbe'));

    // Default Site icon setting.
    $name = 'theme_essentialbe/siteicon';
    $title = get_string('siteicon', 'theme_essentialbe');
    $description = get_string('siteicondesc', 'theme_essentialbe');
    $default = 'laptop';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    // Logo file setting.
    $name = 'theme_essentialbe/logo';
    $title = get_string('logo', 'theme_essentialbe');
    $description = get_string('logodesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Favicon file setting.
    $name = 'theme_essentialbe/favicon';
    $title = get_string('favicon', 'theme_essentialbe');
    $description = get_string('favicondesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Header background file setting.
    $name = 'theme_essentialbe/headerbackgroundurl';
    $title = get_string('headerbackgroundurl', 'theme_essentialbe');
    $description = get_string('headerbackgroundurldesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'headerbackgroundurl');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // header image size setting.
    $name = 'theme_essentialbe/headerbgsize';
    $title = get_string('headerbgsize', 'theme_essentialbe');
    $description = get_string('headerbgsizedesc', 'theme_essentialbe');
    $sizeopts = array('cover' => get_string('cover', 'theme_essentialbe'), 'auto' => get_string('default', 'theme_essentialbe'));
    $setting = new admin_setting_configselect($name, $title, $description, 'headerbgsize', $sizeopts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // header height setting.
    $name = 'theme_essentialbe/headerheight';
    $title = get_string('headerheight', 'theme_essentialbe');
    $description = get_string('headerheightdesc', 'theme_essentialbe');
    $setting = new admin_setting_configtext($name, $title, $description, 80, PARAM_INT);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

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
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Navbar title setting.
    $name = 'theme_essentialbe/navbartitle';
    $title = get_string('navbartitle', 'theme_essentialbe');
    $description = get_string('navbartitledesc', 'theme_essentialbe');
    $default = '2';
    $choices = array(
        0 => get_string('notitle', 'theme_essentialbe'),
        1 => get_string('fullname', 'theme_essentialbe'),
        2 => get_string('shortname', 'theme_essentialbe'),
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    /* Course Menu Settings */
    $name = 'theme_essentialbe/mycoursesinfo';
    $heading = get_string('mycoursesinfo', 'theme_essentialbe');
    $information = get_string('mycoursesinfodesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Toggle courses display in custommenu.
    $name = 'theme_essentialbe/displaymycourses';
    $title = get_string('displaymycourses', 'theme_essentialbe');
    $description = get_string('displaymycoursesdesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Set terminology for dropdown course list
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
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Helplink type
    $name = 'theme_essentialbe/helplinktype';
    $title = get_string('helplinktype', 'theme_essentialbe');
    $description = get_string('helplinktypedesc', 'theme_essentialbe');
    $default = 1;
    $choices = array(1 => get_string('email'),
        2 => get_string('url'),
        0 => get_string('none')
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Helplink
    $name = 'theme_essentialbe/helplink';
    $title = get_string('helplink', 'theme_essentialbe');
    $description = get_string('helplinkdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    /* Social Network Settings */
    $temp->add(new admin_setting_heading('theme_essentialbe_social', get_string('socialheadingsub', 'theme_essentialbe'),
        format_text(get_string('socialdesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    // Website url setting.
    $name = 'theme_essentialbe/website';
    $title = get_string('website', 'theme_essentialbe');
    $description = get_string('websitedesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Facebook url setting.
    $name = 'theme_essentialbe/facebook';
    $title = get_string('facebook', 'theme_essentialbe');
    $description = get_string('facebookdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Flickr url setting.
    $name = 'theme_essentialbe/flickr';
    $title = get_string('flickr', 'theme_essentialbe');
    $description = get_string('flickrdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Twitter url setting.
    $name = 'theme_essentialbe/twitter';
    $title = get_string('twitter', 'theme_essentialbe');
    $description = get_string('twitterdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Google+ url setting.
    $name = 'theme_essentialbe/googleplus';
    $title = get_string('googleplus', 'theme_essentialbe');
    $description = get_string('googleplusdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // LinkedIn url setting.
    $name = 'theme_essentialbe/linkedin';
    $title = get_string('linkedin', 'theme_essentialbe');
    $description = get_string('linkedindesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Pinterest url setting.
    $name = 'theme_essentialbe/pinterest';
    $title = get_string('pinterest', 'theme_essentialbe');
    $description = get_string('pinterestdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Instagram url setting.
    $name = 'theme_essentialbe/instagram';
    $title = get_string('instagram', 'theme_essentialbe');
    $description = get_string('instagramdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // YouTube url setting.
    $name = 'theme_essentialbe/youtube';
    $title = get_string('youtube', 'theme_essentialbe');
    $description = get_string('youtubedesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Skype url setting.
    $name = 'theme_essentialbe/skype';
    $title = get_string('skype', 'theme_essentialbe');
    $description = get_string('skypedesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // VKontakte url setting.
    $name = 'theme_essentialbe/vk';
    $title = get_string('vk', 'theme_essentialbe');
    $description = get_string('vkdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    /* Apps Settings */
    $temp->add(new admin_setting_heading('theme_essentialbe_mobileapps', get_string('mobileappsheadingsub', 'theme_essentialbe'),
        format_text(get_string('mobileappsdesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    // Android App url setting.
    $name = 'theme_essentialbe/android';
    $title = get_string('android', 'theme_essentialbe');
    $description = get_string('androiddesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Windows App url setting.
    $name = 'theme_essentialbe/windows';
    $title = get_string('windows', 'theme_essentialbe');
    $description = get_string('windowsdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Windows PhoneApp url setting.
    $name = 'theme_essentialbe/winphone';
    $title = get_string('winphone', 'theme_essentialbe');
    $description = get_string('winphonedesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // iOS App url setting.
    $name = 'theme_essentialbe/ios';
    $title = get_string('ios', 'theme_essentialbe');
    $description = get_string('iosdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for iOS Icons
    $name = 'theme_essentialbe/iosiconinfo';
    $heading = get_string('iosicon', 'theme_essentialbe');
    $information = get_string('iosicondesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // iPhone Icon.
    $name = 'theme_essentialbe/iphoneicon';
    $title = get_string('iphoneicon', 'theme_essentialbe');
    $description = get_string('iphoneicondesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'iphoneicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // iPhone Retina Icon.
    $name = 'theme_essentialbe/iphoneretinaicon';
    $title = get_string('iphoneretinaicon', 'theme_essentialbe');
    $description = get_string('iphoneretinaicondesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'iphoneretinaicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // iPad Icon.
    $name = 'theme_essentialbe/ipadicon';
    $title = get_string('ipadicon', 'theme_essentialbe');
    $description = get_string('ipadicondesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'ipadicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // iPad Retina Icon.
    $name = 'theme_essentialbe/ipadretinaicon';
    $title = get_string('ipadretinaicon', 'theme_essentialbe');
    $description = get_string('ipadretinaicondesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'ipadretinaicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $ADMIN->add('theme_essentialbe', $temp);


    /* Font Settings */
    $temp = new admin_settingpage('theme_essentialbe_font', get_string('fontsettings', 'theme_essentialbe'));
    // This is the descriptor for the font settings
    $name = 'theme_essentialbe/fontheading';
    $heading = get_string('fontheadingsub', 'theme_essentialbe');
    $information = get_string('fontheadingdesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Font Selector.
    $name = 'theme_essentialbe/fontselect';
    $title = get_string('fontselect', 'theme_essentialbe');
    $description = get_string('fontselectdesc', 'theme_essentialbe');
    $default = 1;
    $choices = array(
        1 => get_string('fonttypestandard', 'theme_essentialbe'),
        2 => get_string('fonttypegoogle', 'theme_essentialbe'),
        3 => get_string('fonttypecustom', 'theme_essentialbe'),
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Heading font name
    $name = 'theme_essentialbe/fontnameheading';
    $title = get_string('fontnameheading', 'theme_essentialbe');
    $description = get_string('fontnameheadingdesc', 'theme_essentialbe');
    $default = 'Verdana';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Text font name
    $name = 'theme_essentialbe/fontnamebody';
    $title = get_string('fontnamebody', 'theme_essentialbe');
    $description = get_string('fontnamebodydesc', 'theme_essentialbe');
    $default = 'Verdana';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    if(get_config('theme_essentialbe', 'fontselect') === "2") {
        // Google Font Character Sets
        $name = 'theme_essentialbe/fontcharacterset';
        $title = get_string('fontcharacterset', 'theme_essentialbe');
        $description = get_string('fontcharactersetdesc', 'theme_essentialbe');
        $default = 'latin-ext';
        $setting = new admin_setting_configmulticheckbox($name, $title, $description, $default, array(
            'latin-ext' => get_string('fontcharactersetlatinext', 'theme_essentialbe'),
            'cyrillic' => get_string('fontcharactersetcyrillic', 'theme_essentialbe'),
            'cyrillic-ext' => get_string('fontcharactersetcyrillicext', 'theme_essentialbe'),
            'greek' => get_string('fontcharactersetgreek', 'theme_essentialbe'),
            'greek-ext' => get_string('fontcharactersetgreekext', 'theme_essentialbe'),
            'vietnamese' => get_string('fontcharactersetvietnamese', 'theme_essentialbe'),
        ));
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

    } else if(get_config('theme_essentialbe', 'fontselect') === "3") {

        // This is the descriptor for the font files
        $name = 'theme_essentialbe/fontfiles';
        $heading = get_string('fontfiles', 'theme_essentialbe');
        $information = get_string('fontfilesdesc', 'theme_essentialbe');
        $setting = new admin_setting_heading($name, $heading, $information);
        $temp->add($setting);

        // Heading Fonts.
        // TTF Font.
        $name = 'theme_essentialbe/fontfilettfheading';
        $title = get_string('fontfilettfheading', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilettfheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // OTF Font.
        $name = 'theme_essentialbe/fontfileotfheading';
        $title = get_string('fontfileotfheading', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileotfheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // WOFF Font.
        $name = 'theme_essentialbe/fontfilewoffheading';
        $title = get_string('fontfilewoffheading', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewoffheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // WOFF2 Font.
        $name = 'theme_essentialbe/fontfilewofftwoheading';
        $title = get_string('fontfilewofftwoheading', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewofftwoheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // EOT Font.
        $name = 'theme_essentialbe/fontfileeotheading';
        $title = get_string('fontfileeotheading', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileweotheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // SVG Font.
        $name = 'theme_essentialbe/fontfilesvgheading';
        $title = get_string('fontfilesvgheading', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilesvgheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // Body fonts.
        // TTF Font.
        $name = 'theme_essentialbe/fontfilettfbody';
        $title = get_string('fontfilettfbody', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilettfbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // OTF Font.
        $name = 'theme_essentialbe/fontfileotfbody';
        $title = get_string('fontfileotfbody', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileotfbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // WOFF Font.
        $name = 'theme_essentialbe/fontfilewoffbody';
        $title = get_string('fontfilewoffbody', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewoffbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // WOFF2 Font.
        $name = 'theme_essentialbe/fontfilewofftwobody';
        $title = get_string('fontfilewofftwobody', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewofftwobody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // EOT Font.
        $name = 'theme_essentialbe/fontfileeotbody';
        $title = get_string('fontfileeotbody', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileweotbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // SVG Font.
        $name = 'theme_essentialbe/fontfilesvgbody';
        $title = get_string('fontfilesvgbody', 'theme_essentialbe');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilesvgbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);
    }

    // Include Awesome Font from Bootstrapcdn
    $name = 'theme_essentialbe/bootstrapcdn';
    $title = get_string('bootstrapcdn', 'theme_essentialbe');
    $description = get_string('bootstrapcdndesc', 'theme_essentialbe');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $ADMIN->add('theme_essentialbe', $temp);


    /* Footer Settings */
    $temp = new admin_settingpage('theme_essentialbe_footer', get_string('footerheading', 'theme_essentialbe'));

    // Copyright setting.
    $name = 'theme_essentialbe/copyright';
    $title = get_string('copyright', 'theme_essentialbe');
    $description = get_string('copyrightdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    // Footnote setting.
    $name = 'theme_essentialbe/footnote';
    $title = get_string('footnote', 'theme_essentialbe');
    $description = get_string('footnotedesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Performance Information Display.
    $name = 'theme_essentialbe/perfinfo';
    $title = get_string('perfinfo', 'theme_essentialbe');
    $description = get_string('perfinfodesc', 'theme_essentialbe');
    $perf_max = get_string('perf_max', 'theme_essentialbe');
    $perf_min = get_string('perf_min', 'theme_essentialbe');
    $default = 'min';
    $choices = array('min' => $perf_min, 'max' => $perf_max);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $ADMIN->add('theme_essentialbe', $temp);

    $temp = new admin_settingpage('theme_essentialbe_frontpage', get_string('frontpageheading', 'theme_essentialbe'));

    $name = 'theme_essentialbe/courselistteachericon';
    $title = get_string('courselistteachericon', 'theme_essentialbe');
    $description = get_string('courselistteachericondesc', 'theme_essentialbe');
    $default = 'graduation-cap';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $temp->add(new admin_setting_heading('theme_essentialbe_frontcontent', get_string('frontcontentheading', 'theme_essentialbe'),
        ''));

    // Toggle Frontpage Content.
    $name = 'theme_essentialbe/togglefrontcontent';
    $title = get_string('frontcontent', 'theme_essentialbe');
    $description = get_string('frontcontentdesc', 'theme_essentialbe');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essentialbe');
    $dontdisplay = get_string('dontdisplay', 'theme_essentialbe');
    $default = 0;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Frontpage Content
    $name = 'theme_essentialbe/frontcontentarea';
    $title = get_string('frontcontentarea', 'theme_essentialbe');
    $description = get_string('frontcontentareadesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe_frontpageblocksheading';
    $heading = get_string('frontpageblocksheading', 'theme_essentialbe');
    $information = '';
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Frontpage Block alignment.
    $name = 'theme_essentialbe/frontpageblocks';
    $title = get_string('frontpageblocks', 'theme_essentialbe');
    $description = get_string('frontpageblocksdesc', 'theme_essentialbe');
    $left = get_string('left', 'theme_essentialbe');
    $right = get_string('right', 'theme_essentialbe');
    $default = 1;
    $choices = array(1 => $left, 0 => $right);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Toggle Frontpage Middle Blocks
    $name = 'theme_essentialbe/frontpagemiddleblocks';
    $title = get_string('frontpagemiddleblocks', 'theme_essentialbe');
    $description = get_string('frontpagemiddleblocksdesc', 'theme_essentialbe');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essentialbe');
    $dontdisplay = get_string('dontdisplay', 'theme_essentialbe');
    $default = 0;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);


    /* Marketing Spot Settings */
    $temp->add(new admin_setting_heading('theme_essentialbe_marketing', get_string('marketingheadingsub', 'theme_essentialbe'),
        format_text(get_string('marketingdesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    // Toggle Marketing Spots.
    $name = 'theme_essentialbe/togglemarketing';
    $title = get_string('togglemarketing', 'theme_essentialbe');
    $description = get_string('togglemarketingdesc', 'theme_essentialbe');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essentialbe');
    $dontdisplay = get_string('dontdisplay', 'theme_essentialbe');
    $default = 1;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Marketing Spot Image Height.
    $name = 'theme_essentialbe/marketingheight';
    $title = get_string('marketingheight', 'theme_essentialbe');
    $description = get_string('marketingheightdesc', 'theme_essentialbe');
    $default = 100;
    $choices = array(50 => '50', 100 => '100', 150 => '150', 200 => '200', 250 => '250', 300 => '300');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $temp->add($setting);

    // This is the descriptor for Marketing Spot One.
    $name = 'theme_essentialbe/marketing1info';
    $heading = get_string('marketing1', 'theme_essentialbe');
    $information = get_string('marketinginfodesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Marketing Spot One.
    $name = 'theme_essentialbe/marketing1';
    $title = get_string('marketingtitle', 'theme_essentialbe');
    $description = get_string('marketingtitledesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing1icon';
    $title = get_string('marketingicon', 'theme_essentialbe');
    $description = get_string('marketingicondesc', 'theme_essentialbe');
    $default = 'star';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing1image';
    $title = get_string('marketingimage', 'theme_essentialbe');
    $description = get_string('marketingimagedesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing1image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing1content';
    $title = get_string('marketingcontent', 'theme_essentialbe');
    $description = get_string('marketingcontentdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing1buttontext';
    $title = get_string('marketingbuttontext', 'theme_essentialbe');
    $description = get_string('marketingbuttontextdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing1buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_essentialbe');
    $description = get_string('marketingbuttonurldesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing1target';
    $title = get_string('marketingurltarget', 'theme_essentialbe');
    $description = get_string('marketingurltargetdesc', 'theme_essentialbe');
    $target1 = get_string('marketingurltargetself', 'theme_essentialbe');
    $target2 = get_string('marketingurltargetnew', 'theme_essentialbe');
    $target3 = get_string('marketingurltargetparent', 'theme_essentialbe');
    $default = '_blank';
    $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for Marketing Spot Two.
    $name = 'theme_essentialbe/marketing2info';
    $heading = get_string('marketing2', 'theme_essentialbe');
    $information = get_string('marketinginfodesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Marketing Spot Two.
    $name = 'theme_essentialbe/marketing2';
    $title = get_string('marketingtitle', 'theme_essentialbe');
    $description = get_string('marketingtitledesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing2icon';
    $title = get_string('marketingicon', 'theme_essentialbe');
    $description = get_string('marketingicondesc', 'theme_essentialbe');
    $default = 'star';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing2image';
    $title = get_string('marketingimage', 'theme_essentialbe');
    $description = get_string('marketingimagedesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing2image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing2content';
    $title = get_string('marketingcontent', 'theme_essentialbe');
    $description = get_string('marketingcontentdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing2buttontext';
    $title = get_string('marketingbuttontext', 'theme_essentialbe');
    $description = get_string('marketingbuttontextdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing2buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_essentialbe');
    $description = get_string('marketingbuttonurldesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing2target';
    $title = get_string('marketingurltarget', 'theme_essentialbe');
    $description = get_string('marketingurltargetdesc', 'theme_essentialbe');
    $target1 = get_string('marketingurltargetself', 'theme_essentialbe');
    $target2 = get_string('marketingurltargetnew', 'theme_essentialbe');
    $target3 = get_string('marketingurltargetparent', 'theme_essentialbe');
    $default = '_blank';
    $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for Marketing Spot Three
    $name = 'theme_essentialbe/marketing3info';
    $heading = get_string('marketing3', 'theme_essentialbe');
    $information = get_string('marketinginfodesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Marketing Spot Three.
    $name = 'theme_essentialbe/marketing3';
    $title = get_string('marketingtitle', 'theme_essentialbe');
    $description = get_string('marketingtitledesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing3icon';
    $title = get_string('marketingicon', 'theme_essentialbe');
    $description = get_string('marketingicondesc', 'theme_essentialbe');
    $default = 'star';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing3image';
    $title = get_string('marketingimage', 'theme_essentialbe');
    $description = get_string('marketingimagedesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing3image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing3content';
    $title = get_string('marketingcontent', 'theme_essentialbe');
    $description = get_string('marketingcontentdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing3buttontext';
    $title = get_string('marketingbuttontext', 'theme_essentialbe');
    $description = get_string('marketingbuttontextdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing3buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_essentialbe');
    $description = get_string('marketingbuttonurldesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing3target';
    $title = get_string('marketingurltarget', 'theme_essentialbe');
    $description = get_string('marketingurltargetdesc', 'theme_essentialbe');
    $target1 = get_string('marketingurltargetself', 'theme_essentialbe');
    $target2 = get_string('marketingurltargetnew', 'theme_essentialbe');
    $target3 = get_string('marketingurltargetparent', 'theme_essentialbe');
    $default = '_blank';
    $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This enables second row of marketing spots.

    $name = 'theme_essentialbe/marketingsecondrow';
    $heading = get_string('marketingsecondrow', 'theme_essentialbe');
    $information = get_string('marketingsecondrowdesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);
    
    $marketingsecondrowstr = get_string('marketingsecondrowenable', 'theme_essentialbe');
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new admin_setting_configselect('theme_essentialbe/marketingsecondrowenable', $marketingsecondrowstr, '', 0, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for Marketing Spot One.
    $name = 'theme_essentialbe/marketing4info';
    $heading = get_string('marketing4', 'theme_essentialbe');
    $information = get_string('marketinginfodesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Marketing Spot Four.
    $name = 'theme_essentialbe/marketing4';
    $title = get_string('marketingtitle', 'theme_essentialbe');
    $description = get_string('marketingtitledesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing4icon';
    $title = get_string('marketingicon', 'theme_essentialbe');
    $description = get_string('marketingicondesc', 'theme_essentialbe');
    $default = 'star';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing4image';
    $title = get_string('marketingimage', 'theme_essentialbe');
    $description = get_string('marketingimagedesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing4image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing4content';
    $title = get_string('marketingcontent', 'theme_essentialbe');
    $description = get_string('marketingcontentdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing4buttontext';
    $title = get_string('marketingbuttontext', 'theme_essentialbe');
    $description = get_string('marketingbuttontextdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing4buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_essentialbe');
    $description = get_string('marketingbuttonurldesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing4target';
    $title = get_string('marketingurltarget', 'theme_essentialbe');
    $description = get_string('marketingurltargetdesc', 'theme_essentialbe');
    $target1 = get_string('marketingurltargetself', 'theme_essentialbe');
    $target2 = get_string('marketingurltargetnew', 'theme_essentialbe');
    $target3 = get_string('marketingurltargetparent', 'theme_essentialbe');
    $default = '_blank';
    $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for Marketing Spot Five.

    $name = 'theme_essentialbe/marketing5info';
    $heading = get_string('marketing5', 'theme_essentialbe');
    $information = get_string('marketinginfodesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Marketing Spot Five.
    $name = 'theme_essentialbe/marketing5';
    $title = get_string('marketingtitle', 'theme_essentialbe');
    $description = get_string('marketingtitledesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing5icon';
    $title = get_string('marketingicon', 'theme_essentialbe');
    $description = get_string('marketingicondesc', 'theme_essentialbe');
    $default = 'star';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing5image';
    $title = get_string('marketingimage', 'theme_essentialbe');
    $description = get_string('marketingimagedesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing5image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing5content';
    $title = get_string('marketingcontent', 'theme_essentialbe');
    $description = get_string('marketingcontentdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing5buttontext';
    $title = get_string('marketingbuttontext', 'theme_essentialbe');
    $description = get_string('marketingbuttontextdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing5buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_essentialbe');
    $description = get_string('marketingbuttonurldesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing5target';
    $title = get_string('marketingurltarget', 'theme_essentialbe');
    $description = get_string('marketingurltargetdesc', 'theme_essentialbe');
    $target1 = get_string('marketingurltargetself', 'theme_essentialbe');
    $target2 = get_string('marketingurltargetnew', 'theme_essentialbe');
    $target3 = get_string('marketingurltargetparent', 'theme_essentialbe');
    $default = '_blank';
    $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for Marketing Spot Six.
    $name = 'theme_essentialbe/marketing6info';
    $heading = get_string('marketing6', 'theme_essentialbe');
    $information = get_string('marketinginfodesc', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Marketing Spot Six.
    $name = 'theme_essentialbe/marketing6';
    $title = get_string('marketingtitle', 'theme_essentialbe');
    $description = get_string('marketingtitledesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing6icon';
    $title = get_string('marketingicon', 'theme_essentialbe');
    $description = get_string('marketingicondesc', 'theme_essentialbe');
    $default = 'star';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing6image';
    $title = get_string('marketingimage', 'theme_essentialbe');
    $description = get_string('marketingimagedesc', 'theme_essentialbe');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing6image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing6content';
    $title = get_string('marketingcontent', 'theme_essentialbe');
    $description = get_string('marketingcontentdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing6buttontext';
    $title = get_string('marketingbuttontext', 'theme_essentialbe');
    $description = get_string('marketingbuttontextdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing6buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_essentialbe');
    $description = get_string('marketingbuttonurldesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_essentialbe/marketing6target';
    $title = get_string('marketingurltarget', 'theme_essentialbe');
    $description = get_string('marketingurltargetdesc', 'theme_essentialbe');
    $target1 = get_string('marketingurltargetself', 'theme_essentialbe');
    $target2 = get_string('marketingurltargetnew', 'theme_essentialbe');
    $target3 = get_string('marketingurltargetparent', 'theme_essentialbe');
    $default = '_blank';
    $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    /* User Alerts */
    $temp->add(new admin_setting_heading('theme_essentialbe_alerts', get_string('alertsheadingsub', 'theme_essentialbe'),
        format_text(get_string('alertsdesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    $information = get_string('alertinfodesc', 'theme_essentialbe');

    // This is the descriptor for Alert One
    $name = 'theme_essentialbe/alert1info';
    $heading = get_string('alert1', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Enable Alert
    $name = 'theme_essentialbe/enable1alert';
    $title = get_string('enablealert', 'theme_essentialbe');
    $description = get_string('enablealertdesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Type.
    $name = 'theme_essentialbe/alert1type';
    $title = get_string('alerttype', 'theme_essentialbe');
    $description = get_string('alerttypedesc', 'theme_essentialbe');
    $alert_info = get_string('alert_info', 'theme_essentialbe');
    $alert_warning = get_string('alert_warning', 'theme_essentialbe');
    $alert_general = get_string('alert_general', 'theme_essentialbe');
    $default = 'info';
    $choices = array('info' => $alert_info, 'error' => $alert_warning, 'success' => $alert_general);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Title.
    $name = 'theme_essentialbe/alert1title';
    $title = get_string('alerttitle', 'theme_essentialbe');
    $description = get_string('alerttitledesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Text.
    $name = 'theme_essentialbe/alert1text';
    $title = get_string('alerttext', 'theme_essentialbe');
    $description = get_string('alerttextdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for Alert Two
    $name = 'theme_essentialbe/alert2info';
    $heading = get_string('alert2', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Enable Alert
    $name = 'theme_essentialbe/enable2alert';
    $title = get_string('enablealert', 'theme_essentialbe');
    $description = get_string('enablealertdesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Type.
    $name = 'theme_essentialbe/alert2type';
    $title = get_string('alerttype', 'theme_essentialbe');
    $description = get_string('alerttypedesc', 'theme_essentialbe');
    $alert_info = get_string('alert_info', 'theme_essentialbe');
    $alert_warning = get_string('alert_warning', 'theme_essentialbe');
    $alert_general = get_string('alert_general', 'theme_essentialbe');
    $default = 'info';
    $choices = array('info' => $alert_info, 'error' => $alert_warning, 'success' => $alert_general);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Title.
    $name = 'theme_essentialbe/alert2title';
    $title = get_string('alerttitle', 'theme_essentialbe');
    $description = get_string('alerttitledesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Text.
    $name = 'theme_essentialbe/alert2text';
    $title = get_string('alerttext', 'theme_essentialbe');
    $description = get_string('alerttextdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for Alert Three
    $name = 'theme_essentialbe/alert3info';
    $heading = get_string('alert3', 'theme_essentialbe');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Enable Alert
    $name = 'theme_essentialbe/enable3alert';
    $title = get_string('enablealert', 'theme_essentialbe');
    $description = get_string('enablealertdesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Type.
    $name = 'theme_essentialbe/alert3type';
    $title = get_string('alerttype', 'theme_essentialbe');
    $description = get_string('alerttypedesc', 'theme_essentialbe');
    $alert_info = get_string('alert_info', 'theme_essentialbe');
    $alert_warning = get_string('alert_warning', 'theme_essentialbe');
    $alert_general = get_string('alert_general', 'theme_essentialbe');
    $default = 'info';
    $choices = array('info' => $alert_info, 'error' => $alert_warning, 'success' => $alert_general);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Title.
    $name = 'theme_essentialbe/alert3title';
    $title = get_string('alerttitle', 'theme_essentialbe');
    $description = get_string('alerttitledesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Text.
    $name = 'theme_essentialbe/alert3text';
    $title = get_string('alerttext', 'theme_essentialbe');
    $description = get_string('alerttextdesc', 'theme_essentialbe');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $ADMIN->add('theme_essentialbe', $temp);

    /* Slideshow Widget Settings */
    $temp = new admin_settingpage('theme_essentialbe_slideshow', get_string('slideshowheading', 'theme_essentialbe'));
    $temp->add(new admin_setting_heading('theme_essentialbe_slideshow', get_string('slideshowheadingsub', 'theme_essentialbe'),
        format_text(get_string('slideshowdesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    // Toggle Slideshow.
    $name = 'theme_essentialbe/toggleslideshow';
    $title = get_string('toggleslideshow', 'theme_essentialbe');
    $description = get_string('toggleslideshowdesc', 'theme_essentialbe');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_essentialbe');
    $dontdisplay = get_string('dontdisplay', 'theme_essentialbe');
    $default = 1;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

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
    $temp->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

    // Hide slideshow on phones.
    $name = 'theme_essentialbe/hideontablet';
    $title = get_string('hideontablet', 'theme_essentialbe');
    $description = get_string('hideontabletdesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Hide slideshow on tablet.
    $name = 'theme_essentialbe/hideonphone';
    $title = get_string('hideonphone', 'theme_essentialbe');
    $description = get_string('hideonphonedesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Slide interval.
    $name = 'theme_essentialbe/slideinterval';
    $title = get_string('slideinterval', 'theme_essentialbe');
    $description = get_string('slideintervaldesc', 'theme_essentialbe');
    $default = '5000';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Slide Text colour setting.
    $name = 'theme_essentialbe/slidecolor';
    $title = get_string('slidecolor', 'theme_essentialbe');
    $description = get_string('slidecolordesc', 'theme_essentialbe');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Show caption options.
    $name = 'theme_essentialbe/slidecaptionoptions';
    $title = get_string('slidecaptionoptions', 'theme_essentialbe');
    $description = get_string('slidecaptionoptionsdesc', 'theme_essentialbe');
    $default = '0';
    $choices = array(
        0 => get_string('slidecaptionbeside', 'theme_essentialbe'),
        1 => get_string('slidecaptionontop', 'theme_essentialbe'),
        2 => get_string('slidecaptionunderneath', 'theme_essentialbe'),
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Show caption centred.
    $name = 'theme_essentialbe/slidecaptioncentred';
    $title = get_string('slidecaptioncentred', 'theme_essentialbe');
    $description = get_string('slidecaptioncentreddesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Slide button colour setting.
    $name = 'theme_essentialbe/slidebuttoncolor';
    $title = get_string('slidebuttoncolor', 'theme_essentialbe');
    $description = get_string('slidebuttoncolordesc', 'theme_essentialbe');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Slide button hover colour setting.
    $name = 'theme_essentialbe/slidebuttonhovercolor';
    $title = get_string('slidebuttonhovercolor', 'theme_essentialbe');
    $description = get_string('slidebuttonhovercolordesc', 'theme_essentialbe');
    $default = '#217a94';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $numberofslides = get_config('theme_essentialbe', 'numberofslides');
    for ($i = 1; $i <= $numberofslides; $i++) {
        // This is the descriptor for Slide One
        $name = 'theme_essentialbe/slide' . $i . 'info';
        $heading = get_string('slideno', 'theme_essentialbe', array('slide' => $i));
        $information = get_string('slidenodesc', 'theme_essentialbe', array('slide' => $i));
        $setting = new admin_setting_heading($name, $heading, $information);
        $temp->add($setting);

        // Title.
        $name = 'theme_essentialbe/slide' . $i;
        $title = get_string('slidetitle', 'theme_essentialbe');
        $description = get_string('slidetitledesc', 'theme_essentialbe');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // Image.
        $name = 'theme_essentialbe/slide' . $i . 'image';
        $title = get_string('slideimage', 'theme_essentialbe');
        $description = get_string('slideimagedesc', 'theme_essentialbe');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'slide' . $i . 'image');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // Caption text.
        $name = 'theme_essentialbe/slide' . $i . 'caption';
        $title = get_string('slidecaption', 'theme_essentialbe');
        $description = get_string('slidecaptiondesc', 'theme_essentialbe');
        $default = '';
        $setting = new admin_setting_configtextarea($name, $title, $description, $default, PARAM_TEXT);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // URL.
        $name = 'theme_essentialbe/slide' . $i . 'url';
        $title = get_string('slideurl', 'theme_essentialbe');
        $description = get_string('slideurldesc', 'theme_essentialbe');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // URL target.
        $name = 'theme_essentialbe/slide' . $i . 'target';
        $title = get_string('slideurltarget', 'theme_essentialbe');
        $description = get_string('slideurltargetdesc', 'theme_essentialbe');
        $target1 = get_string('slideurltargetself', 'theme_essentialbe');
        $target2 = get_string('slideurltargetnew', 'theme_essentialbe');
        $target3 = get_string('slideurltargetparent', 'theme_essentialbe');
        $default = '_blank';
        $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
        $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);
    }

    $ADMIN->add('theme_essentialbe', $temp);

    /* Category Settings */
    $temp = new admin_settingpage('theme_essentialbe_categoryicon', get_string('categoryiconheading', 'theme_essentialbe'));
    $temp->add(new admin_setting_heading('theme_essentialbe_categoryicon', get_string('categoryiconheadingsub', 'theme_essentialbe'),
        format_text(get_string('categoryicondesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    // Category Icons.
    $name = 'theme_essentialbe/enablecategoryicon';
    $title = get_string('enablecategoryicon', 'theme_essentialbe');
    $description = get_string('enablecategoryicondesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // We only want to output category icon options if the parent setting is enabled
    if (get_config('theme_essentialbe', 'enablecategoryicon')) {

        // Default Icon Selector.
        $name = 'theme_essentialbe/defaultcategoryicon';
        $title = get_string('defaultcategoryicon', 'theme_essentialbe');
        $description = get_string('defaultcategoryicondesc', 'theme_essentialbe');
        $default = 'folder-open';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // Category Icons.
        $name = 'theme_essentialbe/enablecustomcategoryicon';
        $title = get_string('enablecustomcategoryicon', 'theme_essentialbe');
        $description = get_string('enablecustomcategoryicondesc', 'theme_essentialbe');
        $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        if (get_config('theme_essentialbe', 'enablecustomcategoryicon')) {

            // This is the descriptor for Custom Category Icons
            $name = 'theme_essentialbe/categoryiconinfo';
            $heading = get_string('categoryiconinfo', 'theme_essentialbe');
            $information = get_string('categoryiconinfodesc', 'theme_essentialbe');
            $setting = new admin_setting_heading($name, $heading, $information);
            $temp->add($setting);

            // Get the default category icon.
            $defaultcategoryicon = get_config('theme_essentialbe', 'defaultcategoryicon');
            if (empty($defaultcategoryicon)) {
                $defaultcategoryicon = 'folder-open';
            }

            // Get all category IDs and their pretty names
            require_once($CFG->libdir . '/coursecatlib.php');
            $coursecats = coursecat::make_categories_list();

            // Go through all categories and create the necessary settings
            foreach ($coursecats as $key => $value) {

                // Category Icons for each category.
                $name = 'theme_essentialbe/categoryicon';
                $title = $value;
                $description = get_string('categoryiconcategory', 'theme_essentialbe', array('category' => $value));
                $default = $defaultcategoryicon;
                $setting = new admin_setting_configtext($name . $key, $title, $description, $default);
                $setting->set_updatedcallback('theme_reset_all_caches');
                $temp->add($setting);
            }
            unset($coursecats);
        }
    }

    $ADMIN->add('theme_essentialbe', $temp);

    /* Analytics Settings */
    $temp = new admin_settingpage('theme_essentialbe_analytics', get_string('analytics', 'theme_essentialbe'));
    $temp->add(new admin_setting_heading('theme_essentialbe_analytics', get_string('analyticsheadingsub', 'theme_essentialbe'),
        format_text(get_string('analyticsdesc', 'theme_essentialbe'), FORMAT_MARKDOWN)));

    $name = 'theme_essentialbe/analyticsenabled';
    $title = get_string('analyticsenabled', 'theme_essentialbe');
    $description = get_string('analyticsenableddesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $temp->add($setting);

    $name = 'theme_essentialbe/analytics';
    $title = get_string('analytics', 'theme_essentialbe');
    $description = get_string('analyticsdesc', 'theme_essentialbe');
    $guniversal = get_string('analyticsguniversal', 'theme_essentialbe');
    $piwik = get_string('analyticspiwik', 'theme_essentialbe');
    $default = 'piwik';
    $choices = array(
        'piwik' => $piwik,
        'guniversal' => $guniversal,
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $temp->add($setting);

    if (get_config('theme_essentialbe', 'analytics') === 'piwik') {
        $name = 'theme_essentialbe/analyticssiteid';
        $title = get_string('analyticssiteid', 'theme_essentialbe');
        $description = get_string('analyticssiteiddesc', 'theme_essentialbe');
        $default = '1';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $temp->add($setting);

        $name = 'theme_essentialbe/analyticsimagetrack';
        $title = get_string('analyticsimagetrack', 'theme_essentialbe');
        $description = get_string('analyticsimagetrackdesc', 'theme_essentialbe');
        $default = true;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
        $temp->add($setting);

        $name = 'theme_essentialbe/analyticssiteurl';
        $title = get_string('analyticssiteurl', 'theme_essentialbe');
        $description = get_string('analyticssiteurldesc', 'theme_essentialbe');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $temp->add($setting);
    } else if (get_config('theme_essentialbe', 'analytics') === 'guniversal') {
        $name = 'theme_essentialbe/analyticstrackingid';
        $title = get_string('analyticstrackingid', 'theme_essentialbe');
        $description = get_string('analyticstrackingiddesc', 'theme_essentialbe');
        $default = 'UA-XXXXXXXX-X';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $temp->add($setting);
    }

    $name = 'theme_essentialbe/analyticstrackadmin';
    $title = get_string('analyticstrackadmin', 'theme_essentialbe');
    $description = get_string('analyticstrackadmindesc', 'theme_essentialbe');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $temp->add($setting);

    $name = 'theme_essentialbe/analyticscleanurl';
    $title = get_string('analyticscleanurl', 'theme_essentialbe');
    $description = get_string('analyticscleanurldesc', 'theme_essentialbe');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $temp->add($setting);

    $ADMIN->add('theme_essentialbe', $temp);
}