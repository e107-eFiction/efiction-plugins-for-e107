<?php
// ----------------------------------------------------------------------
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
 
if(!isset($count)) $count = 0;

$adminlinks = "";

if(!isset($count)) $count = 0;

$sc_story->setVars($stories);

$storyblock = e107::getParser()->parseTemplate($story_template['item'], true, $sc_story);
 
/*
	if(!isset($count)) $count = 0;
 
 
	 
  
    
	if(count($storycodeblocks)) foreach($storycodeblocks as $c) { 
       eval($c); 
    } 
    
    
$tpl->assign("characters", ($stories['charid'] ? charlist($stories['charid']) : _NONE));
	
   
	 
	 
 
	
 

	 
	 
	if(!empty($recentdays)) {
		$recent = time( ) - ($recentdays * 24 * 60 *60);
		if($stories['updated'] > $recent) $tpl->assign("new", isset($new) ? file_exists(_BASEDIR.$new) ? "<img src='$new' alt='"._NEW."'>" : $new : _NEW);
	}
	$tpl->assign("wordcount"   , $stories['wordcount'] ? $stories['wordcount'] : "0" );
	$tpl->assign("numreviews"   , ($reviewsallowed == "1" ? "<a href=\"reviews.php?type=ST&amp;item=".$stories['sid']."\">".$stories['reviews']."</a>" : "") );
	if((isADMIN && uLEVEL < 4) || USERUID == $stories['uid'] || (is_array($stories['coauthors']) && array_key_exists(USERUID, $stories['coauthors'])))
		$adminlinks .= "[<a href=\"stories.php?action=editstory&amp;sid=".$stories['sid'].(isADMIN ? "&amp;admin=1" : "")."\">"._EDIT."</a>] 
        [<a href=\"stories.php?action=delete&amp;sid=".$stories['sid'].(isADMIN ? "&amp;admin=1" : "")."\">"._DELETE."</a>],
        [<a href=\"stories.php?action=newchapter&amp;sid=".$stories['sid'].(isADMIN ? "&amp;admin=1" : "")."\">"._ADDNEWCHAPTER."</a>] 

        ";
//        <a class=\"button btn btn-primary\" href=\"stories.php?action=newchapter&amp;sid=".$stories['sid']."&amp;inorder=$chapters".(isADMIN ?  '&amp;admin=1&amp;uid='.$stories['uid'] : '').'">'._ADDNEWCHAPTER.'</a>	
    
    global $featured;
	if($stories['featured'] == 1) {
		$tpl->assign("featuredstory", (isset($featured) ? $featured : "<img src=\""._BASEDIR."images/blueribbon.gif\" class=\"featured\" alt=\""._FSTORY."\">"));
		$tpl->assign("featuredtext", _FSTORY);
		if(isADMIN && uLEVEL < 4) $adminlinks .= " ["._FEATURED.": <a href=\"admin.php?action=featured&amp;retire=".$stories['sid']."\">"._RETIRE."</a> | <a href=\"admin.php?action=featured&amp;remove=".$stories['sid']."\">"._REMOVE."</a>]";
	}
	else if($stories['featured'] == 2) {
		$tpl->assign("featuredstory", (isset($retired) ? $retired : "<img src=\""._BASEDIR."images/redribbon.gif\"align=\"left\" class=\"retired\" alt=\""._PFSTORY."\">"));
		$tpl->assign("featuredtext", _PFSTORY);
		if(isADMIN && uLEVEL < 4) $adminlinks .= " [<a href=\"admin.php?action=featured&amp;remove=".$stories['sid']."\">"._REMOVE."</a>]";
	}
	else if(isADMIN && uLEVEL < 4) $adminlinks .= " [<a href=\"admin.php?action=featured&amp;feature=".$stories['sid']."\">"._FEATURED."</a>]";
	$tpl->assign("toc", "<a href=\"viewstory.php?sid=".$stories['sid']."&amp;index=1\">"._TOC."</a>");
	$tpl->assign("oddeven", ($count % 2 ? "odd" : "even"));
	$tpl->assign("reportthis", "[<a href=\"report.php?action=report&amp;url=viewstory.php?sid=".$stories['sid']."\">"._REPORTTHIS."</a>]");
	if(isADMIN && uLEVEL < 4) $tpl->assign("adminlinks", "<div class=\"adminoptions\"><span class='label'>"._ADMINOPTIONS.":</span> ".$adminlinks."</div>");
	else if(isMEMBER && (USERUID == $stories['uid'] || array_key_exists(USERUID, $stories['coauthors']))) $tpl->assign("adminlinks", "<div class=\"adminoptions\"><span class='label'>"._OPTIONS.":</span> ".$adminlinks."</div>");
	$count++;
    
    // We only want to pull this list once
	if(!isset($story_endcodeblocks)) {
		$story_endcodeblocks = array( );
		$codequery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'storyblock_end'");
		while($code = dbassoc($codequery)) {
			$story_endcodeblocks[] = $code['code_text'];
		}
	}   
    if(count($story_endcodeblocks)) foreach($story_endcodeblocks as $c) { eval($c); }
?>
*/