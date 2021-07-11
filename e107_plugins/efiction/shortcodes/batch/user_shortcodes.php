<?php


/*
{USER_SORT}
{USER_PROFILE} 
{USER_PANELTABS}
{USER_OUTPUT}
{USER_LISTINGS}
*/

class plugin_efiction_user_shortcodes extends e_shortcode
{
 
    /* {BLOCK_USER_PROFILE} */ 
    public function sc_block_user_profile($parm = null)
	{  
      $uid = $this->var['uid'];  
      $userinfo = $this->var;
      $userinfo['user'] = e107::user($this->var['user_id']); 
      include(_BASEDIR."/member/profile.php");
	  $text = $block_user_profile;
	  return $text;
 
    }
    /* {USER_PANELTABS} */
    public function sc_user_paneltabs($parm = null)
	{
		$uid = $this->var['uid'];  
		$userinfo = $this->var;
		$userinfo['user'] = e107::user($this->var['user_id']); 
		include(_BASEDIR."/member/paneltabs.php");
		 
		$text = $panelstabs;
		return $text;
  
    }
 
    /* {USER_OUTPUT} */
    public function sc_user_output($parm = null)
	{
 
		$action = $this->var['action'];
		$uid = $this->var['uid'];  //needed for panels
		$itemsperpage =  efiction_settings::get_single_setting('itemsperpage');
        $offset =  efiction_settings::get_single_setting('offset');
 
		$penname = $this->var['userinfo']['penname'];
 
		$panel = e107::getDb()->retrieve("SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE ".($action ? "panel_name = '$action' 
        AND (panel_type = 'P' OR panel_type = 'F')" : "panel_type = 'P' AND panel_hidden = 0 ORDER BY panel_order ASC")." LIMIT 1");
 
		if($panel) {
			if(!empty($panel['panel_url']) && file_exists(_BASEDIR.$panel['panel_url'])) include(_BASEDIR.$panel['panel_url']);
			else if(file_exists(_BASEDIR."member/".$panel['panel_name'].".php")) include(_BASEDIR."member/".$panel['panel_name'].".php");
			else $output .= write_error("(A) "._ERROR);
		}

		return $output;
    }
    
    /* {USER_REVIEWSBY} */
    public function sc_user_reviewsby($parm = null) {
    
        $action = $this->var['action'];
		$uid = $this->var['uid'];   
		$penname = $this->var['userinfo']['penname'];      
    
    }
    
    
    
    /* {USER_PENNAME} */
    public function sc_user_penname($parm = null)
	{
 
		$penname = $this->var['penname'];
		return $penname;
    }
 
 
}