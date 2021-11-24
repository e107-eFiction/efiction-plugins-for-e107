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


if($_GET['action'] == "editprefs") $displayform = 1;
 
require_once("header.php");

if($current == "logout") e107::redirect(SITEURL."index.php?logout");

if(!empty($_POST['submit']) && $current == "login") {
   e107::redirect(e_LOGIN); 
}

$favorites =   efiction_settings::get_single_setting('favorites');

//make a new TemplatePower object
if(file_exists("$skindir/default.tpl")) $tpl = new TemplatePower( "$skindir/default.tpl" );
else $tpl = new TemplatePower(_BASEDIR."default_tpls/default.tpl");
if(file_exists("$skindir/listings.tpl")) $tpl->assignInclude( "listings", "$skindir/listings.tpl" );
else $tpl->assignInclude( "listings",_BASEDIR."default_tpls/listings.tpl" );
include(_BASEDIR."includes/pagesetup.php");

if($action) $current = $action;
else $current = "user";

// end main function 
if((empty($action) || $action == "login") && isMEMBER) {
	$caption = _USERACCOUNT; 

	$output .= "<div class=\"tblborder\" id=\"useropts\" style=\"padding: 5px; width: 50%; margin: 1em 25%;\">";
 
    $panels = efiction_panels::member_panel();
    
    foreach($panels AS $panel) 
    {
		$output .= "<a href=\"".$panel['panel_url']."\">".$panel['panel_title']."</a><br />\n";
	}
	$output .= "</div>\n";

	e107::getRender()->tablerender($caption, $output, "member");

	require_once(FOOTERF); 
	exit;	
 
}
else if(!empty($action)) { 

	$panel = efiction_panels::member_panels_byaction($action);
 
	if($panel) {
		 
		if($panel['panel_level'] > 0 && !isMEMBER) accessDenied( );
        
        if($action == "register") e107::redirect(e_SIGNUP); 
        if($action == "login") e107::redirect(e_LOGIN); 
        if($action == "lostpassword") e107::redirect(SITEURL."fpw.php");
        
		if($panel['panel_url'] && file_exists(_BASEDIR.$panel['panel_url'])) require_once($panel['panel_url']);
		else if(file_exists(_BASEDIR."user/{$action}.php")) require_once("user/{$action}.php");
		else $output = write_error(_ERROR);
	}
	else $output .= write_error(_ERROR);
}

else $output = write_error(_NOTAUTHORIZED);
 
e107::getRender()->tablerender($caption, $output, $current);
require_once(FOOTERF); 
exit;