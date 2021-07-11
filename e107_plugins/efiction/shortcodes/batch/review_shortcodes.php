<?php


/*
{REVIEW_ODDEVEN}
{REVIEW_REVIEWER}
{REVIEW_MEMBER}
{REVIEW_RATING}
{REVIEW_REPORTTHIS}
{REVIEW_REVIEWDATE}
{REVIEW_CHAPTER}
{REVIEW_CHAPTER}
{REVIEW_ADMINOPTIONS}
*/

class plugin_efiction_review_shortcodes extends e_shortcode
{
 
 
    /* {REVIEW_LISTING} */
    public function sc_review_listing($parm = null)
	{
      $text = $this->var['listing'];   
      return $text;     
    }
    
    /* {REVIEW_ODDEVEN} */
    public function sc_review_oddeven($parm = null)
	{
      $text = $this->var['oddeven'];
      return $text;     
    }
    /* {REVIEW_REVIEWER} */
    public function sc_review_reviewer($parm = null)
	{
		if($this->var['uid']) {
			$reviewer = "<a href=\"viewuser.php?uid=".$this->var['uid']."\">".$this->var['reviewer']."</a>";
			 
		}
		else {
			$reviewer = $this->var['reviewer'];
		}
      return $reviewer; 
    }
    /* {REVIEW_MEMBER} */
    public function sc_review_member($parm = null)
	{
		if($this->var['uid']) {
			$member = _MEMBER;
		}
		else {
		
			$member = _ANONYMOUS;
		}
      	return $member; 
    }
    /* {REVIEW_RATING} */
    public function sc_review_rating($parm = null)
	{
      $text = ratingpics($this->var['rating']);
      return $text; 
    }    
    /* {REVIEW_REPORTTHIS} */
    public function sc_review_reportthis($parm = null)
	{
      $text = $this->var['reportthis'];
      return $text; 
    }    
    /* {REVIEW_REVIEWDATE} */
    public function sc_review_reviewdate($parm = null)
	{
      $dateformat = efiction_settings::get_single_setting('dateformat');
 
      $text = date("$dateformat", $this->var['date']);
      return $text; 
    }    
    /* {REVIEW_CHAPTER} */
    public function sc_review_chapter($parm = null)
	{
		$chaptitle = $this->var['chaptitle'];
		$chapnum = $this->var['chapnum'];

		$text = (isset($chaptitle) ? _CHAPTER." $chapnum: $chaptitle" : (!empty($this->var['title']) ? $this->var['title'] : _NONE));
		return $text; 
    }    
    /* {REVIEW_REVIEW} */
    public function sc_review_review($parm = null)
	{
 
      $text = '';
      $text = e107::getParser()->toHTML($this->var['review'], true, 'BODY');
      return $text;   
    }    
    /* {REVIEW_ADMINOPTIONS} */
    public function sc_review_adminoptions($parm = null)
	{
		$revdelete =  efiction_settings::get_single_setting('revdelete');
 
		if(isADMIN) $adminlink = _ADMINOPTIONS.": [<a href=\"reviews.php?action=edit&amp;reviewid=".$this->var['reviewid']."\">"._EDIT."</a>]";
		if( isADMIN || (USERUID && USERUID == $this->var['uid'])) $adminlink .= " [<a href=\"reviews.php?action=delete&amp;reviewid=".$this->var['reviewid']."\">"._DELETE."</a>]";
		if(isADMIN) $adminlink = _ADMINOPTIONS.": [<a href=\"reviews.php?action=edit&amp;reviewid=".$this->var['reviewid']."\">"._EDIT."</a>]";
		if( isADMIN || (USERUID && USERUID == $this->var['uid'])) $adminlink .= " [<a href=\"reviews.php?action=delete&amp;reviewid=".$this->var['reviewid']."\">"._DELETE."</a>]";

		if($this->var['uid']) {
			if(USERUID == $this->var['uid'] && $revdelete == 2 && !isADMIN) $adminlink .= " [<a href=\"reviews.php?action=delete&amp;reviewid=".$this->var['reviewid']."\">"._DELETE."</a>]";	 
		}
		else {
			if(USERUID == $this->var['authoruid'] && $revdelete && !isADMIN) $adminlink .= " [<a href=\"reviews.php?action=delete&amp;reviewid=".$this->var['reviewid']."\">"._DELETE."</a>]";
		}
		if(!empty($this->var['authoruid']) && USERUID == $this->var['authoruid']) $adminlink .= " [<a href=\"member.php?action=revres&amp;reviewid=".$this->var['reviewid']."\">"._RESPOND."</a>]";
 
      return $adminlink; 
    }    
    

}
