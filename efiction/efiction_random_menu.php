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

if (class_exists('efiction')) {
    if (e_DEBUG) {
        echo e107::getMessage()->addInfo('efiction class is available')->render();
    }

	$template = e107::getTemplate('efiction', 'storyblock', 'random');

    $blocks = efiction::blocks();

    $caption = $blocks['random']['title'];
	$var = array('BLOCK_CAPTION' => $caption);
	$caption = e107::getParser()->simpleParse($template['caption'], $var);

    $sc = e107::getScParser()->getScObject('efiction_shortcodes', 'efiction', false);
    $text = '';
 
	$limit = isset($blocks['random']['limit']) && $blocks['random']['limit'] > 0 ? $blocks['random']['limit'] : 1;
	$sumlength  = isset($blocks['random']['sumlength']) && $blocks['random']['sumlength'] > 0 ? $blocks['random']['sumlength'] :75;

    $query = _STORYQUERY." ORDER BY rand( ) DESC LIMIT $limit";
    $result = e107::getDb()->retrieve($query, true);
 
	$start = $template['start']; 
	$end = $template['end'];

    foreach ($result as $stories) {
        if (!isset($blocks['random']['allowtags'])) {
            $stories['summary'] = e107::getParser()->toText($stories['summary']);
        } else {
            $stories['summary'] = e107::getParser()->toHTML($this->var['summary'], true, 'SUMMARY');
        }
		$$stories['sumlength'] = $sumlength ;
        $sc->setVars($stories);
        $text .= e107::getParser()->parseTemplate($template['item'], true, $sc);
    }
} else {
    if (e_DEBUG) {
        echo e107::getMessage()->addError('efiction class is not set')->render();
    }
}

e107::getRender()->tablerender($caption, $start.$text.$end);
