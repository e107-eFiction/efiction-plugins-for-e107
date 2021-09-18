<?php
// ----------------------------------------------------------------------
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

$current = "contactus";

include ("header.php");
 
$sec_image = e107::getSecureImg();

	//make a new TemplatePower object
if(file_exists("$skindir/default.tpl")) $tpl = new TemplatePower( "$skindir/default.tpl" );
else $tpl = new TemplatePower(_BASEDIR."default_tpls/default.tpl");
$tpl->assignInclude( "header", "./$skindir/header.tpl" );
$tpl->assignInclude( "footer", "./$skindir/footer.tpl" );
include(_BASEDIR."includes/pagesetup.php");

	$output .= "<h1>"._CONTACTUS."</h1>";

	if(isset($_POST['submit'])) {
		if (USE_IMAGECODE && isset($_POST['rand_num']) && (e107::getSecureImg()->invalidCode($_POST['rand_num'], $_POST['code_verify']))) {
		    $output .= write_error(_CAPTCHAFAIL);
	    } else {
    		$sender = check_email($_POST['email_send']);
    		$subject = e107::getParser()->toEmail($_POST['subject'], true, 'RAWTEXT');
    		$body = nl2br(e107::getParser()->toEmail($_POST['email'], true, 'RAWTEXT'));
    
            $send_to = SITEADMINEMAIL;
    		$send_to_name = ADMIN;
                    
            $eml = array(
    				'subject'      => $subject,
    				'sender_name'  => $sender_name,
    				'body'         => $body,
    				'replyto'      => $sender,
    				'replytonames' => $sender_name,
    				'template'     => 'default'
    		);
                
            $message = e107::getEmail()->sendEmail($sender, $send_to_name, $eml) ? _EMAILSENT : _EMAILFAILED;
            
            e107::getRender()->tablerender('', "<div class='alert alert-success'>" . $message . "</div>");
		}
	}
	else
	{
		$output .= "<form method='POST' enctype='multipart/form-data' action='contact.php'>
		<table class='acp'><tr><td><label for='email'>"._YOUREMAIL.":</label></td><td><INPUT type='text' class='textbox' name='email'></td></tr>";
		if(!$action) $output .= "<tr><td><label for='subject'>"._SUBJECT.":</label></td><td><INPUT  type='text' class='textbox' name='subject'></td></tr>";
		else if($action == "report") $output .= "<tr><td><label for='subject'>"._REPORT.":</label></td><td><select class='textbox' name='subject'>
			<option>"._RULESVIOLATION."</option>
			<option>"._BUGREPORT."</option>
			<option>"._MISSING."</option>
		</select>
		<input type='hidden' name='reportpage' value='".descript($_GET['url'])."'></td></tr>";
		$output .= "<tr><td><label for='comments'>"._COMMENTS.":</label></td><td> <TEXTAREA  class='textbox' name='comments' cols='50' rows='6'></TEXTAREA></td></tr>";
 
        if (!USERUID && USE_IMAGECODE) {
    		//one table field to be able to use recaptcha
    		$output .= "<tr><td><label for='code_verify'>".e107::getSecureImg()->renderLabel().'</label></td><td>';
    		$output .= e107::getSecureImg()->renderimage();
    		$output .= e107::getSecureImg()->renderInput().'</td></tr>';
	    } 
        $output .= "<tr><td colspan='2'><div style='text-align: center;'><INPUT name='submit' class='button' type='submit' value='"._SUBMIT."'></div></td></tr></table></form>";
	}

	$tpl->assign( "output", $output );	
    //$tpl->xprintToScreen( );
    dbclose( );
    $text = $tpl->getOutputContent(); 
    e107::getRender()->tablerender($caption, $text, $current);
    require_once(FOOTERF); 
    exit;