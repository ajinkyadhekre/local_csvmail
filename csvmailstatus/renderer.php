<?php

/**
* Renderer for csvmailstatus local plugin
*
* @package    local_csvmailstatus
* @author     Ajinkya
*
*/
defined('MOODLE_INTERNAL') || die;


class local_csvmailstatus_renderer extends plugin_renderer_base
{
    function dashboard()
    {       
        global $OUTPUT,$DB,$USER;

        $userslist = $DB->get_records('csv_email_users');
        $users = [];
        foreach ($userslist as $key => $value) {
            if($value->mailsent){
                $value->mailtime = date('d/m/Y',$value->mailsent);
            }
            $users[] = $value;
        }
        
        $data = [
            "users" => $users
        ];
        
        echo $OUTPUT->render_from_template('local_csvmailstatus/csvmailstatus_listing', $data);
       
    }

}
