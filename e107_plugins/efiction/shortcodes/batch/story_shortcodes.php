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

/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * e107 efiction Plugin
 *
 * #######################################
 * #     e107 website system plugin      #
 * #     by Jimako                    	 #
 * #     https://www.e107sk.com          #
 * #######################################
 */

/*
{oddeven} - {STORY_ODDEVEN}
{title} - {STORY_TITLE}
{author} - {STORY_AUTHOR}
{rating} - {STORY_RATING}
{roundrobin} - {STORY_ROUNDROBIN}
{score} - {STORY_SCORE}
{reviews} - {STORY_REVIEWS}
{numreviews} - {STORY_NUMREVIEWS}
{new} - {STORY_NEW} 
{featuredstory} - {STORY_FEATUREDSTORY}
{summary} - {STORY_SUMMARY}
{category} - {STORY_CATEGORY}
{characters} - {STORY_CHARACTERS}
{classifications} - {STORY_CLASSIFICATIONS}
{serieslinks} - {STORY_SERIESLINKS}
{numchapters} -{STORY_NUMCHAPTERS}
{toc} - {STORY_TOC}
{completed} - {STORY_COMPLETED} 
{wordcount} - {STORY_WORDCOUNT}
{count} - {STORY_COUNT}
{adminlinks} - {STORY_ADMINLINKS}
{addtofaves} - {STORY_ADDTOFAVES}
{reportthis} - {STORY_REPORTTHIS}
{published} - {STORY_PUBLISHED} 
{updated} - {STORY_UPDATED}
{comment} - {STORY_COMMENT}

{storynotes} - {STORY_STORYNOTES}
{notes} - {STORY_NOTES} 
{printicon} 
{textsizer}
{jumpmenu}
{endnotes} - {STORY_ENDNOTES}
{prev}
{next}
{story}
*/


    class plugin_efiction_story_shortcodes extends e_shortcode
    {
        public function __construct()
        {
  
        
        }
        
        /* {STORY_ADDTOFAVES} {addtofaves} */
        public function sc_story_addtofaves($parm = null)
    	{
        
        /*
        if(isMEMBER && !empty($favorites)) 
		$tpl->assign("addtofaves", "[<a href=\"member.php?action=favst&amp;add=1&amp;sid=".$stories['sid']."\">"._ADDSTORY2FAVES."</a>] 
        [<a href=\"member.php?action=favau&amp;add=".$stories['uid'].(count($stories['coauthors']) ? ",".implode(",", array_keys($stories['coauthors'])) : "")."\">"._ADDAUTHOR2FAVES."</a>]");
        */
        
  		$favorites =  efiction_settings::get_single_setting('favorites');
          if(isMEMBER && $favorites) {
      		$addtofaves = "[<a href=\"member.php?action=favst&amp;uid=".USERUID."&amp;add=".$this->var['sid']."\">"._ADDSTORY2FAVES."</a>]";
      		if($this->var['isopen'] < 2) {
      			$addtofaves .= " [<a href=\"member.php?action=favau&amp;add=".$this->var['uid'].(count($this->var['coauthors']) ? ",".implode(",", array_keys($this->var['coauthors'])) : "")."\">"._ADDAUTHOR2FAVES."</a>]";
      		}
          }
          return $addtofaves; 
        }
        
        /* {STORY_ADMINLINKS} {adminlinks} */
        public function sc_story_adminlinks($parm = null)
    	{
            $stories = $this->var;
            $chapters = $this->sc_story_numchapters();
          	if((isADMIN && uLEVEL < 4) || USERUID == $stories['uid'] || (is_array($stories['coauthors']) && array_key_exists(USERUID, $stories['coauthors']))) {
		    $adminlinks .= "[<a href=\"stories.php?action=editstory&amp;sid=".$stories['sid'].(isADMIN ? "&amp;admin=1" : "")."\">"._EDIT."</a>] 
            [<a href=\"stories.php?action=delete&amp;sid=".$stories['sid'].(isADMIN ? "&amp;admin=1" : "")."\">"._DELETE."</a>]";
            $adminlinks .= 
            "[<a href=\"stories.php?action=newchapter&amp;sid=".$stories['sid']."&amp;inorder=$chapters".(isADMIN ?  '&amp;admin=1&amp;uid='.$stories['uid'] : '').'">'._ADDNEWCHAPTER."</a>]";
            }
            
            if($stories['featured'] == 1) {
        		if(isADMIN && uLEVEL < 4) $adminlinks .= " ["._FEATURED.": <a href=\"admin.php?action=featured&amp;retire=".$stories['sid']."\">"._RETIRE."</a> | <a href=\"admin.php?action=featured&amp;remove=".$stories['sid']."\">"._REMOVE."</a>]";
        	}
        	else if($stories['featured'] == 2) {
        		if(isADMIN && uLEVEL < 4) $adminlinks .= " [<a href=\"admin.php?action=featured&amp;remove=".$stories['sid']."\">"._REMOVE."</a>]";
        	}
        	else if(isADMIN && uLEVEL < 4) $adminlinks .= " [<a href=\"admin.php?action=featured&amp;feature=".$stories['sid']."\">"._FEATURED."</a>]";
  
  
            if(isADMIN && uLEVEL < 4) $text = "<div class=\"adminoptions\"><span class='label'>"._ADMINOPTIONS.":</span> ".$adminlinks."</div>";
	        else if(isMEMBER && (USERUID == $stories['uid'] || array_key_exists(USERUID, $stories['coauthors']))) 
        	$text = "<div class=\"adminoptions\"><span class='label'>"._OPTIONS.":</span> ".$adminlinks."</div>";
    
          return $text;     
        }
        
         /* {STORY_ADMINLINKS_VALIDATE} {adminlinks} in validate.php */
        public function sc_story_adminlinks_validate($parm = null)
    	{
            $stories = $this->var;
            
            $adminlinks = "<div class=\"adminoptions\">
              <span class='label'>"._ADMINOPTIONS.":</span> 
              <a class='btn btn-sm btn-success' href=\"admin.php?action=validate&amp;sid=$stories[sid]&amp;chapid=$stories[chapid]&amp;validate=yes\">"._VALIDATE."</a> | 
              "._EDIT." - <a class='btn btn-sm btn-outline-warning' href=\"stories.php?action=editstory&amp;sid=$stories[sid]&amp;admin=1\">"._STORY."</a> "._OR." 
              <a class='btn btn-sm btn-warning' href=\"stories.php?action=editchapter&amp;chapid=$stories[chapid]&amp;admin=1\">"._CHAPTER."</a> | "._DELETE." - 
              <a class='btn btn-sm btn-outline-danger' href=\"stories.php?action=delete&amp;sid=$stories[sid]\">"._STORY."</a> "._OR." 
              <a class='btn btn-sm btn-danger' href=\"stories.php?action=delete&amp;chapid=$stories[chapid]&amp;sid=$stories[sid]&amp;admin=1&amp;uid=$stories[uid]\">"._CHAPTER."</a> | 
              <a class='btn btn-sm btn-outline-info' href=\"javascript:pop('admin.php?action=yesletter&amp;uid=$stories[uid]&amp;chapid=$stories[chapid]', 400, 350, 'yes')\">"._YESLETTER."</a> | 
              <a class='btn btn-sm btn-secondary' href=\"javascript:pop('admin.php?action=noletter&amp;uid=$stories[uid]&amp;chapid=$stories[chapid]',400, 350, 'yes')\">"._NOLETTER."</a></div>";
		    
            return $adminlinks;
        
        /*
        $output .= "<td><a class='btn btn-sm btn-success'  href=\"admin.php?action=validate&amp;chapid=$story[chapid]\">"._VALIDATE."</a><br />"._DELETE.": 
            <a class='btn btn-sm btn-danger' href=\"stories.php?action=delete&amp;chapid=$story[chapid]&amp;sid=$story[sid]&amp;admin=1&amp;uid=$story[uid]\">"._CHAPTER2."</a> "._OR." 
            <a class='btn btn-sm btn-danger' href=\"stories.php?action=delete&amp;sid=$story[sid]&amp;admin=1\">"._STORY2."</a>
            <br /><a  class='btn btn-sm btn-info'  href=\"javascript:pop('".SITEURL."admin.php?action=yesletter&uid=$story[uid]&chapid=$story[chapid]', 600, 500, 'yes')\">"._YESLETTER."</a> | 
            <a class='btn btn-sm btn-secondary' href=\"javascript:pop('admin.php?action=noletter&uid=$story[uid]&chapid=$story[chapid]', 600, 500, 'yes')\">"._NOLETTER."</a>
            */
            
            $chapters = $this->sc_story_numchapters();
          	if((isADMIN && uLEVEL < 4) || USERUID == $stories['uid'] || (is_array($stories['coauthors']) && array_key_exists(USERUID, $stories['coauthors']))) {
		    $adminlinks .= "[<a href=\"stories.php?action=editstory&amp;sid=".$stories['sid'].(isADMIN ? "&amp;admin=1" : "")."\">"._EDIT."</a>] 
            [<a href=\"stories.php?action=delete&amp;sid=".$stories['sid'].(isADMIN ? "&amp;admin=1" : "")."\">"._DELETE."</a>]";
            $adminlinks .= 
            "[<a href=\"stories.php?action=newchapter&amp;sid=".$stories['sid']."&amp;inorder=$chapters".(isADMIN ?  '&amp;admin=1&amp;uid='.$stories['uid'] : '').'">'._ADDNEWCHAPTER."</a>]";
            }
            
            if($stories['featured'] == 1) {
        		if(isADMIN && uLEVEL < 4) $adminlinks .= " ["._FEATURED.": <a href=\"admin.php?action=featured&amp;retire=".$stories['sid']."\">"._RETIRE."</a> | <a href=\"admin.php?action=featured&amp;remove=".$stories['sid']."\">"._REMOVE."</a>]";
        	}
        	else if($stories['featured'] == 2) {
        		if(isADMIN && uLEVEL < 4) $adminlinks .= " [<a href=\"admin.php?action=featured&amp;remove=".$stories['sid']."\">"._REMOVE."</a>]";
        	}
        	else if(isADMIN && uLEVEL < 4) $adminlinks .= " [<a href=\"admin.php?action=featured&amp;feature=".$stories['sid']."\">"._FEATURED."</a>]";
  
  
            if(isADMIN && uLEVEL < 4) $text = "<div class=\"adminoptions\"><span class='label'>"._ADMINOPTIONS.":</span> ".$adminlinks."</div>";
	        else if(isMEMBER && (USERUID == $stories['uid'] || array_key_exists(USERUID, $stories['coauthors']))) 
        	$text = "<div class=\"adminoptions\"><span class='label'>"._OPTIONS.":</span> ".$adminlinks."</div>";
    
          return $text;     
        }       
        
        
        /* {STORY_AUTHOR} {author} */
        public function sc_story_author($parm = null)
    	{
          $stories = $this->var;
          if ($stories['coauthors'] > 0) {
              $authlink[] = '<a href="'.e_HTTP.'viewuser.php?uid='.$stories['uid'].'">'.$stories['penname'].'</a>';
              $coauth_query = 'SELECT '._PENNAMEFIELD.' as penname, co.uid FROM #fanfiction_coauthors AS co LEFT JOIN '._AUTHORTABLE.' ON co.uid = '._UIDFIELD." WHERE co.sid = '".$stories['sid']."'" ;

              $records = e107::getDb()->retrieve($coauth_query, true);

              foreach ($records as $coauth) {
                  $v = $coauth['penname'];
                  $k = $coauth['uid'];
                  $authlink[] = '<a href="'.e_HTTP.'viewuser.php?uid='.$k.'">'.$v.'</a>';
              }
          }
          if (isset($authlink)) {
              return implode(', ', $authlink);
          } else {
              return '<a href="'.e_HTTP.'viewuser.php?uid='.$stories['uid'].'">'.$stories['penname'].'</a>';
          }
          return $text;     
        }
        
        /* {STORY_AUTHOR_LINK} TODO: TEMPLATE */

        public function sc_story_author_link($parm)
        {
             return $this->sc_story_author();
        }
        
         /* {STORY_AUTHOR_NAME} {author} */
        public function sc_story_author_name($parm = null)
    	{
          $stories = $this->var;
          if ($stories['coauthors'] > 0) {
              $authlink[] =  $stories['penname'] ;
              $coauth_query = 'SELECT '._PENNAMEFIELD.' as penname, co.uid FROM #fanfiction_coauthors AS co LEFT JOIN '._AUTHORTABLE.' ON co.uid = '._UIDFIELD." WHERE co.sid = '".$stories['sid']."'" ;

              $records = e107::getDb()->retrieve($coauth_query, true);

              foreach ($records as $coauth) {
                  $v = $coauth['penname'];
                  $authlink[] =  $v ;
              }
          }
          if (isset($authlink)) {
              return implode(', ', $authlink);
          } else {
              return $stories['penname'];
          }
          return $text;     
        }
        
        /* {STORY_AUTHOR_NAME_SHORT} */
        public function sc_story_author_name_short($parm = null)
    	{
          $stories = $this->var;
          $text = $stories['penname'];
          if ($stories['coauthors'] > 0) {
            $text .= " + ". LAN_OTHERS ;
          } 
  
          return $text;     
        }
              
        
        /* {STORY_CATEGORY} {category} */
        public function sc_story_category($parm = null)
    	{
            $catlist = efiction_categories::catlist();
            $category =    $this->var['catid'] == '-1' || !$this->var['catid'] ? _NONE :  $catlist[$this->var['catid']]['name'] ;
            //serie:  $category = $this->var['catid'] ? catlist($this->var['catid']) : _NONE;
            
             return $category;
        }
        /* {STORY_CHARACTERS} {characters} */
        public function sc_story_characters($parm = null)
    	{
 
           // $characters = $this->var['charid'] ? charlist($this->var['charid']) : _NONE;
            $characters =  e107::getSingleton('efiction_characters')->get_charlist($this->var['charid']);
            return $characters;   
        }
        
        /* {STORY_CLASSIFICATIONS} {classifications} */
        public function sc_story_classifications($parm = null)
    	{
            $classlist = efiction_classes::classlist();
		    $classtypelist = efiction_classes::classtypelist();
            $start = $center = $end = '';
            if($parm['type'] == "dl") {
             $start = '<dt class="col-sm-3">';
             $center = '</dt><dt class="col-sm-9">';
             $end = "</dt>";
            }
            $stories = $this->var;  
        	$allclasslist = "";
        	if($stories['classes']) {
        		unset($storyclasses);
        		foreach(explode(",", $stories['classes']) as $c) {
        			$storyclasses[$classlist["$c"]['type']][] = "<a href='browse.php?type=class&amp;type_id=".$classlist["$c"]['type']."&amp;classid=$c'>".$classlist[$c]['name']."</a>";
        		}
        	}
        	foreach($classtypelist as $num => $c) {
        		if(isset($storyclasses[$num])) {
        			 $c['name'] = implode(", ", $storyclasses[$num]);
        			$allclasslist .= "{$start}<span class='label'>".$c['title'].": </span>{$center} ".implode(", ", $storyclasses[$num])."<br />{$end}";
        		}
        		else {
        			$c['name'] = _NONE;
        			$allclasslist .= "{$start}<span class='label'>".$c['title'].": </span> {$center}"._NONE."<br />{$end}";
        		}
        	}
    
        $classification = $allclasslist;
        return $classification;
       }
        /* {STORY_COMPLETED} {completed} */
        public function sc_story_completed($parm = null)
    	{
          $text = ($this->var['completed'] ? _YES : _NO);   
          return $text;     
        }
        /* {STORY_COMMENT} {comment} */ 
        public function sc_story_comment($parm = null)
    	{
          $text = $this->var['comment'];   
          return $text;     
        }
        /* {STORY_COUNT} {count}  */
        public function sc_story_count($parm = null)
    	{
          return $this->var['count'] ? $this->var['count'] : "0" ;
       
        }
        
        
        /* {STORY_ENDNOTES} {endnotes} */
        public function sc_story_endnotes($parm = null)
    	{
            $text = '';
            if(!empty($this->var['endnotes'])) 
            {
                $text = e107::getParser()->toHTML($this->var['endnotes'], true, 'BODY');
            }
            return $text;
             
        } 
        
        /* {STORY_FEATUREDTEXT}  } */
        public function sc_story_featuredtext($parm = null)
    	{
          global $featured;
          $stories = $this->var;
        	if($stories['featured'] == 1) {
        		$featuredtext = _FSTORY;
 
        	}
        	else if($stories['featured'] == 2) {
        		$featuredtext = _PFSTORY;
        	}
          return $featuredtext;     
        }
        
        /* {STORY_FEATUREDSTORY} {featuredstory} */
        public function sc_story_featuredstory($parm = null)
    	{
          global $featured;
          $stories = $this->var;
        	if($stories['featured'] == 1) {
        		$featuredstory = (isset($featured) ? $featured : "<img src=\""._BASEDIR."images/blueribbon.gif\" class=\"featured\" alt=\""._FSTORY."\">");
        		 
 
        	}
        	else if($stories['featured'] == 2) {
        		$featuredstory = (isset($retired) ? $retired : "<img src=\""._BASEDIR."images/redribbon.gif\"align=\"left\" class=\"retired\" alt=\""._PFSTORY."\">");
        		 
        	}
          return $featuredstory;     
        }
        /* {STORY_NUMCHAPTERS} {numchapters} */
        public function sc_story_numchapters($parm = null)
    	{
    
          $stories = $this->var;
          $numchapters = e107::getDb()->retrieve("SELECT count(sid) AS numchapters FROM ".TABLEPREFIX."fanfiction_chapters WHERE sid = '".$stories['sid']."' AND validated > 0"); 
 
          $text = $this->var['numchapters'];   
          return $numchapters;     
        }
        /* {STORY_NUMREVIEWS} {numreviews} */
        public function sc_story_numreviews($parm = null)
    	{
  
          $reviewsallowed =  efiction_settings::get_single_setting('reviewsallowed');
          $text = $reviewsallowed == "1" ? "<a href=\"reviews.php?type=ST&amp;item=".$this->var['sid']."\">".$this->var['reviews']."</a>" : "" ;   
          return $text;     
        }
        /* {STORY_NEW} {new}  */
        public function sc_story_new($parm = null)
    	{
        	$new =  efiction_settings::get_single_setting('new');
            $recentdays =  efiction_settings::get_single_setting('recentdays');
            if(!empty($recentdays)) {
        		$recent = time( ) - ($recentdays * 24 * 60 *60);
             
        		if($this->var['updated'] > $recent) $new =  '<span class="badge bg-success fs-6">'._NEW.'</span>' ;
        	}
   
          return $new;     
        }
        /* {STORY_ODDEVEN} {oddeven} */
        public function sc_story_oddeven($parm = null)
    	{
  
          $text = ($this->var['count'] % 2 ? "odd" : "even");   
          return $text;     
        }
        /* {STORY_PUBLISHED} {published} */
        public function sc_story_published($parm = null)
    	{
          $dateformat =  efiction_settings::get_single_setting('dateformat');          
          $published = date("$dateformat", $this->var['date']); 
          return $published;       
        }
        /* {STORY_REPORTTHIS} {reportthis} */
        public function sc_story_reportthis($parm = null)
    	{
          $text = "<a class=\"btn btn-light\" href=\"report.php?action=report&amp;url=viewstory.php?sid=".$this->var['sid']."\">"._REPORTTHIS."</a>" ; 
          return $text;     
        }
        /* {STORY_RATING} {rating} */
        public function sc_story_rating($parm = null)
    	{
           $ratingslist = efiction_ratings::get_ratings_list();
           return  $ratingslist[$this->var['rid']];  
            
        }
        
        /* {STORY_RATINGPICS} {ratingpics} */
        public function sc_story_ratingpics($parm = null)
    	{
           global $ratings, $like, $dislike, $star, $halfstar;
 
           $text = ratingpics($this->var['rating']);
           return  $text;  
            
        }        
        
        /* {STORY_REVIEWS} {reviews} */
        public function sc_story_reviews($parm = null)
    	{
          $reviewsallowed =  efiction_settings::get_single_setting('reviewsallowed');
          $text = ($reviewsallowed ? "<a href=\"reviews.php?type=ST&amp;item=".$this->var['sid']."\">"._REVIEWS."</a>" : "");
          return $text;     
        }
        /* {STORY_ROUNDROBIN} {roundrobin} */
        public function sc_story_roundrobin($parm = null)
    	{
          $roundrobin = efiction_settings::get_single_setting('roundrobin');
          $text = $this->var['roundrobin'];   
          $text =  ($this->var['rr'] ?  (!empty($roundrobin) ? $roundrobin : "<img src=\""._BASEDIR."images/roundrobin.gif\" alt=\""._ROUNDROBIN."\">") : "");
          return $text;     
        }
        /* {STORY_SCORE} {score} */
        public function sc_story_score($parm = null)
    	{
            $reviewsallowed =  efiction_settings::get_single_setting('reviewsallowed');
            $anonreviews   =  efiction_settings::get_single_setting('anonreviews');
            if($reviewsallowed && (isMEMBER || $anonreviews)) {
                $score = ratingpics($this->var['rating']);
            }
            else $score = "-";
            return $score;  
        }
        
        /* {STORY_SERIESLINKS} {serieslinks} */
        public function sc_story_serieslinks($parm = null)
    	{
     	    $action = $this->var['action'];
            $seriesquery = "SELECT series.* FROM ".TABLEPREFIX."fanfiction_inseries as list, ".TABLEPREFIX."fanfiction_series as series WHERE list.sid = '".$stories['sid']."' AND series.seriesid = list.seriesid";
          	$seriesresult = e107::getDb()->retrieve($seriesquery, true);
          	$serieslinks = array( );
            foreach($seriesresult  AS $s) {
           
          		if(isset($action) && $action == "printable") $serieslinks[] = stripslashes($s['title']);
          		else $serieslinks[] = "<a href=\"viewseries.php?seriesid=".$s['seriesid']."\">".stripslashes($s['title'])."</a>";
          	}
            $serieslinks =  count($serieslinks) > 0 ? implode(", ", $serieslinks) : _NONE  ;
  
            return $serieslinks ;     
        }
        
        
        /* {STORY_NOTES} {notes} */
        public function sc_story_notes($parm = null)
    	{
            $text = '';
            if($this->var['inorder'] == 1 && !empty($this->var['notes'])) 
            {
                $text = e107::getParser()->toHTML($this->var['notes'], true, 'BODY');
            }
            return $text;
             
        }        
        
        
        /* {STORY_STORYNOTES} {storynotes} */
        public function sc_story_storynotes($parm = null)
    	{
            $text = '';
            if($this->var['inorder'] == 1 && !empty($this->var['storynotes'])) 
            {
                $text = e107::getParser()->toHTML($this->var['storynotes'], true, 'BODY');
            }
            return $text;
             
       }
             
        /* {STORY_SUMMARY} {summary} */
        // ex. {STORY_SUMMARY: limit=100}
        // ex. {STORY_SUMMARY: limit=full}
        public function sc_story_summary($parm = null)
    	{
            $stories = $this->var;
             
            $text = e107::getParser()->toHTML($this->var['summary'], true, 'BODY');
 
            $limit = ($stories['sumlength'] > 0 ? $stories['sumlength'] : 75);  
            if (!empty($parm['limit'])) {
                $limit = $parm['limit'];
            }
            if ($limit == 'full') {
                return $text;
            } else {
                // $text = e107::getParser()->truncate($text, $limit); see issue https://github.com/e107inc/e107/issues/4480 
                $text = efiction_core::truncate_text($text, $limit); //FIX THIS
                return $text;
            }
        }
        
        
         /* {STORY_STORYTEXT} {story} */
        public function sc_story_storytext($parm = null)
    	{
            $store = efiction_settings::get_single_setting('store');
            $storiespath = efiction_settings::get_single_setting('storiespath');
            
            if($store == "files")
    		{
    			$file = STORIESPATH."/$this->var[uid]/$this->var[chapid].txt";
    			$log_file = fopen($file, "r");
    			$file_contents = fread($log_file, filesize($file));
    			$storytext = $file_contents;
    			fclose($log_file);
    		}
    		else if($store == "mysql")
    		{
    			$storytext = $this->var['storytext'];
    		}
    		$storytext = format_story($storytext);
        
            return $storytext; 
        }       
   

        
        /* {STORY_TOC} {toc} */
        public function sc_story_toc($parm = null)
    	{
          $text = "<a href=\"viewstory.php?sid=".$this->var['sid']."&amp;index=1\">"._TOC."</a>"; 
          return $text;     
        }
        /* {STORY_UPDATED} {updated}  */
        public function sc_story_updated($parm = null)
    	{
          $dateformat =  efiction_settings::get_single_setting('dateformat');          
          $updated = date("$dateformat", $this->var['updated']); 
          return $updated;     
        } 
        /* {STORY_WORDCOUNT} {wordcount} */
        public function sc_story_wordcount($parm = null)
    	{
          return $this->var['wordcount'] ? $this->var['wordcount'] : "0" ;  
          
        }

		/* {STORIESBY_PAGELINKS} */
		public function sc_storiesby_pagelinks($parm)
		{
		    $uid = (int) $_GET['uid'];
   
			$pagelinks = '';
				if($this->var['numstories'] > $this->var['itemsperpage'] ) {
				/*
				if($numstories > $itemsperpage) $tpl->assign("pagelinks", build_pagelinks("viewuser.php?action=storiesby&amp;uid=$uid".(isset($_GET['sort']) ? ($_GET['sort'] == "alpha" ? "&amp;sort=alpha" : "&amp;sort=update") : "")."&amp;", $numstories, $offset));
				*/

				$link = "viewuser.php?action=storiesby&amp;uid=$uid".(isset($_GET['sort']) ? ($_GET['sort'] == "alpha" ? "&amp;sort=alpha" : "&amp;sort=update") : "");

				$pagelinks = efiction::build_pagelinks($link."&amp;",  $this->var['numstories'], $this->var['offset'], 1, 'bootstrap4' );
			 
				return $pagelinks;
			}
		} 
        
        /* {STORIESBY_SORT} */
          public function sc_storiesby_sort($parm = null)
      	{
      		$action = $this->var['action'];
      		$uid = $this->var['uid'];
      		//	<label for=\"sort\">"._SORT.":</label> 
      		$sort = "<form name=\"sort\" action=\"\">
      	
      		<select class=\"select2-simple\" name=\"sort\" class=\"textbox\" onchange=\"if(this.selectedIndex.value != 'false') document.location = document.sort.sort.options[document.sort.sort.selectedIndex].value\">
      		<option value=\"false\">"._SORT."</option>";
      		$sort .= "<option value=\"viewuser.php?".($action ? "action=".$action : "")."uid=$uid&amp;sort=alpha\">"._ALPHA."</option>";
      		$sort.= "<option value=\"viewuser.php?".($action ? "action=".$action : "")."uid=$uid&amp;sort=update\">"._MOSTRECENT."</option></select></form>";
      		
      		return $sort;
       
          }




        /* {STORY_TITLE} {title}  */
        public function sc_story_title($parm = null)
    	{
          $text = $this->var['title'];   
          return $text;     
        }

        
        
        /* {STORY_TITLE_LINK} */
        /* TODO: sessions */
        public function sc_story_title_link($parm = NULL)
        {
            global $ageconsent, $disablepopups;
            
            $tp = e107::getParser();
            $stories = $this->var;
            
            $class =  varset($parm['class'],"viewstory");
            
            $link = $this->title_link($stories, $parm );
            
           $title = "<a class='".$class."' href='".$link."'>".$stories['title']."</a>";
            
            return $title;
  
        }

        
        /* {STORY_TITLE_URL} */
        public function sc_story_title_url($parm = NULL)
        {
          $stories = $this->var;
          $link = $this->title_link($stories, $parm );
          return $link;
        }
        
        
        /* {STORY_RATING_NAME} */
        public function sc_story_rating_name($parm)
        {
            $stories = $this->var;
     
            $ratingslist = efiction_ratings::get_ratings_list(); 
               
            $rating_name = $ratingslist[$stories['rid']]['name']; 
            return $rating_name;
            
            return '';
        }
        
    /* {STORY_IMAGE} */
    public function sc_story_image($parm)
    {
        $story_image = $this->var['image'];
        
        if ($story_image) {
            $src =  e107::getParser()->replaceConstants($story_image, 'full');
            return $src;
        }
 
        else {
           $sitetheme = e107::getPref('sitetheme');
           $path = e_THEME_ABS.$sitetheme.'/' ;
           $src = $path."images/nobanner.jpg";
           $icon = e107::getParser()->parseTemplate($src, true);  
        }      	 
        return $src; 
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
 
        	//return $title;
            return $link;
        }
        
        
  
    }
