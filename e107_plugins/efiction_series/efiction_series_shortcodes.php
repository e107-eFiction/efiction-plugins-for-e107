<?php

if (!defined('e107_INIT')) {
    exit;
}

e107::lan('efiction');

/*
{ADDTOFAVES} 1
{ADMINOPTIONS} 2
{CATEGORY} 3
{CHARACTERS} 4
{CLASSIFICATIONS} 5
{IMAGE} 6
{JUMPMENU}
{NUMREVIEWS}  8 
{NUMSTORIES} 9
{OPEN} 10
{PAGETITLE} 11
{PARENTSERIES} 12
{RATING}  13
{REVIEWS} 14
{SUMMARY} 15
*/

/* TODO FIX ME */
 
class efiction_series_shortcodes extends e_shortcode
{
    /* {ADDTOFAVES} */
    public function sc_addtofaves($parm = null)
    {
        $favorites =  efiction_settings::get_single_setting('favorites');
        if (isMEMBER && $favorites) {
            $addtofaves = "[<a href=\"".SITEURL."member.php?action=favse&amp;uid=".USERUID."&amp;add=".$this->var['seriesid']."\">"._ADDSERIES2FAVES."</a>]";
            if ($this->var['isopen'] < 2) {
                $addtofaves .= " [<a href=\"".SITEURL."viewuser.php?action=favau&amp;uid=".USERUID."&amp;author=".$this->var['uid']."\">"._ADDAUTHOR2FAVES."</a>]";
            }
        }
        return $addtofaves;
    }
    
    /* {ADMINOPTIONS} */
    public function sc_adminoptions($parm = null)
    {
        return   '';

		/*
        from viewseries.php
        if(isADMIN)
        $titleblock->assign("adminoptions",
        "<div class=\"adminoptions\">"._ADMINOPTIONS.":
        [<a href=\"manageseries.php?action=add&amp;add=stories&amp;seriesid=$seriesid\">"._ADD2SERIES."</a>]
        [<a href=\"manageseries.php?action=edit&amp;seriesid=$seriesid\">"._EDIT."</a>]
        [<a href=\"manageseries.php?action=delete&amp;seriesid=$seriesid\">"._DELETE."</a>]</div>");
        */
        $adminurl = e_PLUGIN_ABS."efiction_series/admin/admin_config.php?action=edit&id=";  
		  
        if ((isADMIN && uLEVEL < 4) || (USERUID != 0 && USERUID == $this->var['uid'])) {
            $adminoptions =  "<div class=\"adminoptions\"><span class='label'>"._ADMINOPTIONS.":</span> 
			   [<a href=\"".SITEURL."series.php?action=add&amp;add=stories&amp;seriesid=".$this->var['seriesid']."\">"._ADD2SERIES."</a>] 
			   [<a href=\"".$adminurl.$this->var['seriesid']."\">"._EDIT."</a>] 
			   [<a href=\"".SITEURL."series.php?action=delete&amp;seriesid=".$this->var['seriesid']."\">"._DELETE."</a>] </div>";
        } elseif ($this->var['isopen'] == 2 && USERUID) {
            $adminoptions = "[<a href=\"".SITEURL."series.php?action=add&amp;add=stories&amp;seriesid=".$this->var['seriesid']."\">"._ADD2SERIES."</a>]" ;
        }
         
        return $adminoptions;
    }
         
    
    /* {CATEGORY} 3 */
    public function sc_category($parm = null)
    {
        // $category = $this->var['catid'] ? catlist($this->var['catid']) : _NONE;
        return e107::getSingleton('efiction_categories')->get_catlist($this->var['catid']);
    }
     
    /* {CHARACTERS} 4 */
    public function sc_characters($parm = null)
    {
        // $characters = $this->var['characters'] ? charlist($this->var['characters']) : _NONE;
        return e107::getSingleton('efiction_characters')->get_charlist($this->var['characters']);
    }
    /* {CLASSIFICATIONS} 5 */
    public function sc_classifications($parm = null)
    {
        $classlist = e107::getSingleton('efiction_classes')->get_classlist();
        $classtypelist = e107::getSingleton('efiction_classes')->get_classtypelist();
        $start = $center = $end = '';
        if ($parm['type'] == "dl") {
            $start = '<dt class="col-sm-3">';
            $center = '</dt><dt class="col-sm-9">';
            $end = "</dt>";
        }
        $stories = $this->var;
        $allclasslist = "";
        if ($stories['classes']) {
            unset($storyclasses);
            foreach (explode(",", $stories['classes']) as $c) {
                $storyclasses[$classlist["$c"]['type']][] = "<a href='".SITEURL."browse.php?type=class&amp;type_id=".$classlist["$c"]['type']."&amp;classid=$c'>".$classlist[$c]['name']."</a>";
            }
        }
        foreach ($classtypelist as $num => $c) {
            if (isset($storyclasses[$num])) {
                $c['name'] = implode(", ", $storyclasses[$num]);
                $allclasslist .= "{$start}<span class='label'>".$c['title'].": </span>{$center} ".implode(", ", $storyclasses[$num])."<br />{$end}";
            } else {
                $c['name'] = _NONE;
                $allclasslist .= "{$start}<span class='label'>".$c['title'].": </span> {$center}"._NONE."<br />{$end}";
            }
        }
   
        $classification = $allclasslist;
        return $classification;
    }
  
    /* {IMAGE} 6 */
    public function sc_image($parm = null)
    {
        $serie_image = '';
        $serie_image = $this->var['image'];
        $serie_image = $src =  e107::getParser()->replaceConstants($serie_image, 'full');
        if ($serie_image) {
            $serie_image = "<img src=".$serie_image." class='img-fluid card-img-top'>";
        }
       
        /*
        $serie_icon = $this->var['image'];
        $icon = e107::getParser()->toImage($serie_icon, $parm);
        */
        return $serie_image;
    }

	/* {JUMPMENU} 7 */
	public function sc_jumpmenu($parm = null)
	{
 
	$seriesid = $this->var['seriesid'];
	$jumpmenu = "";
	
	$anonreviews = e107::getSingleton('efiction_settings')->getPref('anonreviews');
	$reviewsallowed = e107::getSingleton('efiction_settings')->getPref('reviewsallowed');


	if($reviewsallowed && (isMEMBER || $anonreviews)) {
		$jumpmenu .= "<option value=\"".SITEURL."reviews.php?action=add&amp;type=SE&amp;item=$seriesid\">"._SUBMITREVIEW."</option>";
	}
	if(isMEMBER && $favorites) {
		$jumpmenu .= "<option value=\"".SITEURL."member.php?action=favau&amp;uid=".USERUID."&amp;add=".$series['uid']."\">"._ADDAUTHOR2FAVES."</option>";
	}
	if($series['isopen'] && isMEMBER) {
		$jumpmenu .= "<option value=\"".SITEURL."series.php?action=add&amp;add=stories&amp;seriesid=".$seriesid."&amp;stories=".USERUID."\">"._ADD2SERIES."</option>";
	}
	if($jumpmenu) {
			$jumpmenu = "<form name=\"jump2\" action=\"\"><select name=\"jump2\" onchange=\"if(this.selectedIndex.value != 'false') document.location = document.jump2.jump2.options[document.jump2.jump2.selectedIndex].value\"><option value=\"false\">"._OPTIONS."</option>".$jumpmenu."</select></form>";
	}
		
		return $jumpmenu; 
	}
    
    /* {NUMREVIEWS} 8 */
    public function sc_numreviews($parm = null)
    {
        $numreviews = '';
        $reviewsallowed =  efiction_settings::get_single_setting('reviewsallowed');
        $anonreviews   =  efiction_settings::get_single_setting('anonreviews');
         
        if ($reviewsallowed && (isMEMBER || $anonreviews)) {
            $numreviews =  "<a href=\"".SITEURL."reviews.php?type=SE&amp;item=".$this->var['seriesid']."\">".$this->var['reviews']."</a>";
        }
        return $numreviews;
    }
     
    /* {NUMSTORIES} 9 */
    public function sc_numstories($parm = null)
    {
        $numstories = $this->var['numstories'];
        return $numstories;
    }

	     
    /* {OPEN} 10 */
    public function sc_open($parm = null)
    {
  
		if (!isset($seriesType)) {
            $seriesType = array(_CLOSED, _MODERATED, _OPEN);
        }
        $open = $seriesType[$this->var['isopen']];
        return $open;
    }

	/* {PAGETITLE}  11*/
	public function sc_pagetitle($parm = null)
	{
		// stripslashes($series['title'])." "._BY." <a href=\"viewuser.php?uid=".$series['uid']."\">".$series['penname']."</a>"
		$text = $this->sc_title()." "._BY." ".$this->sc_author();
		return $text;
	}

     
    /* {PARENTSERIES} 12 */
    public function sc_parentseries($parm = null)
    {
        print_a($this->var['seriesid']);
		$query = "SELECT s.title, s.seriesid, s.seriessef FROM #fanfiction_inseries as i, 
		#fanfiction_series as s WHERE s.seriesid = i.seriesid AND i.subseriesid = '".$this->var['seriesid']."'";
		print_a($query);
		$parents = e107::getDb()->retrieve("SELECT s.title, s.seriesid, s.seriesef FROM #fanfiction_inseries as i, 
		  #fanfiction_series as s WHERE s.seriesid = i.seriesid AND i.subseriesid = '".$this->var['seriesid']."'", true);
 
        $plinks = array( );
        foreach ($parents as $p) {
            $plinks[] = "<a href=\"".e107::url('efiction_series', 'viewseries', $s)."\">".$p['title']."</a>";
        }
        $parentseries = count($plinks) ? implode(", ", $plinks) : "";
        return $parentseries;
    }
     
	/* {RATING}  13 */
	public function sc_rating($parm = null)
	{
		$ratingslist = efiction_ratings::get_ratings_list();
		return  $ratingslist[$this->var['rid']];
	}

    /* {REVIEWS} 14  */
    public function sc_reviews($parm = null)
    {
        $reviews = '';
        $reviewsallowed =  efiction_settings::get_single_setting('reviewsallowed');
        $anonreviews =  efiction_settings::get_single_setting('anonreviews');
         
        if ($reviewsallowed && (isMEMBER || $anonreviews)) {
            $reviews =  "<a href=\"".SITEURL."reviews.php?type=SE&amp;item=".$this->var['seriesid']."\">"._REVIEWS."</a>";
        }
        return $reviews;
    }
  
    /* {SUMMARY} 15
    {SUMMARY: limit=100}
    {SUMMARY: limit=full}
    */
    public function sc_summary($parm = null)
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

	/* *************************** */
     
     /* {AUTHOR} */
	 public function sc_author($parm = null)
	 {
 
		$author = "<a href=\"".SITEURL."viewuser.php?uid=".$this->var['uid']."\">".stripslashes($this->var['penname'])."</a>";
	    return $author;
	 }

    /* {TITLE} */
    public function sc_title($parm = null)
    {
        $title = e107::getParser()->toHTML($this->var['title'], true, 'TITLE');
        return $title;
    }
 

}
