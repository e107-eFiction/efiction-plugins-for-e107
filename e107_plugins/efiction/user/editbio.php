<?php
// ----------------------------------------------------------------------
// eFiction 3.2
// Copyright (c) 2007 by Tammy Keefer
// Valid HTML 4.01 Transitional
// Based on eFiction 1.1
// Copyright (C) 2003 by Rebecca Smallwood.
// http://efiction.sourceforge.net/
// ----------------------------------------------------------------------
// LICENSE
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License (GPL)
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// To read the license please visit http://www.gnu.org/copyleft/gpl.html
// ----------------------------------------------------------------------

if(!defined("e107_INIT")) exit( );
 
$uid = isset($_REQUEST['uid']) ? $_REQUEST['uid'] : false;
if(!$uid) $uid = USERUID;
    


$author =  efiction_authors::get_single_author($uid); 
 
$user_id = $author['e107_user_id']; 

/* a bit complicated  *******************************************************/
/* 1. $user_id = 0  use old way, or set this as admin */
/* 3. redirect to e107 usersettings */

/* easier part */
if($user_id > 0 && !isADMIN)   {
 
    if (USERID == $user_id)
    {
    	$url = e107::getUrl()->create('user/myprofile/edit');
        e107::redirect($url); 
    }
    else if(ADMIN && getperms("4"))
    {
       
        $url =  e_ADMIN_ABS."users.php?mode=main&action=edit&id=".$user_id;
       // printx_a($url); die;
        e107::redirect($url); 
    }
    else {
       //var_dump(ADMIN);   var_dump(getperms("4")); var_dump($userData['user_admin']);  die;
       $output .= write_error("(1) "._ERROR);
    }
   
}
else {
 
	if((!isADMIN || uLEVEL > 2) && $uid != USERUID && $action == "editbio") $output .= write_error(_NOTAUTHORIZED);
    
	if(isMEMBER) $output .= "<div id=\"pagetitle\">"._EDITPERSONAL."</div>";
 
	if(!empty($_POST['submit'])) {
		$penname = isset($_POST['newpenname']) ? escapestring($_POST['newpenname']) : false;
        
		$email = escapestring($_POST['email']);  var_dump($email); var_dump(isADMIN);
		if(!isset($email) && !isADMIN) $output .= "<div style='text-align: center;'>"._EMAILREQUIRED."</div>";
		else if($penname && !preg_match("!^[a-z0-9-_ ]{3,30}$!i", $penname)) $output .= "<div style='text-align: center;'>"._BADUSERNAME."</div>";
		else if(!validEmail($email)) $output .= "<div style='text-align: center;'>"._INVALIDEMAIL." "._TRYAGAIN."</div>"; 
		else{
 
			if(isset($_POST['oldpenname']) && $penname != $_POST['oldpenname']) {
				$checkresult = dbquery("SELECT * FROM "._AUTHORTABLE." WHERE penname = '".escapestring($penname)."'");
				if(dbnumrows($checkresult)) {
					$output .= write_message(_PENNAMEINUSE."  "._TRYAGAIN);
				}
				else {
					dbquery("UPDATE "._AUTHORTABLE." SET penname = '".escapestring($penname)."' WHERE uid = '$_POST[uid]'");
					if($logging) dbquery("INSERT INTO ".TABLEPREFIX."fanfiction_log (`log_action`, `log_uid`, `log_ip`, `log_type`) VALUES('".escapestring(sprintf(_NEWPEN, USERPENNAME, USERUID, $_POST[oldpenname], $uid, $penname))."', '".USERUID."', INET_ATON('".$_SERVER['REMOTE_ADDR']."'), 'EB')");
				}
			}
/* The section adds fields from the authorfields table to the authorinfo table allowing dynamic additions to the bio/registration page */
			$fields = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_authorfields WHERE field_on = '1'");
			while($field = dbassoc($fields)) {
				$uid = isset($_POST['uid']) && isNumber($_POST['uid']) ? $_POST['uid'] : false;
				if(!$uid) continue;
				$oldfield = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_authorinfo WHERE field='".$field['field_id']."' AND uid = '".$uid."'");
				if(dbnumrows($oldfield) > 0) {
					$newinfo = isset($_POST["af_".$field['field_name']]) ? escapestring(descript($_POST["af_".$field['field_name']])) : false;
					if(!empty($newinfo)) dbquery("UPDATE ".TABLEPREFIX."fanfiction_authorinfo SET info='".$newinfo."' WHERE uid = '$uid' AND field = '".descript($field['field_id'])."'");
					else dbquery("DELETE FROM ".TABLEPREFIX."fanfiction_authorinfo WHERE uid = '$uid' AND field = '".$field['field_id']."'");
				}
				else if(!empty($_POST["af_".$field['field_name']])) dbquery("INSERT INTO ".TABLEPREFIX."fanfiction_authorinfo(`uid`, `info`, `field`) VALUES('$uid', '".escapestring($_POST["af_".$field['field_name']])."', '".$field['field_id']."');");
			}
/* End dynamic fields */
			dbquery("UPDATE "._AUTHORTABLE." SET realname='".descript(strip_tags(escapestring($_POST['realname'])), $allowed_tags)."', email='$email', bio='".descript(strip_tags(escapestring($_POST['bio']), $allowed_tags))."', image='".($imageupload && !empty($_POST['image']) ? escapestring($_POST['image']) : "")."' WHERE uid = '$uid'");
			$output .= write_message(_ACTIONSUCCESSFUL."  ".(isset($_GET['uid']) ? _BACK2ADMIN : _BACK2ACCT));
		}
	}
	else {
 
        $query =  
  		array(
  			'action' => $action,
  			'uid' => ( $uid != USERUID ? $uid : USERUID),
  		); 
        $query = http_build_query($query , null, '&');   
        $url = "member.php?".$query; 

 
        $output .= "<div id='settingsform' class='col-md-6 offset-md-3'>";
        if(isADMIN) {
          $output .= '<div class="alert alert-info" role="alert"> <h4 class="alert-heading">Only admin info</h4><p>';
           	 $output .= "<div class=\"row mb-3\">";
                $output .= "<div class=\"col-sm-4\"'>Created by admin</div><div class=\"col-sm-8\">".$author["admincreated"]."</div>";
                $output .= "<div class=\"col-sm-4\"'>e107 user</div><div class=\"col-sm-8\">".$author["e107_user_id"]."</div>";
             $output .= "</div>"; 
          $output .= '</div>';
         
        }
        
        $output .= e107::getForm()->open("editbio", "POST",  $url, "class=form-horizontal col-md-6 offset-md-3"); 
 
		$output .= "<div class=\"row mb-3\"><label class=\"col-sm-4 col-form-label\" for='newpenname'>"._PENNAME.":</label>";
              $output .= '<div class="col-sm-8 col-form-label">';
                    $output .= " ".$author['penname'];
		      $output .= "</div>";
        $output .= "</div>";
        
		$output .= "<div class=\"row mb-3\"><label class=\"col-sm-4 col-form-label\" for='realname'>"._REALNAME.":</label>";
              $output .= '<div class="col-sm-8 col-form-label">';
                    $output .= " ".$author['realname'];
		      $output .= "</div>";
        $output .= "</div>";
        
        $field_key = "email";
 		$output .= "<div class=\"row mb-3\"><label class=\"col-sm-4 col-form-label\" for='email'>"._EMAIL.":</label>";
              $output .= '<div class="col-sm-8 col-form-label">';
                    $output .= e107::getForm()->renderElement($field_key, (isset($uid) ? $author['email'] : ""), array( 'type' => 'email', 'data' => 'str' ));
		      $output .= "</div>";
        $output .= "</div>";
        
        $field_key = "bio";
        $output .= '<div class="row mb-3">';
            $output .= "<label class=\"col-sm-4 col-form-label\" for=\'".$field_key."\'>"._BIO.": </label>";
            $output .= '<div class="col-sm-8">'; 
		              $output .= e107::getForm()->renderElement($field_key, (isset($user) ? stripslashes($user['bio']) : ""), array( 'type' => 'textarea', 'data' => 'str' ));
		    $output .= '</div>';
        $output .= '</div>';              
 	    $output .= '<div class="row mb-3">';    
           $output .= '<div class="col-sm-4"></div>';    
            $output .= '<div class="col-sm-8">'; 
       	      $output .= e107::getForm()->hidden("uid", _(isset($user) ? $user['uid'] : "") );
              $output .= e107::getForm()->button("submit", _SUBMIT);
		    $output .= '</div>';        
        $output .= '</div>'; 
	    $output .= e107::getForm()->close();        
        
        if(!isADMIN && $action != "register")
	 	{
			 	$output .= " [<a href=\"admin.php?action=members&delete=$uid\">"._DELETE."</a>]";
	 	}
        
	 	$output .=  write_message("<font color=\"red\">*</font> "._REQUIREDFIELDS). "</div>";
	}
    
}
 


 
        
     