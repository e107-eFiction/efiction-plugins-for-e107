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

if (!defined('e107_INIT')) {
    exit;
}

//function to build story data section of the form.
function storyform($stories, $preview = 0)
{
    global $admin, $allowed_tags,  $roundrobins, $catlist, $coauthallowed, $tinyMCE, $action, $sid;

	$frm = e107::getForm();
    $classes = explode(',', $stories['classes']);
    $charid = explode(',', $stories['charid']);
    $catid = explode(',', $stories['catid']);
    $title = $stories['title'];
    $summary = $stories['summary'];
    $storynotes = $stories['storynotes'];
    $rr = $stories['rr'];
    $feat = $stories['featured'];
    $rid = $stories['rid'];
    $complete = $stories['completed'];
    $validated = $stories['validated'];
    $uid = $stories['uid'];
 
 
	$template = e107::getTemplate('efiction', 'storyform', 'story');
    $sc = e107::getScParser()->getScObject('storyform_shortcodes', 'efiction', false);
  
    $chapter_query = "SELECT sid, chapid, title, inorder, rating, reviews, validated, uid FROM ".TABLEPREFIX."fanfiction_chapters WHERE sid = '$sid' ORDER BY inorder";
    $stories['chapters'] =  e107::getDb()->retrieve($chapter_query, true);
    $stories['action'] = $action;
    $sc->setVars($stories);
    $sc->wrapper('storyform/layout');
 
        
    $output = '';
    $output = e107::getParser()->parseTemplate($template, true, $sc); 
 
	/* TODO */
    if ($roundrobins) {
        $output .= ' <label for="rr">  '._ROUNDROBIN.':</label>
  			<input type="checkbox" class="checkbox" name="rr" id="rr"value="1"'.($rr == 1 ? 'checked' : '').'>';
    }
     
    $codequery = dbquery('SELECT * FROM '.TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'storyform'");
    while ($code = dbassoc($codequery)) {
        eval($code['code_text']);
    }
	
    return $output;
}
// end storyform

// function to build chapter info section of the form.
function chapterform($inorder, $notes, $endnotes, $storytext, $chaptertitle, $uid = 0)
{
    global $admin, $tinyMCE, $action, $preview;
 
    if ($tinyMCE && strpos($storytext, '<br>') === false && strpos($storytext, '<p>') === false && strpos($storytext, '<br />') === false) {
        $storytext = nl2br($storytext);
    }
    $output = '';
    
    $template = e107::getTemplate('efiction', 'storyform', 'chapter');
    $sc = e107::getScParser()->getScObject('storyform_shortcodes', 'efiction', false);
 
    $data['inorder'] = $inorder;
    $data['chaptertitle'] = $chaptertitle;
    $data['storytext'] = $storytext; 
    $data['notes'] = $notes;
    $data['endnotes'] = $endnotes;
    $data['action'] = $action; 
    
    $sc->setVars($data);
   // $sc->wrapper('storyform/layout');
    $output = '';
    $output = e107::getParser()->parseTemplate($template, true, $sc); 
    
    
    if ($admin && ($action == 'newchapter' || $action == 'editchapter')) {
        $authorquery = dbquery('SELECT '._PENNAMEFIELD.' as penname, '._UIDFIELD.' as uid FROM '._AUTHORTABLE.' ORDER BY penname');
        $output .= '<label for="uid">'._AUTHOR.':</label> <select name="uid" id="uid">';
        while ($authorresult = dbassoc($authorquery)) {
            $output .= "<option value=\"$authorresult[uid]\"".($uid == $authorresult['uid'] ? ' selected' : '').">$authorresult[penname]</option>";
        }
        $output .= '</select><br />';
    }
 
    $output .= '<p><strong>'._OR.'</strong> </p>
		<p><label for="storyfile">'._STORYTEXTFILE.':</label> <INPUT type="file" id="storyfile" class="textbox" name="storyfile" onClick="this.form.storytext.disabled=true"> </p>
		 ';
 
    return $output;
}
// end chapterform
