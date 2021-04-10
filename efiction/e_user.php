<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2014 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

if (!defined('e107_INIT')) { exit; }

;

// v2.x Standard 
class efiction_user // plugin-folder + '_user'
{	
	/**
	 * The same field format as admin-ui, with the addition of 'fieldType', 'read', 'write', 'appliable' and 'required' as used in extended fields table.
	 *
	 * @return array
	 */
	function settings()
	{
  
	}

	
	function profile($udata)  // display on user profile page.
	{
 
        $tp = e107::getParser();
        
        $adata = eauthors::get_author_data_by_user_id($udata['user_id']); 
 
        $author_uid = $adata['uid'];
        
		if($author_uid > 0) {
      
            $label = ' <img src="'.e_PLUGIN_ABS.'/efiction_authors/images/icon_128.png" alt="Prekladateľ" style="width: 70px;" > '; 
            
            $membersince =  $tp->toDate($adata['date'], 'short');  
            
            $text  =  '<div class="agent-form bg-light-blue "><h3><a href="#">'.$adata['penname'].'</a></h3>';
             
            $text  .= '</div>';       
                
			$var = array(
				0 => array('label' =>$label, 'text' => $text )
			);
		}
 
		return $var;
	}

}	

// (plugin-folder)_user_form - only required when using custom methods.
class efiction_user_form extends e_form
{

 
   
}