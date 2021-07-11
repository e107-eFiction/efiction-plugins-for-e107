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

$numseries = e107::getDb()->retrieve(_SERIESCOUNT." WHERE uid = '$uid'");

$seriesby_template = e107::getTemplate('efiction', 'user', 'seriesby');
 

$var['USER_PENNAME'] = $this->sc_user_penname(); 
 
$seriesby_title = e107::getParser()->parseTemplate($seriesby_template['title'], true, $var);  
$seriesby_start = ''; //use template
$seriesby_tablerender = varset($seriesby_template['tablerender'], $current);
$seriesbyend = '';  //use template
 
$itemsperpage = efiction_settings::get_single_setting('itemsperpage');
 
if($numseries) {
    /**********SERIES START **************************************************/
	$count = 0;
    $seriesquery = _SERIESQUERY." AND series.uid = '$uid' LIMIT $offset, $itemsperpage";
    $sresult = e107::getDb()->retrieve($seriesquery, true);
   
    $key = varset($key,'listings');  //supported: reviewblock, todo use full power of e107 templating
    
	$series_template = e107::getTemplate('efiction', $key, 'seriesblock');
	$sc_series = e107::getScBatch('series', 'efiction');
	$sc_series->wrapper('series/series');
    
    $seriesblock_start = e107::getParser()->parseTemplate($series_template['start'], true, $sc_series);
    foreach($sresult AS $stories)  {  
        $stories['numseries'] = $numseries;
        $stories['count'] = $count;
        $stories['sort'] = $_GET['sort'];
        $stories['offset'] = $offset;
        $stories['itemsperpage'] = $itemsperpage;
        $sc_series->setVars($stories);
        $seriesblock .= e107::getParser()->parseTemplate($series_template['item'], true, $sc_series);
        $count++;
    }
    $seriesblock_end  = e107::getParser()->parseTemplate($series_template['end'], true, $sc_series);
    $seriesblocks =  $seriesblock_start.$seriesblock.$seriesblock_end;
    
    /********** STORIES END ***************************************************/
 
    
	$output = $serieblocks; 
}
else $output .= write_message(_NORESULTS);

$output = e107::getRender()->tablerender($seriesby_title, $seriesblocks, $seriesby_tablerender, true); 