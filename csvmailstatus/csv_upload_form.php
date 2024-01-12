<?php

/**
 * TODO describe file csv_upload_form
 *
 * @package    local_csvmailstatus
 * @copyright  2024 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once $CFG->libdir.'/formslib.php';
class csv_upload_form extends moodleform {
    function definition () {
        $mform = $this->_form;

        $mform->addElement('header', 'formheader', get_string('formheader','local_csvmailstatus'));

        $url = new moodle_url('sample.csv');
        $link = html_writer::link($url, 'sample.csv');
        $mform->addElement('static', 'examplecsv', get_string('examplecsv', 'local_csvmailstatus'), $link);

        $mform->addElement('filepicker', 'uploadfile', get_string('file','local_csvmailstatus'),NULL,['accepted_types'=>array('.csv')]);
        $mform->addRule('uploadfile', null, 'required');

        $this->add_action_buttons(false, get_string('uploadcsv', 'local_csvmailstatus'));
    }

    function validation($data, $files) {
        return [];
    }
}
