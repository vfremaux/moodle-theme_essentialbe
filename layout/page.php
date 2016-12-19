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
 * Version details
 *
 * @package    theme_essentialbe
 * @copyright  2014 Birmingham City University <michael.grant@groupeigs.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */


require_once(\theme_essentialbe\toolbox::get_tile_file('additionaljs'));
require_once(\theme_essentialbe\toolbox::get_tile_file('header'));
?>

<div id="page" class="container-fluid">
    <?php require_once(\theme_essentialbe\toolbox::get_tile_file('pagetopheader')); ?>
    <!-- Start Main Regions -->
    <div id="page-content" class="row-fluid">
<?php
echo $OUTPUT->essentialbe_blocks('page-top', 'row-fluid', 'aside', 'pagetopblocksperrow');
echo '<section id="region-main">';
echo $OUTPUT->course_title();
echo $OUTPUT->course_content_header();
?>
                <!-- EVERYTHING HERE IS DEFERRED TO format.php OF THE COURSE FORMAT -->
                <div id="format-page-content">
                <?php echo $OUTPUT->main_content() ?>
                </div>
<?php
if (empty($PAGE->layout_options['nocoursefooter'])) {
    echo $OUTPUT->course_content_footer();
}
echo '</section>';
?>
    </div>
    <!-- End Main Regions -->
</div>

<?php require_once(\theme_essentialbe\toolbox::get_tile_file('footer')); ?>
</body>
</html>
