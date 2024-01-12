<?php
/*CSV Mail Status - mail settings
* @author     Ajinkya
* @since      Jan 24
*/

defined('MOODLE_INTERNAL') || die;

global $CFG;

if($ADMIN) {
    $settings = new \admin_settingpage('local_csvmailstatus', get_string('pluginname', 'local_csvmailstatus'));
    $ADMIN->add('localplugins', $settings);

    $settings->add(new admin_setting_configcheckbox('send_random_mails', get_string('setting:randomemail', 'local_csvmailstatus'),get_string('setting:randomemail_title', 'local_csvmailstatus'), 0));

}
