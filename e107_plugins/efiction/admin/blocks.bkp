<?php
// ----------------------------------------------------------------------
// eFiction 3.0
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

$tp = e107::getParser();

e107::lan('efiction', "blocks");  

$tinyMCE = efiction_settings::get_single_setting('tinyMCE'); 
$allowed_tags = efiction_settings::get_single_setting('allowed_tags'); 

function save_blocks( $blocks ) {
    $tp = e107::getParser();
 
	foreach($blocks as $block =>$block_values) { 
		unset($blockvars);
 
        $blockvars = e107::serialize($block_values['block_variables']);
        
		$update = array(
			'block_title' => $tp->filter($block_values['title']),
			'block_file'  => $tp->filter($block_values['file']),
            'block_status'  => $tp->filter($block_values['status']),
            'block_variables'  => $blockvars,
			 'WHERE'   => "block_name = '".$block ."'"

		);
    
        $result = e107::getDb()->update('fanfiction_blocks', $update  );  
	}
 
}
 
 
if(isset($_GET['admin'])) $admin = $_GET['admin'];
else $admin = false;
$content = "";

	if($admin) {
		$caption = "<div id='pagetitle'>"._ADMIN." - ".(isset($blocks[$_GET['admin']]['title']) ? $blocks[$_GET['admin']]['title'] : "")."</div>";
		//include(_BASEDIR."blocks/".$_GET['admin']."/admin.php"); //probably just temp for easier rewritting
		include(_BASEDIR."admin/blocks/".$_GET['admin']."/".$_GET['admin']."_admin.php");
		save_blocks( $blocks );
	}
	if(isset($_GET['init'])) {
		if(file_exists(_BASEDIR."admin/blocks/".$_GET['init']."/init.php")) include(_BASEDIR."admin/blocks/".$_GET['init']."/init.php");
		else return _ERROR;
		save_blocks( $blocks );
	}
	if(isset($_POST['submit']) && empty($admin)) {  //it is not options
		$x = 1;
 
		while(isset($_POST[$x])) { 
			// activate inactive blocks.
			if(isset($blocks[$_POST[$x]])) {
				$blocks[$_POST[$x]]['title'] =  $_POST[$x."_title"]; //sanitized in save_blocks()
				$blocks[$_POST[$x]]["status"] = $_POST[$x."_status"];
			}
			$x++;	
		}
	 	save_blocks( $blocks );
		$output .= write_message(_ACTIONSUCCESSFUL);
        
	}
// In case the skin has already overridden the block settings or we've just changed the settings.
$blocks = efiction::blocks();

if(empty($admin)) {
	$output .= "<form method=\"POST\" enctype=\"multipart/form-data\" action=\"admin.php?action=blocks\">
    <div class='text-center'>
    <table class=\"table table-bordered\">
      <thead class=\"thead-dark\"><tr><th>"._NAME."</th><th>"._TITLE."</th><th>"._STATUS."</th><th>"._ADMIN."</th></tr></thead>";
	$x = 1;
	$directory = opendir(_BASEDIR."admin/blocks");   
    
	while($filename = readdir($directory)) {      
			if($filename=="." || $filename==".." || !is_dir(_BASEDIR."admin/blocks/".$filename)) continue;
             
			$output .= "<tr><td class=\"tblborder\"><input type=\"hidden\" name=\"$x\" value=\"$filename\">$filename</td>";
			if(isset($blocks[$filename]['file'])) {
				$output .= "<td class=\"tblborder\"><input name=\"{$x}_title\" type=\"text\" 
                class=\"form-control textbox\" value=\"".stripslashes($blocks[$filename]['title'])."\"><input name=\"{$x}_file\" type=\"hidden\" value=\"".$blocks[$filename]['file']."\"></td>
				<td class=\"tblborder\"><select class='form-control' name=\"{$x}_status\">
					<option value=\"0\"".(!$blocks[$filename]['status'] ? " selected" : "").">"._INACTIVE."</option>
					<option value=\"1\"".($blocks[$filename]['status'] == 1? " selected" : "").">"._ACTIVE."</option>
					<option value=\"2\"".($blocks[$filename]['status'] == 2 ? " selected" : "").">"._INDEXONLY."</option>
					</select></td>
				<td class=\"tblborder\">".(file_exists(_BASEDIR."admin/blocks/".$filename."/".$filename."_options.php") ? 
            	"<a class='btn btn-default btn-secondary' href=\"admin.php?action=blocks&admin=$filename\">"._OPTIONS."</a>" :  _NONE);
			}
			else {
				$output .= "<td class=\"tblborder\" colspan=\"3\" align=\"center\"><a class='btn btn-primary' href=\"admin.php?action=blocks&init=$filename\">"._INITIALIZE."</a>";
			}	
			$output .= "</td></tr>";
			$x++;
	}
	closedir($directory);
	$output .= "</table><br /><INPUT type=\"submit\" class=\"button btn btn-primary\" name=\"submit\" value=\""._SUBMIT."\"></div></form>";
}


// Now load the skin settings back in.
	if(file_exists("$skindir/variables.php")) include("$skindir/variables.php"); 
?>