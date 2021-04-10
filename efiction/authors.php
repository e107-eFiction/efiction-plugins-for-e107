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

if(isset($_GET['action']) && $_GET['action'] == "list") {
	$current = "members";
	$list = "members";
}
else if(isset($_GET['list']) && $_GET["list"] == "authors") $current = "authors";
else $current = "members";

include ("header.php");

//make a new TemplatePower object
$tpl = new TemplatePower(e_PLUGIN."efiction/default_tpls/default.tpl");  
include("includes/pagesetup.php");

// end basic page setup

$pagetitle = "<span id=\"pagetitle\">";
if(isset($_GET['list'])) $list = $_GET['list'];
else $list = "members";
if(!$let) {
	$let = false;
	$ptitle = "</span>";
}
else {
	$ptitle = " -- $let</span>";
	if($let == _OTHER) {
		$letter = _PENNAMEFIELD." REGEXP '^[^a-z]'";
	}
	else{
		$letter = _PENNAMEFIELD." LIKE '$let%'";
	}
}

$listOpts = ""; $countquery = "";
	if($list == "authors") {
		$pagetitle .= _AUTHORS;
		$authorquery = "SELECT "._PENNAMEFIELD." as penname, "._UIDFIELD." as uid, ap.stories FROM "._AUTHORTABLE." LEFT JOIN ".TABLEPREFIX."fanfiction_authorprefs as ap ON ap.uid = "._UIDFIELD." WHERE ap.stories > 0 ".(isset($letter) ? " AND $letter" : "")." GROUP BY "._UIDFIELD;
		$countquery = "SELECT count("._UIDFIELD.") FROM "._AUTHORTABLE." LEFT JOIN ".TABLEPREFIX."fanfiction_authorprefs as ap ON "._UIDFIELD." = ap.uid WHERE ap.stories > 0 ".(isset($letter) ? " AND $letter" : "");
	}
	else if($list == "admins") {
		$pagetitle .= _SITEADMINS;
		$countquery = _MEMBERCOUNT." WHERE ap.level > 0 AND ap.level < 4".(isset($letter) ? " AND $letter" : "");
		$authorquery = _MEMBERLIST." WHERE ap.level > 0 AND ap.level < 4".(isset($letter) ? " AND $letter" : "")." GROUP BY "._UIDFIELD;
	}
    if($list == "beta") {
    	$countquery = "SELECT COUNT(DISTINCT ai.uid) FROM ".TABLEPREFIX."fanfiction_authorinfo as ai, "._AUTHORTABLE." WHERE ai.field = '$field_id' AND ai.info = '"._YES."' AND "._UIDFIELD." = ai.uid".(isset($letter) ? " AND $letter" : "");
     
        $authorquery = "SELECT author.user_name as penname, author.user_id as uid, ue.* FROM e107_user as author LEFT JOIN e107_user_extended AS ue ON author.user_id = ue.user_extended_id
        WHERE ue.user_plugin_efiction_betareader = 'LAN_NO'  ";
       
    	$pagetitle .= $field_title;
    
    }   

	if(empty($countquery)) {
		$pagetitle .= _MEMBERS;
		$countquery = _MEMBERCOUNT.(isset($letter) ? " WHERE $letter" : "");
		$authorquery = _MEMBERLIST.(isset($letter) ? " WHERE $letter" : "")." GROUP BY "._UIDFIELD;
	}

    if(e107::getUserExt()->user_extended_field_exist('plugin_efiction_betareader')) {
        $field_title = e107::getUserExt()->getFieldLabel('plugin_efiction_betareader');
        $listOpts .= "<option value=\"authors.php?".($let ? "let=$let&amp;" : "")."list=beta\"".($list == "beta" ? " selected" : "").">$field_title</option>";
    }
	$output .= $pagetitle.$ptitle;
	$output .= "<div style=\"text-align: center;\"><form name=\"list\" action=\"\"><select name=\"list\" onchange=\"if(this.selectedIndex.value != 'false') document.location = document.list.list.options[document.list.list.selectedIndex].value\">";
	$output .= "<option value=\"authors.php?".($let ? "let=$let&amp;" : "")."list=members\"".(empty($list) || $list == "members" ? " selected" : "").">"._ALLMEMBERS."</option>
		<option value=\"authors.php?".($let ? "let=$let&amp;" : "")."list=authors\"".($list == "authors" ? " selected" : "").">"._AUTHORS."</option>
		<option value=\"authors.php?".($let ? "let=$let&amp;" : "")."list=admins\"".($list == "admins" ? " selected" : "").">"._SITEADMINS."</option>
        $listOpts
        </select></form></div>";
	$pagelink="authors.php?list=".($list ? $list : "members")."&amp;".($let ? "let=$let&amp;" : "");
	include("includes/members_list.php");

	$tpl->assign( "output", $output );
	//$tpl->printToScreen();
    $output = $tpl->getOutputContent( );  
    $output = e107::getParser()->parseTemplate($output, true); 
    
    e107::getRender()->tablerender($pagetitle.$ptitle, $output, 'authors-index');
    require_once(FOOTERF);
    dbclose( );				 
    exit; 
      
 