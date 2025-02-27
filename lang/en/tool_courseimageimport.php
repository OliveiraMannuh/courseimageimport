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
 * English strings for tool_courseimageimport
 *
 * @package    tool_courseimageimport
 * @copyright  2025, Manuela Oliveira <oliveira.mannuh@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Course Image Batch Import';
$string['description'] = 'Upload a ZIP file containing course images and a CSV file (named courses.csv) with course shortnames and corresponding image filenames. CSV format: shortname,imagefile';
$string['zipfile'] = 'ZIP file';
$string['zipfile_help'] = 'The ZIP file should contain a courses.csv file and all the image files referenced in the CSV. The first line of the CSV should be the header, and each subsequent line should have the course shortname and the image filename.';
$string['import'] = 'Import';

$string['nozipfile'] = 'No ZIP file was uploaded.';
$string['nocsvfile'] = 'The courses.csv file was not found in the ZIP archive.';
$string['cannotreadcsv'] = 'Could not read the courses.csv file.';
$string['invalidrow'] = 'Invalid CSV row';
$string['coursenotfound'] = 'Course not found';
$string['imagenotfound'] = 'Image file not found';
$string['imagesuccess'] = 'Image updated successfully';
$string['imageerror'] = 'Failed to update image';
$string['importresults'] = 'Import completed: {$a->success} successful, {$a->errors} errors';

