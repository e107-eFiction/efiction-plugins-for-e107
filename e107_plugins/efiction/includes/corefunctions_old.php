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

if (!defined('e107_INIT')) exit( );

// Validates emails
function validEmail($str) {
	return (bool) preg_match('/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*@(?:(?![-.])[-a-z0=9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})(?::\d++)?$/iD', $str);
}

// Function used to add and remove stories from category counts
function categoryitems($catid, $value)
{
	//add or subtract one to the current categories
	//find out current category's parent
	if(is_array($catid)) $cats = $catid;
	else $cats = array($catid);
	$cats = array_filter($cats, "isNumber");
	$catquery = dbquery("SELECT catid, parentcatid, leveldown FROM ".TABLEPREFIX."fanfiction_categories WHERE FIND_IN_SET(catid, '$catid') GROUP BY catid");
	while(isset($catquery)) {
		while($cat = dbassoc($catquery)) {
			$pcats = array();
			if($cat['leveldown'] > 0) $pcats[] = $cat['parentcatid'];
			if(!in_array($cat['catid'], $cats)) $cats[] = $cat['catid'];
		}
		if(count($pcats) > 0) $catquery = dbquery("SELECT catid, parentcatid, leveldown FROM ".TABLEPREFIX."fanfiction_categories WHERE FIND_IN_SET(catid, '".implode($pcats)."') GROUP BY catid");
		else unset($catquery);
	}
	e107::getDb()->gen("UPDATE ".TABLEPREFIX."fanfiction_categories SET numitems = (numitems + $value) WHERE FIND_IN_SET(catid, '".implode(",", $cats)."')");
}

// Function to recurse through categories to build a list of the category and all it's sub-categories.
function recurseCategories($catid) {
 
    $catlist = efiction_categories::catlist();
        
	$$catid = $catlist;
	$categorylist[] = $catid;
	foreach($$catid as $cat => $info) {
		if($info['pid'] == $catid) {
			$categorylist = array_merge($categorylist, recurseCategories($cat));
		}
	}
	return $categorylist;
}

// Captcha script validation
function captcha_confirm() {
	if(!e107::getSession()->is(SITEKEY."_digit")) return false;
	$digit =  e107::getSession()->get(SITEKEY."_digit"); 
	$userdigit = $_POST['userdigit'];
	e107::getSession()->clear(SITEKEY."_digit"); 
	if($digit == md5(SITEKEY.$userdigit) && $userdigit > 1) return true;
	return false;
}





// Call this function when something causes an error and the script has to die.
function errorExit( $msg = ""){
	global $tpl, $output;

	$output .= write_error(_ERROR.(!empty($msg) ? " " : "").$msg);
	$tpl->assign("output", $output);
	//$tpl->xprintToScreen( );
	dbclose( );
	$text = $tpl->getOutputContent(); 
	e107::getRender()->tablerender($caption, $text, $current);
	require_once(FOOTERF); 
	exit;
}
// The next three functions are used to calculate the series reviews and rating
/*
function storiesInSeries($thisseries) {
	$storylist = array( );
	if(!isNumber($thisseries)) return $storylist;
	$serieslist = array( );
	$stinseries = dbquery("SELECT sid, subseriesid FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$thisseries'");
	while($st = dbassoc($stinseries)) { 
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
	$stinseries = dbquery("SELECT subseriesid FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$thisseries'");
	while($st = dbassoc($stinseries)) {
		$serieslist[] = $st['subseriesid']; 
		$serieslist = array_merge($serieslist, subseriesList($st['subseriesid']));
	}
	return $serieslist;
}

function seriesreview($thisseries) {

	if(!isNumber($thisseries)) return;
	$storylist = storiesInSeries($thisseries);
	$serieslist = subseriesList($thisseries);
$newrating = dbquery("SELECT AVG(rating) as totalreviews FROM ".TABLEPREFIX."fanfiction_reviews 
	WHERE ((item = '$thisseries' AND type = 'SE')".
	(count($storylist) > 0 ? " OR (FIND_IN_SET(item, '".(implode(",", $storylist))."') > 0 AND type = 'ST')" : "").
	(count($serieslist) > 0 ? " OR (FIND_IN_SET(item, '".(implode(",", $serieslist))."') > 0 AND type = 'SE')" : "").
	") AND rating != '-1'");
list($totalreviews) = dbrow($newrating);
$newcount = dbquery("SELECT count(reviewid) as totalcount FROM ".TABLEPREFIX."fanfiction_reviews 
	WHERE ((item = '$thisseries' AND type = 'SE')".
	(count($storylist) > 0 ? " OR (FIND_IN_SET(item, '".(implode(",", $storylist))."') > 0 AND type = 'ST')" : "").
	(count($serieslist) > 0 ? " OR (FIND_IN_SET(item, '".(implode(",", $serieslist))."') > 0 AND type = 'SE')" : "").
	") AND review != 'No Review'");
list($totalcount) = dbrow($newcount);
if($totalcount) $update = e107::getDb()->gen("UPDATE ".TABLEPREFIX."fanfiction_series SET rating = '".round($totalreviews)."', reviews = '$totalcount' WHERE seriesid = '$thisseries'");
$parentq = dbquery("SELECT seriesid FROM ".TABLEPREFIX."fanfiction_inseries WHERE subseriesid = '$thisseries' AND seriesid != '$thisseries'");
while($parent2 = dbassoc($parentq)) { seriesreview($parent2['seriesid']); }

}
*/


// Per a suggestion from jrabbit, we'll use this function to optimize some queries 
function findclause($field,$set) {
  if (empty($set)) {
    return "1 = 0";
  }
  if(is_array($set)) $set = implode(",", $set);
  if (strpos($set,',')>0) {
    return "FIND_IN_SET($field,'$set') > 0";
  }
  return "$field='$set'";
}

// Added 3.3
function nl2br2($string) {
	$string = str_replace(array("\r\n", "\r", "\n"), "<br />", $string);
	return $string;
}


// Function to Spam-protect emails.  Is called for the IM fields in the user's profile.
function format_email($text) {
	$search = array('@', '.');
	$replace = array(" [AT] ", " [DOT] ");
	return str_replace($search, $replace, $text);
}

// Function to format a URL into a clickable link
function format_link($text, $title = "", $target = 0) {
	if(empty($title)) $title = $text;
	if(strpos($text, "http://") === false) $text = "http://".$text;
	$text = "<a href='$text'".($target ? " target='_blank'" : "").">$title</a>";
	return $text;
}

// Because this is used in places other than the listings of stories, we're setting it up as a function to be called as needed.
/*
function title_link($stories) {
	global $ratingslist, $ageconsent, $disablepopups;

	$rating = $stories['rid'];
	$warningtext = !empty($ratingslist[$rating]['warningtext']) ? addslashes(strip_tags($ratingslist[$rating]['warningtext'])) : "";
		if(empty($ratingslist[$rating]['ratingwarning']))
			$title = "<a href=\""._BASEDIR."viewstory.php?sid=".$stories['sid']."\">".$stories['title']."</a>";
		else {
			$warning = "";
			$warninglevel = sprintf("%03b", $ratingslist[$rating]['ratingwarning']);
			if($warninglevel[2] && !e107::getSession()->is(SITEKEY."_warned_{$rating}")) {
				$location = "viewstory.php?sid=".$stories['sid']."&amp;warning=$rating";
				$warning = $warningtext;
			}
			if($warninglevel[1] && !$ageconsent && !e107::getSession()->is(SITEKEY."_ageconsent")) {
				$location = "viewstory.php?sid=".$stories['sid']."&amp;ageconsent=ok&amp;warning=$rating";
				$warning = _AGECHECK." - "._AGECONSENT." ".$warningtext." -- 1";
			}
			if($warninglevel[0] && !isMEMBER) {
				$location = "member.php?action=login&amp;sid=".$stories['sid'];
				$warning = _RUSERSONLY." - $warningtext";		
			}
			if(!empty($warning)) {
				$warning = preg_replace("@'@", "\'", $warning);
				$title = "<a href=\"javascript:if(confirm('".$warning."')) location = '"._BASEDIR."$location'\">".$stories['title']."</a>";
			}
			else $title = "<a href=\""._BASEDIR."viewstory.php?sid=".$stories['sid']."\">".$stories['title']."</a>";
		}
	return $title;
}
*/



// Used to truncate text (summaries in blocks for example) to a set length.  An improvement on the old version as this keeps words intact
function truncate_text($str, $n = 75, $delim='...') { 
   $len = strlen($str);
   if($len > $n) {
        $pos = strpos($str, " ", $n);
	if($pos) $str = trim(substr($str, 0, $pos), "\n\t\.,"). $delim;
  }
  return closetags($str);
} 

// A helper function for the truncate_text function.  This will close all open tags
function closetags($html){

  $donotclose=array('br','img','input', 'hr');
  preg_match_all("#<([a-z]+)( .*)?(?!/)>#iU",$html,$result);
  $openedtags=$result[1];

  preg_match_all("#</([a-z]+)>#iU",$html,$result);
  $closedtags=$result[1];
  $len_opened = count($openedtags);
  if(count($closedtags) == $len_opened){
	  return $html;
  }

  $openedtags = array_reverse($openedtags);

  for($i=0;$i < $len_opened;$i++) {

    if (!in_array($openedtags[$i],$closedtags) && !in_array($openedtags[$i], $donotclose)){
      $html .= '</'.$openedtags[$i].'>';
    } 
    else {
      unset($closedtags[array_search($openedtags[$i],$closedtags)]);
    }
  }
  return $html;
}

//  Builds the naughty word list for the site's censor
function build_word($myword) {
	$letters =preg_split('//',$myword, -1, PREG_SPLIT_NO_EMPTY);
	$word = "";
	foreach($letters as $letter) { 
		if($word != "") $word .= "\W+";
		$word .= $letter;
	}
	return $word;

}

// Finds forbidden words in text.  Returns true if a forbidden word is found
function find_naughty($text) {
	global $words;
	if(!count($words)) return false;
	$naughty = 0;
	for($i = 0; $i < sizeof($words); $i++) {
		if(strpos($words[$i], "*") === false) {
			// check for whole word
			if(preg_match('/(\s|^)+(('.$words[$i].')|('.build_word($words[$i]).')+(s|es)?)+(\W|$)+/i', $text, $match)) {
				echo $words[$i] ." 0=".$match[0];
				$naughty = 1; 
			}
		}
		if(strpos($words[$i], "*") !== false && strpos($words[$i], "*") == 0 && !$naughty) {
			// remove the * from the beginning of the word
			$word = substr($words[$i], 1, strlen($words[$i]));
			if(strrpos($word, "*") == strlen($word) - 1) $word = substr($word, 0, strlen($word) - 1);
			// check for whole word plus word as suffix
			if(preg_match('/[\s|^]+\w*('.$word.'|\W'.build_word($word).')+(s|es)?(\W|$)/i', $text, $match)) $naughty = 1; 
		}
		if(strrpos($words[$i], "*") == strlen($words[$i]) - 1 && !$naughty) {
			// remove the * from the end of the word
			$word = substr($words[$i], 0, strlen($words[$i]) - 1);
			if(strpos($word, "*") !== false && strpos($word, "*") == 0) $word = substr($word, 1, strlen($word));
			// check for whole word plus word as prefix
			if(preg_match('/(\s|^)('.$word.'|'.build_word($word).'\W)+\w*(s|es)?(\W|$)/i', $text, $match)) $naughty = 1; 
		}
		if($naughty) break;  // no sense continuing down the list and this will make it run faster
	}
	return $naughty;
}

// Replaces forbidden words in text.  The forbidden word is replaced with the first letter and trailing ***
function replace_naughty($text) {
	global $words;

	if(!count($words)) return $text;
	$i = 0;
	for($j = 0; $j < sizeof($words); $j++) {
		if(strpos($words[$j], "*") === false) {
			$replace[$i] = str_pad($words[$j]{0}, strlen($words[$j]), "*");
			$naughtywords[$i] = '/\b('.$words[$j].'\b)|('.build_word($words[$j]).')\b/i';
			$i++;
		}

		if(strpos($words[$j], "*") !== false && strpos($words[$j], "*") == 0) {
			$word = substr($words[$j], 1, strlen($words[$j]));
			if(strrpos($word, "*") == strlen($word) - 1) $word = substr($word, 0, strlen($word) - 1);
			$naughtywords[$i] = '/(\s|^)+(\w*)+('.$word.'|'.build_word($word).')/i';
			$replace[$i] = "$1$2".str_pad(substr($word, 0, 1), strlen($word), "*");
			$i++;
		}
		if(strrpos($words[$j], "*") == strlen($words[$j]) - 1) {
			$word = substr($words[$j], 0, strlen($words[$j]) - 1);
			if(strpos($word, "*") !== false && strpos($word, "*") == 0) $word = substr($word, 1, strlen($word));
			$replace[$i] = '$1'.str_pad(substr($word, 0, 1), strlen($word), "*").'$3';
			$naughtywords[$i] = '/(.*)('.$word.'|'.build_word($word).')(\s|\w)/i';
			$i++;
		}
	}
	$text = preg_replace($naughtywords, $replace, $text);
	return $text;
}

// Format for messages sent back from various forms and actions 
function write_message($str) {
	return "<div style='text-align: center; margin: 1em;'>$str</div>";
}

// Formats error messages sent back from various forms and actions
function write_error($str) {
	//return "<div style='text-align: center; margin: 1em;' class='errortext'>$str</div>"; 
    return  e107::getMessage()->addError($str)->render();
}



// May be needed for sites that have bridged the authors table
function check_prefs($uid) {
	$test = dbquery("SELECT uid FROM ".TABLEPREFIX."fanfiction_authorprefs WHERE uid = '$uid'");
	if(dbnumrows($test)) return true;
	else return false;
}
 





// Most of the pages that list stories and series use this fuction.  This handles showing the series and stories and pagination of the two together when needed
function search($storyquery, $countquery, $pagelink = "searching.php?", $pagetitle = 0) {
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
		$tpl->assign("stories",  "<div class=\"sectionheader\">"._STORIES."</div>");
		$storyquery .= " LIMIT $offset, $itemsperpage";
		$result3 = e107::getDb()->retrieve($storyquery, true);     
		$count = 0;                     
        foreach($result3 AS $stories) {     
			$tpl->newBlock("storyblock");
			include(_BASEDIR."includes/storyblock.php"); 
		}
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
 

?>