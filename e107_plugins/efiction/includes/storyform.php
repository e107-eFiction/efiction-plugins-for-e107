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

if(!defined("e107_INIT")) exit( );



//function to build story data section of the form.
function storyform($stories, $preview = 0){

	global $admin, $allowed_tags,    $roundrobins, $coauthallowed, $tinyMCE, $action, $sid;
 
    $catlist = efiction_categories::get_catlist();
    $multiplecats = efiction_settings::get_single_setting('multiplecats');
 
	$classes = explode(",", $stories['classes']);
	$charid = explode(",", $stories['charid']);
	$catid = explode(",", $stories['catid']);
    
	$title = $stories['title'];
	$summary = $stories['summary'];
	$storynotes = $stories['storynotes'];
	$rr = $stories['rr'];
	$feat = $stories['featured'];
	$rid = $stories['rid'];
	$complete = $stories['completed'];
	$validated = $stories['validated'];
	$uid = $stories['uid'];

	$output = "<br /><label for=\"storytitle\">"._TITLE.":</label> ".(!$title ? "<span style=\"font-weight: bold; color: red\">*</span>" : "")."<input type=\"text\" class=\"textbox\" name=\"title\" size=\"50\"".($title? " value=\"".htmlentities($title)."\"" : "")." maxlength=\"200\" id=\"storytitle\"><br />";
	$authorquery = dbquery("SELECT "._PENNAMEFIELD." as penname, "._UIDFIELD." as uid FROM "._AUTHORTABLE." ORDER BY "._PENNAMEFIELD);
	if($admin) {
		if(!isset($authors)) {
			$authors = "";
			while($authorresult = dbassoc($authorquery)) {	
				$authors .= "<option value=\"$authorresult[uid]\"".($uid == $authorresult['uid'] ? " selected" : "").">$authorresult[penname]</option>";
			}
		}
		$output .= "<br /><label for=\"uid\">"._AUTHOR.":</label> <select name=\"uid\" id=\"uid\">$authors</select><br /><br />";
	}
 
	if($coauthallowed) {
	$output .= "<script language=\"javascript\" type=\"text/javascript\" src=\""._BASEDIR."includes/userselect.js\"></script>
		<script language=\"javascript\" type=\"text/javascript\" src=\""._BASEDIR."includes/xmlhttp.js\"></script><div style=\"text-align: center;\">"._COAUTHORSEARCH."</div>";
	$output .= "<label for='coauthorsSelect'>"._SEARCH.": <input name='coauthorsSelect' id='coauthorsSelect' size='20' type='text' class='userSelect' onkeyup='setUserSearch(\"coauthors\");' autocomplete='off'></label><br />
<div id='coauthorsDiv' name='coauthorsDiv' style='visibility: hidden;'></div>
<iframe id='coauthorsshim' scr='' scrolling='no' frameborder='0' class='shim'></iframe>
<div><label for='coauthorsSelected'>"._COAUTHORS.": <br /><select name='coauthorsSelected' id='coauthorsSelected' size='8' multiple='multiple' class='multiSelect' onclick='javascript: removeMember(\"coauthors\");'>";
	$couids = array() ;
	if(is_array($stories['coauthors']) && count($stories['coauthors'])) {
		$coauths = dbquery("SELECT "._PENNAMEFIELD." as penname, "._UIDFIELD." as uid FROM "._AUTHORTABLE." WHERE FIND_IN_SET("._UIDFIELD.", '".implode(",", $stories['coauthors'])."') > 0");
		while($c = dbassoc($coauths)) {
			if($c['uid'] == $stories['uid']) continue;
			$output .= "<option label='".$c['penname']."' value='".$c['uid']."'>".$c['penname']."</option>";
			$couids[] = $c['uid'];
		}
		$couids = implode(",", $couids);
	}
	$output .= "</select></label>
		<input type='hidden' name='coauthors' id='coauthors' value='$couids'></div>";
	}
    
	$output .= "<p><label for=\"summary\">"._SUMMARY.":</label> ".(!$summary ? "<span style=\"font-weight: bold; color: red\">*</span>" : "")."<br>";	
    $output .= e107::getForm()->textarea('summary',$summary); 
    $output .= "</p>"; 
    
    $output .= "<p><label class='efiction-label' for=\"storynotes\">"._STORYNOTES.":</label> <br />";

    $output .=  e107::getForm()->bbarea('storynotes',$storynotes,'public','efiction','small', array('wysiwyg' => $wysiwyg));
    $output .= "</p>";
    
    if($tinyMCE) 
		$output .= "<div class='tinytoggle'><input type='checkbox' name='toggle' onclick=\"toogleEditorMode('storynotes');\" checked><label for='toggle'>"._TINYMCETOGGLE."</label></div>";
 
	if(!$multiplecats) $output .= "<input type=\"hidden\" name=\"catid\" id=\"catid\" value=\"1\">";
	else {
 
		require_once(_BASEDIR."includes/categories.php");
		$output .= "<input type=\"hidden\" name=\"formname\" value=\"stories\">";
	}
 
    $query = 'SELECT charname, catid, charid FROM #fanfiction_characters ORDER BY charname';
    $result4 = e107::getDb()->retrieve($query, true);
      foreach ($result4 as $charresults) {
          if ((is_array($catid) && in_array($charresults['catid'], $catid)) || $charresults['catid'] == -1) {
              $characters[$charresults['charid']] = stripslashes($charresults['charname']);
          }
      }
      $options = array('title' => _CHARACTERS, 'inline' => true,  'useKeyValues' => 1);
      $text = e107::getForm()->checkboxes('charid', $characters, $charid, $options);
    
    $output .= "<div class='row form-check-inline mt-2'><label for=\"charid\">"._CHARACTERS.":</label><br>".$text. "</div>";
        
    
    $classrows = e107::getDb()->retrieve('SELECT * FROM #fanfiction_classtypes ORDER BY classtype_name', true);
        $ret .= '<style> .form-check {min-width: 300px;}
		#characters-container .checkbox-inline  {margin-left: 20px!important; } 
		#catid-container .checkbox-inline  {margin-left: 20px!important; }  
		#classes-container .checkbox-inline  {margin-left: 20px!important; } 
		</style>';
        foreach ($classrows as $type) {   
            $ret .= "<div class='row form-check-inline mt-2'><label for=\"class_".$type['classtype_id']."\"><b>$type[classtype_title]:</b></label><br>";
            $result2 = e107::getDb()->retrieve("SELECT * FROM #fanfiction_classes WHERE class_type = '$type[classtype_id]' ORDER BY class_name", true);
            $values = array();
            foreach ($result2 as $row) {
                $values[$row['class_id']] = $row['class_name'] ;
            }
            $options['useKeyValues'] = true;
            $options['inline'] = true;
            $ret .= e107::getForm()->checkboxes('classes', $values, $classes, $options);
            $ret .= '</div>';
        }
    
    $output .= $ret; 
      
 
	$output .= "<div style=\"clear: both; height: 1px;\">&nbsp;</div></div>";
	$result5 = dbquery("SELECT rid, rating FROM ".TABLEPREFIX."fanfiction_ratings");
	$output .= "<label for=\"rid\">"._RATING.":</label>".(!$rid ? " <span style=\"font-weight: bold; color: red\">*</span>" : "")." <select size=\"1\" id=\"rid\" name=\"rid\">";
	while ($r = dbassoc($result5)) {
		$output .= "<option value=\"".$r['rid']."\"".($rid == $r['rid'] ? " selected" : "").">".$r['rating']."</option>";
	} 
	$output .= "</select>  <label for=\"complete\">"._COMPLETE.":</label> <input type=\"checkbox\" class=\"checkbox\" id=\"complete\" name=\"complete\" value=\"1\"".($complete == 1 ? " checked" : "") .">";
	if($roundrobins) $output .= " <label for=\"rr\">  "._ROUNDROBIN.":</label>
  			<input type=\"checkbox\" class=\"checkbox\" name=\"rr\" id=\"rr\"value=\"1\"".($rr == 1 ? "checked" : "").">";
	 if(isADMIN && uLEVEL < 4) $output .= "<br /><label for=\"feature\">"._FEATURED.":</label> <select class=\"textbox\" id=\"feature\" name=\"feature\">
				<option value=\"1\"".($feat == 1 ? " selected" : "").">"._ACTIVE."</option>
				<option value=\"2\"".($feat == 2 ? " selected" : "").">"._RETIRED."</option>
				<option value=\"0\"".(!$feat ? " selected" : "").">"._NO."</option>
			</select> 
			<label for=\"validated\">"._VALIDATED.":</label> <select class=\"textbox\" id=\"validated\" name=\"validated\">
				<option value=\"2\"".($validated == 2? " selected" : "").">"._STORY."</option>
				<option value=\"1\"".($validated  == 1? " selected" : "").">"._CHAPTER."</option>
				<option value=\"0\"".(!$validated ? " selected" : "").">"._NO."</option>
			</select>";
	$codequery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'storyform'");
	while($code = dbassoc($codequery)) {
		eval($code['code_text']);
	}
	return $output;
}
// end storyform

// function to build chapter info section of the form.
function chapterform($inorder, $notes, $endnotes, $storytext, $chaptertitle, $uid = 0) {
	global $admin, $tinyMCE, $action, $preview;
	$inorder++;
	$default = _CHAPTER." ". $inorder;
	if($chaptertitle != "") $default = $chaptertitle;
	
    //if($tinyMCE && strpos($storytext, "<br>") === false && strpos($storytext, "<p>") === false && strpos($storytext, "<br />") === false) $storytext = nl2br($storytext);
	
    $output = "";
	if($admin && ($action == "newchapter" || $action == "editchapter")) {
		$authorquery = dbquery("SELECT "._PENNAMEFIELD." as penname, "._UIDFIELD." as uid FROM "._AUTHORTABLE." ORDER BY penname");
		$output .= "<label for=\"uid\">"._AUTHOR.":</label> <select name=\"uid\" id=\"uid\">";
			while($authorresult = dbassoc($authorquery)) {	
				$output .= "<option value=\"$authorresult[uid]\"".($uid == $authorresult['uid']? " selected" : "").">$authorresult[penname]</option>";
			}
		$output .= "</select><br />";
	}
	$output .= "<p><label for=\"chaptertitle\">"._CHAPTERTITLE.":</label> <input type=\"text\" class=\"textbox\" id=\"chaptertitle\" maxlength=\"200\" name=\"chaptertitle\" size=\"50\" value=\"".htmlentities($default)."\"> </p>
		<p>"._ALLOWEDTAGS."</p>
		<p><label for=\"notes\">"._CHAPTERNOTES.":</label><br />".e107::getForm()->textarea('notes',$notes)."</p";
    
    
    $editor = efiction_settings::get_single_setting('tinyMCE'); 
 
    $wysiwyg = is_null($editor) ? 'default' : $editor;  
 
    $output .= "<br><div><label for=\"storytext\">"._STORYTEXTTEXT.":</label>".(!$storytext ? "<span style=\"font-weight: bold; color: red\">*</span>" : "")."";
      
    $output .=  e107::getForm()->bbarea('storytext',$storytext,'public','efiction','large', array('wysiwyg' => $wysiwyg));
    $output .= "</div>";
        
	$output .= "<p><strong>"._OR."</strong> </p>
		<p><label for=\"storyfile\">"._STORYTEXTFILE.":</label> <INPUT type=\"file\" id=\"storyfile\" class=\"textbox\" name=\"storyfile\" onClick=\"this.form.storytext.disabled=true\"> </p>
		<div><label for=\"notes\">"._ENDNOTES.":</label><br><textarea class=\"textbox\" rows=\"5\" id=\"endnotes\" name=\"endnotes\" cols=\"58\">$endnotes</textarea></div>";
	if($tinyMCE) 
		$output .= "<div class='tinytoggle'><input type='checkbox' name='toggle' onclick=\"toogleEditorMode('endnotes');\" checked><label for='toggle'>"._TINYMCETOGGLE."</label></div>";
	return $output;
}
// end chapterform
?>