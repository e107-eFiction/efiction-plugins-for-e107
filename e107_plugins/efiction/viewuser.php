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

// Identify the current page for the pagelinks etc.
$current = "viewuser";

// Include some files for page setup and core functions

include ("header.php");

//make a new TemplatePower object
if(file_exists("$skindir/user.tpl")) $tpl = new TemplatePower( "$skindir/user.tpl" );
else $tpl = new TemplatePower("default_tpls/user.tpl");
if(file_exists("$skindir/listings.tpl")) $tpl->assignInclude( "listings", "./$skindir/listings.tpl" );
else $tpl->assignInclude( "listings", "./default_tpls/listings.tpl" );
 
 
include("includes/pagesetup.php");	
// If uid isn't a number kill the script with an error message.  The only way this happens is a hacker.
if(empty($uid)) {
	if(!isMEMBER) accessDenied( );
	else $uid = USERUID;
}
$favorites = e107::getSingleton('efiction_settings')->getPref('favorites'); 
$alertson = e107::getSingleton('efiction_settings')->getPref('alertson'); 
$agestatement =  e107::getSingleton('efiction_settings')->getPref('agestatement'); 
$displayprofile =  e107::getSingleton('efiction_settings')->getPref('displayprofile');
 
if($displayprofile) {
  include(_BASEDIR."user/profile.php");
  $tpl->assign("profile_block", $profile_text);
}
else if(isADMIN && uLEVEL < 3) {
	$userinfo= e107::getDb()->retrieve("SELECT * FROM "._AUTHORTABLE." LEFT JOIN ".TABLEPREFIX."fanfiction_authorprefs as ap ON ap.uid = "._UIDFIELD." WHERE "._UIDFIELD." = '$uid' LIMIT 1");
 
	$adminopts = "<div class=\"adminoptions\"><span class='label'>"._ADMINOPTIONS.":</span> ".(isset($userinfo['validated']) && $userinfo['validated'] ? "[<a href=\"admin.php?action=members&amp;revoke=$uid\" class=\"vuadmin\">"._REVOKEVAL."</a>] " : "[<a href=\"admin.php?action=members&amp;validate=$uid\" class=\"vuadmin\">"._VALIDATE."</a>] ")."[<a href=\"member.php?action=editbio&amp;uid=$uid\" class=\"vuadmin\">"._EDIT."</a>] [<a href=\"admin.php?action=members&amp;delete=$uid\" class=\"vuadmin\">"._DELETE."</a>]";
	$adminopts .= " [<a href=\"admin.php?action=members&amp;".($userinfo['level'] < 0 ? "unlock=".$userinfo['uid']."\" class=\"vuadmin\">"._UNLOCKMEM : "lock=".$userinfo['uid']."\" class=\"vuadmin\">"._LOCKMEM)."</a>]";
	$adminopts .= " [<a href=\"admin.php?action=admins&amp;".(isset($userinfo['level']) && $userinfo['level'] > 0 ? "revoke=$uid\" class=\"vuadmin\">"._REVOKEADMIN."</a>] [<a href=\"admin.php?action=admins&amp;do=edit&amp;uid=$uid\" class=\"vuadmin\">"._EDITADMIN : "do=new&amp;uid=$uid\" class=\"vuadmin\">"._MAKEADMIN)."</a>]</div>";
	$tpl->assign("adminoptions", $adminopts);
}

$penname =  e107::getDb()->retrieve("SELECT "._PENNAMEFIELD." as penname FROM "._AUTHORTABLE." WHERE "._UIDFIELD." = '$uid' LIMIT 1");
$tpl->assign("pagetitle", "<div id='pagetitle'>$penname</div>");

$panel =  e107::getDb()->retrieve("SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE ".($action ? "panel_name = '$action' AND (panel_type = 'P' OR panel_type = 'F')" : "panel_type = 'P' AND panel_hidden = 0 ORDER BY panel_order ASC")." LIMIT 1") ;

if($panel) {
	if(!empty($panel['panel_url']) && file_exists(_BASEDIR.$panel['panel_url'])) include(_BASEDIR.$panel['panel_url']);
	else if(file_exists(_BASEDIR."user/".$panel['panel_name'].".php")) include(_BASEDIR."user/".$panel['panel_name'].".php");
	else $output .= write_error("(1)"._ERROR);
}
else if($action) $output .= write_error("(2P Not allowed option/panel)"._ERROR);  //TODO: fix me

$tpl->gotoBlock("_ROOT");
$panels_array = e107::getDb()->retrieve("SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_hidden != '1' AND panel_level = '0' AND (panel_type = 'P'".($favorites ? " OR panel_type = 'F'" : "").") ORDER BY panel_type DESC, panel_order ASC, panel_title ASC", true);
$numtabs = count($panelquery);
$tabwidth = floor(100 / $numtabs);
if(!$panels_array) $output .= write_error("(3)"._ERROR);

// Special tab counts
/* Custom code */
$codequery = "SELECT * FROM #fanfiction_codeblocks WHERE code_type = 'userTabs'";
$codes = e107::getDb()->retrieve($codequery, true);
foreach ($codes as $code) {         
        eval($code['code_text']);
}
/* End of custom code */   
 

$paneltabs_template =  e107::getSingleton("efiction_core")->getTpl("user_paneltabs.tpl");

foreach($panels_array AS $panel) {   
	$panellink = "";
	if(substr($panel['panel_name'], -2, 2) == "by") {
		$itemcount = 0;
		if($panel['panel_name'] == "storiesby") {
			$itemcount =  e107::getDb()->retrieve("SELECT stories FROM ".TABLEPREFIX."fanfiction_authorprefs WHERE uid = '$uid'");
		}
		elseif($panel['panel_name'] == "seriesby") {
			$query = _SERIESCOUNT." WHERE uid = '$uid'";
			$itemcount =  e107::getDb()->retrieve($query); 
		}
		elseif($panel['panel_name'] == "reviewsby") {
			$query = "SELECT COUNT(comment_author_id) FROM ".TABLEPREFIX."fanfiction_comments WHERE comment_author_id  = '$uid'";
			$itemcount =  e107::getDb()->retrieve($query); 
		}	
		/*	
		else {
 
			if(substr($panel['panel_name'], 0, 3) == "val") {
				$table = substr($panel['panel_name'], 3);
				$table = substr($table, 0, strlen($table) - 2);
				$valid = 1;
			}
			else {
				$table = $panel['panel_name'];
				if(substr($panel['panel_name'], 0, strlen($panel['panel_name']) - 2) == "stories") $valid = 1;
				else $valid = 0;
			}
			$query = "SELECT COUNT(uid) FROM ".TABLEPREFIX."fanfiction_".substr($table, 0, strlen($panel['panel_name']) - 2)." WHERE (uid = '$uid'".($panel['panel_name'] == "storiesby" ? " OR FIND_IN_SET($uid, coauthors) > 0" : "").")".($valid ? " AND validated > 0" : "").($panel['panel_name'] == "reviewsby" ? " AND review != 'No Review'" : "");
 
			$itemcount =  e107::getDb()->retrieve("SELECT COUNT(uid) FROM ".TABLEPREFIX."fanfiction_".substr($table, 0, strlen($panel['panel_name']) - 2)." WHERE (uid = '$uid'".($panel['panel_name'] == "storiesby" ? " OR FIND_IN_SET($uid, coauthors) > 0" : "").")".($valid ? " AND validated > 0" : "").($panel['panel_name'] == "reviewsby" ? " AND review != 'No Review'" : ""));
		}
        */
	}
	if(substr($panel['panel_name'], 0, 3) == "fav" && $type = substr($panel['panel_name'], 3)) {
		$itemcount = 0;
		$itemcount = e107::getDb()->retrieve("SELECT COUNT(item) AS count FROM ".TABLEPREFIX."fanfiction_favorites WHERE uid = '$uid'");
 
	}
	if($panel['panel_name'] == "favlist") {
		$itemcount = 0;
		$itemcount = e107::getDb()->retrieve("SELECT COUNT(item) AS count FROM ".TABLEPREFIX."fanfiction_favorites WHERE uid = '$uid'");
		 
	}

	if(!empty($tabCounts[$panel['panel_name']])) $itemcount = $tabCounts[$panel['panel_name']];
	
    $panellinkplus = "<a href=\"viewuser.php?action=".$panel['panel_name']."&amp;uid=$uid\">".preg_replace("<\{author\}>", $penname, stripslashes($panel['panel_title'])).(isset($itemcount) ? " [$itemcount]" : "")."</a>\n";
	$panellink = "<a href=\"viewuser.php?action=".$panel['panel_name']."&amp;uid=$uid\">".preg_replace("<\{author\}>", $penname, stripslashes($panel['panel_title']))."</a>\n";
	

    $paneltabs_vars = array(); 
 
    $paneltabs_vars["tabwidth"] = $tabwidth;
	$paneltabs_vars["class"] = $action == $panel['panel_name'] || (empty($action) && $panel['panel_order'] == 1 && $panel['panel_type'] == "P") ? "id='active'" : "";
    $paneltabs_vars["link"] = $panellink;
    $paneltabs_vars["linkcount"] = $panellinkplus;
    $paneltabs_vars["count"] = (isset($itemcount) ? " [$itemcount]" : "");
    
    $paneltab_vars = array_change_key_case($paneltabs_vars,CASE_UPPER);
    $paneltab_text = e107::getParser()->simpleParse($paneltabs_template, $paneltab_vars, false);
    $paneltab_text = e107::getParser()->parseTemplate($paneltab_text, true); //to fix LANs. remove empty shortcodes
 
    $paneltabs_text .= $paneltab_text;
          
    unset($panellink, $panellinkplus, $itemcount, $paneltabs_vars,  $paneltab_text);
    
}

$tpl->assign("paneltabs", $paneltabs_text);
$tpl->gotoBlock("_ROOT");	
$tpl->assign( "output", $output );

$text = $tpl->getOutputContent(); 
e107::getRender()->tablerender($caption, $text, $current);
require_once(FOOTERF); 
exit;