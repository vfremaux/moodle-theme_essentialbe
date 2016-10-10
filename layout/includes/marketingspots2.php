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
?>
<div class="row-fluid" id="marketing-spots2">
    <!-- Advert #4 -->
    <div class="marketing-spot span4">
        <!-- Icon & title. Font Awesome icon used. -->
        <h5><span><i
                    class="fa fa-<?php echo theme_essentialbe_get_setting('marketing4icon'); ?>"></i> <?php echo theme_essentialbe_get_setting('marketing4', true); ?></span>
        </h5>
        <?php if (theme_essentialbe_get_setting('marketing4image')) { ?>
            <div class="marketing-image" id="marketing-image4"></div>
        <?php } ?>
        <?php echo theme_essentialbe_get_setting('marketing4content', 'format_text'); ?>
        <div class="button">
            <a href="<?php echo theme_essentialbe_get_setting('marketing4buttonurl'); ?>"
               target="<?php echo theme_essentialbe_get_setting('marketing4target'); ?>"
               class="marketing-button responsive">
                <?php echo theme_essentialbe_get_setting('marketing4buttontext', true); ?>
            </a>
        </div>
    </div>

    <!-- Advert #5 -->
    <div class="marketing-spot span4">
        <!-- Icon & title. Font Awesome icon used. -->
        <h5><span><i
                    class="fa fa-<?php echo theme_essentialbe_get_setting('marketing5icon'); ?>"></i> <?php echo theme_essentialbe_get_setting('marketing5', true); ?></span>
        </h5>
        <?php if (theme_essentialbe_get_setting('marketing5image')) { ?>
            <div class="marketing-image" id="marketing-image5"></div>
        <?php } ?>
        <?php echo theme_essentialbe_get_setting('marketing5content', 'format_text'); ?>
        <div class="button">
            <a href="<?php echo theme_essentialbe_get_setting('marketing5buttonurl'); ?>"
               target="<?php echo theme_essentialbe_get_setting('marketing5target'); ?>"
               class="marketing-button responsive">
                <?php echo theme_essentialbe_get_setting('marketing5buttontext', true); ?>
            </a>
        </div>
    </div>

    <!-- Advert #6 -->
    <div class="marketing-spot span4">
        <!-- Icon & title. Font Awesome icon used. -->
        <h5><span><i
                    class="fa fa-<?php echo theme_essentialbe_get_setting('marketing6icon'); ?>"></i> <?php echo theme_essentialbe_get_setting('marketing6', true); ?></span>
        </h5>
        <?php if (theme_essentialbe_get_setting('marketing6image')) { ?>
            <div class="marketing-image" id="marketing-image6"></div>
        <?php } ?>
        <?php echo theme_essentialbe_get_setting('marketing6content', 'format_text'); ?>
        <div class="button">
            <a href="<?php echo theme_essentialbe_get_setting('marketing6buttonurl'); ?>"
               target="<?php echo theme_essentialbe_get_setting('marketing6target'); ?>"
               class="marketing-button responsive">
                <?php echo theme_essentialbe_get_setting('marketing6buttontext', true); ?>
            </a>
        </div>
    </div>
</div>
<div class="row-fluid" id="marketing-buttons2">
    <!-- Advert Button #4 -->
    <div class="span4">
        <a href="<?php echo theme_essentialbe_get_setting('marketing4buttonurl'); ?>"
           target="<?php echo theme_essentialbe_get_setting('marketing4target'); ?>" class="marketing-button">
            <?php echo theme_essentialbe_get_setting('marketing4buttontext', true); ?>
        </a>
        <?php echo theme_essentialbe_edit_button('theme_essentialbe_frontpage'); ?>
    </div>

    <!-- Advert Button #5 -->
    <div class="span4">
        <a href="<?php echo theme_essentialbe_get_setting('marketing5buttonurl'); ?>"
           target="<?php echo theme_essentialbe_get_setting('marketing5target'); ?>" class="marketing-button">
            <?php echo theme_essentialbe_get_setting('marketing5buttontext', true); ?>
        </a>
        <?php echo theme_essentialbe_edit_button('theme_essentialbe_frontpage'); ?>
    </div>

    <!-- Advert Button #6 -->
    <div class="span4">
        <a href="<?php echo theme_essentialbe_get_setting('marketing6buttonurl'); ?>"
           target="<?php echo theme_essentialbe_get_setting('marketing6target'); ?>" class="marketing-button">
            <?php echo theme_essentialbe_get_setting('marketing6buttontext', true); ?>
        </a>
        <?php echo theme_essentialbe_edit_button('theme_essentialbe_frontpage'); ?>
    </div>
</div>
