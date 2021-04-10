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
error_reporting(0);

include_once '../../class2.php';

define ("_BASEDIR", e_PLUGIN."efiction/"); 

include_once(_BASEDIR."includes/dbfunctions.php");    
include_once(_BASEDIR."config.php"); 

$settingsresults = dbquery("SELECT sitename, url, siteemail, slogan, language, tableprefix, dateformat FROM ".$settingsprefix."fanfiction_settings WHERE sitekey = '$sitekey'");
$settings = dbassoc($settingsresults);
foreach($settings as $var => $val) {
	$$var = $val;
}
$tp = e107::getParser();

e107::lan('efiction');

define("TABLEPREFIX", MPREFIX);
define("SITEKEY", $sitekey);
  include_once("includes/queries.php");
  if(file_exists("languages/{$language}.php")) include("languages/{$language}.php");
  else include("languages/en.php");
  

 
$ratlist = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_ratings");
while($rate = dbassoc($ratlist)) {
	$ratings[$rate['rid']] = $rate['rating'];
}

 

  $rss = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
  $rss.="<rss version=\"2.0\">\n"; 
  $rss.="<channel>\n"; 
  $rss.="<copyright>Copyright ".date("Y")."</copyright>\n"; 
  $rss.="<lastBuildDate>".date("r")."</lastBuildDate>\n"; 
  $rss.="<description>".$tp->toRss($slogan)."</description>\n"; 
  $rss.="<link>$url</link>\n"; 
  $rss.="<title>".$tp->toRss($sitename)."</title>\n"; 
  

$query = _STORYQUERY." ORDER BY updated DESC LIMIT 20";
$results = dbquery($query);
while($story = dbassoc($results)) {
    $story['authors'][] = $story['penname'];
    if($story['coauthors']) {
		$coauth = dbquery("SELECT "._PENNAMEFIELD." as penname, co.uid FROM ".TABLEPREFIX."fanfiction_coauthors AS co LEFT JOIN "._AUTHORTABLE." ON co.uid = "._UIDFIELD." WHERE co.sid = '".$story['sid']."'");
		while($c = dbassoc($coauth)) {
			$story['authors'][] = $c['penname'];
		}
    }
    foreach($story['authors'] AS $k => $v) {
	$story['authors'][$k] = $tp->toRss($v);
    }
    $rss.= "<item>
	<title>".$tp->toRss($story['title'])." "._BY." ".implode(", ", $story['authors'])." [".$ratings[$story['rid']]."]</title>
	<link>$url/viewstory.php?sid=".$story['sid']."</link>
	<description>".$tp->toRss($story['summary'])."</description>
	<pubDate>".date("r",$story['updated'])."</pubDate>
     </item>\n";  
} 

  $rss.="</channel>
</rss>"; 
ob_start ("ob_gzhandler");
  header("Content-type: application/rss+xml", true); 
  header("Cache-Control: must-revalidate"); 
  header("Expires: ".gmdate("D, d M Y H:i:s", time() + 3600) . " GMT"); 

  echo $rss; 

?>
