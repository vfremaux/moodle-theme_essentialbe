<?php
/**
 * Page Theme
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://opensource.org/licenses/gpl-3.0.html.
 *
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @package theme_page
 * @reauthor Valery Fremaux
 * @author Mark Nielsen
 */

require_once $CFG->dirroot.'/course/format/page/renderers.php';

/**
 * Page Layout File
 *
 * @author Valery Fremaux
 * @package theme_page
 */

/// SPECIAL PAGE LAYOUT INITIALISATION

/**
 * page local library
 * @see format_page_default_width_styles
 */
 
?>
<!-- STANDARD THEME HEADER PART 
The following part should be removed and replaced by the header section of the actual theme
-->

<?php
require_once(dirname(__FILE__) . '/includes/header.php'); 
?>

<div id="page" class="container-fluid">
    <div id="page-navbar" class="clearfix row-fluid">
        <div
            class="breadcrumb-nav pull-<?php echo ($left) ? 'left' : 'right'; ?>"><?php echo $OUTPUT->navbar(); ?></div>
        <nav
            class="breadcrumb-button pull-<?php echo ($left) ? 'right' : 'left'; ?>"><?php echo $OUTPUT->page_heading_button(); ?></nav>
    </div>
    <section role="main-content">

<!-- END OF HEADER -->

<!-- page content -->
    <div id="format_page_content" class="format_page_content clearfix">
    	<!-- EVERYTHING HERE IS DEFERRED TO format.php OF THE COURSE FORMAT -->
        <?php echo $OUTPUT->main_content() ?>
    </div>

<!-- STANDARD THEME FOOTER PART -->
    </section>
</div>

<?php require_once(dirname(__FILE__) . '/includes/footer.php'); ?>
</body>
</html>