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
 * @package    block_courseexpiry
 * @copyright  2021 Zentrum für Lernmanagement (www.lernmanagement.at)
 * @author    Robert Schrenk
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/blocks/moodleblock.class.php');

class block_courseexpiry extends block_base {
    public function init() {
        $this->title = get_string('automatedcoursedeletion', 'block_courseexpiry');
    }
    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = (object) array(
            'text' => '',
            'footer' => ''
        );
        $cache = \cache::make('block_courseexpiry', 'sessioncache');
        $showwarning = $cache->get('showwarning');
        if (empty($showwarning)) {
            if (count(\local_courseexpiry\locallib::get_expired_courses() > 0)) {
                $showwarning = 1;
            } else {
                $showwarning = -1;
            }
            $cache->set('showwarning', $showwarning);
        }
        if ($showwarning == 1) {
            global $CFG, $OUTPUT;
            $this->content->text = $OUTPUT->render_from_template(
                'block_courseexpiry/warning',
                array('wwwroot' => $CFG->wwwroot)
            );
        }

        return $this->content;
    }

    public function hide_header() {
        return false;
    }
    public function has_config() {
        return false;
    }
    public function instance_allow_multiple() {
        return false;
    }
}
