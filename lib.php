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
 * Plugin for batch course image upload
 *
 * @package    tool_courseimageimport
 * @copyright  2025, Manuela Oliveira <oliveira.mannuh@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/filelib.php');
require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->libdir.'/formslib.php');

class tool_courseimageimport_form extends moodleform {
    public function definition() {
        global $CFG;
        
        $mform = $this->_form;
        
        // Header
        $mform->addElement('header', 'general', get_string('pluginname', 'tool_courseimageimport'));
        
        // Instructional text
        $mform->addElement('static', 'description', '', get_string('description', 'tool_courseimageimport'));
        
        // File manager for ZIP file upload
        $mform->addElement('filepicker', 'zipfile', get_string('zipfile', 'tool_courseimageimport'), null,
            array('accepted_types' => array('.zip')));
        $mform->addRule('zipfile', null, 'required');
        $mform->addHelpButton('zipfile', 'zipfile', 'tool_courseimageimport');
        
        // Submit button
        $this->add_action_buttons(true, get_string('import', 'tool_courseimageimport'));
    }
}

/**
 * Process the uploaded ZIP file and update course images
 *
 * @param object $data Form data
 * @return array Results message
 */
function tool_courseimageimport_process($data) {
    global $CFG, $DB, $USER;
    
    $fs = get_file_storage();
    $context = context_user::instance($USER->id);
    
    // Get the ZIP file
    $files = $fs->get_area_files($context->id, 'user', 'draft', $data->zipfile, 'id', false);
    if (empty($files)) {
        return array('error' => get_string('nozipfile', 'tool_courseimageimport'));
    }
    
    $zipfile = reset($files);
    
    // Create a temporary directory
    $tempdir = make_request_directory();
    $packer = get_file_packer('application/zip');
    $zipfile->extract_to_pathname($packer, $tempdir);
    
    // Process the CSV file
    $csvfile = $tempdir . '/courses.csv';
    if (!file_exists($csvfile)) {
        return array('error' => get_string('nocsvfile', 'tool_courseimageimport'));
    }
    
    $handle = fopen($csvfile, 'r');
    if (!$handle) {
        return array('error' => get_string('cannotreadcsv', 'tool_courseimageimport'));
    }
    
    $results = array(
        'success' => 0,
        'errors' => 0,
        'messages' => array()
    );
    
    // Skip header row
    fgetcsv($handle);
    
    // Process each row
    while (($data = fgetcsv($handle)) !== false) {
        if (count($data) < 2) {
            $results['errors']++;
            $results['messages'][] = get_string('invalidrow', 'tool_courseimageimport') . ': ' . implode(',', $data);
            continue;
        }
        
        $shortname = trim($data[0]);
        $imagefile = trim($data[1]);
        
        // Check if course exists
        $course = $DB->get_record('course', array('shortname' => $shortname));
        if (!$course) {
            $results['errors']++;
            $results['messages'][] = get_string('coursenotfound', 'tool_courseimageimport') . ': ' . $shortname;
            continue;
        }
        
        // Check if image file exists
        $imagepath = $tempdir . '/' . $imagefile;
        if (!file_exists($imagepath)) {
            $results['errors']++;
            $results['messages'][] = get_string('imagenotfound', 'tool_courseimageimport') . ': ' . $imagefile;
            continue;
        }
        
        // Upload the image to the course
        $coursecontext = context_course::instance($course->id);
        $success = tool_courseimageimport_set_image($course, $imagepath, $coursecontext);
        
        if ($success) {
            $results['success']++;
            $results['messages'][] = get_string('imagesuccess', 'tool_courseimageimport') . ': ' . $shortname;
        } else {
            $results['errors']++;
            $results['messages'][] = get_string('imageerror', 'tool_courseimageimport') . ': ' . $shortname;
        }
    }
    
    fclose($handle);
    
    return $results;
}

/**
 * Set course image
 *
 * @param object $course Course object
 * @param string $imagepath Path to image file
 * @param object $coursecontext Course context
 * @return bool Success or failure
 */
function tool_courseimageimport_set_image($course, $imagepath, $coursecontext) {
    global $CFG;
    
    $fs = get_file_storage();
    
    // Delete existing course images
    $fs->delete_area_files($coursecontext->id, 'course', 'overviewfiles');
    
    // Create new file record
    $filerecord = array(
        'contextid' => $coursecontext->id,
        'component' => 'course',
        'filearea' => 'overviewfiles',
        'itemid' => 0,
        'filepath' => '/',
        'filename' => basename($imagepath)
    );
    
    // Create file from path
    try {
        $fs->create_file_from_pathname($filerecord, $imagepath);
        // Trigger course updated event
        $event = \core\event\course_updated::create(array(
            'objectid' => $course->id,
            'context' => $coursecontext,
            'other' => array('shortname' => $course->shortname)
        ));
        $event->trigger();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

