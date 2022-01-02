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
 
include (e_PLUGIN."efiction/header.php");
 
include (e_PLUGIN."efiction/includes/queries.php");

//include (e_PLUGIN."efiction/pagesetup.php");
// Page Setup
$current = "series";


//include_once(_BASEDIR."includes/corefunctions_old.php");  
//include_once(_BASEDIR."includes/corefunctions.php");

$caption  = "<div id=\"pagetitle\">"._SERIES.($let ? " - $let" : "")."</div>"; 
//$output .= build_alphalinks("browseseries.php?$terms&amp;", $let);
$output .= build_alphalinks("browseseries.php?", $let);

e107::getRender()->tablerender($caption, $output, $current);
$caption = ''; $output = ''; 
 
/**************************************************************************************************************************/
/* FILTER STUFF */




/**************************************************************************************************************************/
/* QUERIES STUFF */

if($let) {
	$seriesquery .= (empty($seriesquery) ? "" : " AND ").($let == _OTHER ? " series.title REGEXP '^[^a-z]'" : "series.title LIKE '$let%'");
}
	if($searchterm) {
		if($searchtype == "title") $scountquery[] = "series.title LIKE '%$searchterm%'";
		if($searchtype == "summary") $scountquery[] = "series.summary LIKE '%$searchterm%'";
		if(!empty($authorlist)) $scountquery[] = "FIND_IN_SET(series.uid, '".implode(",",$authorlist)."') > 0";
		if($searchtype == "advanced" || !$searchtype) $scountquery[] = "(summary LIKE '%$searchterm%' OR title LIKE '%$searchterm%') ";
	}
	if(isset($_REQUEST['authors'])) $scountquery[] = "FIND_IN_SET(series.uid, '".implode(",",$searchVars['authors'])."') > 0";
	foreach($categories as $cat) {
		$catseries[] = "FIND_IN_SET($cat, series.catid) > 0 ";
	}
	// Now implode the SQL list
	if(!empty($catstories)) {
		$scountquery[] = "(".implode(" OR ", $catseries).")";
	}
	if($charid) {
		foreach($charid as $c) {
			if(empty($c)) continue;
			$charseries[] = "FIND_IN_SET($c, series.characters) > 0 ";
		}
		if(!empty($charseries)) {
			$scountquery[] = "(".implode(" OR ", $charseries).")";
		}
	}
	if($classin) {
		foreach($classin as $class) {
			if(empty($class)) continue;
			$scountquery[] = "FIND_IN_SET($class, series.classes) > 0";
		}
	}
	if($classex) {
		foreach($classex as $class) {
			$scountquery[] = "FIND_IN_SET($class, series.classes) = 0";
		}
	}

$countquery =  _SERIESCOUNT.(!empty($seriesquery) ? " WHERE ".$seriesquery : "  " );
e107::getMessage()->addDebug($query);
$numrows = e107::getDb()->retrieve($countquery);

$query = _SERIESQUERY.(!empty($seriesquery) ? " AND ".$seriesquery : "")." ORDER BY series.title LIMIT $offset, $itemsperpage";
e107::getMessage()->addDebug($query);
$sresult = e107::getDb()->retrieve($query, true);

/****************************************************************************************************/

$template = e107::getTemplate('efiction_series', 'efiction_series', 'default', true, true);

/* filter */
$var = array();
$start =  e107::getParser()->simpleParse($template['start'], $var);
 
$sc = e107::getScBatch('efiction_series', true);

$text = '';

$limit 		= 10;
$sumlength  = 255;

foreach($sresult AS $stories) {
    // render single serie 
	$sc->setVars($stories);
	//$text .= e107::getParser()->parseTemplate($template['item'], true, $sc);
	$text .=e107::getSingleton('efiction_series')->renderSeriesDetail($stories, 'default_item'); 
}

 
 
$itemsperpage  = 1;
 
/* body */
e107::getRender()->tablerender('', $start.$text.$end, $tablerender);
$caption = ''; $output = ''; 

/* pagination */
$output = build_pagelinks("browseseries.php?", $numrows, $offset);
e107::getRender()->tablerender($caption, $output, $current);
$caption = ''; $output = ''; 
 

require_once(FOOTERF); 
exit;

 

