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
$current = "series";
if($_GET['action'] == "add" || $_GET['action'] == "edit") $displayform = 1;

include ("header.php");  //$action and HEADERF */
 
$allowseries = efiction_settings::get_single_setting('allowseries');
 
//include(_BASEDIR."includes/pagesetup.php");
 
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
	list($admincats) = dbrow(dbquery("SELECT categories FROM ".TABLEPREFIX."fanfiction_authorprefs WHERE uid = '".USERUID."'"));
	if(isset($seriesid)) {
		$series = dbquery("SELECT uid, isopen, catid from ".TABLEPREFIX."fanfiction_series WHERE seriesid='$seriesid' LIMIT 1");
		list($owner, $seriesopen, $catid) = dbrow($series);
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
	$count = efiction_stories::get_stories_count_by_uid(USERUID);
	if($count == 0) accessDenied( );
}

if($action == "manage") {

		/*********************************************  SERIE ADMIN LISTING ********************************************** */
		efiction_series::member_serie_listing(USERUID, $current);
		require_once(FOOTERF); 
		exit;

		/*********************************************  END OF SERIE ADMIN LISTING *************************************** */ 
}



if($action == "validate") {
	$inorder = isset($_GET['inorder']) && isNumber($_GET['inorder']) ? $_GET['inorder'] : 0;
	$valid = dbquery("UPDATE ".TABLEPREFIX."fanfiction_inseries SET confirmed = 1 WHERE seriesid = '$seriesid' AND inorder = '$inorder' LIMIT 1");
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
		/* saving to db */
		$title = addslashes(escapestring(strip_tags($_POST['title'], $allowed_tags)));
		$summary = addslashes(escapestring(descript(strip_tags($_POST["summary"], $allowed_tags))));
 

		$open = isset($_POST['open']) && isNumber($_POST['open']) ? $_POST['open'] : 0;
		
		/* IMPORTANT e107 checkboxes returns array directly */
		$catid = isset($_POST['catid']) ? array_filter($_POST['catid'], "isNumber") : array( );
		$charid = isset($_POST['charid']) ? array_filter($_POST['charid'], "isNumber") : array( );
 
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
			  
				$update = array(
					'title'    =>  $title,
					'summary'    =>  $summary,
					'catid'    =>  ($catid ? implode(",", $catid) : ""),
					'isopen'    =>  $open,
					'characters'    => ($charid ? implode(",", $charid) : ""),
					'classes'    =>  $classes,            
					"WHERE"  =>  "seriesid = ".$seriesid
				 );
 
				$result = e107::getDB()->update('fanfiction_series', $update, true);

				if($result == 0 ) {
					e107::getMessage()->addInfo(LAN_SETTINGS_NOT_SAVED_NO_CHANGES_MADE);
				}
				elseif($result == 1 ) {
				   e107::getMessage()->addSuccess(LAN_SETSAVED);
				}
		 
				$output .= e107::getMessage()->render();

				$codequery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'editseries'");
				while($code = dbassoc($codequery)) {
					eval($code['code_text']);
				}
				$output .= write_message(_ACTIONSUCCESSFUL."<br />"._BACK2ACCT);
			}
			else {
				dbquery("INSERT INTO ".TABLEPREFIX."fanfiction_series (title, summary, catid, isopen, uid, characters, classes) VALUES('$title', '$summary', '$category', '$open', '$owner', '$charid', '$classes')");
				$seriesid = dbinsertid();
				dbquery("UPDATE ".TABLEPREFIX."fanfiction_stats SET series = series + 1");
				$codequery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'addseries'");
				while($code = dbassoc($codequery)) {
					eval($code['code_text']);
				}
				$add = "stories";
				unset($_POST['submit']);
			}
		}
	}
	else {
    /********** series form - add/edit  ************/
 
    if($action == "edit") { 
    
    	$caption = _EDITSERIES;
    }
    else if($add ==  "stories" ) {
        $caption = _ADD2SERIES;
    }
    else $caption = _ADDSERIES;
 
	$output = "<form METHOD=\"POST\"  name=\"form\" action=\"series.php?action=$action&amp;add=".(!empty($add) ? $add : "series").(!empty($seriesid) ? "&amp;seriesid=$seriesid" : "")."\">";

	if($action == "edit" && !isset($POST['submit'])) {
 
		$series = efiction_series::serie($seriesid); 
 
		$catid = explode(",", $series['catid']);
		$classes = explode(",", $series['classes']);
		$charid = explode(",", $series['characters']);
		$isopen = isset($series['isopen']) ? $series['isopen'] : 0;

		$owner = $series['uid'];
		$output .= "<input type=\"hidden\" name=\"seriesid\" value=\"$seriesid\">";
	}
	else $series = array("uid" => 0, "title" => "", "summary" => "");
 
	$required = "<span style=\"font-weight: bold; color: red\">*</span>";
 
	if($admin) {
 
		$authorquery = dbquery("SELECT "._PENNAMEFIELD." as penname, "._UIDFIELD." as uid FROM "._AUTHORTABLE." ORDER BY penname");
 
		$authors = '';
		
		while($authorresult = dbassoc($authorquery)) {
			$authors .= "<option value=\"".$authorresult['uid']."\"".((USERUID == $authorresult['uid'] && !$seriesid) || (is_array($series) && $series['uid'] == $authorresult['uid']) ? " selected" : "").">".$authorresult['penname']."</option>";
		}
 
		$text .= "<div class='row mb-3'>"; 
		$text .= "<label class='col-sm-2 col-form-label fw-bold'  for=\"uid\">"._AUTHOR.": ".$required."</label>";
		$text .= "<div class='col-sm-10'>";
			$text .= "<select class='form-control' name=\"uid\" id=\"uid\">$authors</select>";
		$text .= "</div>";
		$text .= "</div>";

	}
	
	$title = isset($series) ? htmlentities($series['title']) : "" ;
	$summary = (isset($series) ? $series['summary'] : "");

	/* title + summary */
	$text .= '<div class="row mb-3">';
	$text .= '<label for="title" class="col-sm-2 col-form-label fw-bold">'._TITLE." ".$required.'</label>'; 
	$text .= '<div class="col-sm-10">';
		$text .= e107::getForm()->text('title', $title, 200, array('size'=>'xxlarge', 'required'=>1));
	$text .= '</div>';
	$text .= '</div>'; 
	$text .= '<div class="row mb-3">';
		$text .= '<label for="title" class="col-sm-2 col-form-label fw-bold">'._SUMMARY.(!$title ? $required : "").'</label>'; 
		$text .= '<div class="col-sm-10">';
			$text .= e107::getForm()->textarea('summary',$summary, 6,80, array('size'=>'xxlarge', 'required'=>1));
		$text .= '</div>';
	$text .= '</div>';
    $output .= $text;

	/* category */
	if(!$multiplecats) $output .= "<input type=\"hidden\" name=\"catid\" id=\"catid\" value=\"1\">";
	else {
		
		$catid = isset($series['catid']) ? explode(",", $series['catid']) : array( );

		$text  = '<div class="row mb-3">';
		$text .= "<label class=\"col-sm-2 col-form-label fw-bold\" for=\"catid\">"._CATOPTIONS.":</label>";
		$text .= '<div class="col-sm-10">';
		$categories = efiction_categories::get_categories();
		$options = array('title' => _SELECTCATS, 'inline' => true,  'useKeyValues' => 1  );
		$text .= e107::getForm()->checkboxes('catid', $categories, $catid, $options);
			$text .= '</div>';
		$text .= '</div>';
		$text .= "<input type=\"hidden\" name=\"formname\" value=\"series\">";
	}
 
	$output .= $text;

	/*  characters */
	$catid[] = -1;
	$text  = '<div class="row mb-3">';
        $text .= "<label class=\"col-sm-2 col-form-label fw-bold\" for=\"charid\">"._CHARACTERS.":</label>";   
        $characters = efiction_characters::characters();  
		$text .= '<div class="col-sm-10">';
        $options = array('title' => _CHARACTERS, 'inline' => true,  'useKeyValues' => 1);
        $text .= e107::getForm()->checkboxes('charid', $characters, $charid, $options);
        $text .= '</div>';
    $text .= '</div>';    
 
	$text .= '<style> .form-check {min-width: 270px;}
	#characters-container .checkbox-inline  {margin-left: 20px!important; } 
	#catid-container .checkbox-inline  {margin-left: 20px!important; }  
	#classes-container .checkbox-inline  {margin-left: 20px!important; } 
	</style>';

	$output .= $text;  $text = '';

	/*  categorization */
	$classrows = e107::getDb()->retrieve('SELECT * FROM #fanfiction_classtypes ORDER BY classtype_name', true);
 
	foreach ($classrows as $type) {   
		$text .= "<div class='row mb-3'>";
			$text .= "<label class=\"col-sm-2 col-form-label fw-bold\" for=\"class_".$type['classtype_id']."\"><b>$type[classtype_title]:</b></label>";
			$result2 = e107::getDb()->retrieve("SELECT * FROM #fanfiction_classes WHERE class_type = '$type[classtype_id]' ORDER BY class_name", true);
			$values = array();
			$text .= '<div class="col-sm-10">';
				foreach ($result2 as $row) {
					$values[$row['class_id']] = $row['class_name'] ;
				}
				$options['useKeyValues'] = true;
				$options['inline'] = true;
			$text .= e107::getForm()->checkboxes('classes', $values, $classes, $options);
			$text .= '</div>';
		$text .= '</div>';
	}

	$output .= $text;  $text = '';

    $open_options = "<option value=\"2\"".($isopen == "2" ? " selected" : "").">"._OPEN."</option>
	<option value=\"1\"".($isopen == "1" ? " selected" : "").">"._MODERATED."</option>
	<option value=\"0\"".(!$isopen ? " selected" : "").">"._CLOSED."</option>";

	$text .= "<div class='row mb-3'>"; 
	$text .= "<label class='col-sm-2 col-form-label fw-bold'  for=\"uid\">"._SERIESTYPE.": </label>";
	$text .= "<div class='col-sm-10'>";
		$text .= "<select class='form-control' name=\"uid\" id=\"uid\">$open_options</select>";
	$text .= "</div>";
	$text .= "</div>";

    $text .= "<div class='row mb-3'>";
	$text .= "<div style=\"margin: 1em;\">"._OPENNOTE."</div>";
	$text .= "</div>";
	$output .= $text;  $text = '';

 
	$codequery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'seriesform'");
	while($code = dbassoc($codequery)) {
		eval($code['code_text']);
	}


	$output .= "<div style=\"text-align: center;\"><input type=\"submit\" class=\"submit btn btn-success\" name=\"submit\" value=\""._SUBMIT."\"></div> </form>";
	if($action == "add") {
		$output .= "<div class='text-center'>"._SERIESNOTE."</div>";
		$showlist = false;
	}
}
}
if($add == "stories") {
  
	if(isset($seriesid) && isset($_POST['submit'])) { 
       
		if(!$seriesid) accessDenied( );
        $result = efiction_series::get_series_by_serieid($seriesid);
        $owner = $result['uid'];
        $isopen = $result['isopen'];
        $title = $result['title'];
 
        $query = "SELECT count(seriesid) FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid'";
        $count = e107::getDb()->retrieve($query);
        
        
        $query = "SELECT sid, subseriesid FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid'";
        $seriesitems = e107::getDb()->retrieve($query, true); 
        
        foreach($seriesitems AS $item ) {
                if($item['sid']) $items[] = $item['sid'];
                if($item['subseriesid']) $subs[] = $item['subseriesid'];
        }
 
		if($admin || USERUID == $owner || $isopen == 2 ) $confirmed = 1;
		else {
			$confirmed = 0;
			 
			$seriesMail = sprintf(_NEWSERIESITEMS, stripslashes($title));
			$subject = sprintf("_SERIESITEMSSUBS", stripslashes($title));
            
            $query = "SELECT "._PENNAMEFIELD." as penname, "._EMAILFIELD." as email FROM "._AUTHORTABLE." WHERE "._UIDFIELD." = '$owner' LIMIT 1";
			$mailInfo = e107::getDb()->retrieve($query);
			$result = efiction_core::sendemail($mailInfo['penname'], $mailInfo['email'], $sitename, $siteemail, $subject, $seriesMail, "html");
            unset($mailInfo); 
            
		}
 
		if(!empty($_POST["sid"])) {
			foreach($_POST["sid"] as $story) {
				if(!isNumber($story)) continue;
				if(!isset($items) || !is_array($items) || !in_array($story, $items)) {
					$count++;
                    $query = "SELECT validated FROM ".TABLEPREFIX."fanfiction_stories WHERE sid = '$story' LIMIT 1";
					$valid = e107::getDb()->retrieve($query);
 
					if($valid) {
                        $query = "INSERT INTO ".TABLEPREFIX."fanfiction_inseries (seriesid, sid, inorder, confirmed) VALUES('$seriesid', '$story', '$count', '$confirmed')" ;
                        e107::getDb()->gen($query);   
                    }
                }
			}
		}
        
        $query = "SELECT count(seriesid) FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid'";
        $count = e107::getDb()->retrieve($query);
 
		if(!empty($_POST["subseriesid"])) {
			foreach($_POST["subseriesid"] as $subseries) {
				if(!isNumber($subseries)) continue;
				if(!isset($subs) || !in_array($subseries, $subs)) {
					$count++;
					$query = "INSERT INTO ".TABLEPREFIX."fanfiction_inseries (seriesid, subseriesid, inorder) VALUES('$seriesid', '$subseries', '$count')" ;
                    e107::getDb()->gen($query);  
				}
			}
		}
        
        
		$numstories = count(storiesInSeries($seriesid));
        $query = "UPDATE ".TABLEPREFIX."fanfiction_series SET numstories = '$numstories' WHERE seriesid = $seriesid LIMIT 1";
        e107::getDb()->gen($query);  
      
		 
	 	seriesreview($seriesid);
		$showlist = true;
    
		$output .= write_message(_ACTIONSUCCESSFUL);
	}
	else {
    
		/**** add story to serie form *********************************/
		$caption = "<div id=\"pagetitle\">".($action == "edit" ? _EDITSERIES : $add == "stories" ? _ADD2SERIES : _ADDSERIES)."</div>";

		$output = "<form METHOD=\"POST\" style='width: 90%; margin: 0 auto;' name=\"form\" action=\"series.php?action=$action&amp;add=".(!empty($add) ? $add : "series").(!empty($seriesid) ? "&amp;seriesid=$seriesid" : "")."\">";
		$output .= "<input type=\"hidden\" name=\"seriesid\" value=\"$seriesid\">";
 
		$series = efiction_series::get_series_by_serieid($seriesid);
		$title = $series['title'];
		$owner = $series['uid'];
		 
		$caption .= "<div class='sectionheader'>"._SERIES.": ".stripslashes($title)."</div>";
 
		if(($admin || USERUID == $owner ) && isset($_GET['stories']) && $_GET['stories'] == "others") {
			if($let == _OTHER) $letter= _PENNAMEFIELD." REGEXP '^[^a-z]'";
			else $letter = _PENNAMEFIELD." LIKE '$let%'";
			$pagelink = "series.php?action=$action&amp;add=stories&amp;stories=others&amp;seriesid=$seriesid&amp;";
			$authorlink = "<a href=\"series.php?action=$action&amp;add=stories&amp;seriesid=$seriesid&amp;stories=";
			$countquery = _MEMBERCOUNT." WHERE ap.stories > 0".(isset($letter) ? " AND $letter" : "");
			$authorquery = _MEMBERLIST." WHERE ap.stories > 0".(isset($letter) ? " AND $letter" : "");
			include("includes/members_list.php");
			$showlist = false;
		}
		else {
			$series_uid = (isset($_GET["stories"]) && isNumber($_GET['stories']) ? $_GET["stories"] : USERUID); 
 
			$stories = efiction_stories::get_validated_stories_by_uid($series_uid); 
			$seriesstories = efiction_series:: get_stories_ids_in_series($seriesid);
 
			foreach($seriesstories AS $story) 
			{
				$selectedstories["$story[sid]"] = 1;
			}

			if($admin || USERUID == $owner) $output .= "<div style=\"text-align: center;\"><a href=\"series.php?action=$action&amp;add=$add&amp;stories=others&amp;seriesid=$seriesid\">"._CHOOSEAUTHOR."</a></div>";
			
			$output .= "<div class='table-responsive'><table class=\"tblborder\"><tr><th class=\"tblborder\">"._STORIES."</th></tr>";
			$numstories = 0;
			foreach($stories AS $story) {
				if(!empty($selectedstories[$story['sid']])) continue;
				$output .= "<tr><td><input type=\"checkbox\" class=\"checkbox\" value=\"".$story['sid']."\" name=\"sid[]\">".stripslashes($story['title'])."</td></tr>";
				$numstories++;
			}
 
			if($numstories  == 0) $output .= "<tr><td align=\"center\">"._NORESULTS."</td></tr>";
			$serie2 = efiction_series::get_series_by_uid($series_uid);
			
			$output .= "<tr><th class=\"tblborder\">"._SERIES."</th></tr>";
			$numseries = 0;


			foreach($serie2 AS $series) {  
				
				if($series['seriesid'] != $seriesid) {   
					$output .= "<tr><td><input type=\"checkbox\" 
					class=\"checkbox\" value=\"".$series['seriesid']."\" name=\"subseriesid[]\">".stripslashes($series['title'])."</td></tr>";
					$numseries++;
				}
			}
			if($numseries < 1) $output .= "<tr><td align=\"center\">"._NORESULTS."</td></tr>";
			$output .="</table></div> <p style=\"text-align: center;\">"._SERIESNOTE2."<br />
			<input type=\"submit\" class=\"button btn btn-outline-success\" name=\"submit\" value=\"submit\"></p></form>";
			$showlist = false;
		}	
         
	}
}


if($action == "delete") {
	global $seriesid;

	$confirmed = isset($_GET["confirmed"]) ? $_GET['confirmed'] : false;
	$caption = "<div id=\"pagetitle\">".(!empty($inorder) ? _REMOVEFROM : _DELETESERIES)."</div>";
	$output = "";
	if($confirmed == "no") {
		$output .=  write_message(_ACTIONCANCELLED);
	}
	else if($confirmed == "yes" && $seriesid) {
		if(!empty($inorder)) {
			$info = dbquery("SELECT inorder, subseriesid, sid FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid' AND inorder = '$inorder' LIMIT 1");
			list($inorder, $subseriesid, $sid) = dbrow($info);
			$countquery = dbquery("SELECT count(seriesid) FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid'");
			list($count) = dbrow($countquery);
			dbquery("DELETE FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid' AND ".($sid ? "sid = '$sid'" : "subseriesid = '$subseriesid'"). " LIMIT 1");
			if($inorder < $count) dbquery("UPDATE ".TABLEPREFIX."fanfiction_inseries SET inorder = (inorder - 1) WHERE seriesid = '$seriesid' AND inorder > '$inorder'");
			$output .= write_message(_ACTIONSUCCESSFUL);
			$showlist = true;
		}
		else {

			$seriesinfo = dbquery("SELECT title, uid FROM ".TABLEPREFIX."fanfiction_series WHERE seriesid = '$seriesid'");
			list($title, $uid) = dbrow($seriesinfo);
			include("includes/deletefunctions.php");
			deleteSeries($seriesid);
			$output .= write_message(_ACTIONSUCCESSFUL);
			if($admin || USERUID == $uid) $showlist = true;
			$seriesid = false;
		}
	}
	else {
		$output .= write_message((!empty($inorder) ? _CONFIRMREMOVE : _CONFIRMDELETE)."<br /><br />[ <a class='btn btn-outline-danger' href=\"series.php?action=delete&amp;confirmed=yes&amp;seriesid=$seriesid".(!empty($inorder) ? "&amp;inorder=$inorder" : "")."\">"._YES."</a> | 
			<a class='btn btn-outline-info' href=\"series.php?action=delete&amp;confirmed=no\">"._NO."</a> ]");
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
				dbquery("UPDATE ".TABLEPREFIX."fanfiction_inseries SET inorder = '$inorder' WHERE inorder = '$oneabove' AND seriesid = '$seriesid'");
				dbquery("UPDATE ".TABLEPREFIX."fanfiction_inseries SET inorder = '$oneabove' WHERE ".(isset($sid) ? "sid = '$sid'" : "subseriesid = '$subseriesid'")." AND seriesid = '$seriesid'");	
			}
		}
	}
	if(empty($action) || $action == "manage") { 
		 $caption  = "<div id=\"pagetitle\">"._MANAGESERIES."</div>";
		 $output = "";
	}

	if($seriesid) { 
 
		list($owner, $isopen) = dbrow(dbquery("SELECT uid,isopen FROM ".TABLEPREFIX."fanfiction_series WHERE seriesid = '$seriesid' LIMIT 1"));
		$result = dbquery("SELECT series.seriesid AS mainid, series.inorder, confirmed, series.sid, series.subseriesid, stories.title AS storytitle, sub.title AS subtitle FROM ".TABLEPREFIX."fanfiction_inseries AS series LEFT JOIN ".TABLEPREFIX."fanfiction_stories AS stories ON ( series.sid = stories.sid ) LEFT JOIN ".TABLEPREFIX."fanfiction_series AS sub ON ( sub.seriesid = series.subseriesid ) WHERE series.seriesid = '$seriesid' ORDER BY series.inorder");
		$output .= "<table style=\"margin: 1em auto;\" cellpadding=\"0\" class=\"tblborder\">
			<tr><th class=\"tblborder\">"._TITLE."</th><th class=\"tblborder\" width=\"26\">"._ORDER."</th><th class=\"tblborder\">"._OPTIONS."</th></tr>";
		$rows = dbnumrows($result);
		while($series = dbassoc($result)) {
			$output .= "<tr><td class=\"tblborder\"><a href=\"".($series['subseriesid'] == 0 ? "viewstory.php?sid=".$series['sid']."\">".stripslashes($series['storytitle']) : "viewseries.php?seriesid=$series[subseriesid]\">".stripslashes($series['subtitle']))."</a></td>
				<td class=\"tblborder\" align=\"center\">".($series['inorder'] == $rows ? "" : "<a href=\"series.php?action=manage&amp;go=down&amp;inorder=".$series['inorder']."&amp;".($series['sid'] ? "sid=".$series['sid'] : "subseriesid=".$series['subseriesid'])."&amp;seriesid=$seriesid\"><img src=\""._BASEDIR."images/arrowdown.gif\" align=\"right\" border=\"0\" width=\"13\" height=\"18\" alt=\""._DOWN."\"></a>").
				($series['inorder'] == 1 ? "&nbsp;" : "<a href=\"series.php?action=manage&amp;go=up&amp;inorder=$series[inorder]&amp;".($series['sid'] ? "sid=".$series['sid'] : "subseriesid=".$series['subseriesid'])."&amp;seriesid=$seriesid\"><img src=\""._BASEDIR."images/arrowup.gif\" border=\"0\" width=\"13\" height=\"18\" align=\"left\" alt=\""._UP."\"></a>")."</td>
				<td class=\"tblborder\">".($owner == USERUID || $admin ? "<a class='btn btn-outline-danger' href=\"series.php?action=delete&amp;seriesid=$seriesid&amp;inorder=".$series['inorder']."\">"._REMOVE."</a>" : "&nbsp;").($isopen == 1 && empty($series['confirmed']) && USERUID == $owner ? " | <a href=\"series.php?action=validate&amp;seriesid=$seriesid&amp;inorder=".$series['inorder']."\">"._VALIDATE."</a>" : "")."</td></tr>";
		}
		$output .= "<tr><td colspan=\"3\" align=\"center\"><a class=\"btn btn-outline-primary me-md-2\" href=\"series.php?action=add&amp;add=stories&amp;seriesid=$seriesid\">"._ADD2SERIES."</a></td></tr></table>";
	}
	else {


		 
	}
}
 
e107::getRender()->tablerender($caption, $output, $current);
require_once(FOOTERF); 
exit;