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

if(empty($favorites)) accessDenied( );  

	if(empty($uid)) {
		$uid = USERUID;
		$caption = _YOURSTATS.":  ";
	}
	$caption  .= _FAVORITEAUTHORS;
 
	
	$add = !empty($_GET['add']) ? $_GET['add'] : "";
	$delete = isset($_GET['delete']) && isNumber($_GET['delete']) ? $_GET['delete'] : false;
	$edit = isset($_GET['edit']) && isNumber($_GET['edit']) ? $_GET['edit'] : false;
	$author = explode(",", $add);
	$author = array_filter($author, "isNumber");
	if(($add || $edit || $delete) && !isMEMBER) accessDenied( );

	if(isMEMBER && $uid == USERUID) {
		if($delete) {
			$result = dbquery("DELETE FROM ".TABLEPREFIX."fanfiction_favorites WHERE uid = '".USERUID."' AND item = '$delete' AND type = 'AU' LIMIT 1");
			if($result) $output .= write_message(_ACTIONSUCCESSFUL." "._BACK2ACCT);
			else $output .= write_error(_ERROR);
		}
		if($add && isset($_POST['submit'])) {
			$comment = escapestring(descript(strip_tags(replace_naughty($_POST['comments']), $allowed_tags)));
			foreach($author AS $a) {
				$result = dbquery("INSERT INTO ".TABLEPREFIX."fanfiction_favorites(uid, item, type, comments) VALUES('".USERUID."', '$a', 'AU', '$comment') ON DUPLICATE KEY UPDATE comments = '$comment'");
			}
			if($result) $output .= write_message(_ACTIONSUCCESSFUL." "._BACK2ACCT);
			else $output .= write_error(_ERROR);
		}
		if($edit && isset($_POST['submit'])) {
			$result = dbquery("UPDATE ".TABLEPREFIX."fanfiction_favorites SET comments = '".escapestring(descript(strip_tags(replace_naughty($_POST['comments']), $allowed_tags)))."' WHERE uid = '".USERUID."' AND item = '$edit' AND type = 'AU'");
			if($result) $output .= write_message(_ACTIONSUCCESSFUL." "._BACK2ACCT);
			else $output .= write_error(_ERROR);
		}
		if(($add || $edit) && !isset($_POST['submit'])) {
			if($add) {
				$check = dbquery("SELECT item FROM ".TABLEPREFIX."fanfiction_favorites WHERE uid = '".USERUID."' AND ".findclause("item", $author)." AND type = 'AU'");
				if(dbnumrows($check)) {
					while($c = dbassoc($check)) {
						$edit[] = $c['item'];
					}
					$edit = array_diff($author, $edit);
				}
				else {
					$pQuery = dbquery("SELECT "._PENNAMEFIELD." as penname FROM "._AUTHORTABLE." WHERE ".findclause(_UIDFIELD, $author));
					while($pRes = dbassoc($pQuery)) {
						$pennames[] = $pRes['penname'];
					}
					$pennames = implode(", ", $pennames);
				}
				$output = "<div class='sectionheader'>"._ADDTOFAVORITES.": ".$pennames."</div>";
			}
			if($edit) {
				$pQuery = dbquery("SELECT fav.*, "._PENNAMEFIELD." as penname FROM "._AUTHORTABLE." LEFT JOIN ".TABLEPREFIX."fanfiction_favorites as fav ON fav.item = "._UIDFIELD." AND fav.type = 'AU' AND fav.uid = '".USERUID."' WHERE "._UIDFIELD." = '$edit' LIMIT 1");
				if(dbnumrows($pQuery)) {
					$info = dbassoc($pQuery);
					$pennames = $info['penname'];
					$output .= "<div class='sectionheader'>"._EDITFAVORITES.": ".$pennames."</div>";
				}
				else {
					$author = array($edit);
					$pQuery = dbquery("SELECT "._PENNAMEFIELD." as penname FROM "._AUTHORTABLE." WHERE ".findclause(_UIDFIELD, $author));
					while($pRes = dbassoc($pQuery)) {
						$pennames[] = $pRes['penname'];
					}
					$pennames = implode(", ", $pennames);
					$output .= "<div class='sectionheader'>"._ADDTOFAVORITES.": ".$pennames."</div>";
				}
			}
			$author = implode(",", $author);
            
            $query =  
    		array(
    			'action' => 'favau',
    			'add' => ( $add ? $author : $edit),
    		); 
            $query = http_build_query($query , null, '&');   
            $url = "member.php?".$query; 
       
            $output .= e107::getForm()->open("favau", "POST", $url, "class=form-horizontal col-md-6 offset-md-3"); 
            
            $field_key = "comments";
            $output .= '<div class="row mb-3">';
                $output .= "<label class=\"col-sm-12 col-form-label\" for=\'".$field_key."\'>"._COMMENTS.": </label>";
                $output .= '<div class="col-sm-12">'; 
    		              $output .= e107::getForm()->renderElement($field_key, $info['comments'], array( 'type' => 'textarea', 'data' => 'str' ));
    		    $output .= '</div>';
            $output .= '</div>';
            $output .= e107::getForm()->button("submit", _SUBMIT);
		    $output .= e107::getForm()->close();
		}
	}
	if(!$add && !$edit) {
		$query = "SELECT "._UIDFIELD." as uid, "._PENNAMEFIELD." as penname, fav.comments as comments FROM ".TABLEPREFIX."fanfiction_favorites as fav, "._AUTHORTABLE." WHERE fav.uid = '$uid' AND fav.type = 'AU' AND fav.item = "._UIDFIELD." ORDER BY "._PENNAMEFIELD;
		
        $countquery =  "SELECT COUNT(item) FROM ".TABLEPREFIX."fanfiction_favorites WHERE uid = '$uid' AND type = 'AU' GROUP BY uid" ;
		
        $count = e107::getDb()->retrieve($countquery);
		
        $x = 1;
		
        if($count) {
                $author_list = e107::getDb()->retrieve($query."  LIMIT $offset, $itemsperpage", true) ;
                
				$template = e107::getTemplate('efiction', 'favcomment', 'favau', true, true);

				foreach($author_list AS $author)
				{ 
 					$avatar = efiction_authors::get_author_avatar($author['uid']);
                    $vars["x"] = $x;   
                    $vars["avatar"] = $avatar;
                    $vars["comment"] = format_story($author['comments']);
                    $vars["author"] = $author['penname'];
                    $vars["authorlink"] = "<a href=\"viewuser.php?uid=".$author['uid']."\">".$author['penname']."</a>";
					 
                    /* note: temp fix for styling, not time to do full shortcodes */ 
					if(USERUID == $uid)  {
                       	 $vars["commentoptions"] = "<div class='adminoptions'><span class='label'>"._OPTIONS.":</span> <a href=\"member.php?action=favau&amp;edit=".$author['uid']."\">"._EDIT."</a> | 
                            <a href=\"member.php?action=favau&amp;delete=".$author['uid']."\">"._REMOVEFAV."</a></div>";
                         $vars["commentoptions_alt"] = "<a class=\"btn btn-outline-success btn-sm ms-1\" href=\"member.php?action=favau&amp;edit=".$author['uid']."\">"._EDIT."</a>";             
                         $vars["commentoptions_alt"] .= "<a class=\"btn btn-outline-danger btn-sm ms-1\" href=\"member.php?action=favau&amp;delete=".$author['uid']."\">"._REMOVEFAV."</a>";      
                    }

                    $vars["oddeven"] = $x % 2 ? "odd" : "even" ;
					
                    $output .= e107::getParser()->simpleParse($template['item'], $vars);
                    
					$x++;
				}
			if($count > $itemsperpage) $output .= build_pagelinks("viewuser.php?action=favau&amp;uid=$uid&amp;", $count, $offset);
		}
		else $output .= write_message(_NORESULTS);
	}
    
    //member.php is rendering output 
    //e107::getRender()->tablerender($caption, $output, $current);
    //$output = '';
 
