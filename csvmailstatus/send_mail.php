<?php
require_once('../../config.php');

function send_sample_email($userid) {
    global $DB;
    $status = false;
    $user = $DB->get_record('user',['id'=>$userid->id]);
    $success    = email_to_user($user, 'noreply@gmail.com', "Sample Email Testing", "Sample mail");
    
    if ($success) { 
        $status = true; 
        $csvmail = $DB->get_field('csv_email_users','id',['email'=>$userid->email]);
        
        if($csvmail){
            $record = new stdClass();
            $record->id = (int)$csvmail;
            $record->mailsent = time();
            
            if($record->id){
                $id = $DB->update_record('csv_email_users',(object)$record);
            }
            
        }
    }
    
    return $status;
}
