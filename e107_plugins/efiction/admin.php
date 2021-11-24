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

/* in header.php with HEADERF
if (!defined('e107_INIT'))
{
	require_once(__DIR__.'/../../class2.php');
}
*/
$current = "adminarea";

if(isset($_GET['action']) && ($_GET['action'] == "categories" || $_GET['action'] == "admins")) $displayform = 1;

$disableTiny = true;
 
include ("header.php");
// print_xa($displayform);
//make a new TemplatePower object
if(file_exists("$skindir/default.tpl")) $tpl = new TemplatePower( "$skindir/default.tpl" );
else $tpl = new TemplatePower(_BASEDIR."default_tpls/default.tpl");
include(_BASEDIR."includes/pagesetup.php");

e107::lan('efiction', true);

// end basic page setup
 
// check that user has permissions to perform this action before going further.  Otherwise kick 'em
	if(!isADMIN) accessDenied( );
	$adminquery = dbquery("SELECT categories FROM ".TABLEPREFIX."fanfiction_authorprefs WHERE uid = '".USERUID."' LIMIT 1");
	list($admincats) = dbrow($adminquery);
	if(empty($admincats)) $admincats = "0";
    
    if(!empty($_GET['action']) && $_GET['action'] == "yesletter") {   
      // not display admin menu, it is opened in new window for now 
    }
    else {
      $caption = EFICTION_ADMIN_001;
    	$output = "<div style='text-align: center; margin: 1em;'>";
        $panellist = efiction_panels::admin_panels();
 
  	    foreach($panellist as $accesslevel => $row) {
    		$output .= implode(" | ", $row)."<br />";
    	}
    	$output .= "</div>\n";
        
        e107::getRender()->tablerender($caption, $output, $current);
        $output = '';
        $caption = ''; 
	}
 
    if($action) {
		$panelquery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_name = '$action' AND panel_type = 'A' LIMIT 1");
		if(dbnumrows($panelquery)) {
			$panel = dbassoc($panelquery);
			if((isset($panel['panel_level']) ? $panel['panel_level'] : 0) >= uLEVEL) {
				if($panel['panel_url'] && file_exists(_BASEDIR.$panel['panel_url'])) require_once(_BASEDIR.$panel['panel_url']);
				else if (file_exists(_BASEDIR."admin/{$action}.php")) require_once("admin/{$action}.php");
			}
	  	else accessDenied( );
		}
	}
	else {
		if (file_exists("install"))
			$output .= write_error(_SECURITYDELETE);
		$adminnotices = "";
		$countquery = dbquery("SELECT COUNT(DISTINCT chapid) FROM ".TABLEPREFIX."fanfiction_chapters WHERE validated < 1");
		list($count) = dbrow($countquery);
		if($count) $adminnotices .= write_message(sprintf(_QUEUECOUNT, $count));
		$codequery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'adminnotices'");
		while($code = dbassoc($codequery)) {
			eval($code['code_text']);
		}
		$output .= write_message($adminnotices);
 
	}	
 
 	e107::getRender()->tablerender($caption, $output, $current);
	require_once(FOOTERF); 
	exit;
 