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


$output .= "<div id=\"pagetitle\">"._SUBMITTED."</div>";
$view = isset($_GET['view']) ? $_GET['view'] : false;
$output .= 	"<p style=\"text-align: right; margin: 1em;\"><a href=\"admin.php?action=submitted&amp;view=".($view == "all" ? "cats\">"._VIEWMYCATS : "all\">"._VIEWALL)."</a></p>";
 
$result = efiction_stories::get_submissions();

if($result) {
	$output .= " 
    <table class=\"table table-striped table-bordered border-info \" >
    
     <thead><tr><th>"._TITLE."</th><th>"._AUTHOR."</th><th>"._CATEGORY."</th><th>"._OPTIONS."</th></tr> </thead>
    
    <tbody>";
	$array = explode(",", $admincats);
	foreach($result AS $story) {
		if(!$admincats || $_GET['view'] == "all" || sizeof(array_intersect(explode(",", $story['catid']), explode(",", $admincats)))) {
			$output .= "<tr>";
			$output .= "<td><a href=\"viewstory.php?sid=$story[sid]\">".stripslashes($story['storytitle'])."</a>";
			if(isset($story['title'])) $output .= " <b>:</b> <a href=\"viewstory.php?sid=$story[sid]&amp;chapter=$story[inorder]\">".stripslashes($story['title'])."</a>";
			$output .= "</td><td><a href=\"viewuser.php?uid=$story[uid]\">$story[penname]</a></td>";
			$output .= "<td>".catlist($story['catid'])."</td>";
			$output .= "<td><a class='btn btn-sm btn-success'  href=\"admin.php?action=validate&amp;chapid=$story[chapid]\">"._VALIDATE."</a><br />"._DELETE.": 
            <a class='btn btn-sm btn-danger' href=\"stories.php?action=delete&amp;chapid=$story[chapid]&amp;sid=$story[sid]&amp;admin=1&amp;uid=$story[uid]\">"._CHAPTER2."</a> "._OR." 
            <a class='btn btn-sm btn-danger' href=\"stories.php?action=delete&amp;sid=$story[sid]&amp;admin=1\">"._STORY2."</a>
            <br /><a  class='btn btn-sm btn-info'  href=\"javascript:pop('".SITEURL."admin.php?action=yesletter&uid=$story[uid]&chapid=$story[chapid]', 600, 500, 'yes')\">"._YESLETTER."</a> | 
            <a class='btn btn-sm btn-secondary' href=\"javascript:pop('admin.php?action=noletter&uid=$story[uid]&chapid=$story[chapid]', 600, 500, 'yes')\">"._NOLETTER."</a>
       </td></tr>";
		}
	}
	$output .= "</tbody></table> ";
 
}
else $output .= write_message(_NORESULTS);
?>