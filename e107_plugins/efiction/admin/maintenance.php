<?php
// ----------------------------------------------------------------------
// eFiction 3.0
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

if(!defined("_CHARSET")) exit( );

$maint = isset($_GET['maint']) ? $_GET['maint'] : false;
$output .= "<div id='pagetitle'>"._ARCHIVEMAINT."</div>";
 
if($maint == "reviews") {

    e107::getMessage()->addInfo("Reviews recalculation started. For more info set debug mode on.") ;

$query =  "UPDATE ".TABLEPREFIX."fanfiction_stories SET rating = '0', reviews = '0'";  /* NOTE: access rating is field rid */  // Set them all to 0 before we re-insert. 
    e107::getDb()->gen($query);
    e107::getMessage()->addDebug($query);
          
    $query = "SELECT AVG(rating) as average, item FROM ".MPREFIX."fanfiction_reviews WHERE type = 'ST' AND rating != '-1' GROUP BY item";
	$stories = e107::getDb()->retrieve($query, true);
    e107::getMessage()->addDebug($query);
    
    foreach($stories AS $s)  {
        $query = "UPDATE ".TABLEPREFIX."fanfiction_stories SET rating = '".round($s['average'])."' WHERE sid = '".$s['item']."'";
        e107::getDb()->gen($query);
        e107::getMessage()->addDebug($query);
	}
 
    $query = "SELECT COUNT(reviewid) as count, item FROM ".TABLEPREFIX."fanfiction_reviews WHERE type = 'ST' AND review != 'No Review' GROUP BY item";
	$stories = e107::getDb()->retrieve($query, true);
    e107::getMessage()->addDebug($query);
    
    foreach($stories AS $s)  {
        $query = "UPDATE ".TABLEPREFIX."fanfiction_stories SET reviews = '".$s['count']."' WHERE sid = '".$s['item']."'";
        e107::getDb()->gen($query);
        e107::getMessage()->addDebug($query);
	}
    
    $query =  "UPDATE ".TABLEPREFIX."fanfiction_chapters SET rating = '0', reviews = '0'";
    e107::getDb()->gen($query);
    e107::getMessage()->addDebug($query);
    
    $query = "SELECT AVG(rating) as average, chapid FROM ".TABLEPREFIX."fanfiction_reviews WHERE type = 'ST' AND rating != '-1' GROUP BY chapid";
    $chapters = e107::getDb()->retrieve($query, true);
    e107::getMessage()->addDebug($query);

    foreach($chapters AS $c)  {
        $query = "UPDATE ".TABLEPREFIX."fanfiction_chapters SET rating = '".round($c['average'])."' WHERE chapid = '".$c['chapid']."'";
		e107::getDb()->gen($query);
        e107::getMessage()->addDebug($query);
	}
    
    $query =  "SELECT COUNT(reviewid) as count, chapid FROM ".TABLEPREFIX."fanfiction_reviews WHERE type = 'ST' AND review != 'No Review' GROUP BY chapid";
    $chapters = e107::getDb()->retrieve($query, true);
    e107::getMessage()->addDebug($query);
        
    foreach($chapters AS $c)  {
        $query = "UPDATE ".TABLEPREFIX."fanfiction_chapters SET reviews = '".$c['count']."' WHERE chapid = '".$c['chapid']."'";
		e107::getDb()->gen($query);
        e107::getMessage()->addDebug($query);
	}
    
    $query =  "UPDATE ".TABLEPREFIX."fanfiction_series SET rating = '0', reviews = '0'";
    e107::getDb()->gen($query);
    e107::getMessage()->addDebug($query);
        
    $query = "SELECT seriesid FROM ".TABLEPREFIX."fanfiction_series";
    $series = e107::getDb()->retrieve($query, true);
    e107::getMessage()->addDebug($query);
        
	foreach($series AS $s)  {
		$thisseries = $s['seriesid'];
		include(_BASEDIR."includes/seriesreviews.php");
	}
 
	// For modules which may allow reviews.    
    $query = "SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'revfix'";
    $codequery  = e107::getDb()->retrieve($query, true);
    e107::getMessage()->addDebug($query);
    
    foreach($codequery AS $code) {
		$eval($code['code_text']);
	}
 
    $output .= e107::getMessage()->render();
        
    $output .= write_message(_ACTIONSUCCESSFUL);
}
else if($maint == "stories") {
		$authors = e107::getDb()->retrieve("SELECT uid, count(uid) AS count FROM ".TABLEPREFIX."fanfiction_stories WHERE validated > 0 GROUP BY uid", true);
 
        foreach($authors AS $a)   {   
			$alist[$a['uid']] = $a['count'];
		}
        $query = "SELECT uid, count(sid) AS count FROM ".TABLEPREFIX."fanfiction_coauthors GROUP BY uid";
		$coauthors = e107::getDb()->retrieve($query, true);
        e107::getMessage()->addDebug($query);   
        foreach($coauthors AS $ca)   {  
			if(isset($alist[$ca['uid']])) $alist[$ca['uid']] = $alist[$ca['uid']] + $ca['count'];
			else $alist[$ca['uid']] = $ca['count'];
		}
        
		foreach($alist AS $a => $s) {
            $query = "UPDATE ".TABLEPREFIX."fanfiction_authorprefs SET stories = '$s' WHERE uid = '$a' LIMIT 1"; 
            e107::getDb()->gen($query);
            e107::getMessage()->addDebug($query);
		}
		$count =   e107::getDb()->retrieve("SELECT SUM(wordcount) as count, sid FROM ".TABLEPREFIX."fanfiction_chapters WHERE validated = '1' GROUP BY sid");
        foreach($count AS $c)  {
            $query = "UPDATE ".TABLEPREFIX."fanfiction_stories SET wordcount = '".$c['count']."' WHERE sid = '".$c['sid']."'";
            e107::getDb()->gen($query);
            e107::getMessage()->addDebug($query);
		}
	$output .= e107::getMessage()->render();
    $output .= write_message(_ACTIONSUCCESSFUL);
}
else if($maint == "categories") {
	e107::getDb()->gen("UPDATE ".TABLEPREFIX."fanfiction_categories SET numitems = '0'");
	$cats = e107::getDb()->retrieve("SELECT catid FROM ".TABLEPREFIX."fanfiction_categories ORDER BY leveldown DESC", true);
    foreach($cats AS $cat) {
        $catid = $cat['catid'];
		unset($subcats);
		$subs = e107::getDb()->retrieve("SELECT catid FROM ".TABLEPREFIX."fanfiction_categories WHERE parentcatid = $catid", true);
 
		$subcats = array( );
        foreach($subs AS $sub) {
			$subcats[] = $sub['catid'];
			if($categories[$sub['catid']]) $subcats = array_merge($subcats, $categories[$sub['catid']]);
		}
		$categories[$cat[0]] = $subcats;
    
       $query = 
       "SELECT count(sid) FROM #fanfiction_stories 
       WHERE FIND_IN_SET('$catid', catid) ".(count($subcats) > 0 ? " OR FIND_IN_SET(". implode(", catid) OR FIND_IN_SET(",$subcats).", catid)" : "")." AND validated > 0 ";     
 
       $count = e107::getDb()->retrieve($query);  
 
	 	e107::getDb()->gen("UPDATE #fanfiction_categories SET numitems = $count WHERE catid = $catid");
	}
 
	$output .= write_message(_CATCOUNTSUPDATED);
}
else if($maint == "categories2") {
	$selectA = "SELECT category, catid FROM ".TABLEPREFIX."fanfiction_categories WHERE parentcatid = -1 ORDER BY displayorder";
	$resultA = e107::getDb()->retrieve($selectA, true);
	$countA = 1;
    foreach($resultA AS $cat) {
		$count = 1;
		if($cat['parentcatid'] = -1) {
			e107::getDb()->gen("UPDATE ".TABLEPREFIX."fanfiction_categories SET displayorder = $countA WHERE catid = $cat[catid]");
			$countA++;
		}
		$selectB = "SELECT category, catid FROM ".TABLEPREFIX."fanfiction_categories WHERE parentcatid = '$cat[catid]' ORDER BY displayorder";
		$resultB = e107::getDb()->retrieve($selectB, true);
        foreach($resultB AS $sub) {
			e107::getDb()->gen("UPDATE ".TABLEPREFIX."fanfiction_categories SET displayorder = $count WHERE catid = $sub[catid]");
			$count++;
		}
	}
	$output .= write_message(_ACTIONSUCCESSFUL);
}
else if($maint == "stats") {
	// check that the statisics is working before doing anything else
    $query = "SELECT * FROM ".TABLEPREFIX."fanfiction_stats WHERE sitekey = '".SITEKEY."' LIMIT 1";
	$check = e107::getDb()->retrieve($query);
    e107::getMessage()->addDebug($query);
    
	if(!$check) e107::getDb()->gen("INSERT INTO ".TABLEPREFIX."fanfiction_stats(`sitekey`) VALUES('".SITEKEY."')");

	$serieslist = e107::getDb()->retrieve("SELECT seriesid FROM ".TABLEPREFIX."fanfiction_series", true);
	$totalseries = count($serieslist);
    foreach($serieslist AS $s) {
		$numstories = count(storiesInSeries($s['seriesid']));
        $query = "UPDATE ".TABLEPREFIX."fanfiction_series SET numstories = '$numstories' WHERE seriesid = ".$s['seriesid']." LIMIT 1";
		e107::getDb()->gen($query);
        e107::getMessage()->addDebug($query);
	}
 
	$storiesquery =  "SELECT COUNT(sid) as totals, SUM(wordcount) as totalwords FROM ".TABLEPREFIX."fanfiction_stories WHERE validated > 0 ";
    $tmp = e107::getDb()->retrieve($storiesquery);
    e107::getMessage()->addDebug($storiesquery);
 
    $stories = $tmp['totals'];
    $words = $tmp['totalwords'];
 
    $authorsquery = "SELECT count(uid) AS count FROM ".TABLEPREFIX."fanfiction_authorprefs WHERE stories > 0";
    $authors = e107::getDb()->retrieve($authorsquery);
 
    $updatequery = "UPDATE ".TABLEPREFIX."fanfiction_stats SET stories = '$stories', authors = '$authors', wordcount = '$words' WHERE sitekey = '".SITEKEY."'";
    
	e107::getDb()->gen($updatequery); 
    e107::getMessage()->addDebug($updatequery);

	$chapters = e107::getDb()->retrieve("SELECT COUNT(chapid) as chapters FROM ".TABLEPREFIX."fanfiction_chapters where validated > 0");
 
	$authorquery =  "SELECT COUNT("._UIDFIELD.") as totalm FROM "._AUTHORTABLE; 
    e107::getMessage()->addDebug($authorquery);
    $members = e107::getDb()->retrieve($authorquery); 
 
 
    $authorquery = "SELECT "._UIDFIELD." as uid FROM "._AUTHORTABLE." ORDER BY "._UIDFIELD." DESC LIMIT 1";
    $tmp  = e107::getDb()->retrieve($authorquery); 
    $newest = $tmp;
    
//	list($newest) = dbrow(dbquery("SELECT "._UIDFIELD." as uid FROM "._AUTHORTABLE." ORDER BY "._UIDFIELD." DESC LIMIT 1"));

	$reviewquery = dbquery("SELECT COUNT(reviewid) as totalr FROM ".TABLEPREFIX."fanfiction_reviews WHERE review != 'No Review'");

	list($reviews) = dbrow($reviewquery);

	$reviewquery = dbquery("SELECT COUNT(DISTINCT uid) FROM ".TABLEPREFIX."fanfiction_reviews WHERE review != 'No Review' AND uid != 0");
	list($reviewers) = dbrow($reviewquery);
    
    $updatequery = "UPDATE ".TABLEPREFIX."fanfiction_stats SET series = '$totalseries', chapters = '$chapters', members = '$members', newestmember = '$newest', reviews = '$reviews', reviewers = '$reviewers' WHERE sitekey = '".SITEKEY."'";  
	e107::getDb()->gen($updatequery); 
    e107::getMessage()->addDebug($updatequery);
    
    $output .= e107::getMessage()->render();
	$output .= write_message(_ACTIONSUCCESSFUL);
}
else if($maint == "panels") {
	$ptypes = dbquery("SELECT panel_type FROM ".TABLEPREFIX."fanfiction_panels GROUP BY panel_type");
	while($ptype = dbassoc($ptypes)) {
		if($ptype['panel_type'] == "A") {
			for($x = 1; $x < 5; $x++) {
				$count = 1;
				$plist = dbquery("SELECT panel_name, panel_id FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_hidden = '0' AND panel_type = '".$ptype['panel_type']."' AND panel_level = '$x' ORDER BY panel_level, panel_order");
				while($p = dbassoc($plist)) {
					e107::getDb()->gen("UPDATE ".TABLEPREFIX."fanfiction_panels SET panel_order = '$count' WHERE panel_id = '".$p['panel_id']."' LIMIT 1");
					$count++;
				}
			}
		}
		else {
			$count = 1;
			$plist = dbquery("SELECT panel_name, panel_id FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_hidden = '0' AND panel_type = '".$ptype['panel_type']."' ORDER BY ".($ptype['panel_type'] == "A" ? "panel_level," : "")."panel_order");
			while($p = dbassoc($plist)) {
				e107::getDb()->gen("UPDATE ".TABLEPREFIX."fanfiction_panels SET panel_order = '$count' WHERE panel_id = '".$p['panel_id']."' LIMIT 1");
				$count++;
			}
		}
	}
	$output .= write_message(_ACTIONSUCCESSFUL);
}
 
else {
	$output .= "
<ul>
	<li><a href='admin.php?action=maintenance&amp;maint=reviews'>"._RECALCREVIEWS."</a> <A HREF=\"#\" class=\"pophelp\">[?]<span>"._HELP_RECALCREVIEWS."</span></A></li>
	<li><a href='admin.php?action=maintenance&amp;maint=stories'>"._RECALCSTORIES."</a> <A HREF=\"#\" class=\"pophelp\">[?]<span>"._HELP_RECALCSTORIES."</span></A></li>
	<li><a href='admin.php?action=maintenance&amp;maint=categories'>"._COUNTCATS."</a> <A HREF=\"#\" class=\"pophelp\">[?]<span>"._HELP_CATCOUNTS."</span></A></li>
	<li><a href='admin.php?action=maintenance&amp;maint=categories2'>"._CATORDER."</a> <A HREF=\"#\" class=\"pophelp\">[?]<span>"._HELP_CATORDER."</span></A></li>
	<li><a href='admin.php?action=maintenance&amp;maint=stats'>"._STATS."</a> <A HREF=\"#\" class=\"pophelp\">[?]<span>"._HELP_STATS."</span></A></li>
	<li><a href='admin.php?action=maintenance&amp;maint=panels'>"._PANELORDER."</a> <A HREF=\"#\" class=\"pophelp\">[?]<span>"._HELP_PANELORDER."</span></A></li>
</ul>";
}
?>