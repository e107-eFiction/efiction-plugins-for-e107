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

$favorites = efiction::settings('favorites');
 
if(empty($favorites)) accessDenied( );

if(!isset($uid)) {
	$pagetitle = _MANAGEFAVORITES;
	 
	$uid = USERUID;
}
else {
	$authquery = "SELECT "._PENNAMEFIELD." FROM "._AUTHORTABLE." WHERE "._UIDFIELD." = '$uid'";
	$penname =e107::getDb()->retrieve($authquery);

	 $output .= "<div class='sectionheader'>"._FAVORITESOF." $penname</div>";
}
	$output .= "<div class=\"tblborder\" style=\"padding: 5px; width: 200px; margin: 0 auto;\">";
	$favlinks = efiction::favourite_panels($uid);
 
	foreach($favlinks AS $favlink) {
		$panellink = "";
 
		$output .= $favlink;
	  	 	 
		
	}
 
	$output .= "</div>\n";
 