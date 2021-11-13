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

if(!defined("_CHARSET")) exit( );

$caption  = _MESSAGESETTINGS;  //Submission rejected

if(isset($_POST['submit'])) {
    $title = e107::getParser()->toDb($_POST['title']);
    $body =  e107::getParser()->toDb($_POST['text']);
    
	$result = e107::getDb()->gen("UPDATE ".TABLEPREFIX."fanfiction_messages 
          SET  message_title = '".$title."', message_text = '".$body."' WHERE message_name = '".$_GET['message']."' LIMIT 1");
     
    if ($result === false) { $output .= write_error(_ERROR); } else { $output .= write_message(_ACTIONSUCCESSFUL); }
 
}
else {
	$pagequery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_messages WHERE message_name = '".$_GET['message']."' LIMIT 1");
	$message =  dbassoc($pagequery);
	$text = $message['message_text'];
    $title = $message['message_title'];
    
	if(!$message) e107::getDb()->gen("INSERT INTO `".TABLEPREFIX."fanfiction_messages` (`message_name` , `message_title` , `message_text` ) VALUES ('".$_GET['message']."', '', '')");
    
	/* $search = array("@\{sitename\}@", "@\{adminname\}@",  "@\{author\}@", "@\{storytitle\}@",  "@\{chaptertitle\}@", "@\{rules\}@");
	$replace = array( $sitename, $adminname, $story['penname'], $story['title'], $story['chapter'], "<a href=\"$url/viewpage.php?id=rules\">"._RULES."</a>");
	$letter = preg_replace($search, $replace, $letter);
	$subject = preg_replace($search, $replace, $subject);
    */        
    
	$caption .= " - ". preg_replace("@\{sitename\}@", $sitename, $message['message_title']);
    
	$output .= "<form method=\"POST\" enctype=\"multipart/form-data\" action=\"admin.php?action=messages&message=".$_GET['message']."\">";
        
    $output .= "<label for=\"message_title\">".LAN_SUBJECT.":</label>";    
    $output .= e107::getForm()->text('title', $title); 
    $output .= "<label for=\"text\">".LAN_MESSAGE.":</label>";
    $output .= e107::getForm()->bbarea('text', $text, '', '', 'small');
	$output .= "<div style='clear: both;'>&nbsp;</div><INPUT type='submit' class='button btn btn-sm btn-success' id='submit' value='"._SUBMIT."' name='submit'>
				</form>  ";
}

 