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
  
require_once("header.php"); 
 

$tpl = new TemplatePower(e_PLUGIN."efiction/default_tpls/default.tpl");
 
include("includes/pagesetup.php");
 
$action = $_GET['action'];
e107::lan('efiction');

if($action) $current = $action;
else $current = "user";
// end main function 

$pagetitle = _USERACCOUNT;
 
 
if((empty($action) || $action == "login") && isMEMBER) {

	/* $panelquery = "SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_hidden != '1' 
    AND panel_level = '1' AND 
    (panel_type = 'U' ".(!$submissionsoff || isADMIN ? " OR panel_type = 'S'" : "").($favorites ? " OR panel_type = 'F'" : "").") 
    ORDER BY panel_type, panel_order, panel_title ASC"; */
      
	$output .= "<div class=\"tblborder\" id=\"useropts\" style=\"padding: 5px; width: 50%; margin: 1em 25%;\">";
        $userlinks = efiction::userpanels();  
        foreach($userlinks AS $userlink) {
              $output .= $userlink;
    } 
	$output .= "</div>\n";
     
}
else if(!empty($action)) {

    /*
    "SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_name = '$action' AND 
    (panel_type='U' ".(!$submissionsoff || isADMIN ? " OR panel_type = 'S'" : "").($favorites ? " OR panel_type = 'F'" : "").") LIMIT 1"
    */
   $panel = efiction::panel_byaction($action); 
 
    if($panel['use_panel']) { 
	    require_once($panel['use_panel']);
	}
	else $output .= write_error(_ERROR);
}
else $output = write_error(_NOTAUTHORIZED);
 
$output = e107::getParser()->parseTemplate($output, true); 
e107::getRender()->tablerender($pagetitle, $output, 'authors-index');
require_once(FOOTERF);
dbclose( );				 
exit; 
 