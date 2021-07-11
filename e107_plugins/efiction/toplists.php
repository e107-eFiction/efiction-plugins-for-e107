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

$current = "tens";

// Include some files for page setup and core functions
include ("header.php");
require_once(HEADERF);

if(file_exists("$skindir/browse.tpl")) $tpl = new TemplatePower( "$skindir/browse.tpl" );
else $tpl = new TemplatePower(_BASEDIR."default_tpls/browse.tpl");
if(file_exists("$skindir/listings.tpl")) $tpl->assignInclude("listings", "$skindir/listings.tpl");
else $tpl->assignInclude( "listings", _BASEDIR."default_tpls/listings.tpl" );
 

$list = isset($_GET['list']) ? $_GET['list'] : false;
include(_BASEDIR."includes/pagesetup.php");
	if(!$list) {
        
		$caption = "<div id='pagetitle'>".$pagelinks['tens']['text']."</div>";
        $toplists_template = e107::getTemplate('efiction', 'efiction', 'toplists');
        
		$panelquery = "SELECT * FROM #fanfiction_panels WHERE panel_type = 'L' AND panel_hidden != '1' AND panel_level = '0' ORDER BY panel_order";
        $panels = e107::getDb()->retrieve($panelquery, true);
        
        $text = '';
 
		foreach($panels AS $l) { 
        
            $sc_browse['panel_name'] =  $l['panel_name'];
            $sc_browse['panel_title'] =  $l['panel_title'];
		    $text .= e107::getParser()->simpleParse($toplists_template['item'], $sc_browse, true);
        }
		
		if(dbnumrows($lists)) $output .= "</div>";
 
       $start = $toplists_template['start']; 
       $end = $toplists_template['end']; 
 
       e107::getRender()->tablerender($caption, $start.$text.$end, $current);
       require_once(FOOTERF); 
       exit;
 
	}
	else {
		$panelquery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_name = '".escapestring($list)."' AND panel_type = 'L' LIMIT 1");
		if(dbnumrows($panelquery)) {
			$panel = dbassoc($panelquery);
			$caption = "<div id='pagetitle'>".$panel['panel_title']."</div>";
			$numrows = 0;
			if($panel['panel_url'] && file_exists(_BASEDIR.$panel['panel_url'])) include($panel['panel_url']);
			else if(file_exists(_BASEDIR."toplists/{$type}.php")) include(_BASEDIR."toplists/{$type}.php");
			else $output .= write_error(_ERROR);
		}
		else $output .= write_error(_ERROR);		
	}

$tpl->assign("output", $output);
$output = $tpl->getOutputContent();  
$output = e107::getParser()->parseTemplate($output, true);
e107::getRender()->tablerender($caption, $output, $current);
dbclose( );
require_once(FOOTERF); 
?>
