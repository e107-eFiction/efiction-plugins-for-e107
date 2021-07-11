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
if(isset($_GET['action'])) $current = $_GET['action'];
else $current = "login";
 
// Include some files for page setup and core functions
require_once(HEADERF);
include ("header.php");
/*
if(file_exists("$skindir/default.tpl")) $tpl = new TemplatePower( "$skindir/default.tpl" );
else $tpl = new TemplatePower(_BASEDIR."default_tpls/default.tpl");
if(file_exists("$skindir/listings.tpl")) $tpl->assignInclude( "listings", "$skindir/listings.tpl" );
else $tpl->assignInclude( "listings", _BASEDIR."default_tpls/listings.tpl" );
include(_BASEDIR."includes/pagesetup.php");
*/

if($action) $current = $action;
else $current = "user";
 
// end main function 
if(empty($action) && isMEMBER) {
    $caption = _USERACCOUNT;
	$output .= " 
		<div class=\"tblborder\" id=\"useropts\" style=\"padding: 5px; width: 50%; margin: 1em 25%;\">";
	$panelquery = e107::getDb()->retrieve("SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_hidden != '1' AND panel_level = '1' AND (panel_type = 'U' ".(!$submissionsoff || isADMIN ? " OR panel_type = 'S'" : "").($favorites ? " OR panel_type = 'F'" : "").") ORDER BY panel_type, panel_order, panel_title ASC", true);

	if(!$panelquery) $output .= _FATALERROR;
	foreach($panelquery AS $panel) {
		if(!$panel['panel_url']) $output .=  "<a href=\"member.php?action=".$panel['panel_name']."\">".$panel['panel_title']."</a><br />\n";
		else $output .= "<a href=\"".$panel['panel_url']."\">".$panel['panel_title']."</a><br />\n";
	}
	$output .= "</div>\n";
}
else if(!empty($action)) {
	$panel = e107::getDb()->retrieve("SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_name = '$action' AND (panel_type='U' ".(!$submissionsoff || isADMIN ? " OR panel_type = 'S'" : "").($favorites ? " OR panel_type = 'F'" : "").") LIMIT 1");
	if($panel) {
		if($panel['panel_level'] > 0 && !isMEMBER) accessDenied( );
		if($panel['panel_url'] && file_exists(_BASEDIR.$panel['panel_url'])) require_once(_BASEDIR.$panel['panel_url']);
		else if(file_exists(_BASEDIR."user/{$action}.php")) require_once(_BASEDIR."user/{$action}.php");
		else $output = write_error(_ERROR);
	}
	else $output .= write_error(_ERROR);
}
else $output = write_error(_NOTAUTHORIZED);

 
$output = e107::getParser()->parseTemplate($output, true);
e107::getRender()->tablerender($caption, $output, $current);

require_once(FOOTERF);  
exit( );