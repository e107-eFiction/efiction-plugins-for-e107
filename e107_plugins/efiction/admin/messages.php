<?php
// ----------------------------------------------------------------------
// Copyright (c) 2007 by Tammy Keefer
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

	$caption  = "<div id=\"pagetitle\">"._MESSAGESETTINGS."</div>";
	$get_message  = e107::getParser()->filter($_GET['message'], 'str'); 
if(isset($_POST['submit'])) {
	$tmp = e107::getParser()->toDb($_POST['text']);
	
	$result = e107::getDb()->gen("UPDATE ".TABLEPREFIX."fanfiction_messages SET message_text = '".$tmp."' WHERE message_name = '".$get_message."' LIMIT 1");
	if($result > 0 ) $output .= write_message(_ACTIONSUCCESSFUL);
	elseif($result === 0) $output .= e107::getMessage()->addInfo(LAN_NO_CHANGE)->render();
	else $output .=  write_error(_ERROR);  
}
else {
	$message = e107::getDb()->retrieve("SELECT * FROM ".TABLEPREFIX."fanfiction_messages WHERE message_name = '".$_GET['message']."' LIMIT 1");
	$text = $message['message_text'];
	if(!$message) e107::getDb()->gen("INSERT INTO `".TABLEPREFIX."fanfiction_messages` (`message_name` , `message_title` , `message_text` ) VALUES ('".$_GET['message']."', '', '')");

 
	$output .= 
	   "<div class='sectionheader'><h3>".preg_replace("@\{sitename\}@", SITENAME, $message['message_title'])."</h3></div>";

	$output .= "<div style='width: 100%;'><div  id=\"settingsform\"><form method=\"POST\" enctype=\"multipart/form-data\" action=\"".e_SELF."?action=messages&message=".$get_message."\">";
	$output .= e107::getForm()->bbarea('text', $text, 'admin', '_common', 'medium', array('counter'=>1));
	/*
		<textarea rows=\"10\" cols=\"60\" style=\"width: 100%;\" ".($_GET['message'] == "tinyMCE" ? "class='mceNoEditor'" :"")." name=\"text\">$text</textarea>";

	if($tinyMCE && $_GET['message'] != "tinyMCE") 
		$output .= "<div class='tinytoggle'><input type='checkbox' name='toggle' onclick=\"toogleEditorMode('text');\" checked><label 
		for='toggle'>"._TINYMCETOGGLE."</label></div>";
	*/
		$output .= "<div style='clear: both;'>&nbsp;</div><INPUT type='submit' class='button' id='submit' value='"._SUBMIT."' name='submit'>
				</form></div><div style='clear: both;'>&nbsp;</div></div>";
}
 