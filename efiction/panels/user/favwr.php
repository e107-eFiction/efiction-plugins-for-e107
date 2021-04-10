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

$favorites = efiction::settings('favorites');

if(empty($favorites)) accessDenied( );

	if(empty($uid)) {
		$uid = USERUID;
		$output .= "<div id='pagetitle'>"._YOURSTATS."</div>";
	}
	$output .= "<div class='sectionheader'>"._FAVORITEWRITERS."</div>";
 
	$add = !empty($_GET['add']) ? $_GET['add'] : "";
	$delete = isset($_GET['delete']) && isNumber($_GET['delete']) ? $_GET['delete'] : false;
	$edit = isset($_GET['edit']) && isNumber($_GET['edit']) ? $_GET['edit'] : false;
	$author = $add;
	$author =(int) $author;
	if(($add || $edit || $delete) && !isMEMBER) accessDenied( );

	if(isMEMBER && $uid == USERUID) {
		if($delete) {
			$result = dbquery("DELETE FROM ".TABLEPREFIX."fanfiction_favorites WHERE uid = '".USERUID."' AND item = '$delete' AND type = 'WR' LIMIT 1");
			if($result) $output .= write_message(_ACTIONSUCCESSFUL." "._BACK2ACCT);
			else $output .= write_error(_ERROR);
		}
		if($add && isset($_POST['submit'])) {
		   
			$comment = escapestring(descript(strip_tags(replace_naughty($_POST['comments']), $allowed_tags)));
      $result = dbquery("INSERT INTO ".TABLEPREFIX."fanfiction_favorites(uid, item, type, comments) VALUES('".USERUID."', $add, 'WR', '$comment') 
			ON DUPLICATE KEY UPDATE comments = '$comment'");

			if($result) $output .= write_message(_ACTIONSUCCESSFUL." "._BACK2ACCT);
			else $output .= write_error(_ERROR);
		}
		if($edit && isset($_POST['submit'])) {
			$result = dbquery("UPDATE ".TABLEPREFIX."fanfiction_favorites SET comments = '".escapestring(descript(strip_tags(replace_naughty($_POST['comments']), $allowed_tags)))."'
			 WHERE uid = '".USERUID."' AND item = '$edit' AND type = 'WR'");
			if($result) $output .= write_message(_ACTIONSUCCESSFUL." "._BACK2ACCT);
			else $output .= write_error(_ERROR);
		}
		if(($add || $edit) && !isset($_POST['submit'])) {
		  $author = ($add ? $add : $edit);
		  $writers = dbassoc(dbquery("SELECT "._PENNAMEWRITERFIELD." as penname FROM "._WRITERTABLE." WHERE ". _UIDWRITERFIELD ." = ". $author ." LIMIT 1"));
		  
	
			if($add) {
				$check = dbquery("SELECT item FROM ".TABLEPREFIX."fanfiction_favorites WHERE uid = '".USERUID."' AND item = ". $author ." AND type = 'WR'");
				if(dbnumrows($check)) {
					while($c = dbassoc($check)) {
						$edit[] = $c['item'];
					}
					$edit = array_diff($author, $edit);
				}
				else {
					$pQuery = dbquery("SELECT "._PENNAMEWRITERFIELD." as penname FROM "._WRITERTABLE." WHERE ".findclause(_UIDWRITERFIELD, $author));
					while($pRes = dbassoc($pQuery)) {
						$pennames[] = $pRes['penname'];
					}
					$pennames = implode(", ", $pennames);
				}
				$output = "<div class='sectionheader'>"._ADDTOFAVORITES.": ".$pennames."</div>";
			}
			if($edit) {
				$pQuery = dbquery("SELECT fav.*, "._PENNAMEWRITERFIELD." as penname FROM "._WRITERTABLE." 
				LEFT JOIN ".TABLEPREFIX."fanfiction_favorites as fav ON fav.item = "._UIDWRITERFIELD." AND fav.type = 'WR' AND fav.uid = '".USERUID."' 
				WHERE "._UIDWRITERFIELD." = '$edit' LIMIT 1");
				if(dbnumrows($pQuery)) {
					$info = dbassoc($pQuery);
					$pennames = $info['penname'];
					$output .= "<div class='sectionheader'>"._EDITFAVORITES.": ".$pennames."</div>";
				}
				else {
					$author = array($edit);
					$writers = dbassoc(dbquery("SELECT "._PENNAMEWRITERFIELD." as penname FROM "._WRITERTABLE." WHERE ". _UIDWRITERFIELD ." = ". $author ."' LIMIT 1"));
 
					$penname = $writers['penname'];
					$pennames = implode(", ", $pennames);
					$output .= "<div class='sectionheader'>"._ADDTOFAVORITES.": ".$penname."</div>";
				}
			}
			//$author = implode(",", $author);
			$output .= "<form method=\"POST\" enctype=\"multipart/form-data\" action=\"member.php?action=favwr&amp;".( $add ? "add=$author" : "edit=$edit")."\">\n
				<div style=\"width: 100%; margin: 0 auto; text-align: left;\"><label for=\"comments\">"._COMMENTS.":</label><br />
				<textarea class=\"textbox\" name=\"comments\" id=\"comments\" cols=\"40\" rows=\"2\">".(isset($info['comments']) ? $info['comments'] : "")."</textarea><br />
				<INPUT type=\"submit\" class=\"button\" name=\"submit\" value=\""._SUBMIT."\"></div></form>";
		}
	}
	if(!$add && !$edit) {
		$query = "SELECT "._UIDWRITERFIELD." as uid, "._PENNAMEWRITERFIELD." as penname, fav.comments as comments FROM ".TABLEPREFIX."fanfiction_favorites as fav,
         "._WRITERTABLE." WHERE fav.uid = '$uid' AND fav.type = 'WR' AND fav.item = "._UIDWRITERFIELD." ORDER BY "._PENNAMEWRITERFIELD;
		$countquery = dbquery("SELECT COUNT(item) FROM ".TABLEPREFIX."fanfiction_favorites WHERE uid = '$uid' AND type = 'WR' GROUP BY uid");
		list($count) = dbrow($countquery);
		$x = 1;
		if($count) {
				$list = dbquery($query."  LIMIT $offset, $itemsperpage");
				while($author = dbassoc($list)) { 
				//	$output .= "<span class='label'>$x.</span> <a href=\"viewuser.php?uid=".$author['uid']."\">".$author['penname']."</a><br />";
				  $output .= "<span class='label'>$x.</span> <a href=\"browse.php?type=original_authors&wrid=".$author['uid']."\">".$author['penname']."</a><br />";
				  
					$cmt = new TemplatePower(e_PLUGIN."efiction/default_tpls/favcomment.tpl" );
					$cmt->prepare( );
					$cmt->newBlock("comment");
					$cmt->assign("comment", format_story($author['comments']));
					if(USERUID == $uid) 
					$cmt->assign("commentoptions", "<div class='adminoptions'><span class='label'>"._OPTIONS.":</span> <a href=\"member.php?action=favwr&amp;edit=".$author['uid']."\">"._EDIT."</a> | <a href=\"member.php?action=favwr&amp;delete=".$author['uid']."\">"._REMOVEFAV."</a></div>");
					$cmt->assign("oddeven", ($x % 2 ? "odd" : "even"));
					$output .= $cmt->getOutputContent( );
					$x++;
				}
			if($count > $itemsperpage) $output .= build_pagelinks("viewuser.php?action=favwr&amp;uid=$uid&amp;", $count, $offset);
		}
		else $output .= write_message(_NORESULTS);
	}
	$tpl->assign("output", $output);
	$tpl->gotoBlock( "_ROOT" );
?>
