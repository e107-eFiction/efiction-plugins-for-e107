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

if (!defined('e107_INIT')) { exit; }

function sendemail($to_name,$to_email,$from_name,$from_email,$subject,$message,$type="plain",$cc="",$bcc="") {
                 
    $eml = array();
	$eml['email_subject']		= $subject;
	$eml['send_html']			= true;
	$eml['email_body']			= $message;
	$eml['template']			= 'default';
    // $eml['sender_email']        = $from_email;  always $pref['replyto_email']
    // $eml['sender_name']         = $from_name;   always $pref['replyto_name']
 
    $eml['cc']			= $cc;
    $eml['bcc']			= $bcc;
    
    if($type == 'plain')   { 
       $eml['template'] =  'textonly'; 
       $eml['send_html'] =  false;  
    }  //texthtml

 	if(e107::getEmail()->sendEmail($to_email, $to_name, $eml))
	{
		return true;
	}
	else
	{
		return false;
	}
   
}

 