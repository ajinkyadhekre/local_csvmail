<?php

/**
 * TODO describe file index
 *
 * @package    local_csvmailstatus
 * @copyright  2024 YOUR NAME <your@email.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once('csv_upload_form.php');
require_once('send_mail.php');
require_once "{$CFG->dirroot}/local/csvmailstatus/classes/upload_csv.php";

require_login();

$manager = has_capability('local/csvmailstatus:viewpages', context_system::instance());
if (!$manager ) {
    print_error('error:pagepermission', 'local_csvmailstatus');
}

global $DB;

$url = new moodle_url('/local/csvmailstatus/index.php', []);
$PAGE->set_url($url);
$PAGE->set_context(context_system::instance());

$PAGE->set_heading($SITE->fullname);
echo $OUTPUT->header();


$mform = new csv_upload_form();

    if ($formdata = $mform->get_data()) {
        
        $content = $mform->get_file_content('uploadfile');

        $csvupload = new local_csvmailstatus_upload_csv();
        $result = $csvupload->process($content);

        if($result == false){
            print_error('error:csvcolumn', 'local_csvmailstatus');
        }

    } else {
        
        $mform->display();
        
    }

    $userssql = "SELECT u.id,u.email FROM {user} u JOIN {csv_email_users} cu ON cu.email = u.email WHERE mailsent IS NULL order by id DESC";
    $users = $DB->get_records_sql($userssql);
    foreach($users as $key => $value){
        send_sample_email($value);
    }

    $renderer = $PAGE->get_renderer('local_csvmailstatus');
    $renderer->dashboard();
echo $OUTPUT->footer();
