<?php
// ----------------------------------------------------------------------
// Copyright (c) 2007 by Tammy Keefer
// Also Like Module developed for eFiction 3.0
// // http://efiction.hugosnebula.com/
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
$current = "translations";

include ("../../header.php");
require_once(HEADERF);
                                     
//make a new TemplatePower object
if(file_exists( "$skindir/default.tpl")) $tpl = new TemplatePower("$skindir/default.tpl" );
else $tpl = new TemplatePower(_BASEDIR."default_tpls/default.tpl");
 
include(_BASEDIR."includes/pagesetup.php");

e107::lan('efiction', true);

if(!isADMIN) accessDenied( );  
    
$confirm = isset($_GET['confirm']) ? $_GET['confirm'] : false;
if($confirm == "yes") {
    include("version.php");
        
	list($installed) = dbrow(dbquery("SELECT COUNT(code_module) FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_module = 'translations'"));
	if(!$installed) {
    
    }
	$browsequery = dbquery("SELECT count(panel_id) FROM `".TABLEPREFIX."fanfiction_panels` WHERE panel_type = 'B' AND panel_hidden = '0'");
    list($browse) = dbrow($browsequery);   
    $panel = dbassoc(dbquery("SELECT count(panel_id) AS count FROM `".TABLEPREFIX."fanfiction_panels` WHERE panel_type = 'B' AND panel_name = 'original_authors'"));   
    if ($panel['count'] == 0) {
       $browse++;         
        dbquery("INSERT INTO `".TABLEPREFIX."fanfiction_panels` (`panel_name` , `panel_title` , `panel_url` , `panel_level` , `panel_order` , `panel_hidden` , `panel_type` ) 
        VALUES ('original_authors', 'Original Author', 'modules/translations/browse/original_authors.php', '0', $browse, 0, 'B');");
    }
    
    
    $panel = dbassoc(dbquery("SELECT count(panel_id) AS count FROM `".TABLEPREFIX."fanfiction_panels` WHERE panel_type = 'B' AND panel_name = 'original_titles'"));     
    if ($panel['count'] == 0) {
       $browse++;
        dbquery("INSERT INTO `".TABLEPREFIX."fanfiction_panels` (`panel_name` , `panel_title` , `panel_url` , `panel_level` , `panel_order` , `panel_hidden` , `panel_type` ) 
        VALUES ('original_titles', 'Original Title', 'modules/translations/browse/original_titles.php', '0', $browse, 0, 'B');");
    }
    
    //the same file for edit and add */
    $panel = dbassoc(dbquery("SELECT count(code_id) AS count FROM `".TABLEPREFIX."fanfiction_codeblocks` WHERE code_type = 'editstory' AND code_module = 'translations'"));     
    if ($panel['count'] == 0) {
       $browse++;
        dbquery("INSERT INTO `".TABLEPREFIX."fanfiction_codeblocks` (`code_text` , `code_type` , `code_module`   ) 
        VALUES ('include(_BASEDIR.\"modules/translations/admin/edistory.php\");', 'editstory', 'translations');");
    }
    
    $panel = dbassoc(dbquery("SELECT count(code_id) AS count FROM `".TABLEPREFIX."fanfiction_codeblocks` WHERE code_type = 'addstory' AND code_module = 'translations'"));     
    if ($panel['count'] == 0) {
       $browse++;
        dbquery("INSERT INTO `".TABLEPREFIX."fanfiction_codeblocks` (`code_text` , `code_type` , `code_module`   ) 
        VALUES ('include(_BASEDIR.\"modules/translations/admin/edistory.php\");', 'addstory', 'translations');");
    }
    
    $panel = dbassoc(dbquery("SELECT count(code_id) AS count FROM `".TABLEPREFIX."fanfiction_codeblocks` WHERE code_type = 'storyform_start' AND code_module = 'translations'"));     
    if ($panel['count'] == 0) {
       $browse++;
        dbquery("INSERT INTO `".TABLEPREFIX."fanfiction_codeblocks` (`code_text` , `code_type` , `code_module`   ) 
        VALUES ('include(_BASEDIR.\"modules/translations/admin/storyform.php\");', 'storyform_start', 'translations');");
    }  
    
    dbquery("INSERT INTO `".TABLEPREFIX."fanfiction_codeblocks`(`code_text`, `code_type`, `code_module`)
         VALUES ('include(_BASEDIR.\"modules/translations/storyblock.php\");', 'storyblock', 'translations');");
         
        dbquery("UPDATE ".TABLEPREFIX."fanfiction_modules SET version = '1.1' WHERE name = 'translations' LIMIT 1"); 
        
          $panel = dbassoc(dbquery("SELECT count(panel_id) AS count FROM `".TABLEPREFIX."fanfiction_panels` WHERE panel_type = 'B' AND panel_name = 'temynahpkizi'"));   
        if ($panel['count'] == 0) {
            $browse++;         
        dbquery("INSERT INTO `".TABLEPREFIX."fanfiction_panels` (`panel_name` , `panel_title` , `panel_url` , `panel_level` , `panel_order` , `panel_hidden` , `panel_type` ) 
        VALUES ('temynahpkizi', 'Témy na hpkizi', 'modules/translations/browse/temynahpkizi.php', '0', $browse, 0, 'B');");
     } 
    
    
 $output = write_message(_ACTIONSUCCESSFUL);
  dbquery("INSERT INTO `".TABLEPREFIX."fanfiction_modules`(`version`, `name`) VALUES('$moduleVersion', '$moduleName')");
  
}
else if($confirm == "no") {
	$output = write_message(_ACTIONCANCELLED);
}
else {
	$output = write_message(_CONFIRMINSTALL."<br /><a href='install.php?confirm=yes'>"._YES."</a> "._OR." <a href='install.php?confirm=no'>"._NO."</a>");
}
$tpl->assign("output", $output);
$output = $tpl->getOutputContent();  
$output = e107::getParser()->parseTemplate($output, true);
e107::getRender()->tablerender($caption, $output, $current);
dbclose( );
require_once(FOOTERF);  
exit( );