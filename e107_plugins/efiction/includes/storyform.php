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

	global $admin, $action, $sid;
 
    $catlist = efiction_categories::get_catlist();
    $multiplecats = efiction_settings::get_single_setting('multiplecats');
	$roundrobins = efiction_settings::get_single_setting('roundrobins');
	$coauthallowed = efiction_settings::get_single_setting('coauthallowed');
    
    $tinyMCE = efiction_settings::get_single_setting('tinyMCE'); 
    $wysiwyg = is_null($editor) ? 'default' : $tinyMCE;
    
	$allowed_tags = efiction_settings::get_single_setting('allowed_tags');  // todo: remove

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

	$required = "<span style=\"font-weight: bold; color: red\">*</span>";
    /* title + summary */	
    $text = '<div class="row mb-3">';
    	$text .= '<label for="title" class="col-sm-2 col-form-label fw-bold">'._TITLE.(!$title ? $required : "").'</label>'; 
    	$text .= '<div class="col-sm-10">';
			$text .= e107::getForm()->text('title', $title, 200, array('size'=>'xxlarge', 'required'=>1));
		$text .= '</div>';
	$text .= '</div>'; 
    $text .= '<div class="row mb-3">';
		$text .= '<label for="title" class="col-sm-2 col-form-label fw-bold">'._SUMMARY.(!$title ? $required : "").'</label>'; 
		$text .= '<div class="col-sm-10">';
			$text .= e107::getForm()->textarea('summary',$summary, 10,80, array('size'=>'xxlarge', 'required'=>1));
		$text .= '</div>';
	$text .= '</div>';  
    
    $output .= e107::getRender()->tablerender('', $text, 'addstory-block', true);  $text = '';
 
    /* authors part */ 
    $authorquery = dbquery("SELECT "._PENNAMEFIELD." as penname, "._UIDFIELD." as uid FROM "._AUTHORTABLE." ORDER BY "._PENNAMEFIELD);
	if($admin) {
		if(!isset($authors)) {
			$authors = "";
			while($authorresult = dbassoc($authorquery)) {	
				$authors .= "<option value=\"$authorresult[uid]\"".($uid == $authorresult['uid'] ? " selected" : "").">$authorresult[penname]</option>";
			}
		}
		$text .= "<div class='row mb-3'>";
			$text .= "<label class='col-sm-2 col-form-label fw-bold'  for=\"uid\">"._AUTHOR.":</label>";
			$text .= "<div class='col-sm-10'>";
				$text .= "<select class='form-control' name=\"uid\" id=\"uid\">$authors</select>";
			$text .= "</div>";
		$text .= "</div>";
	}
 
	if($coauthallowed) {
		//loaded in e_header, just for sure
		e107::js('url', _BASEDIR."includes/userselect.js");
		e107::js('url', _BASEDIR."includes/xmlhttp.js");
	  
    $text .= "<div class='row mb-3'>";    
        $text .= "<div class='col-sm-2'";
			$text .= "<label class='col-form-label fw-bold'  for=\"coauthorsSelected\">"._COAUTHORS.":</label><br><span class='text-small'>"._COAUTHORSEARCH."</span>";
		$text .= "</div>";
        $text .= "<div class='col-sm-5'>";
	        $text .= "<label class='col-form-label fw-bold' for='coauthorsSelect'>"._SEARCH.": </label>";
            $text .= "<input name='coauthorsSelect' id='coauthorsSelect' size='20' type='text' class='form-control userSelect' onkeyup='setUserSearch(\"coauthors\");' autocomplete='off'>";
			$text .= "<div id='coauthorsDiv' name='coauthorsDiv' style='visibility: hidden;'></div>";
			$text .= "<iframe id='coauthorsshim' scr='' scrolling='no' frameborder='0' class='shim'></iframe>";
		$text .= "</div>";
		$text .= "<div class='col-sm-5'>";
        	$text .="<select name='coauthorsSelected' id='coauthorsSelected' size='8' multiple='multiple' class='form-control multiSelect' onclick='javascript: removeMember(\"coauthors\");'>";
              	$couids = array() ;
              	if(is_array($stories['coauthors']) && count($stories['coauthors'])) {
              		$coauths = dbquery("SELECT "._PENNAMEFIELD." as penname, "._UIDFIELD." as uid FROM "._AUTHORTABLE." WHERE FIND_IN_SET("._UIDFIELD.", '".implode(",", $stories['coauthors'])."') > 0");
              		while($c = dbassoc($coauths)) {
              			if($c['uid'] == $stories['uid']) continue;
              			$text .= "<option label='".$c['penname']."' value='".$c['uid']."'>".$c['penname']."</option>";
              			$couids[] = $c['uid'];
              		}
              		$couids = implode(",", $couids);
              	}
	   		$text .= "</select>"; 
			$text .= "<input type='hidden' name='coauthors' id='coauthors' value='$couids'>";
		$text .= "</div>";
	$text .= "</div>";	
	}
    
    if($text) {
    $output .= e107::getRender()->tablerender('', $text, 'addstory-block', true);  $text = '';
    }
 
    /* category */
  	if(!$multiplecats) $output .= "<input type=\"hidden\" name=\"catid\" id=\"catid\" value=\"1\">";
	else {
        $text  = '<div class="row mb-3">';
        $text .= "<label class=\"col-sm-2 col-form-label fw-bold\" for=\"catid\">"._CATOPTIONS.":</label>";
        $text .= '<div class="col-sm-10">';
        $categories = efiction_categories::get_categories();
        $options = array('title' => _SELECTCATS, 'inline' => true,  'useKeyValues' => 1  );
        $text .= e107::getForm()->checkboxes('catid', $categories, $catid, $options);
         $text .= '</div>';
        $text .= '</div>';
		$text .= "<input type=\"hidden\" name=\"formname\" value=\"stories\">";
	}
      
     /* rating */
     $ratings = efiction_ratings::get_ratings_list();
     $text .= '<div class="row mb-3">';
     	$text .= '<label for="rid" class="col-sm-2 col-form-label fw-bold">'._RATING.(!$rid ?   $required : ""). '</label>';
		$text .= '<div class="col-sm-10">';
			$text .= "<select size=\"1\" id=\"rid\" name=\"rid\">";
				foreach($ratings AS $key => $r) {
						$text .= "<option value=\"".$key ."\"".($rid == $key ? " selected" : "").">".$r."</option>";
				}
			$text .= '</select>';
		$text .= '</div>';
	$text .= '</div>';
      
    $output .= e107::getRender()->tablerender('', $text, 'addstory-block', true);  $text = '';

    /*  characters */
    $text  = '<div class="row mb-3">';
        $text .= "<label class=\"col-sm-2 col-form-label fw-bold\" for=\"charid\">"._CHARACTERS.":</label>";
        $text .= '<div class="col-sm-10">';       
          $characters = efiction_characters::characters();   
          $options = array('title' => _CHARACTERS, 'inline' => true,  'useKeyValues' => 1);
          $text .= e107::getForm()->checkboxes('charid', $characters, $charid, $options);
    
        $text .= '</div>';
    $text .= '</div>';    
    
 	/*  categorization */
    $classrows = e107::getDb()->retrieve('SELECT * FROM #fanfiction_classtypes ORDER BY classtype_name', true);
    $text .= '<style> .form-check {min-width: 270px;}  .checkbox-inline {min-width: 270px;}
		#characters-container .checkbox-inline  {margin-left: 20px!important; } 
		#catid-container .checkbox-inline  {margin-left: 20px!important; }  
		#classes-container .checkbox-inline  {margin-left: 20px!important; } 
		</style>';
 
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
    
    $text .= $ret; 
      
    $output .= e107::getRender()->tablerender('', $text, 'addstory-block', true);  $text = '';
 
    /* complete */
    $text .= '<div class="row mb-3">';
        $text .= "<label class=\"col-sm-2 col-form-label fw-bold\" for=\"complete\">"._COMPLETE.":</label>";
		$text .= '<div class="col-sm-10">';
			$text .= "<input type=\"checkbox\" class=\"checkbox\" id=\"complete\" name=\"complete\" value=\"1\"".($complete == 1 ? " checked" : "") .">";
		$text .= '</div>';
	$text .= '</div>';
    
    /* roundrobins */
    if($roundrobins) {
		$text .= '<div class="row mb-3">';
			$text .= "<label class=\"col-sm-2 col-form-label fw-bold\" for=\"rr\">"._ROUNDROBIN.":</label>";
			$text .= '<div class="col-sm-10">';
			$text .= "<input type=\"checkbox\" class=\"checkbox\" id=\"rr\" name=\"rr\" value=\"1\"".($rr == 1 ? " checked" : "") .">";
			$text .= '</div>';
		$text .= '</div>';
    }
 
    if(isADMIN && uLEVEL < 4)  {
        $text .= '<div class="row mb-3">';
        	$text .= "<label class=\"col-sm-2 col-form-label fw-bold\" for=\"feature\">"._FEATURED.":</label>";
        	$text .= '<div class="col-sm-10">';
			$text .= "<select class=\"textbox\" id=\"feature\" name=\"feature\">
					<option value=\"1\"".($feat == 1 ? " selected" : "").">"._ACTIVE."</option>
					<option value=\"2\"".($feat == 2 ? " selected" : "").">"._RETIRED."</option>
					<option value=\"0\"".(!$feat ? " selected" : "").">"._NO."</option>
				</select>";
        	$text .= '</div>';
		$text .= '</div>';
 
        $text .= '<div class="row mb-3">';
        	$text .= "<label class=\"col-sm-2 col-form-label fw-bold\" for=\"validated\">"._VALIDATED.":</label>";
        	$text .= '<div class="col-sm-10">';
			$text .= "<select class=\"textbox\" id=\"validated\" name=\"validated\">
					<option value=\"2\"".($validated == 2? " selected" : "").">"._STORY."</option>
					<option value=\"1\"".($validated  == 1? " selected" : "").">"._CHAPTER."</option>
					<option value=\"0\"".(!$validated ? " selected" : "").">"._NO."</option>
					</select>";
        	$text .= '</div>';
		$text .= '</div>';        
    }
    
    $text .= '<div class="row mb-3">';
    	$text .= '<label for="storynotes" class="col-sm-2 col-form-label fw-bold">'._STORYNOTES. '</label>';
    	$text .= '<div class="col-sm-10">';
        $text .=  e107::getForm()->bbarea('storynotes',$storynotes,'public','efiction','small', array('wysiwyg' => $wysiwyg));
		$text .= '</div>';
	$text .= '</div>';  
    
	$output .= e107::getRender()->tablerender('', $text, 'addstory-block', true);  $text = '';
    
	$codequery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'storyform'");
	while($code = dbassoc($codequery)) {
		eval($code['code_text']);
	}
	return $output;
}
// end storyform

// function to build chapter info section of the form.
function chapterform($inorder, $notes, $endnotes, $storytext, $chaptertitle, $uid = 0) {
	global $admin, $action, $preview;
	
    $tinyMCE = efiction_settings::get_single_setting('tinyMCE'); 
    $wysiwyg = is_null($editor) ? 'default' : $tinyMCE;
    $allowed_tags = efiction_settings::get_single_setting('allowed_tags');     
  
    $inorder++;
	$default = _CHAPTER." ". $inorder;
	if($chaptertitle != "") $default = $chaptertitle;
 
    $required = "<span style=\"font-weight: bold; color: red\">*</span>";
 
    $output = "";
    $text = "";
    
	if($admin && ($action == "newchapter" || $action == "editchapter")) {
    
            $authorquery = dbquery("SELECT "._PENNAMEFIELD." as penname, "._UIDFIELD." as uid FROM "._AUTHORTABLE." ORDER BY penname");
            
            $text .= '<div class="row mb-3">';
          	$text .= '<label for="uid" class="col-sm-2 col-form-label fw-bold">'._STORYTEXTTEXT. '</label>';
          	$text .= '<div class="col-sm-10">';
              $text .=  "<select name=\"uid\" id=\"uid\">";
     			while($authorresult = dbassoc($authorquery)) {	
    				$text .= "<option value=\"$authorresult[uid]\"".($uid == $authorresult['uid']? " selected" : "").">$authorresult[penname]</option>";
    			}             
              $text .= "</select>";
        	$text .= '</div>';
        	$text .= '</div>';  
            
   
	}
    
    $text .= '<div class="row mb-3">';
    $text .= '<div class="col-sm-2">';
  	$text .= '<label for="chaptertitle" class="col-form-label fw-bold">'._CHAPTERTITLE. "</label>".(!$default ? $required : "")."";
    	$text .= '</div>'; 
  	$text .= '<div class="col-sm-10">';
      $text .=  "<input type=\"text\" class=\"textbox\" id=\"chaptertitle\" maxlength=\"200\" name=\"chaptertitle\" size=\"50\" value=\"".htmlentities($default)."\">";
	$text .= '</div>';
	$text .= '</div>';  
    
    
    $text .= '<div class="row mb-3">';
     $text .= '<div class="col-sm-2">';
  	$text .= '<label for="notes" class=" col-form-label fw-bold">'._CHAPTERNOTES. "</label>";
    $text  .= "<p class='text-small'>"._ALLOWEDTAGS.":  ".  htmlspecialchars($allowed_tags)." </p>";
    $text .= '</div>'; 
  	$text .= '<div class="col-sm-10">';
      $text .= e107::getForm()->textarea('notes',$notes, 5, 58 );
	$text .= '</div>';
	$text .= '</div>';  
 
    $text .= '<div class="row mb-3">';
  	$text .= '<label for="storytext" class="col-sm-2 col-form-label fw-bold">'._STORYTEXTTEXT. '</label>';
  	$text .= '<div class="col-sm-10">';
      $text .=  e107::getForm()->bbarea('storytext',$storytext,'public','efiction','xxlarge', array('wysiwyg' => $wysiwyg));
	$text .= '</div>';
	$text .= '</div>';  
    $text .= "<div><strong>"._OR."</strong> </div>";
 
    $text .= '<div class="row mb-3">';
  	$text .= '<label for="storyfile" class="col-sm-2 col-form-label fw-bold">'._STORYTEXTFILE.'</label>';
  	$text .= '<div class="col-sm-10">';
      $text .=  "<input type=\"file\" id=\"storyfile\" class=\"textbox\" name=\"storyfile\" onClick=\"this.form.storytext.disabled=true\">"; 
	$text .= '</div>';
	$text .= '</div>'; 
    
    $output = $text;
    
    $output = e107::getRender()->tablerender($caption, $text, 'addstory-block', true);  $text = '';
        
   // $output .=  e107::getForm()->textarea('endnotes', $endnotes, 'size=tiny');    
    $caption = _CHAPTER;
    
    $output = e107::getRender()->tablerender($caption, $output, 'addstory', true); 
 
	return $output;
}
// end chapterform
?>