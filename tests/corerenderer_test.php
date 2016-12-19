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
 * Essential theme.
 *
 * @package    theme
 * @subpackage essentialbe
 * @copyright  &copy; 2015-onwards G J Barnard in respect to modifications of the Bootstrap theme.
 * @author     G J Barnard - gjbarnard at gmail dot com and {@link http://moodle.org/user/profile.php?id=442195}
 * @author     Based on code originally written by Bas Brands, David Scotson and many other contributors.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Core renderer unit tests for the Essential theme.
 * @group theme_essentialbe
 */
class theme_essentialbe_corerenderer_testcase extends advanced_testcase {

    protected $outputus;

    protected function setUp() {
        set_config('themetextcolor', '#00ff00', 'theme_essentialbe');
        set_config('logo', '/test.jpg', 'theme_essentialbe');
        $this->resetAfterTest(true);

        global $PAGE;
        $this->outputus = $PAGE->get_renderer('theme_essentialbe', 'core');
        \theme_essentialbe\toolbox::set_core_renderer($this->outputus);
    }

    public function test_version() {
        $ourversion = \theme_essentialbe\toolbox::get_setting('version');
        $coretheme = \theme_config::load('essentialbe');

        $this->assertEquals($coretheme->settings->version, $ourversion);
    }

    public function test_textcolour() {
        $ourcolour = \theme_essentialbe\toolbox::get_setting('themetextcolor');

        $this->assertEquals('#00ff00', $ourcolour);
    }

    public function test_logo() {
        $ourlogo = \theme_essentialbe\toolbox::setting_file_url('logo', 'logo');

        $this->assertEquals('//www.example.com/moodle/pluginfile.php/1/theme_essentialbe/logo/1/test.jpg', $ourlogo);
    }

    public function test_pix() {
        $ouricon = \theme_essentialbe\toolbox::pix_url('essentialbe_button', 'theme');

        $this->assertEquals('http://www.example.com/moodle/theme/image.php/_s/essentialbe/theme/1/essentialbe_button',
            $ouricon->out(false));
    }
}