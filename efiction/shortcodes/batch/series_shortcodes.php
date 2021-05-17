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

class plugin_efiction_series_shortcodes extends e_shortcode
{
	public function __construct()
	{
	}
    
    
    /* {SERIES_ADDTOFAVES} */
	public function sc_series_addtofaves($parm = null)
	{
		$favorites =  efiction::settings('favorites');
        if(isMEMBER && $favorites) {
    		$addtofaves = "[<a href=\"member.php?action=favse&amp;uid=".USERUID."&amp;add=".$this->var['seriesid']."\">"._ADDSERIES2FAVES."</a>]";
    		if($this->var['isopen'] < 2) {
    			$addtofaves .= " [<a href=\"viewuser.php?action=favau&amp;uid=".USERUID."&amp;author=".$this->var['uid']."\">"._ADDAUTHOR2FAVES."</a>]";
    		}
        }
        return $addtofaves;
	} 
    
    
    
    /* {SERIES_CATEGORY} */
	public function sc_series_category($parm = null)
	{
		$category = $this->var['catid'] ? catlist($this->var['catid']) : _NONE;
        return $category;
	}
    
    /* {SERIES_CHARACTERS} */
	public function sc_series_characters($parm = null)
	{
		$characters = $this->var['characters'] ? charlist($this->var['characters']) : _NONE;
        return $characters;
	}
    
    /* {SERIES_CLASSIFICATIONS} */
	public function sc_series_classifications($parm = null)
	{
            $classlist = efiction::classlist();
		    $classtypelist = efiction::classtypelist();
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
    
    /* {SERIES_SERIESHEADER} */
	public function sc_series_seriesheader($parm = null)
	{
	 
		return $seriesheader;
	}
	
    /* {SERIES_ODDEVEN} */
	public function sc_series_oddeven($parm = null)
	{
        if(!isset($this->var['count'])) $this->var['count'] = 0;
        $oddeven =  ($this->var['count'] % 2 ? "odd" : "even");
		return $oddeven;
	}
 
    
    /* {SERIES_LINK} */
	public function sc_series_link($parm)
	{
		$text = "viewseries.php?seriesid=".$this->var['seriesid'];
		return $text;
	}

    /* {SERIES_SUBMITREVIEWS} not used */
	public function sc_series_submitreviews($parm = null)
	{
 
        $reviewsallowed =  efiction::settings('reviewsallowed');
        $anonreviews   =  efiction::settings('anonreviews');
        
        if($reviewsallowed && (isMEMBER || $anonreviews)) {
           $numreviews =  "[<a href=\"reviews.php?action=add&amp;type=SE&amp;item=".$this->var['seriesid']."\">"._SUBMITREVIEW."</a>]";
        }
    	return $numreviews;
	}  
    
    /* {SERIES_NUMREVIEWS} */
	public function sc_series_numreviews($parm = null)
	{
		$numreviews = '';
        $reviewsallowed =  efiction::settings('reviewsallowed');
        $anonreviews   =  efiction::settings('anonreviews');
        
        if($reviewsallowed && (isMEMBER || $anonreviews)) {
           $numreviews =  "<a href=\"reviews.php?type=SE&amp;item=".$this->var['seriesid']."\">".$this->var['reviews']."</a>";
        }
    	return $numreviews;
	}      
    
    /* {SERIES_NUMSTORIES} */
	public function sc_series_numstories($parm = null)
	{  
        $numstories = $this->var['numstories'];
        return $numstories;
	}
    
    /* {SERIES_PARENTSERIES} */
	public function sc_series_parentseries($parm = null)
	{
 
     	$parents = e107::getDb()->retrieve("SELECT s.title, s.seriesid FROM #fanfiction_inseries as i, 
         #fanfiction_series as s WHERE s.seriesid = i.seriesid AND i.subseriesid = '".$this->var['seriesid']."'", true);
 
    	$plinks = array( );
    	foreach($parents AS $p) {
    		$plinks[] = "<a href=\"viewseries.php?seriesid=".$p['seriesid']."\">".$p['title']."</a>";
    	}
    	$parentseries = count($plinks) ? implode(", ", $plinks) : _NONE;
        return $parentseries;
	}      
    
    /* {SERIES_REVIEWS} */
	public function sc_series_reviews($parm = null)
	{
		$reviews = '';
        $reviewsallowed =  efiction::settings('reviewsallowed');
        $anonreviews =  efiction::settings('anonreviews');
        
        if($reviewsallowed && (isMEMBER || $anonreviews)) {
             $reviews =  "<a href=\"reviews.php?type=SE&amp;item=".$this->var['seriesid']."\">"._REVIEWS."</a>";
        }
        return $reviews;
	}        
 
	/* {SERIES_SCORE} */
	public function sc_series_score($parm = null)
	{
        $reviewsallowed =  efiction::settings('reviewsallowed');
        $anonreviews   =  efiction::settings('anonreviews');
        if($reviewsallowed && (isMEMBER || $anonreviews)) {
            $score = ratingpics($this->var['rating']);
        }
    	return $score;
	} 
	/* {SERIES_RATING}   */
	public function sc_series_rating($parm = null)
	{
        $ratingslist = efiction::get_ratings_list();
        return  $ratingslist[$this->var['rid']];  
	} 
    
    
    /* {SERIES_SUMMARY}
    {SERIES_SUMMARY: limit=100}
    {SERIES_SUMMARY: limit=full}
    */
    public function sc_series_summary($parm = null)
    {
        $stories = $this->var;
        $text = e107::getParser()->toHTML($this->var['summary'], true, 'DESCRIPTION');
	 
        $limit = ($stories['sumlength'] > 0 ? $stories['sumlength'] : 75);  
        if (!empty($parm['limit'])) {
            $limit = $parm['limit'];
        }
        if ($limit == 'full') {
            return $text;
        } else {
            $text = e107::getParser()->truncate($stories['summary'], $limit);
            return $text;
        }
    }
    

	/* {SERIES_TITLE} */
	public function sc_series_title($parm = null)
	{
		$title = e107::getParser()->toHTML($this->var['title'], true, 'TITLE');
		return $title;
	}
  
    
    /* {SERIES_TITLE_LINK} */
	public function sc_series_title_link($parm = null)
	{
		$title = e107::getParser()->toHTML($this->var['title'], true, 'TITLE');
        $text = "<a href=\"viewseries.php?seriesid=".$this->var['seriesid']."\">".$title."</a>";
		return $text;
	}
    
    /* {SERIES_CODEBLOCK} */
    public function sc_series_codeblock($parm = null)
    {
        if ($parm == 'seriesblock') {
            $stories = $this->var;
            $codequery = "SELECT * FROM #fanfiction_codeblocks WHERE code_type = 'seriesblock'";
            $codes = e107::getDb()->retrieve($codequery, true);
            foreach ($codes as $code) {
                //example:  include(_BASEDIR."modules/translations/admin/storyform.php"
                eval($code['code_text']);
            }
            $text = $output;
            $output = '';
            return $text;
       } 
    }
 
    
    /* {SERIES_OPEN} */
	public function sc_series_open($parm = null)
	{
		if(!isset($seriesType)) $seriesType = array(_CLOSED, _MODERATED, _OPEN);
        $open = $seriesType[$this->var['isopen']];
        return $open;
	}
    
 

        
    /* {SERIES_REPORTTHIS} */
	public function sc_series_reportthis($parm = null)
	{
	    $reportthis = "<a class=\"btn btn-light\" href=\"report.php?action=report&amp;url=manageseries.php?seriesid=".$this->var['seriesid']."\">"._REPORTTHIS."</a>";
    	return $reportthis;
	}     
    
    
    /* {SERIES_ADMINOPTIONS} */
	public function sc_series_adminoptions($parm = null)
	{
	    /*
        from viewseries.php
        if(isADMIN) 
        $titleblock->assign("adminoptions", 
        "<div class=\"adminoptions\">"._ADMINOPTIONS.": 
        [<a href=\"manageseries.php?action=add&amp;add=stories&amp;seriesid=$seriesid\">"._ADD2SERIES."</a>] 
        [<a href=\"manageseries.php?action=edit&amp;seriesid=$seriesid\">"._EDIT."</a>] 
        [<a href=\"manageseries.php?action=delete&amp;seriesid=$seriesid\">"._DELETE."</a>]</div>");
        */
        
        if((isADMIN && uLEVEL < 4) || (USERUID != 0 && USERUID == $this->var['uid'])) {
		$adminoptions =  "<div class=\"adminoptions\"><span class='label'>"._ADMINOPTIONS.":</span> 
          [<a href=\"manageseries.php?action=add&amp;add=stories&amp;seriesid=".$this->var['seriesid']."\">"._ADD2SERIES."</a>] 
          [<a href=\"manageseries.php?action=edit&amp;seriesid=".$this->var['seriesid']."\">"._EDIT."</a>] 
          [<a href=\"manageseries.php?action=delete&amp;seriesid=".$this->var['seriesid']."\">"._DELETE."</a>] </div>";
          
	    }
       	else if($this->var['isopen'] == 2 && USERUID) 
           $adminoptions = "[<a href=\"manageseries.php?action=add&amp;add=stories&amp;seriesid=".$this->var['seriesid']."\">"._ADD2SERIES."</a>]" ;
    
        return $adminoptions;
	}   
    
    /* {SERIES_ADDTOSERIES} */
 	public function sc_series_addtoseries($parm = null)
	{
        $series = $this->var;
        if($series['isopen'] && isMEMBER) {
            $text = "[<a href='manageseries.php?action=add&amp;add=stories&seriesid=$seriesid&amp;stories=".USERUID."'>"._ADD2SERIES."</a>]";
        }
        return $text;
    
    }     
    
     /* {SERIES_COMMENT} */
	public function sc_series_comment($parm = null)
	{
        /* TODO Find content */
		return '';
	}   
  
      /* {SERIES_AUTHOR} */
      public function sc_series_author($parm = null)
      {
          $author = "<a href=\"viewuser.php?uid=".$this->var['uid']."\">".stripslashes($this->var['penname'])."</a>";
          return $author;
      }  
 

	/* {SERIES_EDIT_BUTTON} */
	public function sc_series_edit_button($parm = null)
	{
		$serie = $this->var;
		$text = "<a class='btn btn-success' href=\"stories.php?action=editserie&amp;chapid=".$serie['chapid'].($this->admin ? '&amp;admin=1&amp;uid='.$serie['uid'] : '')."\">"._EDIT.'</a>';
		return $text;
	}

	/* {SERIES_DELETE_BUTTON} */
	public function sc_series_delete_button($parm = null)
	{
		$serie = $this->var;
		$text = "<a class='btn btn-danger'  href=\"stories.php?action=delete&amp;chapid=".$serie['chapid'].($this->admin ? '&amp;admin=1&amp;uid='.$serie['uid'] : '')."\">"._DELETE.'</a>';
		return $text;
	}
    
    /* {SERIES_IMAGE_SRC} */
    public function sc_series_image_src($parm = null)
    {
 
        $serie_icon = $this->var['image']; 
        $src =  e107::getParser()->replaceConstants($serie_icon, 'full');
        return $src; 
    }
    
    /* {SERIES_IMAGE} */
    public function sc_series_image($parm = null)
    {
 
        $serie_icon = $this->var['image']; 
        $icon = e107::getParser()->toImage($serie_icon, $parm); 
        return $icon; 
    }
    
    /* {SERIES_PAGETITLE} */
    public function sc_series_pagetitle($parm = null)
    {
 // stripslashes($series['title'])." "._BY." <a href=\"viewuser.php?uid=".$series['uid']."\">".$series['penname']."</a>"
 
        $text = $this->sc_series_title()." "._BY." ".$this->sc_series_author();
        return $text; 
    } 
    
 
      
     /* {SERIES_JUMPMENU} */
    public function sc_series_jumpmenu($parm = null)
    {
    global $anonreviews, $reviewsallowed ;  //check
    $series = $this->var;
    $jumpmenu = "";
    
    if($reviewsallowed && (isMEMBER || $anonreviews)) {
        $jumpmenu .= "<option value=\"reviews.php?action=add&amp;type=SE&amp;item=$seriesid\">"._SUBMITREVIEW."</option>";
    }
    if(isMEMBER && $favorites) {
        $jumpmenu .= "<option value=\"member.php?action=favau&amp;uid=".USERUID."&amp;add=".$series['uid']."\">"._ADDAUTHOR2FAVES."</option>";
    }
    if($series['isopen'] && isMEMBER) {
        $jumpmenu .= "<option value=\"manageseries.php?action=add&amp;add=stories&amp;seriesid=".$seriesid."&amp;stories=".USERUID."\">"._ADD2SERIES."</option>";
    }
    if($jumpmenu) {
            $jumpmenu = "<form name=\"jump2\" action=\"\"><select name=\"jump2\" onchange=\"if(this.selectedIndex.value != 'false') document.location = document.jump2.jump2.options[document.jump2.jump2.selectedIndex].value\"><option value=\"false\">"._OPTIONS."</option>".$jumpmenu."</select></form>";
    }
        
        return $jumpmenu; 
    }
    
    /* {SERIESBY_PAGELINKS} */
    public function sc_seriesby_pagelinks($parm)
    {
        $uid = (int) $_GET['uid'];
 
    	$pagelinks = '';
    		if($this->var['numseries'] > $this->var['itemsperpage'] ) {

    		$link = "viewuser.php?action=seriesby&amp;uid=$uid".(isset($_GET['sort']) ? ($_GET['sort'] == "alpha" ? "&amp;sort=alpha" : "&amp;sort=update") : "");
 
    		$pagelinks = efiction::build_pagelinks($link."&amp;",  $this->var['numseries'], $this->var['offset'], 1, 'bootstrap4' );
     
    		return $pagelinks;
    	}
    }    
    
}
