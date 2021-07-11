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

    class plugin_efiction_searchform_shortcodes extends e_shortcode
    {
        public function __construct()
        {     
        }
 
        
        /* {SEARCHFORM_SORTBEGIN} */ 
    	public function sc_searchform_sortbegin($parm)
    	{
    		$text = $this->var['searchform_sortbegin'];
    		return $text;
    	}
        /* {SEARCHFORM_CATEGORYMENU} */
    	public function sc_searchform_categorymenu($parm)
    	{
    		$text = $this->var['searchform_categorymenu'];
    		return $text;
    	}        
        /* {SEARCHFORM_CHARACTERMENU1} */
    	public function sc_searchform_charactermenu1($parm)
    	{
    		$text = $this->var['searchform_charactermenu1'];
    		return $text;
    	}           
        /* {SEARCHFORM_CHARACTERMENU2} */
    	public function sc_searchform_charactermenu2($parm)
    	{
    		$text = $this->var['searchform_charactermenu2'];
    		return $text;
    	}            
        /* {SEARCHFORM_PAIRINGSMENU} */
    	public function sc_searchform_pairingsmenu($parm)
    	{
    		$text = $this->var['searchform_pairingsmenu'];
    		return $text;
    	}          
        /* {SEARCHFORM_RATINGMENU} */
    	public function sc_searchform_ratingmenu($parm)
    	{
            
			if(in_array("ratings", $this->disablesorts)) {
				return '';
			}
			
			$ratingslist = $ratlist = efiction::ratingslist();

			$options[0] = LAN_ALL;
            foreach($ratingslist AS $key=>$value) {
                $options[$key] = $value['name'];
            }
 
            $selected = implode(',', $this->var['rating_selected']);  
            
			$text  =  "<label for='rating'>"._RATING;
			$text .= "</label>";
			$text .= e107::getForm()->select('rating', $options, $selected, array('class'=> 'select2-single', "title" => _RATINGS ) );
 
    		return $text;
    	}   
        /* {SEARCHFORM_CLASSMENU} */
    	public function sc_searchform_classmenu($parm)
    	{
    		$text = $this->var['searchform_classmenu'];
    		return $text;
    	}    
        /* {SEARCHFORM_SORTMENU} */
    	public function sc_searchform_sortmenu($parm)
    	{
    		$text = $this->var['searchform_sortmenu'];
    		return $text;
    	} 
        /* {SEARCHFORM_COMPLETEMENU} */
    	public function sc_searchform_completemenu($parm)
    	{
    		$text = $this->var['searchform_completemenu'];
    		return $text;
    	}              
        /* {SEARCHFORM_SORTEND} */
    	public function sc_searchform_sortend($parm)
    	{
    		$text = $this->var['searchform_sortend'];
    		return $text;
    	}    
 
    }
