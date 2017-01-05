<?php

require_once($CFG->dirroot.'/admin/renderer.php');

class theme_essentialbe_core_admin_renderer extends core_admin_renderer{

    function admin_notifications_page($maturity, $insecuredataroot, $errorsdisplayed,
        $cronoverdue, $dbproblems, $maintenancemode, $availableupdates, $availableupdatesfetch, $buggyiconvnomb,
        $registered, array $cachewarnings = array()){
        global $OUTPUT, $CFG;

        $str = '';

        $str .= $this->header();

        $str .= $OUTPUT->heading(get_string('users'));
        $str .= '<div id="admin-user-management">';
        $usersurl = new moodle_url('/admin/user.php');
        $str .= '<a href="'.$usersurl.'" class="admin-flat-button" title="'.get_string('users').'"><img src="'.$OUTPUT->pix_url('a/users', 'theme').'"></a>';

        $usersurl = new moodle_url('/admin/tool/uploaduser/index.php');
        $str .= '<a href="'.$usersurl.'" class="admin-flat-button" title="'.get_string('uploadusers', 'theme_essentialbe').'"><img src="'.$OUTPUT->pix_url('a/importusers', 'theme').'"></a>';

        $usersurl = new moodle_url('/user/editadvanced.php?id=-1');
        $str .= '<a href="'.$usersurl.'" class="admin-flat-button" title="'.get_string('adduser', 'theme_essentialbe').'"><img src="'.$OUTPUT->pix_url('a/adduser', 'theme').'"></a>';

        if (file_exists($CFG->dirroot.'/admin/tool/userldapinvite/invite.php')) {
            if (is_enabled_auth('ldap')) {
                $usersurl = new moodle_url('/admin/tool/userldapinvite/invite.php');
                $str .= '<a href="'.$usersurl.'" class="admin-flat-button" title="'.get_string('inviteuser', 'tool_userldapinvite').'"><img src="'.$OUTPUT->pix_url('a/inviteuser', 'theme').'"></a>';
            }
        }

        $str .= '</div>';

        $str .= $OUTPUT->heading(get_string('cohorts', 'cohort'));
        $str .= '<div id="admin-cohort-management">';

        $cohorturl = new moodle_url('/cohort/index.php');
        $str .= '<a href="'.$cohorturl.'" class="admin-flat-button" title="'.get_string('cohorts', 'cohort').'"><img src="'.$OUTPUT->pix_url('a/cohorts', 'theme').'"></a>';

        if (file_exists($CFG->dirroot.'/enrol/delayedcohort/planner.php')) {
            $cohorturl = new moodle_url('/enrol/delayedcohort/planner.php', array('view' => 'bycohort'));
            $str .= '<a href="'.$cohorturl.'" class="admin-flat-button" title="'.get_string('planner', 'enrol_delayedcohort').'"><img src="'.$OUTPUT->pix_url('a/cohortplanning', 'theme').'"></a>';
        }

        $str .= '</div>';

        $str .= $OUTPUT->heading(get_string('roles'));
        $str .= '<div id="admin-roles-management">';
        $rolesurl = new moodle_url('/admin/roles/manage.php');
        $str .= '<a href="'.$rolesurl.'" class="admin-flat-button" title="'.get_string('defineroles', 'role').'"><img src="'.$OUTPUT->pix_url('a/roles', 'theme').'"></a>';

        $rolesurl = new moodle_url('/admin/roles/check.php?contextid=1');
        $str .= '<a href="'.$rolesurl.'" class="admin-flat-button" title="'.get_string('checkglobalpermissions', 'role').'"><img src="'.$OUTPUT->pix_url('a/permissions', 'theme').'"></a>';

        $rolesurl = new moodle_url('/admin/roles/check.php?contextid=1');
        $str .= '<a href="'.$rolesurl.'" class="admin-flat-button" title="'.get_string('assignglobalroles', 'role').'"><img src="'.$OUTPUT->pix_url('a/assignsiteroles', 'theme').'"></a>';

        $str .= '</div>';

        $str .= $OUTPUT->heading(get_string('courses'));
        $str .= '<div id="admin-course-management">';

        $courseurl = new moodle_url('/course/management.php');
        $str .= '<a href="'.$courseurl.'" class="admin-flat-button" title="'.get_string('courses').'"><img src="'.$OUTPUT->pix_url('a/courses', 'theme').'"></a>';

        $str .= '</div>';

        $str .= $OUTPUT->heading(get_string('technical', 'theme_essentialbe'));
        $str .= '<div id="admin-technical-management">';

        $courseurl = new moodle_url('/admin/purgecaches.php');
        $str .= '<a href="'.$courseurl.'" class="admin-flat-button" title="'.get_string('purgecaches', 'admin').'"><img src="'.$OUTPUT->pix_url('a/purgecaches', 'theme').'"></a>';

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
}