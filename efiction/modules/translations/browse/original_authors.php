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

$current = "writers";
$writerid = isset($_GET['wrid']) && isNumber($_GET['wrid']) ? $_GET['wrid'] : 0;
      
$writerid = (int) $writerid;

if($writerid > 0) {

    $storyquery = " AND stories.writer = ".$writerid." ";
    $countquery = " AND stories.writer = ".$writerid." ";
	$writerquery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_writers WHERE cw_author_id = '$writerid' LIMIT 1");
	$writer = dbassoc($writerquery);
    $rsekcia = '';
 
    if($writer['cw_author_rs'])   {
       $rsekcia = ' <span class="label label-danger">Sekcia s obmedzeným prístupom  </span> ';  
    }
    
	$output = "<div id='pagetitle'> Autor originálu: ".stripslashes($writer['cw_author_name']).$rsekcia."</div><div>".format_story($writer['cw_author_info'])."</div> ";
	$numrows = search(_STORYQUERY.$storyquery._ORDERBY, _STORYCOUNT.$countquery, "browse.php?");
 
}
else {
        
    $output .= "<div id='pagetitle'>Autori originálu: </div>".build_alphalinks("browse.php?type=original_authors&amp;", $let);
	$numrows = 0;
	$writerquery = array( );
	if(!empty($charid)) {
		$chars = array( );
		foreach($charid as $c) {
			$chars[] = "FIND_IN_SET('$c', characters) > 0";
		}
		$writerquery[] = implode(" OR ", $chars);
	}
   
	if($let == _OTHER) {
		$writerquery[] = "writer.cw_author_name REGEXP '^[^a-zčřňšúž]'";
	}
	else if(!empty($let)) {
		$writerquery[] = "writer.cw_author_name LIKE '$let%'";
	}
	$writerquery = count($writerquery) > 0 ? " WHERE ".implode(" AND ", $writerquery) : "";
 
	$count = dbquery("SELECT count(cw_author_id) FROM ".TABLEPREFIX."fanfiction_writers as writer $writerquery");


    
	list($numrows) = dbrow($count);                      

    	$limit = $itemsperpage *  $displaycolumns;         
    	$total = ($numrows > $limit ? $limit : $numrows);    
    	$list = floor($total /  $displaycolumns);            
    	if($total % $displaycolumns != 0) $list++;
	    $colwidth = (100/ $displaycolumns) -1;              
    	$count = 0;
    	$column = 1; 
        
        $query = "SELECT writer.* FROM ".TABLEPREFIX."fanfiction_writers as writer $writerquery ORDER BY cw_author_name LIMIT $offset, $limit";
        $result = dbquery($query);    
        $output .= "<div id=\"columncontainer\"><div id=\"browseblock\">".($displaycolumns ? "<div class=\"column\">" : "");
               
		while($writer = dbassoc($result)) {   
          $count++;                   
          if(empty($writer['cw_author_stories'])) $writer['cw_author_stories'] = 0; // For bridges site that may not have author prefs set.
    	    $output .= "<a href=\"browse.php?type=original_authors&amp;wrid=".$writer['cw_author_id']."\">".stripslashes($writer['cw_author_name'])."</a> [".$writer['cw_author_stories']."]<br />";
    		if( $count >= $list && $column != $displaycolumns) {
               
    			$output .= "</div><div class=\"column\">";
    			if($total % $displaycolumns == $column) $list--;
    			$column++;
    			$count = 0;
    		} 
		}      
        $output .= "</div>".($displaycolumns ? "</div>" : "")."<div class='cleaner'>&nbsp;</div></div>";
  
 
	if ($numrows > $limit) {
		$output .= build_pagelinks("browse.php?type=original_authors".($let ? "&amp;let=$let" : "")."&amp;", $numrows, $offset, $displaycolumns);
	}
	else if(!$numrows) $output .= write_message(_NORESULTS);   
    
    $numrows = 0;
}	
if($writerid > 0) $writerlist1 = $writerid;