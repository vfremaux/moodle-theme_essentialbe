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

defined('MOODLE_INTERNAL') || die;

function xmldb_theme_essentialbe_install() {
    global $DB, $CFG, $TEST;

    set_config('pagewidth', 100, 'theme_essentialbe');

    if (empty($CFG->custommenuitems)) {
        $supportedlangs = array('en', 'fr');

        $button = new StdClass;
        $button->name = 'allcourses';
        $button->url = '/local/courseindex/browser.php';
        $button->component = 'theme_essentialbe';
        $button->level = 0;
        $buttons[] = $button;

        $button = new StdClass;
        $button->name = 'messaging';
        $button->url = '!/blocks/jmail/mailbox.php';
        $button->component = 'theme_essentialbe';
        $button->level = 0;
        $buttons[] = $button;

        $button = new StdClass;
        $button->name = 'calendar';
        $button->url = '!/calendar/view.php?view=month';
        $button->component = 'theme_essentialbe';
        $button->level = 0;
        $buttons[] = $button;

        $button = new StdClass;
        $button->name = 'admin';
        $button->url = 'local/adminsettings:nobody!/admin/index.php';
        $button->component = 'theme_essentialbe';
        $button->level = 0;
        $buttons[] = $button;

        $button = new StdClass;
        $button->name = 'admin';
        $button->url = 'moodle/site:config^!/local/admin/delegatedadmin.php';
        $button->component = 'theme_essentialbe';
        $button->level = 0;
        $buttons[] = $button;

        $button = new StdClass;
        $button->name = 'profile';
        $button->url = '!/';
        $button->component = 'theme_essentialbe';
        $button->level = 0;
        $buttons[] = $button;

        $button = new StdClass;
        $button->name = 'myprofile';
        $button->url = '!/user/profile.php';
        $button->component = 'theme_essentialbe';
        $button->level = 1;
        $buttons[] = $button;

        $button = new StdClass;
        $button->name = 'editmyprofile';
        $button->url = '!/user/edit.php';
        $button->component = 'theme_essentialbe';
        $button->level = 1;
        $buttons[] = $button;

        $button = new StdClass;
        $button->name = 'changemypassword';
        $button->url = '!/login/change_password.php';
        $button->component = 'theme_essentialbe';
        $button->level = 1;
        $buttons[] = $button;

        $button = new StdClass;
        $button->name = 'mymessagingprefs';
        $button->url = '!/message/edit.php';
        $button->component = 'theme_essentialbe';
        $button->level = 1;
        $buttons[] = $button;

        $button = new StdClass;
        $button->name = 'myfiles';
        $button->url = '!/user/files.php';
        $button->component = 'theme_essentialbe';
        $button->level = 1;
        $buttons[] = $button;

        $button = new StdClass;
        $button->name = 'library';
        $button->url = '!/local/sharedresources/index.php?course=%COURSEID%';
        $button->component = 'theme_essentialbe';
        $button->level = 0;
        $buttons[] = $button;
    
        $button = new StdClass;
        $button->name = 'login';
        $button->url = '0!/login/index.php';
        $button->component = 'core';
        $button->level = 0;
        $buttons[] = $button;
    
        $button = new StdClass;
        $button->name = 'logout';
        $button->url = '!/login/logout.php';
        $button->component = 'core';
        $button->level = 0;
        $buttons[] = $button;

        $btnlines = array();
        foreach ($buttons as $button) {
            $btn = '';
            if ($button->level == 1) {
                $btn .= '- ';
            }
            if ($button->level == 2) {
                $btn .= '-- ';
            }
            foreach ($supportedlangs as $l) {
                $str = new lang_string($button->name, $button->component, $l);
                $btn .= '<span class="multilang" lang="'.$l.'">'.$str.'</span>';
            }
            $btnlines[] = $btn.'|'.$button->url;
        }
        $custommenuitems = implode("\n", $btnlines);

        if (!empty($TEST)) {
            echo ('<pre>'.htmlentities($custommenuitems).'</pre>');
            if ($force = optional_param('force', false, PARAM_BOOL)) {
                set_config('custommenuitems', $custommenuitems);
            }
        } else {
            set_config('custommenuitems', $custommenuitems);
        }
    }

    /*
    if (empty($CFG->custommenuitems)) {
        $CFG->custommenuitems = 'Tous les cours|/local/courseindex/browser.php
Messagerie|!/blocks/jmail/mailbox.php
Calendrier|!/calendar/view.php?view=month
Administration|local/adminsettings:nobody!/admin/index.php
Administration|moodle/site:config^!/local/admin/delegatedadmin.php
Profil|!/
-Voir mon profil|!/user/profile.php
-Modifier mon profil|!/user/edit.php
-Changer mon mot de passe|!/login/change_password.php
-Préférences de notification|!/message/edit.php
-Fichiers personnels|!/user/files.php
Librairie|!/local/sharedresources/index.php?course=%COURSEID%
Déconnexion|!/login/logout.php
Connexion|0!/login
        ';
    */
}