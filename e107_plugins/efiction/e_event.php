<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 * XXX HIGHLY EXPERIMENTAL AND SUBJECT TO CHANGE WITHOUT NOTICE. 
*/

if (!defined('e107_INIT')) { exit; }

 

class eficion_event // plugin-folder + '_event'
{

	/**
	 * Configure functions/methods to run when specific e107 events are triggered.
	 * For a list of events, please visit: http://e107.org/developer-manual/classes-and-methods#events
	 * Developers can trigger their own events using: e107::getEvent()->trigger('plugin_event',$array);
	 * Where 'plugin' is the folder of their plugin and 'event' is a unique name of the event.
	 * $array is data which is sent to the triggered function. eg. myfunction($array) in the example below.
	 *
	 * @return array
	 */
	function config()
	{

		$event = array();

		$event[] = array(
			'name'	=> "login", // when this is triggered... (see http://e107.org/developer-manual/classes-and-methods#events)
			'function'	=> "create_author_account", // ..run this function (see below).
		);
        
        //userdatachanged
        
/*
		$event[] = array(
			'name'	=> "user_comment_deleted", // when this is triggered... (see http://e107.org/developer-manual/classes-and-methods#events)
			'function'	=> "commentCountDown", // ..run this function (see below).
		);
*/
		return $event;

	}
    
 
	function create_author_account($data) // the method to run.
	{

        $efiction_prefs = e107::pref('efiction');
        
        if($efiction_prefs['pref_author_after_login']) {
        
            $userData = e107::user(USERID);
            $author_uid = $userData['user_plugin_efiction_author']; 
            $author_level = $userData['user_plugin_efiction_level'];
            
            if($author_uid)  {
             //? check if ID is correct?
            }
            else {
            
                    $insert = array(
					'penname' => $userData['user_name'], 
					'email' => $userData['user_email'],  
					'password' => '', //delete 
					'date' => $userData['user_join'],   
					'_DUPLICATE_KEY_UPDATE' => 1
				);
				$dbinsertid = e107::getDB()->insert("fanfiction_authors", $insert);
				if($dbinsertid)	{
					
					$insert2 = array(
						'uid'    =>  $dbinsertid,
						'level' => 1,  //main admin
						'_DUPLICATE_KEY_UPDATE' => 1
					);
					e107::getDB()->insert("fanfiction_authorprefs", $insert2);
				
                        //update e107 extended field
                        $qry = "
                  		INSERT INTO `#user_extended` (user_extended_id, user_plugin_efiction_author)
                  		VALUES (USERID, $dbinsertid)
                  		ON DUPLICATE KEY UPDATE user_plugin_efiction_author = $dbinsertid
                  		";
                        
                        $sql->gen($qry);
                        
                        e107::setRegistry('core/e107/user/'.USERID);
    
                    }	
                        
            }
        }
 
	}


} //end class