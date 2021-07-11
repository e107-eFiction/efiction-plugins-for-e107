<?php
// ----------------------------------------------------------------------
// Copyright (c) 2005-07 by Tammy Keefer
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

//Begin basic page setup
$current = "manageseries";
if($_GET['action'] == "add" || $_GET['action'] == "edit") $displayform = 1;

// Include some files for page setup and core functions
include ("header.php");
require_once(HEADERF);

//make a new TemplatePower object
 
include(_BASEDIR."includes/pagesetup.php");
$seriesid = isset($_GET['seriesid']) && isNumber($_GET['seriesid']) ? $_GET['seriesid'] : false;
$showlist = true;
$inorder = isset($_GET['inorder']) && isNumber($_GET['inorder']) ? $_GET['inorder'] : false;
$add = isset($_GET['add']) ? $_GET['add'] : false;

// before doing anything else check if the visitor is logged in.  If they are, check if they're an admin.  If not, check that they're 
// trying to edit/delete/etc. their own stuff then get the penname 
if(!isMEMBER) accessDenied( );
 
if(isADMIN && uLEVEL < 3) $admin = 1;
else $admin = 0;
if(isADMIN && uLEVEL == 3) {
 
	$admincats= e107::getDB()->retrieve("SELECT categories FROM ".TABLEPREFIX."fanfiction_authorprefs WHERE uid = '".USERUID."'");
 
	if(isset($seriesid)) {
		$series = e107::getDB()->retrieve("SELECT uid, isopen, catid from ".TABLEPREFIX."fanfiction_series WHERE seriesid='$seriesid' LIMIT 1");
		list($owner, $seriesopen, $catid) = $series;
		$owner = $series['uid'];
		$seriesopen = $series['catid'];
		$catid = $series['isopen'];
		if(uLEVEL == 3 && $admincats != 0) {
			$seriescats = explode(",", $catid);
			$adcats = explode(",", $admincats);
			foreach($seriescats as $cat) {
				if(in_array($cat, $adcats)) $admin = 1;
			}
		}
	}
}
if(!$allowseries && !$admin) accessDenied( );
if($allowseries == 1 && !$admin) {
	$count = e107::getDB()->retrieve("SELECT COUNT(sid) FROM ".TABLEPREFIX."fanfiction_stories WHERE uid = '".USERUID."'");
	if($count == 0) accessDenied( );
}

if($action == "validate") {
	$inorder = isset($_GET['inorder']) && isNumber($_GET['inorder']) ? $_GET['inorder'] : 0;
	// $valid = dbxquery("UPDATE ".TABLEPREFIX."fanfiction_inseries SET confirmed = 1 WHERE seriesid = '$seriesid' AND inorder = '$inorder' LIMIT 1");
	$valid = e107::getDB()->gen("UPDATE ".TABLEPREFIX."fanfiction_inseries SET confirmed = 1 WHERE seriesid = '$seriesid' AND inorder = '$inorder' LIMIT 1");
	if($valid) {
		$output .= write_message(_ACTIONSUCCESSFUL);
		$showlist = true;
	}
}

if($add == "series" || ($action == "add" && !$add) || $action == "edit") {
	if(isset($_GET['cat']) && !empty($_GET['cat'])) $cat = $_GET['cat'];
	else $cat = -1;
	$isopen = isset($_GET['isopen']) ? $_GET['isopen'] : 0;

	if(isset($_POST['submit'])) {
		$title = addslashes(escapestring(strip_tags($_POST['title'], $allowed_tags)));
		$summary = addslashes(escapestring(descript(strip_tags($_POST["summary"], $allowed_tags))));
		//$category = isset($_POST['catid']) ? explode(",", $_POST['catid']) : array();
		//$category = array_filter($category, "isNumber");
        
        $catid = isset($_POST['catid']) ? array_filter($_POST['catid'], "isNumber") : array( );
        /* story example
        catid = '".(is_array($catid) ? implode(",", $catid) : $catid)."',
        */
        $category = (is_array($catid) ? implode(",", $catid) : $catid);
        
        $charid = isset($_POST['charid']) ? array_filter($_POST['charid'], "isNumber") : array( );
        $characters = (is_array($charid) ? implode(",", $charid) : $charid);
                
		/* if($category) $category = implode(",", $category);
		else $category = ""; */
        
		$open = isset($_POST['open']) && isNumber($_POST['open']) ? $_POST['open'] : 0;
 
		$classes = array( );
		foreach($classtypelist as $type => $cinfo) {
			if(isset($_POST["classes_".$type])) {
				$opts = is_array($_POST["classes_".$type]) ? array_filter($_POST["classes_".$type], "isNumber") : array( );
				$classes = array_merge($opts, $classes);
			}
		}
		$classes = implode(",", $classes);
		if(!empty($_POST['uid']) && isNumber($_POST['uid'])) $owner = $_POST['uid'];
		else $owner = USERUID;
		if($title == "" || $summary == "") {
			$output .= write_error(_REQUIREDINFO);
		}
		else if(find_naughty($title) || find_naughty($summary)) {
			$output .= write_error(_NAUGHTYWORDS);
		}				
		else {
			$title = replace_naughty($title);
			$summary = replace_naughty($summary);
			if($action == "edit") {
				$seriesid = $_POST['seriesid'];
				// dbxquery("UPDATE ".TABLEPREFIX."fanfiction_series SET title = '$title', summary ='$summary', catid = '$category', isopen = '$open', characters = '$charid', classes = '$classes' WHERE seriesid = '$seriesid'");
				e107::getDb()->gen("UPDATE ".TABLEPREFIX."fanfiction_series SET title = '$title', summary ='$summary', catid = '$category', isopen = '$open', characters = '$characters', classes = '$classes' WHERE seriesid = '$seriesid'");
				
				//$codequery = dbxquery("SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'editseries'");
				$codequery =  e107::getDB()->retrieve("SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'editseries'", true);
				foreach($codequery AS $code) { 
				//while($code = dbassoc($codequery)) {
					eval($code['code_text']);
				}
				if($logging && $admin) {
					//$seriesinfo = dbxquery("SELECT title, uid FROM ".TABLEPREFIX."fanfiction_series WHERE seriesid = '$seriesid'");
					$seriesinfo = e107::getDB()->retrieve("SELECT title, uid FROM ".TABLEPREFIX."fanfiction_series WHERE seriesid = '$seriesid'"); 
					$title = $seriesinfo['title'];
					$uid =  $seriesinfo['uid'];
					//list($title, $uid) = dbrow($seriesinfo);
					if($uid != USERUID) { 
						dbquery("INSERT INTO ".TABLEPREFIX."fanfiction_log (`log_action`, `log_uid`, `log_ip`, `log_type`) VALUES('".escapestring(sprintf(_LOG_ADMIN_EDIT_SERIES, USERPENNAME, USERUID, $title, $seriesid))."', '".USERUID."', INET_ATON('".$_SERVER['REMOTE_ADDR']."'), 'ED')");
					    e107::getDb()->gen("INSERT INTO ".TABLEPREFIX."fanfiction_log (`log_action`, `log_uid`, `log_ip`, `log_type`) VALUES('".escapestring(sprintf(_LOG_ADMIN_EDIT_SERIES, USERPENNAME, USERUID, $title, $seriesid))."', '".USERUID."', INET_ATON('".$_SERVER['REMOTE_ADDR']."'), 'ED')");
					}

				}
				$output = write_message(_ACTIONSUCCESSFUL."<br />"._BACK2ACCT);
			}
			else {
				// dbxquery("INSERT INTO ".TABLEPREFIX."fanfiction_series (title, summary, catid, isopen, uid, characters, classes) VALUES('$title', '$summary', '$category', '$open', '$owner', '$charid', '$classes')");

				$insert = array(
					'title'     => $title,
					'summary'   => $summary , 
					'catid'     => $category,
					'isopen'    => $summary ,
					'title'     => $open,
					'uid'       => $owner ,
					'characters'   => $charid,
					'classes'  => $classes ,

					'_DUPLICATE_KEY_UPDATE' => 1
					);

				// $seriesid = dbinsertid(); 
				$seriesid = e107::getDB()->insert("fanfiction_series", $insert);

				//dbquery("UPDATE ".TABLEPREFIX."fanfiction_stats SET series = series + 1");
				e107::getDb()->gen("UPDATE ".TABLEPREFIX."fanfiction_stats SET series = series + 1");

				//$codequery = dbxquery("SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'addseries'");
				$codequery =  e107::getDB()->retrieve("SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'addseries'", true);
				foreach($codequery AS $code) { 					
				//while($code = dbassoc($codequery)) {
					eval($code['code_text']);
				}
				$add = "stories";
				unset($_POST['submit']);
			}
		}
	}
	else {
	$caption = "<div id=\"pagetitle\">".($action == "edit" ? _EDITSERIES : $add == "stories" ? _ADD2SERIES : _ADDSERIES)."</div>
<form METHOD=\"POST\" style='width: 90%; margin: 0 auto;' name=\"form\" action=\"manageseries.php?action=$action&amp;add=".(!empty($add) ? $add : "series").(!empty($seriesid) ? "&amp;seriesid=$seriesid" : "")."\">";
	if($action == "edit" && !isset($POST['submit'])) {
		/* $seriesquery = dbxquery(_SERIESQUERY." AND seriesid = '$seriesid' LIMIT 1");
		$series = dbassoc($seriesquery);
		$series = array_map("stripslashes", $series);
		*/
		$series = e107::getDB()->retrieve(_SERIESQUERY." AND seriesid = '$seriesid' LIMIT 1");
		$owner = $series['uid'];
		$output .= "<input type=\"hidden\" name=\"seriesid\" value=\"$seriesid\">";
	}
	else $series = array("uid" => 0, "title" => "", "summary" => "");
	$output .= "<div>";
	if($admin) {
		// $authorquery = dbxquery("SELECT "._PENNAMEFIELD." as penname, "._UIDFIELD." as uid FROM "._AUTHORTABLE." ORDER BY penname");
		$authors = e107::getDB()->retrieve("SELECT "._PENNAMEFIELD." as penname, "._UIDFIELD." as uid FROM "._AUTHORTABLE." ORDER BY penname");
		$output .= "<label for=\"uid=\">"._AUTHOR.":</label> <select name=\"uid\" id=\"uid\">";
		// while($authorresult = dbassoc($authorquery)) {	
		foreach($authors AS $authorresult) {
			$output .= "<option value=\"".$authorresult['uid']."\"".((USERUID == $authorresult['uid'] && !$seriesid) || (is_array($series) && $series['uid'] == $authorresult['uid']) ? " selected" : "").">".$authorresult['penname']."</option>";
		}
		$output .= "</select><font color=\"red\">*</font><br />";
	}
	$output .= "<label for=\"title\">"._TITLE.":</label> <font color=\"red\">*</font> <input  type=\"text\" class=\"textbox=\" name=\"title\" id=\"title\" value=\"".(isset($series) ? htmlentities($series['title']) : "")."\"  maxlength=\"200\" size=\"60\"><input type=\"hidden\" value=\"".(isset($series) ? $series['uid'] : "")."\"><br />
		<label for=\"summary\">"._SUMMARY.":</label><font color=\"red\">*</font><br /><textarea rows=\"6\" id=\"summary\" name=\"summary\" cols=\"58\">".(isset($series) ? $series['summary'] : "")."</textarea><br />";
	if($tinyMCE) 
		$output .= "<div class='tinytoggle'><input type='checkbox' name='toggle' onclick=\"toogleEditorMode('summary');\" checked><label for='toggle'>"._TINYMCETOGGLE."</label></div>";
	if(!$multiplecats) $output .= "<input type=\"hidden\" name=\"catid[]\" id=\"catid\" value=\"1\">";
	else {	
		$catid = isset($series['catid']) ? explode(",", $series['catid']) : array( );
		include(_BASEDIR."includes/categories.php");
		$output .= "<input type=\"hidden\" name=\"formname\" value=\"series\">";
	}
	if(count($charlist) > 0) {
		$output .= "<div style=\"float: left; width: 99%;\"><div style=\"float: left; padding: 5px; width: 47%;\"><label for=\"charid\">"._CHARACTERS.":</label> <br /><select size=\"5\" style=\"width: 99%;\" name=\"charid[]\" id=\"charid\" multiple>";
		$chars = isset($series['characters']) ? explode(",", $series['characters']) : array( );
		$catid[] = -1;
		foreach($charlist as $char => $vars) {
			if(is_array($catid) && in_array($vars['catid'], $catid)) $output .= "<option value=\"$char\"".(in_array($char, $chars) ? " selected" : "").">".$vars['name']."</option>";
		}
		$output .= "</select></div>";
	}
	$classes = isset($series['classes']) ? explode(",", $series['classes']) : array( );
	foreach($classtypelist as $type => $typevars) {
		$output .= "<div style=\"float: left; padding: 5px; width: 47%;\"><label for=\"classes_{$type}\">{$typevars['title']}:</label><br /><select size=\"5\" style=\"width: 99%;\" name=\"classes_{$type}[]\" id=\"$type\" multiple>";
		foreach($classlist as $c => $vars) {
			if($vars['type'] == $type) $output .= "<option value=\"$c\"".(in_array($c, $classes) ? " selected" : "").">".$vars['name']."</option>";
		}
		$output .= "</select></div>";
	}
	$isopen = isset($series['isopen']) ? $series['isopen'] : 0;
	$output .= "<div style=\"clear:left;\">&nbsp;</div></div><label for=\"open\">"._SERIESTYPE.":</label> <select id=\"open\" name=\"open\">
			<option value=\"2\"".($isopen == "2" ? " selected" : "").">"._OPEN."</option>
			<option value=\"1\"".($isopen == "1" ? " selected" : "").">"._MODERATED."</option>
			<option value=\"0\"".(!$isopen ? " selected" : "").">"._CLOSED."</option>
		</select><div style=\"margin: 1em;\">"._OPENNOTE."</div>";
	$codequery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'seriesform'");
	while($code = dbassoc($codequery)) {
		eval($code['code_text']);
	}
	$output .= "<div style=\"text-align: center;\"><input type=\"submit\" class=\"submit\" name=\"submit\" value=\""._SUBMIT."\"></div></div></form>";
	if($action == "add") {
		$output .= "<center>"._SERIESNOTE."</center>";
		$showlist = false;
	}
}
}
if($add == "stories") {
	if(isset($seriesid) && isset($_POST['submit'])) {
		if(!$seriesid) accessDenied( );
		// list($owner, $isopen, $title) = dbrow(dbxquery("SELECT uid, isopen, title FROM ".TABLEPREFIX."fanfiction_series WHERE seriesid = '$seriesid' LIMIT 1"));
		$tmp = e107::getDb()->retrieve("SELECT uid, isopen, title FROM ".TABLEPREFIX."fanfiction_series WHERE seriesid = '$seriesid' LIMIT 1");
		$owner = $tmp['uid'];
		$isopen = $tmp['isopen'];
		$title = $tmp['title'];
		// $seriescount = dbxquery("SELECT count(seriesid) FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid'");
		// list($count) = dbrow($seriescount);
		 
		$count = e107::getDb()->retrieve("SELECT count(seriesid) AS count FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid'");
	 
		//$seriesitems = dbquery("SELECT sid, subseriesid FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid'");
		$seriesitems = e107::getDb()->retrieve("SELECT sid, subseriesid FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid'", true);

		//while($item = dbassoc($seriesitems)) {
		foreach($seriesitems AS $item) {
			if($item['sid']) $items[] = $item['sid'];
			if($item['subseriesid']) $subs[] = $item['subseriesid'];
		}
		if($admin || USERUID == $owner || $isopen == 2 ) $confirmed = 1;
		else {
			$confirmed = 0;
			include(_BASEDIR."includes/emailer.php");
			$seriesMail = sprintf(_NEWSERIESITEMS, stripslashes($title));
			$subject = sprintf("_SERIESITEMSSUBS", stripslashes($title));
			//$mailInfo = dbassoc(dbxquery("SELECT "._PENNAMEFIELD." as penname, "._EMAILFIELD." as email FROM "._AUTHORTABLE." WHERE "._UIDFIELD." = '$owner' LIMIT 1"));
			$mailInfo = e107::getDb()->retrieve("SELECT "._PENNAMEFIELD." as penname, "._EMAILFIELD." as email FROM "._AUTHORTABLE." WHERE "._UIDFIELD." = '$owner' LIMIT 1");
			sendemail($mailInfo['penname'], $mailInfo['email'], $sitename, $siteemail, $subject, $seriesMail, "html");
		}
		if(!empty($_POST["sid"])) {
			foreach($_POST["sid"] as $story) {
				if(!isNumber($story)) continue;
				if(!isset($items) || !is_array($items) || !in_array($story, $items)) {
					$count++;
					//$validate = dbxquery("SELECT validated FROM ".TABLEPREFIX."fanfiction_stories WHERE sid = '$story' LIMIT 1");
					//list($valid) = dbrow($validate);
					$validate =  e107::getDb()->retrieve("SELECT validated FROM ".TABLEPREFIX."fanfiction_stories WHERE sid = '$story' LIMIT 1");
					$valid = $validate; //check this 
					if($valid) {
						 //dbxquery("INSERT INTO ".TABLEPREFIX."fanfiction_inseries (seriesid, sid, inorder, confirmed) VALUES('$seriesid', '$story', '$count', '$confirmed')");
						e107::getDb()->gen("INSERT INTO ".TABLEPREFIX."fanfiction_inseries (seriesid, sid, inorder, confirmed) VALUES('$seriesid', '$story', '$count', '$confirmed')");
						}
				}
			}
		}
		//$seriescount = dbquery("SELECT count(seriesid) FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid'");
		//list($count) = dbrow($seriescount);
		$count = e107::getDb()->retrieve("SELECT count(seriesid) FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid'");

		if(!empty($_POST["subseriesid"])) {
			foreach($_POST["subseriesid"] as $subseries) {
				if(!isNumber($subseries)) continue;
				if(!isset($subs) || !in_array($subseries, $subs)) {
					$count++;
					//dbxquery("INSERT INTO ".TABLEPREFIX."fanfiction_inseries (seriesid, subseriesid, inorder) VALUES('$seriesid', '$subseries', '$count')");
					e107::getDb()->gen("INSERT INTO ".TABLEPREFIX."fanfiction_inseries (seriesid, subseriesid, inorder) VALUES('$seriesid', '$subseries', '$count')");
				}
			}
		}
		$numstories = count(storiesInSeries($seriesid));
		//dbxquery("UPDATE ".TABLEPREFIX."fanfiction_series SET numstories = '$numstories' WHERE seriesid = $seriesid LIMIT 1");
		e107::getDb()->gen("UPDATE ".TABLEPREFIX."fanfiction_series SET numstories = '$numstories' WHERE seriesid = $seriesid LIMIT 1");
		seriesreview($seriesid);
		$showlist = true;
		$output .= write_message(_ACTIONSUCCESSFUL);
	}
	else {
		$caption = "<div id=\"pagetitle\">".($action == "edit" ? _EDITSERIES : $add == "stories" ? _ADD2SERIES : _ADDSERIES)."</div>
			<form METHOD=\"POST\" style='width: 90%; margin: 0 auto;' name=\"form\" action=\"manageseries.php?action=$action&amp;add=".(!empty($add) ? $add : "series").(!empty($seriesid) ? "&amp;seriesid=$seriesid" : "")."\">";
		$output .= "<input type=\"hidden\" name=\"seriesid\" value=\"$seriesid\">";
		//$series = dbxquery("SELECT title, uid, isopen FROM ".TABLEPREFIX."fanfiction_series WHERE seriesid = '$seriesid' LIMIT 1");
		//list($title, $owner) = dbrow($series);
		$series = e107::getDb()->retrieve("SELECT title, uid, isopen FROM ".TABLEPREFIX."fanfiction_series WHERE seriesid = '$seriesid' LIMIT 1"); 
		$title = $series['title'];
		$owner = $series['uid'];
		$isopen = $series['isopen'];
	
		$caption .= "<div class='sectionheader'>"._SERIE.": ".stripslashes($title)."</div>";
		if(($admin || USERUID == $owner ) && isset($_GET['stories']) && $_GET['stories'] == "others") {
			if($let == _OTHER) $letter= _PENNAMEFIELD." REGEXP '^[^a-z]'";
			else $letter = _PENNAMEFIELD." LIKE '$let%'";
			$pagelink = "manageseries.php?action=$action&amp;add=stories&amp;stories=others&amp;seriesid=$seriesid&amp;";
			$authorlink = "<a id='327' href=\"manageseries.php?action=$action&amp;add=stories&amp;seriesid=$seriesid&amp;stories=";
			$countquery = _MEMBERCOUNT." WHERE ap.stories > 0".(isset($letter) ? " AND $letter" : "");
			$authorquery = _MEMBERLIST." WHERE ap.stories > 0".(isset($letter) ? " AND $letter" : "");
			include(_BASEDIR."includes/members_list.php");
			$showlist = false;
		}
		else {
			//$stories = dbxquery("SELECT title, sid FROM ".TABLEPREFIX."fanfiction_stories WHERE validated > 0 AND uid = '".(isset($_GET["stories"]) && isNumber($_GET['stories']) ? $_GET["stories"] : USERUID)."' ORDER BY title ASC");
			$stories = e107::getDb()->retrieve("SELECT title, sid FROM ".TABLEPREFIX."fanfiction_stories WHERE validated > 0 AND uid = '".(isset($_GET["stories"]) && isNumber($_GET['stories']) ? $_GET["stories"] : USERUID)."' ORDER BY title ASC", true);

			//$seriesstories = dbxquery("SELECT sid FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid'");
			$seriesstories = e107::getDb()->retrieve("SELECT sid FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid'", true);
			//while($story = dbassoc($seriesstories)) {
			foreach($seriesstories AS $story) {	
				$selectedstories["$story[sid]"] = 1;
			}
			if($admin || USERUID == $owner) $output .= "<div style=\"text-align: center;\">
			<a id='344' class='btn btn-outline-primary waves-effect' href=\"manageseries.php?action=$action&amp;add=$add&amp;stories=others&amp;seriesid=$seriesid\">"._CHOOSEAUTHOR."</a></div>";
			$output .= "<table id='544' class=\"table table-bordered table-hover table-striped\">
			<thead class='info-color'><tr><th class=\"tblborder\">"._STORIES."</th></tr></thead>";
			$numstories = 0;
			//while($story = dbassoc($stories)) {
			
			foreach($stories AS $story) {
				if(!empty($selectedstories[$story['sid']])) continue;
				//<input type=\"checkbox\" class=\"checkbox\" value=\"".$story['sid']."\" name=\"sid[]\">" use e107 snippet
				$title = e107::getParser()->toHTML($story['title'], 'TITLE');
				$checkbox = e107::getForm()->checkbox('sid[]', $story['sid'], false, array('label'=>$title ) );
				$output .= "<tr><td>".$checkbox."</td></tr>";
				$numstories++;
			}
			if($numstories  == 0) $output .= "<tr><td align=\"center\">"._NORESULTS."</td></tr>";
			//$series2 = dbxquery("SELECT title, seriesid FROM ".TABLEPREFIX."fanfiction_series WHERE uid = '".(isset($_GET['stories']) && isNumber($_GET['stories']) ? $_GET['stories'] : USERUID)."' ORDER BY title ASC");
			$series2 = e107::getDb()->retrieve("SELECT title, seriesid FROM ".TABLEPREFIX."fanfiction_series WHERE uid = '".(isset($_GET['stories']) && isNumber($_GET['stories']) ? $_GET['stories'] : USERUID)."' ORDER BY title ASC",true);
			$output .= "<tr><th class=\"tblborder\">"._SERIES."</th></tr>";
			$numseries = 0;
			//while($series = dbassoc($series2)) {
			foreach($series2 AS $series) {
				if($series['seriesid'] != $seriesid) {
					$title = e107::getParser()->toHTML($series['title'], 'TITLE');
					$checkbox = e107::getForm()->checkbox('subseriesid[]', $series['seriesid'], false, array('label'=>$title ) );
					$output .= "<tr><td>".$checkbox."</td></tr>";
					//$output .= "<tr><td><input type=\"checkbox\" class=\"checkbox\" value=\"".$series['seriesid']."\" name=\"subseriesid[]\">".stripslashes($series['title'])."</td></tr>";
					$numseries++;
				}
			}
			if($numseries < 1) $output .= "<tr><td align=\"center\">"._NORESULTS."</td></tr>";
			$output .="</table><p style=\"text-align: center;\">"._SERIESNOTE2."<br />
			<input type=\"submit\" class=\"button\" name=\"submit\" value=\"submit\"></p></form>";
			$showlist = false;
		}		
	}
}
if($action == "delete") {
	global $seriesid;

	$confirmed = isset($_GET["confirmed"]) ? $_GET['confirmed'] : false;
	$caption = "<div id=\"pagetitle\">".(!empty($inorder) ? _REMOVEFROM : _DELETESERIES)."</div>";

	if($confirmed == "no") {
		$output .=  write_message(_ACTIONCANCELLED);
	}
	else if($confirmed == "yes" && $seriesid) {
		if(!empty($inorder)) {
			//$info = dbxquery("SELECT inorder, subseriesid, sid FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid' AND inorder = '$inorder' LIMIT 1");
			//list($inorder, $subseriesid, $sid) = dbrow($info);
			$info = e107::getDb()->retrieve("SELECT inorder, subseriesid, sid FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid' AND inorder = '$inorder' LIMIT 1");
			$inorder = $info['inorder'];
			$subseriesid = $info['subseriesid'];
			$sid = $info['sid'];

			//$countquery = dbxquery("SELECT count(seriesid) FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid'");
			//list($count) = dbrow($countquery);
			$count = e107::getDb()->retrieve("SELECT count(seriesid) AS count FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid'");
			
			//dbxquery("DELETE FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid' AND ".($sid ? "sid = '$sid'" : "subseriesid = '$subseriesid'"). " LIMIT 1");
			e107::getDb()->gen("DELETE FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid' AND ".($sid ? "sid = '$sid'" : "subseriesid = '$subseriesid'"). " LIMIT 1");
			if($inorder < $count) { 
				//dbxquery("UPDATE ".TABLEPREFIX."fanfiction_inseries SET inorder = (inorder - 1) WHERE seriesid = '$seriesid' AND inorder > '$inorder'");
				e107::getDb()->gen("UPDATE ".TABLEPREFIX."fanfiction_inseries SET inorder = (inorder - 1) WHERE seriesid = '$seriesid' AND inorder > '$inorder'");
			}
			$output .= write_message(_ACTIONSUCCESSFUL);
			$showlist = true;
		}
		else {
			//$seriesinfo = dbxquery("SELECT title, uid FROM ".TABLEPREFIX."fanfiction_series WHERE seriesid = '$seriesid'");
			// list($title, $uid) = dbrow($seriesinfo);
			$seriesinfo = e107::getDb()->retrieve("SELECT title, uid FROM ".TABLEPREFIX."fanfiction_series WHERE seriesid = '$seriesid'");
			$title = $seriesinfo['title'];
			$uid = $seriesinfo['uid'];
			include(_BASEDIR."includes/deletefunctions.php");
			deleteSeries($seriesid);
			$output .= write_message(_ACTIONSUCCESSFUL);
			if($admin || USERUID == $uid) $showlist = true;
			$seriesid = false;
		}
	}
	else {
		$output .= write_message((!empty($inorder) ? _CONFIRMREMOVE : _CONFIRMDELETE)."<br /><br />[ 
			<a id='422' href=\"manageseries.php?action=delete&amp;confirmed=yes&amp;seriesid=$seriesid".(!empty($inorder) ? "&amp;inorder=$inorder" : "")."\">"._YES."</a> | 
			<a id='423' href=\"manageseries.php?action=delete&amp;confirmed=no\">"._NO."</a> ]");
		$showlist = false;
	}
}
if($showlist) {
	$go = isset($_GET['go']) ? $_GET['go'] : false;
	if($go != "" && $seriesid != "") {
		if(!empty($_GET['sid']) && isNumber($_GET['sid'])) $sid = $_GET["sid"];
		if(!empty($_GET['subseriesid']) && isNumber($_GET['subseriesid'])) $subseriesid = $_GET["subseriesid"];
		if(isset($inorder) && (isset($sid) || isset($subseriesid))) {
			if($go == "up") $oneabove = $inorder - 1;
			else $oneabove = $inorder + 1;
			if($oneabove >= 1) {
				//dbquery("UPDATE ".TABLEPREFIX."fanfiction_inseries SET inorder = '$inorder' WHERE inorder = '$oneabove' AND seriesid = '$seriesid'");
				e107::getDb()->gen("UPDATE ".TABLEPREFIX."fanfiction_inseries SET inorder = '$inorder' WHERE inorder = '$oneabove' AND seriesid = '$seriesid'");
				//dbquery("UPDATE ".TABLEPREFIX."fanfiction_inseries SET inorder = '$oneabove' WHERE ".(isset($sid) ? "sid = '$sid'" : "subseriesid = '$subseriesid'")." AND seriesid = '$seriesid'");
				e107::getDb()->gen("UPDATE ".TABLEPREFIX."fanfiction_inseries SET inorder = '$oneabove' WHERE ".(isset($sid) ? "sid = '$sid'" : "subseriesid = '$subseriesid'")." AND seriesid = '$seriesid'");	
			}
		}
	}
	if(empty($action) || $action == "manage") $caption = "<div id=\"pagetitle\">"._MANAGESERIES."</div>";
	if($seriesid) {
		//list($owner, $isopen) = dbrow(dbxquery("SELECT uid,isopen FROM ".TABLEPREFIX."fanfiction_series WHERE seriesid = '$seriesid' LIMIT 1"));
		$tmp = e107::getDb()->retrieve("SELECT uid,isopen FROM ".TABLEPREFIX."fanfiction_series WHERE seriesid = '$seriesid' LIMIT 1");
		$owner = $tmp['uid'];
		$isopen = $tmp['isopen'];
		// $result = dbxquery("SELECT series.seriesid AS mainid, series.inorder, confirmed, series.sid, series.subseriesid, stories.title AS storytitle, sub.title AS subtitle FROM ".TABLEPREFIX."fanfiction_inseries AS series LEFT JOIN ".TABLEPREFIX."fanfiction_stories AS stories ON ( series.sid = stories.sid ) LEFT JOIN ".TABLEPREFIX."fanfiction_series AS sub ON ( sub.seriesid = series.subseriesid ) WHERE series.seriesid = '$seriesid' ORDER BY series.inorder");
		$result = e107::getDb()->retrieve("SELECT series.seriesid AS mainid, series.inorder, confirmed, series.sid, series.subseriesid, stories.title AS storytitle, sub.title AS subtitle FROM ".TABLEPREFIX."fanfiction_inseries AS series LEFT JOIN ".TABLEPREFIX."fanfiction_stories AS stories ON ( series.sid = stories.sid ) LEFT JOIN ".TABLEPREFIX."fanfiction_series AS sub ON ( sub.seriesid = series.subseriesid ) WHERE series.seriesid = '$seriesid' ORDER BY series.inorder", true);

		$output .= "<table id='445' class=\"table table-bordered table-hover table-striped\">
			<tr><th class=\"tblborder\">"._TITLE."</th><th class=\"tblborder\" width=\"26\">"._ORDER."</th><th class=\"tblborder\">"._OPTIONS."</th></tr>";
		//$rows = dbnumrows($result);
		$rows = count($result);
		//while($series = dbassoc($result)) {
		foreach($result AS $series) {
			$output .= "<tr><td class=\"tblborder\"><a id='458' href=\"".($series['subseriesid'] == 0 ? "viewstory.php?sid=".$series['sid']."\">".stripslashes($series['storytitle']) : "viewseries.php?seriesid=$series[subseriesid]\">".stripslashes($series['subtitle']))."</a></td>
				<td class=\"tblborder\" align=\"center\">".($series['inorder'] == $rows ? "" : "<a id='459' href=\"manageseries.php?action=manage&amp;go=down&amp;inorder=".$series['inorder']."&amp;".($series['sid'] ? "sid=".$series['sid'] : "subseriesid=".$series['subseriesid'])."&amp;seriesid=$seriesid\"><img src=\""._BASEDIR."images/arrowdown.gif\" align=\"right\" border=\"0\" width=\"13\" height=\"18\" alt=\""._DOWN."\"></a>").
				($series['inorder'] == 1 ? "&nbsp;" : "<a id='460' href=\"manageseries.php?action=manage&amp;go=up&amp;inorder=$series[inorder]&amp;".($series['sid'] ? "sid=".$series['sid'] : "subseriesid=".$series['subseriesid'])."&amp;seriesid=$seriesid\"><img src=\""._BASEDIR."images/arrowup.gif\" border=\"0\" width=\"13\" height=\"18\" align=\"left\" alt=\""._UP."\"></a>")."</td>
				<td class=\"tblborder\">".($owner == USERUID || $admin ? "<a id='461' class='btn btn-sm  btn-danger' href=\"manageseries.php?action=delete&amp;seriesid=$seriesid&amp;inorder=".$series['inorder']."\">"._REMOVE."</a>" : "&nbsp;").($isopen == 1 && empty($series['confirmed']) && USERUID == $owner ? " | <a id='465'  href=\"manageseries.php?action=validate&amp;seriesid=$seriesid&amp;inorder=".$series['inorder']."\">"._VALIDATE."</a>" : "")."</td></tr>";
		}
		$output .= "<tr><td colspan=\"3\" align=\"center\">
		<a id='462' class='btn btn-outline-success' href=\"manageseries.php?action=add&amp;add=stories&amp;seriesid=$seriesid\">"._ORDER. " + ". _ADD2SERIES."</a>
		<a id='469' class='btn btn-outline-primary' href=\"manageseries.php\">"._MANAGESERIES."</a>
		</td></tr></table>";
	}
	else {
		//$result = dbquery("SELECT * from ".TABLEPREFIX."fanfiction_series WHERE uid = '".USERUID."' ORDER BY title");
        // $result = e107::getDb()->retrieve("SELECT * from ".TABLEPREFIX."fanfiction_series WHERE  uid = '".USERUID."' ORDER BY title", true);
        
        if($admin) { $where = true; } else { $where = "uid = '".USERUID."'";  } //possibility to see all series for level < 3 
        
		$result = e107::getDb()->retrieve(_SERIESQUERY." AND  ".$where." ORDER BY title", true);
		
		$output .= "<table id='462' class=\"table table-bordered table-hover table-striped\"> 
		<thead class='info-color'><tr><th class=\"tblborder\">"._TITLE."</th><th class=\"tblborder\">"._AUTHOR."</th><th class=\"tblborder\">"._OPTIONS."</th></tr></thead>";
		// while($series = dbassoc($result)) {
		foreach($result AS $series) {
			$output .= "
            <tr><td class=\"tblborder\"><a href=\"viewseries.php?seriesid=".$series['seriesid']."\">".stripslashes($series['title'])."</a></td>
            <td> <a href=\"viewuser.php?uid=".$series['uid']."\">".stripslashes($series['penname'])."</a> </td>
            <td class=\"tblborder\">
			<a id='473' class='btn btn-sm btn-warning' href=\"manageseries.php?action=add&amp;add=stories&amp;seriesid=".$series['seriesid']."\">"._ADD2SERIES."</a> | 
			<a  id='474' class='btn btn-sm btn-success' href=\"manageseries.php?action=edit&amp;seriesid=$series[seriesid]\">"._EDIT."</a> | 
			<a  id='475' class='btn btn-sm btn-danger' href=\"manageseries.php?action=delete&amp;seriesid=$series[seriesid]\">"._DELETE."</a></td></tr>";
		}
		$output .= "<tr><td colspan='2' align='center' class=\"tblborder\">
		<a class='btn btn-success' href='manageseries.php?action=add'>"._ADDSERIES."</a></td></tr></table>";
	}
}
 
$output = e107::getParser()->parseTemplate($output, true);
e107::getRender()->tablerender($caption, $output, $current);
dbclose( );
require_once(FOOTERF);  
 