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

if(!function_exists("catlist")) include(_BASEDIR."includes/listings.php");  //this file is not there...
 
$reviewsby_template = e107::getTemplate('efiction', 'user', 'reviewsby');

if(!isset($uid)) {  //why this would be possible?
	$uid = USERUID;
	$output .=  "<div id='pagetitle'>"._YOURREVIEWS."</div>";
	$reviewsby_title = e107::getParser()->parseTemplate($reviewsby_template['usertitle'], true, $var );
}
else {
	/* $authquery = dbquery("SELECT "._PENNAMEFIELD." FROM "._AUTHORTABLE." WHERE "._UIDFIELD." = '$uid'");
	list($penname) = dbrow($authquery); */
	$var['USER_PENNAME'] = $this->sc_user_penname(); 
	$reviewsby_title = e107::getParser()->parseTemplate($reviewsby_template['title'], true, $var); 
	 
}

$reviewcount = e107::getDb()->retrieve("SELECT COUNT(reviewid) AS reviewcount FROM ".TABLEPREFIX."fanfiction_reviews WHERE uid = '$uid' AND review != 'No Review'");
 
 
$reviewsby_start = ''; //use template
$reviewsby_tablerender = varset($reviewsby_template['tablerender'], $current);
$reviewsbyend = '';  //use template
 
$itemsperpage = efiction_settings::get_single_setting('itemsperpage');
 
if($reviewcount) {

   /**********REVIEWS START **************************************************/
    	$count = 0;
        $counter = 0;
    	$reviewsquery =  
        "SELECT rev.*, UNIX_TIMESTAMP(rev.date) as date, "._PENNAMEFIELD." FROM ".TABLEPREFIX."fanfiction_reviews as rev, 
        "._AUTHORTABLE." WHERE rev.uid = "._UIDFIELD." AND rev.uid = '$uid' AND rev.review != 'No Review' ORDER BY type, item LIMIT $offset, $itemsperpage" ;
        $sresult = e107::getDb()->retrieve($reviewsquery, true);
       
        $key = varset($key,'listings');  //supported: reviewblock, todo use full power of e107 templating
        
    	$review_template = e107::getTemplate('efiction', 'review', 'reviewblock');
    	$sc_review = e107::getScBatch('review', 'efiction');
    	$sc_review->wrapper('review/review');
     
        $reviewblock_start = e107::getParser()->parseTemplate($review_template['start'], true, $sc_review);  
        foreach($sresult AS $reviews)  {  
            $reviews['numseries'] = $numseries;
            $reviews['count'] = $count;
            $reviews['sort'] = $_GET['sort'];
            $reviews['offset'] = $offset;
            $reviews['itemsperpage'] = $itemsperpage;
            if($reviews['type'] == 'ST') {
                $stories = e107::getDB()->retrieve(_STORYQUERY." AND sid = '".$reviews['item']."' LIMIT 1");
    			$reviews['authoruid'] = $stories['uid'];
                $reviews['title'] = $stories['title'];
                $reviews['story'] = $stories;
                if($reviews['chapid']) {
				    $chapquery = e107::getDB()->retrieve("SELECT title, inorder FROM ".TABLEPREFIX."fanfiction_chapters WHERE chapid = '".$reviews['chapid']."' LIMIT 1");
				    $reviews['chaptitle'] = $chapquery['title'];
                    
				    $reviews['chapnum'] = $chapquery['inorder'];
			    }
            }
            elseif($reviews['type'] == 'SE') {
                $stories = e107::getDB()->retrieve(_SERIESQUERY." AND seriesid = '".$reviews['item']."' LIMIT 1");
                $reviews['authoruid'] = $stories['uid'];
                $reviews['title'] = $stories['title'];
                $reviews['serie'] = $stories;
            }
            else {
            	$codeblocks = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_codeblocks WHERE code_type = 'reviewsby'");
    			while($code = dbassoc($codeblocks)) {
    				eval($code['code_text']);
    			}
            }
            
            $sc_review->setVars($reviews);
            $reviewblock .= e107::getParser()->parseTemplate($review_template['item'], true, $sc_review);
            $count++;
        }
        $reviewblock_end  = e107::getParser()->parseTemplate($review_template['end'], true, $sc_review);
        $reviewblocks =  $reviewblock_start.$reviewblock.$reviewblock_end;
     
        /********** REVIEWS END ***************************************************/
         $output = $reviewblocks; 
    }
    else $output .= write_message(_NORESULTS);
    
    $output = e107::getRender()->tablerender($reviewby_title, $reviewblocks, $reviewby_tablerender, true); 

 // delete 
 /*
	foreach ($revquery as $reviews) {
		if(empty($lastreview)) $lastreview = array('type' => '', 'item' => '');
		$adminlink = "";
		$reviewblock_start = $user_template['start'];
		$reviewblock_item  = $reviewblock_template['item']; 
 

 
		$reviews['chapter'] = (isset($chaptitle) ? _CHAPTER." $chapnum: $chaptitle" : (!empty($stories['title']) ? $stories['title'] : _NONE));
		$reviews['chapternumber'] = isset($chapnum) ? $chapnum : "";
		$reviews['oddeven'] = ($counter % 2 ? "odd" : "even");
		$reviews['adminoptions'] = (!empty($adminlink)) ? "<div class=\"adminoptions\">$adminlink</div>" : "";
 
		$sc_reviewblock = e107::getScBatch('reviewblock', 'efiction');
		$sc_reviewblock->wrapper('reviewblock/review');
		$sc_reviewblock->setVars($reviews);
		
		$reviewblock_items .= e107::getParser()->parseTemplate($reviewblock_item, true, $sc_reviewblock );
		$counter++;
		$lastreview = $reviews;
	}

	$reviewblock_end = $user_template['end'];

	$reviewblock_tablerender = varset($user_template['tablerender'], 'review');
	 
	$content = $reviewblock_start.$reviewblock_items.$reviewblock_end;
	$output = e107::getRender()->tablerender('', $reviewblock_title. $content, $reviewblock_tablerender, true); 
}
else {
	$output .= write_message(_NORESULTS);
}

*/

 

/* 
	if($reviewcount > $itemsperpage) {
		$tpl->gotoBlock("_ROOT");
		$tpl->newBlock("listings");
		$tpl->assign("pagelinks", build_pagelinks(e_PAGE."?action=reviewsby&amp;uid=$uid&amp;", $reviewcount, $offset));
	}		
 	 
*/