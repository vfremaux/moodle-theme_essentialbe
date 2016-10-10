<?php

require('../../../config.php');

require_once($CFG->dirroot.'/theme/essentialbe/db/install.php');

require_login();
require_capability('moodle/site:config', context_system::instance());

global $TEST;
$TEST = true;

xmldb_theme_essentialbe_install();