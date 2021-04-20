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

namespace block_courseexpiry\privacy;
use core_privacy\local\metadata\collection;
use \core_privacy\local\request\writer;

defined('MOODLE_INTERNAL') || die;

class provider implements
\core_privacy\local\metadata\provider,
\core_privacy\local\request\user_preference_provider {
    public static function get_metadata(collection $collection) : collection {
        $collection->add_user_preference(
            'block_courseexpiry_minimizeuntil',
            'privacy:metadata:preference:block_courseexpiry_minimizeuntil'
        );

        return $collection;
    }
    public static function export_user_preferences(int $userid) {
        $minimizeuntil = \get_user_preferences('block_courseexpiry_minimizeuntil', -1, $userid);
        if ($minimizeuntil > -1) {
            $label = get_string('privacy:metadata:preference:block_courseexpiry_minimizeuntil', 'block_courseexpiry');
            writer::export_user_preference('block_courseexpiry', 'block_courseexpiry_minimizeuntil', $minimizeuntil, $label);
        }
    }
}
