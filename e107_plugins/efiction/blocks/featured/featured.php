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

$template = e107::getTemplate('efiction', 'blocks', 'featured', true, true);

$blocks = efiction_blocks::get_blocks();

$caption = $blocks['featured']['title'];
$block_key = 'featured';
$var = array('BLOCK_CAPTION' => $caption);
$caption = e107::getParser()->simpleParse($template['caption'], $var);

$sc = e107::getScParser()->getScObject('story_shortcodes', 'efiction', false);
$text = '';

$limit = isset($blocks['featured']['limit']) && $blocks['featured']['limit'] > 0 ? $blocks['featured']['limit'] : 1;
$sumlength = isset($blocks['featured']['sumlength']) && $blocks['featured']['sumlength'] > 0 ? $blocks['featured']['sumlength'] : 75;

$query = _STORYQUERY." AND stories.featured = '1'".($limit ? " LIMIT $limit" : '');

$result = e107::getDb()->retrieve($query, true);

$start = $template['start'];
$end = $template['end'];
$tablerender = varset($template['tablerender'], '');
 
foreach ($result as $stories) {
    if (!isset($blocks['featured']['allowtags'])) {
        $stories['summary'] = e107::getParser()->toText($stories['summary']);
    } else {
        $stories['summary'] = e107::getParser()->toHTML($stories['summary'], true, 'SUMMARY');
    }
    $stories['sumlength'] = $sumlength;
    $sc->setVars($stories);
    $text .= e107::getParser()->parseTemplate($template['item'], true, $sc);
}

$content = e107::getRender()->tablerender($caption, $start.$text.$end, $tablerender, true);
