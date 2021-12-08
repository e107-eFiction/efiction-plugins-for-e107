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

// Sanitizes user input to help prevent XSS attacks 
function descript($text) {
	 
    $text = e107::getParser()->toDB($text); 
	return $text;
}


// Checks that the given $num is actually a number.  Used to help prevent XSS attacks.
function isNumber($num) {
 
	if(empty($num)) return false;  
	if(!is_string($num)) return false;   
	return preg_match("/^[0-9]+$/", $num);
}

// The next three functions are used to calculate the series reviews and rating
function storiesInSeries($thisseries) {
	$storylist = array( );
	if(!isNumber($thisseries)) return $storylist;
	$serieslist = array( );
    
	$query =  "SELECT sid, subseriesid FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$thisseries'" ;
	$stinseries = e107::getDb()->retrieve($query, true);
    foreach($stinseries AS $st) { 
		if(!empty($st['sid'])) $storylist[] = $st['sid'];
		else if(!empty($st['subseriesid'])) $serieslist[] = $st['subseriesid'];
	}
	if($serieslist) {
		foreach($serieslist as $s) {
			$storylist = array_merge($storylist, storiesInSeries($s));
		}
	}
	return $storylist;
}


function subseriesList($thisseries) {
	$serieslist = array( );
	if(!isNumber($thisseries)) return $serieslist;
    $query = "SELECT subseriesid FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$thisseries'";
    $stinseries = e107::getDb()->retrieve($query, true);
    
	foreach($stinseries AS $st) { 
		$serieslist[] = $st['subseriesid']; 
		$serieslist = array_merge($serieslist, subseriesList($st['subseriesid']));
	}
	return $serieslist;
}

function seriesreview($thisseries) {

	if(!isNumber($thisseries)) return;
	$storylist = storiesInSeries($thisseries);
	$serieslist = subseriesList($thisseries);
    
    $newrating_query = "SELECT AVG(rating) as totalreviews FROM ".TABLEPREFIX."fanfiction_reviews 
	WHERE ((item = '$thisseries' AND type = 'SE')".
	(count($storylist) > 0 ? " OR (FIND_IN_SET(item, '".(implode(",", $storylist))."') > 0 AND type = 'ST')" : "").
	(count($serieslist) > 0 ? " OR (FIND_IN_SET(item, '".(implode(",", $serieslist))."') > 0 AND type = 'SE')" : "").
	") AND rating != '-1'";
 
    
    $totalreviews = e107::getDb()->retrieve($query);
 
    $newcount_dbquery =  "SELECT count(reviewid) as totalcount FROM ".TABLEPREFIX."fanfiction_reviews 
	WHERE ((item = '$thisseries' AND type = 'SE')".
	(count($storylist) > 0 ? " OR (FIND_IN_SET(item, '".(implode(",", $storylist))."') > 0 AND type = 'ST')" : "").
	(count($serieslist) > 0 ? " OR (FIND_IN_SET(item, '".(implode(",", $serieslist))."') > 0 AND type = 'SE')" : "").
	") AND review != 'No Review'" ;
    
    $totalcount = e107::getDb()->retrieve($query);
 
    if($totalcount) { 
      $update_query = "UPDATE ".TABLEPREFIX."fanfiction_series SET rating = '".round($totalreviews)."', reviews = '$totalcount' WHERE seriesid = '$thisseries'";
      e107::getDb()->gen($update_query);
    }
    
    $parentq_query = "SELECT seriesid FROM ".TABLEPREFIX."fanfiction_inseries WHERE subseriesid = '$thisseries' AND seriesid != '$thisseries'" ; 
    $parentq = e107::getDb()->retrieve($parentq_query); 
    foreach($parentq AS $parent2) {
        seriesreview($parent2['seriesid']);
    }
 
}


// Call this function when the user tries to do something they shouldn't have access to.
function accessDenied($str = ""){
    global $output;
    
	if(!empty($str)) $output = write_error($str);
	else $output = write_error(_NOTAUTHORIZED);
 
	e107::getRender()->tablerender($caption, $output, $current);
	require_once(FOOTERF); 
	exit;
 
}


// Formats the text of the story when displayed on screen.  
function format_story($text = '') {
      $text = e107::getParser()->toHTML($text, true, "DESCRIPTION"); 
 
      /*
      $text = trim($text);
      if(strpos($text, "<br>") === false && strpos($text, "<p>") === false && strpos($text, "<br />") === false) $text = nl2br2($text);
      if(_CHARSET != "ISO-8859-1" && _CHARSET != "US-ASCII") return stripslashes($text);
      $badwordchars = array(chr(212), chr(213), chr(210), chr(211), chr(209), chr(208), chr(201), chr(145), chr(146), chr(147), chr(148), chr(151), chr(150), chr(133));
      $fixedwordchars = array('&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#8212;', '&#8211;', '&#8230;', '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#8212;', '&#8211;',  '&#8230;' );
      $text = str_replace($badwordchars,$fixedwordchars,stripslashes($text));
      */
      return $text;
}



function saveformat_story($text) {
     $text = e107::getParser()->toDb($text); 
     return $text;
}

function format_title($text) {
     $text = e107::getParser()->toHTML($text, true, "TITLE"); 
     return $text;
}

function format_summary($text) {
     $text = e107::getParser()->toHTML($text, true, "SUMMARY"); 
     return $text;
}

// Because this is used in places other than the listings of stories, we're setting it up as a function to be called as needed.
function title_link($stories, $parm = NULL) {
    
    $ageconsent =  efiction_settings::get_single_setting('ageconsent');
    $disablepopups =  efiction_settings::get_single_setting('disablepopups');
    
    $class =  varset($parm['class'],"viewstory");
    
    $ratingslist = efiction_ratings::get_ratings_list();
	$rating = $stories['rid'];
	$warningtext = !empty($ratingslist[$rating]['warningtext']) ? addslashes(strip_tags($ratingslist[$rating]['warningtext'])) : "";
		if(empty($ratingslist[$rating]['ratingwarning'])) {
            $link = "viewstory.php?sid=".$stories['sid'];
			$title = "<a class=\"".$class."\" href=\"viewstory.php?sid=".$stories['sid']."\">".$stories['title']."</a>";
        }    
		else {
			$warning = "";
			$warninglevel = sprintf("%03b", $ratingslist[$rating]['ratingwarning']);
			if($warninglevel[2] && !e107::getSession()->is(SITEKEY."_warned/{$rating}")) {
				$location = "viewstory.php?sid=".$stories['sid']."&amp;warning=$rating";
				$warning = $warningtext;
			}
			if($warninglevel[1] && !$ageconsent && !e107::getSession()->is(SITEKEY."_ageconsent")) {
				$location = "viewstory.php?sid=".$stories['sid']."&amp;ageconsent=ok&amp;warning=$rating";
				$warning = _AGECHECK." - "._AGECONSENT." ".$warningtext." -- 1";
			}
			if($warninglevel[0] && !isMEMBER) {
				//$location = "member.php?action=login&amp;sid=".$stories['sid'];
		//$location = "member.php?action=login&amp;sid=".$stories['sid'];
		$previousUrl = e_HTTP."viewstory.php?sid=".$stories['sid'];
		e107::getRedirect()->setPreviousUrl($previousUrl);
		$location =  e_HTTP."login.php";
				$warning = _RUSERSONLY." - $warningtext";		
			}
			if(!empty($warning)) {
				$warning = preg_replace("@'@", "\'", $warning);
                $link = "javascript:if(confirm('".$warning."')) location = '$location'";
				$title = "<a class='".$class."'  href=\"javascript:if(confirm('".$warning."')) location = '$location'\">".$stories['title']."</a>";
			}
			else {
              $link = "viewstory.php?sid=".$stories['sid'];
              $title = "<a class=\".$class.\" href=\"viewstory.php?sid=".$stories['sid']."\">".$stories['title']."</a>";
		    }  
        }

	return $title;
    //return $link;
}


// Most of the pages that list stories and series use this fuction.  This handles showing the series and stories and pagination of the two together when needed
// template is used instead storyblock 

function search_new($storyquery, $countquery, $pagelink = "searching.php?", $pagetitle = 0) {
	global $tpl, $new, $ratingslist, $itemsperpage, $reviewsallowed, $output, $dateformat, $current, $featured, $favorites, $retired, $ageconsent, $classtypelist, $classlist, $offset, $recentdays;
     
	$count = dbquery($countquery);
	list($numrows) = dbrow($count);
	if($numrows) {
		$tpl->assign("output", ($pagetitle ? "<div id=\"pagetitle\">$pagetitle</div>" : ""));
		$tpl->newBlock("listings");
		if(!$ratingslist) {
			$ratlist = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_ratings");
			while($rate = dbassoc($ratlist)) {
				$ratings[$rate['rid']] = array("rating" => $rate['rating'], "ratingwarning" => $rate['ratingwarning'], "warningtext" => $rate['warningtext']);
			}
		}
		$tpl->newBlock("listings");
		$tpl->gotoBlock("listings");
		$caption = "<div class=\"listingsheader\">"._STORIES."</div>";
		$storyquery .= " LIMIT $offset, $itemsperpage";
		$result3 = e107::getDb()->retrieve($storyquery, true);     
		$count = 0;        
        
        $sc = e107::getScParser()->getScObject('story_shortcodes', 'efiction', false);
        
        $template = e107::getTemplate('efiction', 'listings', 'browse', true, true);             
        
        $text = '';
        foreach($result3 AS $stories) {     
            $sc->setVars($stories);
            
            $text .=  e107::getParser()->parseTemplate($template['item'], true, $sc);    
              
			//$tpl->newBlock("storyblock");
            
		    //include(_BASEDIR."includes/storyblock.php"); 
		}
        $storyblock = e107::getRender()->tablerender($caption, $start.$text.$end, $current, true);
        $tpl->assign("stories",  $storyblock);
		$tpl->gotoBlock("_ROOT");		
	}
	else {
		$tpl->newBlock("listings");
		$tpl->assign("pagelinks", write_message(_NORESULTS));
	}
	if($numrows > $itemsperpage) {
		$termArray = array_merge($_GET, $_POST);
		$terms = array();
		foreach($termArray as $term => $value) {
			if($term == "submit" || $term == "go" || $term == "offset" || ($term != "complete" &&empty($value))) continue;
			$terms[] = "$term=".(is_array($value) ? implode(",", $value) : $value);
		}
		$terms = implode("&amp;", $terms);
		$terms .= "&amp;";
	 	$tpl->gotoBlock("listings");
		$tpl->assign( "pagelinks", build_pagelinks($pagelink.$terms, $numrows, $offset));
	}
	$tpl->gotoBlock("_ROOT");
	return $numrows;
}

// Function builds the alphabet links on various pages.
function build_alphalinks($url, $let) {
   
    $alphabet = efiction_settings::get_alphabet();   
	$alpha = "<div id=\"alphabet\">";
	foreach( $alphabet as $link ) {
		// Build a link that calls a function with ($link and 1 (page number) )
		$alpha .= "<a href=\"{$url}let=$link\"".($let == $link ? " id='currentletter'" : "").">$link</a> \n";
	}
	$alpha .= "</div>";   
	return $alpha;
}

// Function builds the pagination links
function build_pagelinks($url, $total, $offset = 0, $columns = 1) {
 
 
    $itemsperpage = e107::getSingleton('efiction_settings')->getPref("itemsperpage");
    $linkstyle = e107::getSingleton('efiction_settings')->getPref("linkstyle");  /* 0,1,2 */
    $linkrange = e107::getSingleton('efiction_settings')->getPref("linkrange");
 
	$pages = "";
	$itemsperpage = $itemsperpage * $columns;

	if($itemsperpage >= $total) return;
 	if($itemsperpage == 0) return;   

	if(empty($linkrange)) $linkrange = 4;
 
	$totpages = floor($total/$itemsperpage) + ($total % $itemsperpage ? 1 : 0);
	$curpage = floor($offset/$itemsperpage) + 1;
	if(!$linkstyle) $startrange = $curpage;
	else {
		if($totpages <= $linkrange || $curpage == 1) $startrange = 1;
		else if($curpage >= $totpages - floor($linkrange / 2) + 1) $startrange = $totpages - $linkrange;
		else $startrange = $curpage - floor($linkrange / 2) > 0 ? $curpage - floor($linkrange / 2) : 1;
	}
	if($startrange >= $totpages - $linkrange ) $startrange = $totpages - $linkrange > 0 ? $totpages - $linkrange : 1;
	$stoprange = $totpages > $startrange + $linkrange ? $startrange + $linkrange : $totpages + 1;
	if($curpage > 1 && $linkstyle != 1) $pages .= "<a href='".$url."offset=".( $offset - $itemsperpage)."' id='plprev'>["._PREVIOUS."]</a> ";
	if($startrange > 1 && $linkstyle > 0) $pages .= "<a href='".$url."offset=0'>1</a><span class='ellipses'>...</span>";
	for($x = $startrange; $x < $stoprange; $x++) {
		$pages .= "<a href='".$url."offset=".(($x - 1) * $itemsperpage)."'".($x == $curpage ? "id='currentpage'" : "").">".$x."</a> \n";
	}
	if($stoprange < $totpages && $linkstyle > 0) $pages .= "<span class='ellipses'>...</span> <a href='".$url."offset=".(($totpages - 1) * $itemsperpage)."'>$totpages</a>\n";
	if ($curpage < $totpages && $linkstyle != 1) $pages .=  " <a href='".$url."offset=".($offset+$itemsperpage)."' id='plnext'>["._NEXT."]</a>";
	return "<div id=\"pagelinks\">$pages</div>";
}


//original solution fails on national characters
function e107_wordscount($title = '') {
  $tp = e107::getParser();
 
  //see application title2sef helper
  //$title = $tp->toText($title);
  //it can't be used because strip_tags() in toText() fails on <p><strong>Kapitola 8 3/3</strong></p> 
  
  //replace national stuff otherwise str_word_count() fails
  $storytext = $tp->toASCII($title);
  
  //$storytext = str_replace("><", '> <', $storytext);
 
  //to make it one word
  $storytext = str_replace(array("https://www.youtube.com/watch?v="), 'x', $storytext); 
   // issue #3245: strip all html and bbcode before processing 
  $words_to_count = flame_strip_tags($storytext );    
   
  $words = str_word_count($words_to_count, 1 , "1234567890/" );
    
 
  return $words  ;
}

function flame_strip_tags($html, $allowed_tags=array()) {
  $allowed_tags=array_map(strtolower,$allowed_tags);
  $rhtml=preg_replace_callback('/<\/?([^>\s]+)[^>]*>/i', function ($matches) use (&$allowed_tags) {       
    return in_array(strtolower($matches[1]),$allowed_tags)?$matches[0]:'';
  },$html);
  return $rhtml;
}
 
function rip_tags_better($string, $rep = ' ') {
   
    // ----- remove HTML TAGs -----
    $string = preg_replace ('/<[^>]*>/', $rep, $string);
   
    // ----- remove control characters -----
    $string = str_replace("\r", '', $string);    // --- replace with empty space
    $string = str_replace("\n", $rep, $string);   // --- replace with space
    $string = str_replace("\t", $rep, $string);   // --- replace with space
   
    // ----- remove multiple spaces -----
    $string = trim(preg_replace('/ {2,}/', $rep, $string));
   
    return $string;

}