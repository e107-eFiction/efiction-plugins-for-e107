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

if(!defined("e107_INIT")) exit( );

$query = _SERIESCOUNT." WHERE uid = '$uid'";
$numseries = e107::getDb()->retrieve($query);
e107::getMessage()->addDebug($query);
 
echo e107::getMessage()->render();
 
if($numseries) {
	$count = 0;
	$tpl->newBlock("listings");
	$listings_template =  e107::getSingleton("efiction_core")->getTpl("listings_main.tpl");
	$listings_vars = array();
	$tpl->assign("seriesheader", "<div class='sectionheader'>"._SERIESBY." $penname</div>");
	$listings_vars["seriesheader"] = "<div class='sectionheader'>"._SERIESBY." $penname</div>";

	$series_array = e107::getDb()->retrieve(_SERIESQUERY." AND series.uid = '$uid' LIMIT $offset, $itemsperpage", true);
    
	foreach($series_array AS $stories) {
		include(_BASEDIR."includes/seriesblock.php");
        
        $serieslisting .= $seriesblock;
	}
	$tpl->gotoBlock("listings");
    $listings_vars["serieslisting'"] = $serieslisting; 
	if($numseries > $itemsperpage) {
		$tpl->assign("pagelinks", build_pagelinks("viewuser.php?action=seriesby&amp;uid=$uid&amp;", $numseries, $offset));
		$listings_vars["pagelinks"] = build_pagelinks("viewuser.php?action=seriesby&amp;uid=$uid&amp;", $numseries, $offset);
	}
	$tpl->gotoBlock("_ROOT");
	$listings_vars = array_change_key_case($listings_vars,CASE_UPPER);
	$listings_text = e107::getParser()->simpleParse($listings_template,$listings_vars, false);
	$listings_text = e107::getParser()->parseTemplate($listings_text, true); //to fix LANs. remove empty shortcodes

}
else $output .= write_message(_NORESULTS);
?>
