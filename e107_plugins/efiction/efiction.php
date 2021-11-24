<?php
// ----------------------------------------------------------------------
// Copyright (c) 2007 by Tammy Keefer
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

$current = "home";

if (!defined('e107_INIT'))
{
	require_once(__DIR__.'/../../class2.php');
}
 
include ("header.php");

include ("includes/queries.php");

/*
"SELECT a.name, 
a.url, 
a.email, 
s.sid, 
s.catid, 
s.aid, 
s.title, 
s.time, 
s.hometext, 
s.bodytext, 
s.comments, 
s.counter, 
s.topic, 
s.informant, 
s.notes, 
s.acomm, 
s.score, 
s.ratings, 
sc.title AS cat_title   t.topicname, t.topicimage, t.topictext, t.mod_group, t.serieid, t.storyid
FROM ".UN_TABLENAME_STORIES." s 
LEFT JOIN ".UN_TABLENAME_STORIES_CAT." sc ON sc.catid = s.catid 
LEFT JOIN ".UN_TABLENAME_AUTHORS." a ON a.aid = s.aid ".$qdb." ".$querylang." ORDER BY s.time DESC LIMIT ".$offset.", ".$storynum
LEFT JOIN ".UN_TABLENAME_TOPICS." t ON t.topicid = s.topic WHERE s.sid = '".$sid."'"

*/

	$template = e107::getTemplate('efiction', 'chapter', 'default', true, true);

    $blocks['recent'] = efiction_blocks::get_single_block('recent');

    $caption = $blocks['recent']['title'];
	$var = array('BLOCK_CAPTION' => $caption);
	$caption = e107::getParser()->simpleParse($template['caption'], $var);

    $sc = e107::getScParser()->getScObject('chapter_shortcodes', 'efiction', false);
    $text = '';
 
    $limit 		= 10;
	$sumlength  = 255;

    $query = _STORYQUERY." ORDER BY stories.updated DESC LIMIT 0, $limit";

    $query = "SELECT author.penname, author.email, chapter.*,  t.title AS topicname,  t.summary, t.storynotes FROM ".MPREFIX."fanfiction_chapters as chapter 
    LEFT JOIN "._AUTHORTABLE." ON  "._UIDFIELD." = chapter.uid 
    LEFT JOIN ".MPREFIX."fanfiction_stories AS t ON t.sid = chapter.sid 
    WHERE chapter.validated > 0 ORDER BY chapter.chapter_datestamp DESC " ;
  
    $result = e107::getDb()->retrieve($query, true);  
 
	$start = $template['start']; 
	$end = $template['end'];
    $tablerender= varset($template['tablerender'], '');

    foreach ($result as $stories) {   
 
        $stories['summary'] = e107::getParser()->toHTML($stories['summary'], true, 'SUMMARY');
         
		$stories['sumlength'] = $sumlength;
        $sc->setVars($stories);
        
        $text .= e107::getParser()->parseTemplate($template['item'], true, $sc);
    }
     
e107::getRender()->tablerender($caption, $start.$text.$end, $tablerender);
require_once(FOOTERF); 
exit;
 