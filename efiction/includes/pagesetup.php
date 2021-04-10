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


/* 
This file does some of the setup of the common elements of the pages within your site. 
It also checks the common $_GET variables and cleans them up to prevent hacking and attacks.
*/

if(!defined("_CHARSET")) exit( );

$favtypes = array("SE" => "series", "ST" => "stories", "AU" =>"authors");
$revtypes = array("SE" => "series", "ST" => "stories");

$catlist = efiction::catlist(); 
$charlist = efiction::charlist();
$classlist = efiction::classlist();
$classtypelist = efiction::classtypelist();
$ratingslist = $ratlist = efiction::ratingslist();
 
$action = escapestring($action);
// Set up the page template
 
$tpl->prepare( );
// End page template setup
 
// If they weren't set in variables.php, set the defaults for these 
if(!isset($up)) $up = "<img src=\""._BASEDIR."images/arrowup.gif\" border=\"0\" width=\"13\" height=\"18\" align=\"left\" alt=\""._UP."\">";
if(!isset($down)) $down = "<img src=\""._BASEDIR."images/arrowdown.gif\" border=\"0\" width=\"13\" height=\"18\" align=\"right\" alt=\""._DOWN."\">";


$pagelinks =efiction::pagelinks();
 

foreach($blocks as $block=>$value) {
	if(empty($value['status']) || ($value['status'] == 2 && $current != "home")) continue;
	if(empty($value['file'])) continue;
	if($value['status'] && file_exists(_BASEDIR."blocks/".$value['file'])) {
		$content = "";
		$tpl->assignGlobal($block."_title", !empty($value['title']) ? stripslashes($value['title']) : "");
		if(file_exists(_BASEDIR."blocks/".$value['file'])) include(_BASEDIR."blocks/".$value['file']);
		$tpl->assignGlobal($block."_content", $content);
	}
}

$tpl->gotoBlock( "_ROOT" );

?>