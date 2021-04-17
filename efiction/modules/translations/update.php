<?php
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
include("version.php");

list($currentVersion) = dbrow(dbquery("SELECT version FROM ".TABLEPREFIX."fanfiction_modules WHERE name = 'Translations' LIMIT 1"));
$currentVersion = explode(".", $currentVersion);
if(empty($currentVersion ) || $currentVersion[1] < 1) {
if($confirm == "yes") {
	if(empty($currentVersion) || $currentVersion[1] == 0) {
		dbquery("INSERT INTO `".TABLEPREFIX."fanfiction_codeblocks`(`code_text`, `code_type`, `code_module`)
         VALUES ('include(_BASEDIR.\"modules/translations/storyblock.php\");', 'storyblock', 'translations');");
         
        dbquery("UPDATE ".TABLEPREFIX."fanfiction_modules SET version = '1.1' WHERE name = 'translations' LIMIT 1"); 
	}
    
    $browsequery = dbquery("SELECT count(panel_id) FROM `".TABLEPREFIX."fanfiction_panels` WHERE panel_type = 'B' AND panel_hidden = '0'");
    list($browse) = dbrow($browsequery);  
    
    if(empty($currentVersion) || $currentVersion[1] == 1) {
        $panel = dbassoc(dbquery("SELECT count(panel_id) AS count FROM `".TABLEPREFIX."fanfiction_panels` WHERE panel_type = 'B' AND panel_name = 'temynahpkizi'"));   
        if ($panel['count'] == 0) {
            $browse++;         
        dbquery("INSERT INTO `".TABLEPREFIX."fanfiction_panels` (`panel_name` , `panel_title` , `panel_url` , `panel_level` , `panel_order` , `panel_hidden` , `panel_type` ) 
        VALUES ('temynahpkizi', 'Témy na hpkizi', 'modules/translations/browse/temynahpkizi.php', '0', $browse, 0, 'B');");
    }
         
        dbquery("UPDATE ".TABLEPREFIX."fanfiction_modules SET version = '1.2' WHERE name = 'translations' LIMIT 1"); 
	}
	 
	$output = write_message(_ACTIONSUCCESSFUL);
}
else if($confirm == "no") {
	$output = write_message(_ACTIONCANCELLED);
}
else {
	$output = write_message(_CONFIRMUPDATE."<br /><a href='update.php?confirm=yes'>"._YES."</a> "._OR." <a href='update.php?confirm=no'>"._NO."</a>");
}
}
else $output .= write_message(_ALREADYUPDATED);
$tpl->assign("output", $output);
    $output = $tpl->getOutputContent();  
    $output = e107::getParser()->parseTemplate($output, true);
    e107::getRender()->tablerender($caption, $output, $current);
	dbclose( );
    require_once(FOOTERF);  
    exit( );