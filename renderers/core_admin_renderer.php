<?php

require_once($CFG->dirroot.'/admin/renderer.php');

class theme_essentialbe_core_admin_renderer extends core_admin_renderer {

    function admin_notifications_page($maturity, $insecuredataroot, $errorsdisplayed, $cronoverdue, $dbproblems, $maintenancemode,
        $availableupdates, $availableupdatesfetch, $buggyiconvnomb, $registered, array $cachewarnings = array(), $eventshandlers = 0) {
        global $OUTPUT, $CFG;

        $str = '';

        $str .= $this->header();

        $str .= '<div class="admin-friendly">';

        $str .= $this->quick_access_buttons(true);

        $str .= '</div>';

        $str .= $this->maturity_info($maturity);
        $str .= empty($CFG->disableupdatenotifications) ? $this->available_updates($availableupdates, $availableupdatesfetch) : '';
        $str .= $this->insecure_dataroot_warning($insecuredataroot);
        $str .= $this->display_errors_warning($errorsdisplayed);
        $str .= $this->buggy_iconv_warning($buggyiconvnomb);
        $str .= $this->cron_overdue_warning($cronoverdue);
        $str .= $this->db_problems($dbproblems);
        $str .= $this->maintenance_mode_warning($maintenancemode);
        // $str .= $this->cache_warnings($cachewarnings);
        $str .= $this->registration_warning($registered);

        //////////////////////////////////////////////////////////////////////////////////////////////////
        ////  IT IS ILLEGAL AND A VIOLATION OF THE GPL TO HIDE, REMOVE OR MODIFY THIS COPYRIGHT NOTICE ///
        $str .= $this->moodle_copyright();
        //////////////////////////////////////////////////////////////////////////////////////////////////

        $str .= $this->footer();

        return $str;
    }

    /**
     * Displays all known plugins and links to manage them
     *
     * This default implementation renders all plugins into one big table.
     * Adds more control on uninstall and upgradeinfo
     *
     * @param plugin_manager $pluginman provides information about the plugins.
     * @param array $options filtering options
     * @return string HTML code
     */
    public function plugins_control_panel(core_plugin_manager $pluginman, array $options = array()) {
        global $CFG;

        $plugininfo = $pluginman->get_plugins();
        $systemcontext = context_system::instance();

        // Filter the list of plugins according the options.
        if (!empty($options['updatesonly'])) {
            $updateable = array();
            foreach ($plugininfo as $plugintype => $pluginnames) {
                foreach ($pluginnames as $pluginname => $pluginfo) {
                    if (!empty($pluginfo->availableupdates)) {
                        foreach ($pluginfo->availableupdates as $pluginavailableupdate) {
                            if ($pluginavailableupdate->version > $pluginfo->versiondisk) {
                                $updateable[$plugintype][$pluginname] = $pluginfo;
                            }
                        }
                    }
                }
            }
            $plugininfo = $updateable;
        }

        if (!empty($options['contribonly'])) {
            $contribs = array();
            foreach ($plugininfo as $plugintype => $pluginnames) {
                foreach ($pluginnames as $pluginname => $pluginfo) {
                    if (!$pluginfo->is_standard()) {
                        $contribs[$plugintype][$pluginname] = $pluginfo;
                    }
                }
            }
            $plugininfo = $contribs;
        }

        if (empty($plugininfo)) {
            return '';
        }

        $table = new html_table();
        $table->id = 'plugins-control-panel';
        $table->head = array(
            get_string('displayname', 'core_plugin'),
            get_string('source', 'core_plugin'),
            get_string('version', 'core_plugin'),
            get_string('availability', 'core_plugin'),
            get_string('actions', 'core_plugin'),
            get_string('notes','core_plugin'),
        );
        $table->headspan = array(1, 1, 1, 1, 2, 1);
        $table->colclasses = array(
            'pluginname', 'source', 'version', 'availability', 'settings', 'uninstall', 'notes'
        );

        foreach ($plugininfo as $type => $plugins) {

            $heading = $pluginman->plugintype_name_plural($type);
            $pluginclass = core_plugin_manager::resolve_plugininfo_class($type);
            if ($manageurl = $pluginclass::get_manage_url()) {
                $heading = html_writer::link($manageurl, $heading);
            }
            $header = new html_table_cell(html_writer::tag('span', $heading, array('id'=>'plugin_type_cell_'.$type)));
            $header->header = true;
            $header->colspan = array_sum($table->headspan);
            $header = new html_table_row(array($header));
            $header->attributes['class'] = 'plugintypeheader type-' . $type;
            $table->data[] = $header;

            if (empty($plugins)) {
                $msg = new html_table_cell(get_string('noneinstalled', 'core_plugin'));
                $msg->colspan = array_sum($table->headspan);
                $row = new html_table_row(array($msg));
                $row->attributes['class'] .= 'msg msg-noneinstalled';
                $table->data[] = $row;
                continue;
            }

            foreach ($plugins as $name => $plugin) {

                $fullqualified = $plugin->type.'_'.$plugin->name;

                $row = new html_table_row();
                $row->attributes['class'] = 'type-' . $plugin->type . ' name-' . $plugin->type . '_' . $plugin->name;

                if ($this->page->theme->resolve_image_location('icon', $plugin->type . '_' . $plugin->name)) {
                    $icon = $this->output->pix_icon('icon', '', $plugin->type . '_' . $plugin->name, array('class' => 'icon pluginicon'));
                } else {
                    $icon = $this->output->pix_icon('spacer', '', 'moodle', array('class' => 'icon pluginicon noicon'));
                }
                $status = $plugin->get_status();
                $row->attributes['class'] .= ' status-'.$status;
                if ($status === core_plugin_manager::PLUGIN_STATUS_MISSING) {
                    $msg = html_writer::tag('span', get_string('status_missing', 'core_plugin'), array('class' => 'statusmsg'));
                } else if ($status === core_plugin_manager::PLUGIN_STATUS_NEW) {
                    $msg = html_writer::tag('span', get_string('status_new', 'core_plugin'), array('class' => 'statusmsg'));
                } else {
                    $msg = '';
                }
                $pluginname  = html_writer::tag('div', $icon . '' . $plugin->displayname . ' ' . $msg, array('class' => 'displayname')).
                               html_writer::tag('div', $plugin->component, array('class' => 'componentname'));
                $pluginname  = new html_table_cell($pluginname);

                if ($plugin->is_standard()) {
                    $row->attributes['class'] .= ' standard';
                    $source = new html_table_cell(get_string('sourcestd', 'core_plugin'));
                } else {
                    $row->attributes['class'] .= ' extension';
                    $source = new html_table_cell(get_string('sourceext', 'core_plugin'));
                }

                $version = new html_table_cell($plugin->versiondb);

                $fullqualified = $plugin->type.'_'.$plugin->name;
                $integratorplugin = !empty($CFG->integratorplugins) && in_array($fullqualified, explode(',', $CFG->integratorplugins));
                $canmanage = (empty($CFG->integratorplugins)) || !in_array($fullqualified, explode(',', $CFG->integratorplugins));

                $isenabled = $plugin->is_enabled();
                if (is_null($isenabled)) {
                    $availability = new html_table_cell('');
                } else if ($isenabled) {
                    $row->attributes['class'] .= ' enabled';
                    $availability = new html_table_cell(get_string('pluginenabled', 'core_plugin'));
                } else {
                    $row->attributes['class'] .= ' disabled';
                    $availability = new html_table_cell(get_string('plugindisabled', 'core_plugin'));
                }

                $settingsurl = $plugin->get_settings_url();
                if (!is_null($settingsurl)) {
                    if ($canmanage) {
                        $settings = html_writer::link($settingsurl, get_string('settings', 'core_plugin'), array('class' => 'settings'));
                    } else {
                        $settings = get_string('settings', 'core_plugin');
                    }
                } else {
                    $settings = '';
                }
                $settings = new html_table_cell($settings);

                if ($pluginman->can_uninstall_plugin($plugin->component) && has_capability('local/adminsettings:nobody', $systemcontext)) {
                    // $uninstallurl = $plugin->get_uninstall_url();
                    $uninstallurl = '';
                    $uninstall = html_writer::link($uninstallurl, get_string('uninstall', 'core_plugin'));
                } else {
                    $uninstall = '';
                }
                $uninstall = new html_table_cell($uninstall);

                $requiredby = $pluginman->other_plugins_that_require($plugin->component);
                if ($requiredby) {
                    $requiredby = html_writer::tag('div', get_string('requiredby', 'core_plugin', implode(', ', $requiredby)),
                        array('class' => 'requiredby'));
                } else {
                    $requiredby = '';
                }

                $updateinfo = '';
                if (empty($CFG->disableupdatenotifications) && is_array($plugin->available_updates()) && has_capability('local/adminsettings:nobody', $systemcontext)) {
                    foreach ($plugin->available_updates() as $availableupdate) {
                        $updateinfo .= $this->plugin_available_update_info($availableupdate);
                    }
                }

                $notes = new html_table_cell($requiredby.$updateinfo);

                $row->cells = array(
                    $pluginname, $source, $version, $availability, $settings, $uninstall, $notes
                );
                $table->data[] = $row;
            }
        }

        return html_writer::table($table);
    }

    function quick_access_buttons($full = true) {
        global $OUTPUT, $CFG;

        $str = '';

        $str .= $OUTPUT->heading(get_string('users'));

        $str .= '<div id="admin-user-management">';
        $usersurl = new moodle_url('/admin/user.php');
        $str .= '<a href="'.$usersurl.'" class="admin-flat-button" title="'.get_string('users').'"><img src="'.$OUTPUT->pix_url('a/users', 'theme').'"></a>';

        if ($full) {
            $usersurl = new moodle_url('/admin/tool/uploaduser/index.php');
            $str .= '<a href="'.$usersurl.'" class="admin-flat-button" title="'.get_string('uploadusers', 'theme_essentialbe').'"><img src="'.$OUTPUT->pix_url('a/importusers', 'theme').'"></a>';

            $usersurl = new moodle_url('/user/editadvanced.php?id=-1');
            $str .= '<a href="'.$usersurl.'" class="admin-flat-button" title="'.get_string('adduser', 'theme_essentialbe').'"><img src="'.$OUTPUT->pix_url('a/adduser', 'theme').'"></a>';
        }

        if (!empty($CFG->usemanualldap)) {
            $usersurl = new moodle_url('/admin/tool/userldapinvite/invite.php');
            $str .= '<a href="'.$usersurl.'" class="admin-flat-button" title="'.get_string('inviteuser', 'tool_userldapinvite').'"><img src="'.$OUTPUT->pix_url('a/inviteuser', 'theme').'"></a>';
        }

        if ($full) {
            $usersurl = new moodle_url('/admin/roles/manage.php');
            $str .= '<a href="'.$usersurl.'" class="admin-flat-button" title="'.get_string('defineroles', 'role').'"><img src="'.$OUTPUT->pix_url('a/roles', 'theme').'"></a>';

            $usersurl = new moodle_url('/admin/roles/check.php?contextid=1');
            $str .= '<a href="'.$usersurl.'" class="admin-flat-button" title="'.get_string('checkglobalpermissions', 'role').'"><img src="'.$OUTPUT->pix_url('a/permissions', 'theme').'"></a>';
        }

        $str .= '</div>';

        $str .= $OUTPUT->heading(get_string('cohorts', 'cohort'));
        $str .= '<div id="admin-cohort-management">';

        $cohorturl = new moodle_url('/cohort/index.php');
        $str .= '<a href="'.$cohorturl.'" class="admin-flat-button" title="'.get_string('cohorts', 'cohort').'"><img src="'.$OUTPUT->pix_url('a/cohorts', 'theme').'"></a>';

        $cohorturl = new moodle_url('/enrol/delayedcohort/planner.php', array('view' => 'bycohort'));
        $str .= '<a href="'.$cohorturl.'" class="admin-flat-button" title="'.get_string('planner', 'enrol_delayedcohort').'"><img src="'.$OUTPUT->pix_url('a/cohortplanning', 'theme').'"></a>';

        $str .= '</div>';

        if ($full) {
            $str .= $OUTPUT->heading(get_string('courses'));
            $str .= '<div id="admin-course-management">';
    
            $courseurl = new moodle_url('/course/management.php');
            $str .= '<a href="'.$courseurl.'" class="admin-flat-button" title="'.get_string('courses').'"><img src="'.$OUTPUT->pix_url('a/courses', 'theme').'"></a>';

            $courseurl = new moodle_url('/backup/restorefile.php?contextid=1');
            $str .= '<a href="'.$courseurl.'" class="admin-flat-button" title="'.get_string('restorecourse', 'admin').'"><img src="'.$OUTPUT->pix_url('a/restore', 'theme').'"></a>';

            $str .= '</div>';
        }

        if (is_dir($CFG->dirroot.'/report/globalactivity')) {
            $str .= $OUTPUT->heading(get_string('reports'));
            $str .= '<div id="admin-report-management">';
    
            $courseurl = new moodle_url('/report/globalactivity/index.php');
            $str .= '<a href="'.$courseurl.'" class="admin-flat-button" title="'.get_string('pluginname', 'report_globalactivity').'"><img width="110" height="104" src="'.$OUTPUT->pix_url('a/globalreport', 'theme').'"></a>';
    
            $str .= '</div>';
        }

        if ($full) {
            $str .= $OUTPUT->heading(get_string('technical', 'theme_essentialbe'));
            $str .= '<div id="admin-technical-management">';

            $courseurl = new moodle_url('/admin/purgecaches.php');
            $str .= '<a href="'.$courseurl.'" class="admin-flat-button" title="'.get_string('purgecaches', 'admin').'"><img src="'.$OUTPUT->pix_url('a/purgecaches', 'theme').'"></a>';

            $str .= '</div>';
        }

        return $str;
    }
}