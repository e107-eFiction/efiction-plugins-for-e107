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

class eAuthors 
{

    public function __construct()
    {
        $sql = e107::getDb();

        /** @var efiction_shortcodes sc */
        $this->sc = e107::getScParser()->getScObject('efiction_shortcodes', 'efiction', false);

        $this->get = varset($_GET);
        $this->post = varset($_POST);

        $this->pref = e107::pref('efiction');
 
    }
    
    public function init() { 
    
    
    }
 
    
    public function get_author_data($uid=null)
	{
		$uid = intval($uid);

		if(empty($uid)){ return false; }

	    $authorquery = "SELECT ap.*, "._UIDFIELD." as uid, "._PENNAMEFIELD." as penname, "._EMAILFIELD." as email, "._PASSWORDFIELD." as password 
        FROM "._AUTHORTABLE." LEFT JOIN ".TABLEPREFIX."fanfiction_authorprefs as ap ON ap.uid = "._UIDFIELD." WHERE "._UIDFIELD." = '".$uid."'"  ;
 
		$authordata = e107::getDb()->retrieve($authorquery);
        
      
        
        $var = array();
        
		if($authordata)
		{
			$var = $authordata;
		}

		return $var;
	}    
    
 
    public function get_author_data_by_user_id($user_id=null)
	{
		$user_id = intval($user_id);

		if(empty($user_id)){ return false; }
        
        $where = " user_id = ".$user_id; 

	    $authorquery = "SELECT *, ap.* 
        FROM "._AUTHORTABLE." LEFT JOIN #fanfiction_authorprefs as ap ON ap.uid = "._UIDFIELD." WHERE ". $where. " LIMIT 1" ;
  
		$authordata = e107::getDb()->retrieve($authorquery);
        
       
        $var = array();
        
		if($authordata)
		{
			$var = $authordata;
		}

		return $var;
	}   
}