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

 
$content = "";
$blocks = eFiction::blocks();
/*
if(empty($blocks['categories']['tpl'])) {
	include("blocks/".$blocks['categories']['file']);
	$tpl->gotoBlock("_ROOT");
}
*/

e107::includeLan(e_PLUGIN.'efiction/blocks/categories/'.e_LANGUAGE.'.php');

$output .= "
<div class='panel panel-primary'>
	<div class='panel-heading text-center bg-primary'>".LAN_EFICTION_CURRENT.':</div>
	<div class="panel-body tblborder text-left">'.$content.'</div>
</div>';


$output .= "<div> 
	<textarea name=\"template\" id=\"template\" rows=\"5\" cols=\"40\">$template</textarea><br />";
if($tinyMCE) 
	$output .= "<div class='tinytoggle'><input type='checkbox' name='toggle' onclick=\"toogleEditorMode('template');\"><label for='toggle'>"._TINYMCETOGGLE."</label></div>";	
$output .= "<select name=\"columns\" class=\"textbox\" style='margin: 3px;'><option value=\"0\"".(empty($blocks['categories']['columns']) ? " selected" : "").">"._ONECOLUMN."</option>
			<option value=\"1\"".(!empty($blocks['categories']['columns']) ? " selected" : "").">"._MULTICOLUMN."</option></select> 
	<select name=\"tpl\" class=\"textbox\" style='margin: 3px;'><option value=\"0\"".(empty($blocks['categories']['tpl']) ? " selected" : "").">".LAN_EFICTION_DEFAULT."</option>
			<option value=\"1\"".(!empty($blocks['categories']['tpl']) ? " selected" : "").">".LAN_EFICTION_USETPL."</option></select><br />
	 <div style='clear: both;'>&nbsp;</div>
<div class='well'>"._CATBLOCKNOTE."</div>";
 
 