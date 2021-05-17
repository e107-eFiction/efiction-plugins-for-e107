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

    class plugin_efiction_efiction_shortcodes extends e_shortcode
    {
        public function __construct()
        {     
        }

        /* {BROWSE_CAPTION} */
    	public function sc_browse_caption($parm)
    	{
        
    		$text = $this->var['caption'];
    		return $text;
    	}
        
        /* {BROWSE_SORTBEGIN} */ 
    	public function sc_browse_sortbegin($parm)
    	{
    		$text = $this->var['sortbegin'];
    		return $text;
    	}
        /* {BROWSE_CATEGORYMENU} */
    	public function sc_browse_categorymenu($parm)
    	{
    		$text = $this->var['categorymenu'];
    		return $text;
    	}        
        /* {BROWSE_CHARACTERMENU1} */
    	public function sc_browse_charactermenu1($parm)
    	{
    		$text = $this->var['charactermenu1'];
    		return $text;
    	}           
        /* {BROWSE_CHARACTERMENU2} */
    	public function sc_browse_charactermenu2($parm)
    	{
    		$text = $this->var['charactermenu2'];
    		return $text;
    	}            
        /* {BROWSE_PAIRINGSMENU} */
    	public function sc_browse_pairingsmenu($parm)
    	{
    		$text = $this->var['pairingsmenu'];
    		return $text;
    	}          
        /* {BROWSE_RATINGMENU} */
    	public function sc_browse_ratingmenu($parm)
    	{
    		print_a($this->var['ratingmenu']);
            $text = $this->var['ratingmenu'];
    		return $text;
    	}   
        /* {BROWSE_CLASSMENU} */
    	public function sc_browse_classmenu($parm)
    	{
    		$text = $this->var['classmenu'];
    		return $text;
    	}    
        /* {BROWSE_SORTMENU} */
    	public function sc_browse_sortmenu($parm)
    	{
    		$text = $this->var['sortmenu'];
    		return $text;
    	} 
        /* {BROWSE_COMPLETEMENU} */
    	public function sc_browse_completemenu($parm)
    	{
    		$text = $this->var['completemenu'];
    		return $text;
    	}              
        /* {BROWSE_SORTEND} */
    	public function sc_browse_sortend($parm)
    	{
    		$text = $this->var['sortend'];
    		return $text;
    	}    
        /* {BROWSE_ALPHALINKS} */
    	public function sc_browse_alphalinks($parm)
    	{
  
    		$alphalinks =  build_alphalinks("browse.php?".$this->var['terms']."&amp;", $this->var['let']) ;
    		return $alphalinks;
    	}  
        /* {BROWSE_OUTPUT} */
    	public function sc_browse_output($parm)
    	{ 
    		$text = $this->var['output'];
    		return $text;
    	} 
        /* {BROWSE_OTHERRESULTS} */
    	public function sc_browse_otherresults($parm)
    	{
    		$text = $this->var['otherresults'];
    		return $text;
    	}  
        /* {BROWSE_SERIESBLOCK} */
    	public function sc_browse_seriesblock($parm)
    	{
    		$text = $this->var['seriesblock'];
    		return $text;
    	}          
        /* {BROWSE_PAGELINKS} */
    	public function sc_browse_pagelinks($parm)
    	{
            $itemsperpage =  efiction::settings('itemsperpage');
 
            $pagelinks = '';
 
            if($this->var['numrows'] > $itemsperpage) {  
              $pagelinks = build_pagelinks("browse.php?".$this->var['terms']."&amp;",  $this->var['numrows'], $this->var['offset'] );
            }
 
    		return $pagelinks;
    	}  
        
        /* {BROWSE_SEARCHFORM}*/
       	public function sc_browse_searchform($parm)
    	{

             $browse_template = e107::getTemplate('efiction', 'searchform', 'default');
             $search_browse = e107::getScParser()->getScObject('searchform_shortcodes', 'efiction', false);
             $search_vars = array();
             $search_browse->wrapper('searchform/default');
      
              
              $search_vars['searchform_sortbegin'] = $this->sc_browse_sortbegin($parm);
              $search_vars['searchform_categorymenu'] = $this->sc_browse_categorymenu($parm);
              $search_vars['searchform_charactermenu1'] = $this->sc_browse_charactermenu1($parm);
              $search_vars['searchform_charactermenu2'] = $this->sc_browse_charactermenu2($parm);            
              $search_vars['searchform_pairingsmenu'] = $this->sc_browse_pairingsmenu($parm);
                       
              $search_vars['searchform_classmenu'] = $this->sc_browse_classmenu($parm);       
              $search_vars['searchform_sortmenu'] = $this->sc_browse_sortmenu($parm);       
              $search_vars['searchform_ompletemenu'] = $this->sc_browse_completemenu($parm);       
              $search_vars['searchform_sortend'] = $this->sc_browse_sortend($parm);                          
              
              $search_vars = array_merge($search_vars, $this->var);
 
              $search_browse->setVars($search_vars);
     
              $text = e107::getParser()->parseTemplate($browse_template['form'], true, $search_browse);
             
    		return $text;
    	}  
        
    }
