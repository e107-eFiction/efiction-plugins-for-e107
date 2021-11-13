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

 

class efiction_event // plugin-folder + '_event'
{

	/**
	 * Configure functions/methods to run when specific e107 events are triggered.
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
			'name'	=> "login", 
			'function'	=> "create_author_account", // ..run this function (see below).
		);
        
		$event[] = array(
			'name'	=> "user_profile_edit",  
			'function'	=> "create_author_account", // ..run this function (see below).
		);        
 
        
        //userdatachanged
        
/*
		$event[] = array(
			'name'	=> "user_comment_deleted",  
			'function'	=> "commentCountDown", // ..run this function (see below).
		);
*/
		return $event;

	}
    
	function check_author_account($data) // the method to run.
	{
            $userData = e107::user(USERID);
            $author_uid = $userData['user_plugin_efiction_author_uid']; 
            
 
    }
    
	function create_author_account($data) // the method to run.
	{
 
        $efiction_prefs = e107::pref('efiction');
        // $efiction_prefs['pref_author_after_login']
        if(true) {
        
            $userData = e107::user(USERID);
            $author_uid = $userData['user_plugin_efiction_author_uid']; 
 
            if($author_uid)  {
                  /* if already exists author with that penname, unattached to user, it is solved by _DUPLICATE_KEY_UPDATE */
                  /* cheks prefs */
                  $authorquery = "SELECT  
        			author.uid as author_uid, 
        			author.penname as penname, 
        			author.email as email, 
        			author.password as password 
        			FROM #fanfiction_authors as author  
                    WHERE author.uid = ".$author_uid." LIMIT 1" ; 
                    if($authordata = e107::getDb()->retrieve($authorquery))  { 
                       $authorprefsquery = "SELECT #fanfiction_authorprefs as ap ON ap.uid = ".$author_uid." LIMIT 1";
                       if($authordprefsdata = e107::getDb()->retrieve($authorprefsquery))  { 
                       }
                       else { 
                             $insert2 = array(
        						'uid'    =>  $author_uid,
        						'_DUPLICATE_KEY_UPDATE' => 1
        					 );
        					 e107::getDB()->insert("fanfiction_authorprefs", $insert2);
                       }
                    }
            }
            else {  
                 /* check penname */
                $authorquery = "SELECT  
      			author.uid as author_uid, 
      			author.penname as penname, 
      			author.email as email, 
      			author.password as password 
      			FROM #fanfiction_authors as author  
                WHERE author.penname = '".$userData['user_name']."' OR author.email = '".$userData['user_email']."' "  ; 
 
                $authordata = e107::getDb()->retrieve($authorquery);
             
                if($authordata = e107::getDb()->retrieve($authorquery))  {
                    /* if the name and email are the same */
                   
                    if($authordata['email'] ==  $userData['user_email'] && $authordata['penname'] ==  $userData['user_name'])
                    {
 
                        /* not generate author */
                        $ue = new e107_user_extended;
      	                $ue->user_extended_setvalue(USERID, 'user_plugin_efiction_author_uid', $authordata['author_uid']);
                        $message = "Succcesfully added author with penname ".$authordata['penname'];
                         echo  e107::getMessage()->addSuccess($message)->render();
                          
                    }  
                    else 
                    {
                
                       $message = "Something is wrong with possible Author account. Your email or penname could be used with different user account. Contact administrators";
                       echo e107::getMessage()->addWarning($message)->render();
                       //todo warning
                    } 
                }
                /* penname doesn't exist */ 
                else 
                {
                  
                   $insert = array(
  					'penname' => $userData['user_name'], 
  					'email' => $userData['user_email'],  
  					'password' => '', //delete 
  					'date' => $userData['user_join'], 
                     'user_id' => USERID,  
  					'_DUPLICATE_KEY_UPDATE' => 1
    				);
    				$dbinsertid = e107::getDB()->insert("fanfiction_authors", $insert);
                    
    				if($dbinsertid)	{
   
  					$insert2 = array(
  						'uid'    =>  $dbinsertid,
                        'level'  => 1,
  						'_DUPLICATE_KEY_UPDATE' => 1
  					);
  					e107::getDB()->insert("fanfiction_authorprefs", $insert2);
  				
                     $ue = new e107_user_extended;
  	                 $ue->user_extended_setvalue(USERID, 'user_plugin_efiction_author_uid', $dbinsertid);
  
                     e107::getDb()->gen($qry);
                          
                     e107::setRegistry('core/e107/user/'.USERID);
  
                }      
                }        
            }
        }
 
	}


} //end class