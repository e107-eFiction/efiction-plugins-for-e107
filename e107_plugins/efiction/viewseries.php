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

//Begin basic page setup
$current = "series";
 
// Include some files for page setup and core functions
include ("header.php");
require_once(HEADERF);
 
if(file_exists( "$skindir/default.tpl")) $tpl = new TemplatePower("$skindir/default.tpl" );
else $tpl = new TemplatePower(_BASEDIR."default_tpls/default.tpl");
if(file_exists("$skindir/listings.tpl")) $tpl->assignInclude( "listings", "$skindir/listings.tpl" );
else $tpl->assignInclude( "listings", _BASEDIR."default_tpls/listings.tpl" );
 
include(_BASEDIR."includes/pagesetup.php");

$seriesid = (isset($_GET['seriesid']) && is_numeric($_GET['seriesid'])) ? escapestring($_GET['seriesid']) : false;
//$sresult = dbxquery(_SERIESQUERY." AND seriesid = '$seriesid' LIMIT 1");
//$series = dbassoc($sresult);
$series = e107::getDb()->retrieve(_SERIESQUERY." AND seriesid = '$seriesid' LIMIT 1" ); 

if($series) {
	$template = e107::getTemplate('efiction', 'series', 'titleblock');  
	$sc_serie = e107::getScParser()->getScObject('series_shortcodes', 'efiction', false);
	$sc_serie->setVars($series);
	$caption =  e107::getParser()->parseTemplate($template['caption'], true, $sc_serie);
	$series_title = e107::getParser()->parseTemplate($template['content'], true, $sc_serie);
	e107::getRender()->tablerender($caption, $series_title, 'series_title' );
}

$caption = '';
/* this will not work anymore 
$codeblocks = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'seriestitle'");
while($code = dbassoc($codeblocks)) {
	eval($code['code_text']);
}
*/
 
$cquery = dbquery("SELECT subseriesid, sid, inorder FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid' AND confirmed = 1");
$scount = dbnumrows($cquery);
$serieslist = array( );
if($scount) {
	$subs = array( );
	$stories = array( );
	while($item = dbassoc($cquery)) {
		if($item['subseriesid']) $subs[$item['inorder']] = $item['subseriesid'];
		else $stories[$item['inorder']] = $item['sid'];
	}
	if(count($subs) > 0) {
		$subsquery = dbquery(_SERIESQUERY." AND FIND_IN_SET(seriesid, '".implode(",", $subs)."') > 0");
		while($sub = dbassoc($subsquery)) {
			$serieslist[array_search($sub['seriesid'], $subs)] = $sub;
		}
	}
	if(count($stories)) {
		$seriesstoryquery = dbquery(_STORYQUERY." AND FIND_IN_SET(sid, '".implode(",", $stories)."') > 0");
		while($story = dbassoc($seriesstoryquery)) {
			$serieslist[array_search($story['sid'], $stories)] = $story;
		}
	}
}
ksort($serieslist);
$count = 0;
for($a = $offset + 1; $a <= $itemsperpage + $offset; $a++) {
	$tpl->newBlock("listings");
	$stories = isset($serieslist[$a]) ? $serieslist[$a] : false;
	if(isset($stories['seriesid'])) {
		$tpl->newBlock("seriesblock");
		include(_BASEDIR."includes/seriesblock.php");
	}
	else if(isset($stories['sid'])) {
		$tpl->newBlock("storyblock");
		include(_BASEDIR."includes/storyblock.php");
// print_r($stories);
	}
	$tpl->gotoBlock("_ROOT");
}
if($scount > $itemsperpage) {
	$tpl->gotoBlock("listings");
	$tpl->assign("pagelinks", build_pagelinks("viewseries.php?seriesid=$seriesid&amp;", $scount, $offset));
}
$tpl->gotoBlock( "_ROOT" );
$tpl->assign("output", $output);
$output = $tpl->getOutputContent();  
$output = e107::getParser()->parseTemplate($output, true);
e107::getRender()->tablerender($caption, $output, $current);
dbclose( );
require_once(FOOTERF);  
 