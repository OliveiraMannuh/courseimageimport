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
 * Main page for course image import tool
 *
 * @package    tool_courseimageimport
 * @copyright  2025, Manuela Oliveira <oliveira.mannuh@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot.'/admin/tool/courseimageimport/lib.php');

// Admin check
admin_externalpage_setup('toolcourseimageimport');

$url = new moodle_url('/admin/tool/courseimageimport/index.php');
$PAGE->set_url($url);
$PAGE->set_title(get_string('pluginname', 'tool_courseimageimport'));
$PAGE->set_heading(get_string('pluginname', 'tool_courseimageimport'));

$mform = new tool_courseimageimport_form();

// Process form
if ($data = $mform->get_data()) {
    $results = tool_courseimageimport_process($data);
    
    if (isset($results['error'])) {
        // Show error
        echo $OUTPUT->header();
        echo $OUTPUT->notification($results['error'], 'notifyproblem');
        $mform->display();
        echo $OUTPUT->footer();
        die;
    }
    
    // Show results
    echo $OUTPUT->header();
    echo $OUTPUT->notification(get_string('importresults', 'tool_courseimageimport', $results), 'notifysuccess');
    
    // Display messages
    if (!empty($results['messages'])) {
        echo html_writer::start_tag('div', array('class' => 'import-results'));
        echo html_writer::start_tag('ul');
        foreach ($results['messages'] as $message) {
            echo html_writer::tag('li', $message);
        }
        echo html_writer::end_tag('ul');
        echo html_writer::end_tag('div');
    }
    
    echo $OUTPUT->continue_button($url);
    echo $OUTPUT->footer();
    die;
}

// Display form
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'tool_courseimageimport'));
$mform->display();
echo $OUTPUT->footer();

