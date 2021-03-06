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

/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * e107 efiction Plugin
 *
 * #######################################
 * #     e107 website system plugin      #
 * #     by Jimako                    	 #
 * #     https://www.e107sk.com          #
 * #######################################
 */

if (!defined('e107_INIT')) {
    exit;
}
 
include ("includes/queries.php");
 
if (class_exists('efiction_blocks')) {
   /* if (e_DEBUG) {
        echo e107::getMessage()->addInfo('efiction class is available')->render();
    }*/

	$template = e107::getTemplate('efiction', 'blocks', 'recent', true, true);

    $blocks['recent'] = efiction_blocks::get_single_block('recent');

    $caption = $blocks['recent']['title'];
	$var = array('BLOCK_CAPTION' => $caption);
	$caption = e107::getParser()->simpleParse($template['caption'], $var);

    $sc = e107::getScParser()->getScObject('story_shortcodes', 'efiction', false);
    $text = '';
 
    $limit 		= isset($blocks['recent']['num']) && $blocks['recent']['num'] > 0 ? $blocks['recent']['num'] : 10;
	$sumlength  = isset($blocks['recent']['sumlength']) && $blocks['recent']['sumlength'] > 0 ? $blocks['recent']['sumlength'] :75;

    $query = _STORYQUERY." ORDER BY stories.updated DESC LIMIT 0,$limit";
    $result = e107::getDb()->retrieve($query, true);
 
	$start = $template['start']; 
	$end = $template['end'];
    $tablerender= varset($template['tablerender'], '');
 
    foreach ($result as $stories) {
        if (!isset($blocks['recent']['allowtags'])) {
            $stories['summary'] = e107::getParser()->toText($stories['summary']);
        } else {
            $stories['summary'] = e107::getParser()->toHTML($stories['summary'], true, 'SUMMARY');
        }
		$stories['sumlength'] = $sumlength;
        $sc->setVars($stories);
        $text .= e107::getParser()->parseTemplate($template['item'], true, $sc);
    }
} else {
    if (e_DEBUG) {
        echo e107::getMessage()->addError('efiction class is not set')->render();
    }
}
 
e107::getRender()->tablerender($caption, $start.$text.$end, $tablerender);
