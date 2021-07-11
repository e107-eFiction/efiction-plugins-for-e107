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

$dir = opendir(_BASEDIR."modules");
 
$admin = isset($_GET['admin']) && $_GET['admin'] == true ? true : false;
$module = isset($_GET['module']) ? $_GET['module'] : false;

//list of available modules:
if(!$module) {
	$output .= "<table class=\"tblborder\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 0 auto;\">
	<tr><th class=\"tblborder\">"._NAME."</th><th class=\"tblborder\">"._VERSION."</th><th class=\"tblborder\">"._OPTIONS."</th></tr>";
	$modquery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_modules ORDER BY name");
	while($m = dbassoc($modquery)) {
		$modules[$m['name']] = $m;
	}
 
}
 
while($folder = readdir($dir)) { 
    //skip all not redirectories
 	if($folder == "." || $folder == ".." || !is_dir(_BASEDIR."modules/$folder")) continue;
	$moduleVersion = ""; $moduleName = ""; $moduleDescription = ""; $moduleAuthor = ""; $moduleOpts = array( ); 
	$moduleAuthorEmail = ""; $moduleWebsite = "";
	//selected module
    if($module && $module == $folder) { 
		if($admin) {
			if(file_exists(_BASEDIR."modules/$folder/admin.php")) include(_BASEDIR."modules/$folder/admin.php");
			else accessDenied( );
		}
		else if(file_exists(_BASEDIR."modules/$folder/version.php")) {
			include(_BASEDIR."modules/$folder/version.php");
			$output .= "<div class='sectionheader'>$moduleName - $moduleVersion</div>";
			if($moduleDescription) $output .= "<p><span class='label'>"._DESC.":</span> $moduleDescription</p>";
			if($moduleAuthor || $moduleAuthorEmail) $output .= "<p><span class='label'>"._AUTHOR.":</span> ".($moduleAuthorEmail ? "<a href='mailto:$moduleAuthorEmail'>".($moduleAuthor ? $moduleAuthor : $moduleAuthorEmail)."</a>" : $moduleAuthor)."</p>";
			if($moduleWebsite) $output .= "<p><span class='label'>"._WEBSITE.":</span> <a href='$moduleWebsite'>$moduleWebsite</a></p>";
			if(file_exists(_BASEDIR."modules/$folder/changelog.txt")) {
				$output .= "<p><span class='label'>"._CHANGELOG."</span>:<br /><br />";
				$file = _BASEDIR."modules/$folder/changelog.txt";
				$log_file = @fopen($file, "r");
				$file_contents = @fread($log_file, filesize($file));
				$output .= format_story($file_contents);
				@fclose($log_file);
			}
		}
		else $output .= write_message(_NORESULTS);
	}
    //default
	else if(!$module) {
		if(!file_exists(_BASEDIR."modules/".$folder."/version.php")) continue;
		else include(_BASEDIR."modules/".$folder."/version.php");
 
        if(empty($moduleName)) continue;
		$output .= "<tr><td class=\"tblborder\">
        <a href='admin.php?action=modules&amp;module=$folder'>$moduleName</a></td><td class=\"tblborder\" style=\"text-align: center;\">"
        .(isset($modules[$moduleName]['version']) ? $modules[$moduleName]['version'] : $moduleVersion)."</td><td class=\"tblborder\">";
        
         //install
		if(file_exists(_BASEDIR."modules/$folder/install.php") && !isset($modules[$moduleName])) $moduleOpts[] 
         = "<a href='"._BASEDIR."modules/$folder/install.php'>"._INSTALLMODULE."</a>";
         
        //update 
		if(isset($modules[$moduleName]['version']) && $modules[$moduleName]['version'] < $moduleVersion && 
        file_exists(_BASEDIR."modules/$folder/update.php")) $moduleOpts[] = "<a href='"._BASEDIR."modules/$folder/update.php'>"._UPDATE."</a> ";
        
       
		if(file_exists(_BASEDIR."modules/$folder/admin.php") && isset($modules[$moduleName])) $moduleOpts[] = 
            "<a href='admin.php?action=modules&amp;module=$folder&admin=true'>"._OPTIONS."</a>";
            
		if(file_exists(_BASEDIR."modules/$folder/uninstall.php") && isset($modules[$moduleName])) $moduleOpts[] = 
            "<a href='"._BASEDIR."modules/$folder/uninstall.php'>"._UNINSTALLMODULE."</a>";
		$output .= implode(" | ", $moduleOpts);
		$output .= "</td></tr>";
	}
}

closedir($dir);
if(!$module) $output .= "</table>";
?>