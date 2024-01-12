<?php
defined('MOODLE_INTERNAL') || die();

class local_csvmailstatus_upload_csv {
    public static function process($data) {
        global $DB;
        if($data){
            $data = explode(PHP_EOL,$data);
            $keys = explode(",",$data[0]);

            if(strpos($data[0],'firstname') == false && strpos($data[0],'lastname') == false && 
                strpos($data[0],'email') == false){
                    return false;
                }
            
            foreach ($data as $key => $value) {
                if($key != 0 && !empty($value)){
                    $splitvalues = explode(",",$value);
                    $record = [];
                    $record[$keys[0]] = $splitvalues[0];
                    $record[$keys[1]] = $splitvalues[1];
                    $record[$keys[2]] = $splitvalues[2];
                    $csvdata = (object) $record;
                    
                    $recordexistssql = "SELECT id FROM {csv_email_users} WHERE ".$keys[0]." = ? AND ".$keys[1]." = ? AND ".$keys[2]." = ?";
                    $recordexist = $DB->get_field_sql($recordexistssql,[$splitvalues[0],$splitvalues[1],$splitvalues[2]]);

                    $userexists = $DB->get_record('user',['email'=>$splitvalues[2]]);
                    if(!$userexists){
                        $isuser = self::create_user($record);
                    }
                    
                    if($recordexist){
                        $csvdata->id = $recordexistssql;
                        $DB->update_record('csv_email_users',$csvdata);
                    }else{
                        $DB->insert_record('csv_email_users',$csvdata);
                    }
                    
                }
                
            }
            return true;
        }
        
    }

    public static function create_user($userdata){
        global $DB,$USER;
        
        // Creating new user.
        $user = new stdClass();
        $user->id = -1;
        $user->auth = 'manual';
        $user->confirmed = 1;
        $user->deleted = 0;
        $user->timezone = '99';
        $user->username = strtolower($userdata['firstname']);
        $user->firstname = $userdata['firstname'];
        $user->lastname = $userdata['lastname'];
        $user->email = $userdata['email'];
        
        $authplugin = get_auth_plugin($user->auth);

        $user->timecreated = time();
        $user->password = '';
        
        $usernew->id = user_create_user($user, false, false);
        
    }
}
