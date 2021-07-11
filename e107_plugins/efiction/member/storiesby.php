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

if (!defined('e107_INIT')) { exit; }

 
$numstories = e107::getDb()->retrieve("SELECT count(stories.sid) AS numstories FROM ".TABLEPREFIX."fanfiction_stories as stories LEFT JOIN ".TABLEPREFIX."fanfiction_coauthors as coauth ON stories.sid = coauth.sid WHERE validated > 0 AND (stories.uid = '$uid' OR coauth.uid = '$uid')");
 
$storiesby_template = e107::getTemplate('efiction', 'user', 'storiesby');

$var['USER_PENNAME'] = $this->sc_user_penname(); 
 
$storiesby_title = e107::getParser()->parseTemplate($storiesby_template['title'], true, $var);  
$storiesby_start = ''; //use template
$storiesby_tablerender = varset($storiesby_template['tablerender'], $current);
$storiesby_end = '';  //use template
 
$itemsperpage = efiction_settings::get_single_setting('itemsperpage');
 
if($numstories) {
    /********** STORIES START **************************************************/
	$count = 0;
	$storyquery = e107::getDb()->retrieve("SELECT stories.*, "._PENNAMEFIELD." as penname, UNIX_TIMESTAMP(stories.date) as date, UNIX_TIMESTAMP(stories.updated) as updated 
    FROM ("._AUTHORTABLE.", ".TABLEPREFIX."fanfiction_stories as stories) LEFT JOIN ".TABLEPREFIX."fanfiction_coauthors as coauth ON coauth.sid = stories.sid 
    WHERE "._UIDFIELD." = stories.uid AND stories.validated > 0 AND (stories.uid = '$uid' OR coauth.uid = '$uid') GROUP BY stories.sid "._ORDERBY." LIMIT $offset, $itemsperpage", true);

	$key = varset($key,'listings');  //supported: reviewblock, todo use full power of e107 templating   
	$story_template = e107::getTemplate('efiction', $key, 'storyblock');
	$sc_story = e107::getScBatch('story', 'efiction');
	$sc_story->wrapper('story/story');

    $storyblock_start = e107::getParser()->parseTemplate($story_template['start'], true, $sc_story);
	foreach($storyquery AS $stories) {	
        $stories['numstories'] = $numstories;
        $stories['count'] = $count;
        $stories['sort'] = $_GET['sort'];
        $stories['offset'] = $offset;
        $stories['itemsperpage'] = $itemsperpage;
        $sc_story->setVars($stories);
        $storyblock .= e107::getParser()->parseTemplate($story_template['item'], true, $sc_story);
        $count++;
	}
    $storyblock_end  = e107::getParser()->parseTemplate($story_template['end'], true, $sc_story);
    $storyblocks =  $storyblock_start.$storyblock.$storyblock_end;
    
    /********** STORIES END ***************************************************/
    
	
    
	$output = $storyblocks; 
   
}
else $output .= write_message(_NORESULTS);

$output = e107::getRender()->tablerender($storiesby_title, $storyblocks, $storiesby_tablerender, true); 