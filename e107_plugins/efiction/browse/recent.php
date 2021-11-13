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
 
if(!defined("e107_INIT")) exit( );
 
 $recentdays = efiction_settings::get_single_setting('recentdays');
 $title =  e107::getParser()->lanVars(_RECENTSTORIES, array($recentdays ), true);
 
 $output .= "<div id=\"pagetitle\">".($recentdays ? $title : _MOSTRECENT)." ".efiction_pagelinks::get_single_link('rss')."</div>";

 $countquery .= ($recentdays ? " AND updated > ".strtotime('-7 days')."" : "");
 $query = $storyquery.($recentdays ? " AND updated > ".strtotime('-7 days')."" : "");
 $query .= " ORDER BY ".(isset($_REQUEST['sort']) && $_REQUEST['sort'] == "alpha" ? "stories.title" : "updated DESC");
 $numrows = search(_STORYQUERY.$query, _STORYCOUNT.$countquery, "browse.php?");

 