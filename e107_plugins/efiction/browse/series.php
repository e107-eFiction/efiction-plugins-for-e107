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

// Page Setup
$current = "series";

$caption =  _SERIES.($let ? " - $let" : "");
 
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
    
    
$itemsperpage = 5;
$countquery = _SERIESCOUNT.(!empty($seriesquery) ? " WHERE ".$seriesquery : "");
$cresult = e107::getDb()->retrieve($countquery);
$query = _SERIESQUERY.(!empty($seriesquery) ? " AND ".$seriesquery : "")." ORDER BY series.title LIMIT $offset, $itemsperpage";
$sresult = e107::getDb()->retrieve($query, true);
$numrows = $cresult['count'];
$count = 0;
 
/* series listing starts */
$template = e107::getTemplate('efiction', 'series', 'listing');
$sc_serie = e107::getScParser()->getScObject('series_shortcodes', 'efiction', false);
$seriesblock = e107::getParser()->parseTemplate($template['start'], true, $sc_serie);

$template_key = 'series';
 
$browse_vars['numrows'] = $numrows;
$browse_vars['terms'] =  $terms ;
foreach($sresult AS $serie)  { 
  
    $serie['numrows'] = count(storiesInSeries($serie['seriesid']));
    $serie['count'] = $count;
 
    $sc_serie->setVars($serie);
    
    $count++;
    //include(_BASEDIR."includes/seriesblock.php"); 
    $item =  e107::getParser()->parseTemplate($template['item'], true, $sc_serie);
    $seriesblock .= $item;
}

$seriesblock .= e107::getParser()->parseTemplate($template['end'], true, $sc_serie); 

$seriesblock =  e107::getRender()->tablerender($caption, $seriesblock, 'serie-listing', true);
$tpl->assign("seriesblock", $seriesblock); 

/* series listing ends */
     
//if($numrows > $itemsperpage) $tpl->assign("pagelinks", build_pagelinks("browse.php?$terms&amp;", $numrows, $offset));
 
if(!$numrows) {
   
    echo e107::getMessage()->addInfo(_NORESULTS);
 
	
}

//$disablesorts = array("ratings", "sorts", "complete");
 
$browse_vars['caption'] = $caption;