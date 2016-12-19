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
 * @copyright   2014 Gareth J Barnard, David Bezemer
 * @copyright   2013 Julian Ridden
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$numberofslides = \theme_essentialbe\toolbox::showslider();

if ($numberofslides) {
    $slideinterval  = \theme_essentialbe\toolbox::get_setting('slideinterval');
    $data = array('data' => array('slideright' => !$left));
    if ($slideinterval) {
        $data['data']['slideinterval'] = $slideinterval;
    }
    $PAGE->requires->js_call_amd('theme_essentialbe/carousel', 'init', $data);

    $captionscenter = (\theme_essentialbe\toolbox::get_setting('slidecaptioncentred')) ? ' centred' : '';
    $captionoptions = \theme_essentialbe\toolbox::get_setting('slidecaptionoptions');

    switch($captionoptions) {
        case 0:
            if (\theme_essentialbe\toolbox::get_setting('pagebackground')) {
                $captionsclass = ' pagebackground';
            } else {
                $captionsclass = '';
            }
        break;
        case 1:
            $captionsclass = ' ontop';
        break;
        case 2:
            $captionsclass = ' below';
        break;
        default:
            $captionsclass = '';
    }
    ?>
    <div class="row-fluid">
        <div class="span12">
            <div id="essentialbeCarousel" class="carousel slide" data-interval="<?php echo $slideinterval;?>">
                <?php echo $OUTPUT->essentialbe_edit_button('slideshow');?>
                <ol class="carousel-indicators">
                    <?php echo \theme_essentialbe\toolbox::render_indicators($numberofslides); ?>
                </ol>
                <div class="carousel-inner<?php echo $captionscenter.$captionsclass;?>">
                    <?php
                    if ($left) {
                        for ($slideindex = 1; $slideindex <= $numberofslides; $slideindex++) {
                            echo \theme_essentialbe\toolbox::render_slide($slideindex, $captionoptions);
                        }
                    } else {
                        for ($slideindex = $numberofslides; $slideindex > 0; $slideindex--) {
                            echo \theme_essentialbe\toolbox::render_slide($slideindex, $captionoptions);
                        }
                    }
                    ?>
                </div>
                <?php echo \theme_essentialbe\toolbox::render_slide_controls(); ?>
            </div>
        </div>
    </div>
<?php
}
