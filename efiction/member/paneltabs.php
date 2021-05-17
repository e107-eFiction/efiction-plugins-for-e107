<?php

if (!defined('e107_INIT')) { exit; }
 
$favorites =  efiction::settings('favorites');
$penname = $this->sc_user_penname();
 
//panels not hidden, visible for members, type P or F if allowed)
$panels = e107::getDb()->retrieve("SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_hidden != '1' AND panel_level = '0' AND (panel_type = 'P'".($favorites ? " OR panel_type = 'F'" : "").") ORDER BY panel_type DESC, panel_order ASC, panel_title ASC", true);
 
$numtabs = count($panels);
$tabwidth = floor(100 / $numtabs);
if(!$panels) $panelstabs  = write_error("(C) "._ERROR);
else {
	$paneltabs_template = e107::getTemplate('efiction', 'user', 'paneltabs');  
	$paneltabs_title 	= e107::getParser()->parseTemplate($paneltabs_template['title'], true, $this );
	$paneltabs_start 	= $paneltabs_template['start'];
 

	// Special tab counts
	$codequery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'userTabs'");
	while($code = dbassoc($codequery)) {
		eval($code['code_text']);
	}

	//panels 
	foreach($panels AS $panel) {
		$panellink = "";
		//user tabs
		if(substr($panel['panel_name'], -2, 2) == "by") {
			$itemcount = 0;
			//counting related records ? seriesby is not used ?
			if($panel['panel_name'] == "storiesby") {
				$itemcount = e107::getDb()->retrieve("SELECT stories AS itemcount FROM ".TABLEPREFIX."fanfiction_authorprefs WHERE uid = '$uid'");
 			}
			else {  //no idea what is this there are only admin validate panels
				if(substr($panel['panel_name'], 0, 3) == "val") {
					$table = substr($panel['panel_name'], 3);
					$table = substr($table, 0, strlen($table) - 2);
					$valid = 1;
				}
				else {  // panel_name = table name f.e. series (from seriesby)  reviews (from reviewsby)
					$table = $panel['panel_name'];
					if(substr($panel['panel_name'], 0, strlen($panel['panel_name']) - 2) == "stories") $valid = 1;
					else $valid = 0;
				}
				/* $count = dbquery("SELECT COUNT(uid) FROM ".TABLEPREFIX."fanfiction_".substr($table, 0, strlen($panel['panel_name']) - 2)." WHERE (uid = '$uid'".($panel['panel_name'] == "storiesby" ? " OR FIND_IN_SET($uid, coauthors) > 0" : "").")".($valid ? " AND validated > 0" : "").($panel['panel_name'] == "reviewsby" ? " AND review != 'No Review'" : "")); */

				$itemcount = e107::getDb()->retrieve("SELECT COUNT(uid) FROM ".TABLEPREFIX."fanfiction_".substr($table, 0, strlen($panel['panel_name']) - 2)." WHERE (uid = '$uid'".($panel['panel_name'] == "storiesby" ? " OR FIND_IN_SET($uid, coauthors) > 0" : "").")".($valid ? " AND validated > 0" : "").($panel['panel_name'] == "reviewsby" ? " AND review != 'No Review'" : ""));

			}
		}
		//detailed favorites counts
		if(substr($panel['panel_name'], 0, 3) == "fav" && $type = substr($panel['panel_name'], 3)) {
			$itemcount = 0;
			/* $countquery = dbquery("SELECT COUNT(item) FROM ".TABLEPREFIX."fanfiction_favorites WHERE uid = '$uid' AND type = '$type'");
			list($itemcount) = dbrow($countquery); */
			$itemcount = e107::getDb()->retrieve("SELECT COUNT(item) AS itemcount FROM ".TABLEPREFIX."fanfiction_favorites WHERE uid = '$uid' AND type = '$type'");
		}
		//favorites stories only ?
		if($panel['panel_name'] == "favlist") {
			$itemcount = 0;
			/* $countquery = dbquery("SELECT COUNT(item) FROM ".TABLEPREFIX."fanfiction_favorites WHERE uid = '$uid'");
			list($itemcount) = dbrow($countquery); */
			$itemcount = e107::getDb()->retrieve("SELECT COUNT(item) AS itemcount FROM ".TABLEPREFIX."fanfiction_favorites WHERE uid = '$uid'");
		}

		//probably for custom code
		if(!empty($tabCounts[$panel['panel_name']])) $itemcount = $tabCounts[$panel['panel_name']];

		$panellinkplus = "<a href=\"viewuser.php?action=".$panel['panel_name']."&amp;uid=$uid\">".preg_replace("<\{author\}>", $penname, stripslashes($panel['panel_title'])).(isset($itemcount) ? " [$itemcount]" : "")."</a>\n";
 
		$panelname = preg_replace("<\{author\}>", $penname, stripslashes($panel['panel_title']));
		
		$panellink = "viewuser.php?action=".$panel['panel_name']."&amp;uid=$uid";
		$panelnamelink = "<a href=\"viewuser.php?action=".$panel['panel_name']."&amp;uid=$uid\">".preg_replace("<\{author\}>", $penname, stripslashes($panel['panel_title']))."</a>\n";
 
		$var['USER_PENNAME'] = $this->sc_user_penname();

		$var['TABWIDTH'] 	= $tabwidth;
		$var['CLASS'] 	 	= $action == $panel['panel_name'] || (empty($action) && $panel['panel_order'] == 1 && $panel['panel_type'] == "P") ? "id='active'" : "";

		$var['NAME']  		= $panelname;
		$var['LINK'] 		= $panellink;  //just src of link
		$var['NAMELINK'] 	= $panelnamelink;  //full link with name
		$var['COUNT'] 		= (isset($itemcount) ? " [$itemcount]" : "") ;
	 
		unset($panelname, $panellink,$panellinkplus,$panelnamelink,$itemcount );  

		$paneltabs_items .= e107::getParser()->parseTemplate($paneltabs_template['item'], true, $var );
 
	}	
	$paneltabs_end  		= $paneltabs_template['end'];
	$paneltabs_content 		= $paneltabs_start.$paneltabs_items.$paneltabs_end;
	$paneltabs_tablerender 	= varset($profile_template['tablerender'], $this->var['current']);
	$panelstabs = e107::getRender()->tablerender('', $paneltabs_title.$paneltabs_content, $paneltabs_tablerender, true); 
}

//clean after yourself
unset($paneltabs_title, $paneltabs_content, $paneltabs_tablerender, $paneltabs_items, $paneltabs_end, $var, $paneltabs_start );  
 
 