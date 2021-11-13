<?php
// ----------------------------------------------------------------------
// eFiction 3.0
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


$chapid = isset($_GET['chapid']) && isNumber($_GET['chapid']) ? $_GET['chapid'] : 0;

		$adminquery =e107::getDb()->retrieve("SELECT "._EMAILFIELD." as email, "._PENNAMEFIELD." as penname FROM "._AUTHORTABLE." WHERE "._UIDFIELD." = '".USERUID."' LIMIT 1");
        
		 $adminemail = $adminquery[_EMAILFIELD];
         $adminname = $adminquery[_PENNAMEFIELD];
 
		if($adminemail)
			$ademail = $adminemail;
		else 
			$ademail = $siteemail;
            
	if(isset($_POST['submit'])) {
		$subject = strip_tags(descript($_POST['subject']));
		$letter = stripslashes(descript($_POST['letter']));
	 
		$result = efiction_core::sendemail($_POST['authorname'], $_POST['authoremail'], $adminname, $ademail, $subject, $letter, "html");
		if($result) echo write_message(_EMAILSENT);
		else echo write_error(_ERROR);
	}
	else {
			$storyquery = dbquery("SELECT story.title, chapter.title as chapter, "._EMAILFIELD." as email, "._PENNAMEFIELD." as penname, chapter.uid FROM ".TABLEPREFIX."fanfiction_stories as story, ".TABLEPREFIX."fanfiction_chapters as chapter, "._AUTHORTABLE." WHERE chapter.uid = "._UIDFIELD." AND chapter.chapid = '$chapid' AND chapter.sid = story.sid LIMIT 1");
			$story = dbassoc($storyquery);
            
			$letterquery = e107::getDb()->retrieve("SELECT message_text, message_title FROM ".TABLEPREFIX."fanfiction_messages WHERE message_name = 'thankyou' LIMIT 1");
			$letter = $letterquery['message_text'];
            $subject = $letterquery['message_title'];
 
            
			$search = array("@\{sitename\}@", "@\{adminname\}@",  "@\{author\}@", "@\{storytitle\}@",  "@\{chaptertitle\}@", "@\{rules\}@");
			$replace = array( $sitename, $adminname, $story['penname'], $story['title'], $story['chapter'], "<a href=\"$url/viewpage.php?id=rules\">"._RULES."</a>");
			$letter = preg_replace($search, $replace, $letter);
			$subject = preg_replace($search, $replace, $subject);
            
			$text = "<div>
			<div class='h2 text-center' id=\"pagetitle\"> $story[title]: $story[chapter] "._BY." $story[penname]</div>
			<div style=\"line-height: 4ex; margin: 0 auto; width: 90%;\">
				<form method=\"POST\" enctype=\"multipart/form-data\" action=\"admin.php?action=yesletter&amp;uid=$story[uid]\">
				<input type=\"hidden\" name=\"authoremail\" value=\"$story[email]\">
                <input type=\"hidden\" name=\"authorname\" value=\"story[penname]\">
				<label for=\"subject\">".LAN_SUBJECT.":</label>";
                
             $text .= e107::getForm()->text('subject', $subject);   
             $text .= "<label for=\"letter\">".LAN_MESSAGE.":</label>";
             $text .= e107::getForm()->bbarea('letter', $letter, '', '', 'small');
             $text .= "<INPUT type=\"submit\" style=\"margin: 10px;\" class=\"button btn btn-sm btn-success\" name=\"submit\" value=\""._SUBMIT."\"></form></div></div> ";
	   
            echo $text;
    }
 
?>