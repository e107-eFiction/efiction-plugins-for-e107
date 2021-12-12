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

if (!class_exists('efiction_categories')) {
    class efiction_categories
    {
        /* ID => array */   
        public static function catlist() {
        
          $catquery =  "SELECT * FROM ".TABLEPREFIX."fanfiction_categories ORDER BY leveldown, displayorder";
          $records = e107::getDb()->retrieve($catquery, true);
          foreach($records AS $cat) {
                $catlist[$cat['catid']] = array("catid" => $cat['catid'], "name" => stripslashes($cat['category']), "pid" => $cat['parentcatid'], "order" => $cat['displayorder'], "locked" => $cat['locked'], "leveldown" => $cat['leveldown']);
          }
 
		  return $catlist;
        
        }

        /* ID => NAME */
        /* TODO: replace with get_categories_list() */
        public static function get_categories() {
        
          $catlist = self::catlist();
          
          foreach($catlist AS $cat) {
                $category[$cat['catid']] = $cat["name"];
          }
 
		  return $category;
        
        }
        
        /* used in admin_config.php for OptArray*/
       public function get_categories_list() {
 
		$values = array();

        $catlist = self::catlist();
     
        foreach($catlist AS $cat) {
              $values[$cat['catid']] = $cat["name"];
        }
 
		return $values;    
  
      }
      
      /* e107::getSingleton('efiction_categories')->get_catlist($this->var['catid']); */  
      // This function builds the list of category links (including the breadcrumb depending on settings)
      function get_catlist($catid = NULL) {
      	global $extendcats,  $action;
      
        $catlist = efiction_categories::catlist();
          
      	if(!is_array($catid)) $catid = explode(",", $catid);
      	$categorylinks = array();
      	foreach($catid as $cat) {
      		if(empty($catlist[$cat])) continue;
      		if($extendcats) {
      			unset($link);
      			$thiscat = $cat;
      			while(isset($thiscat)) {
      				if(isset($link)) $link = " > ".$link;
      				else $link = "";
      				if($action != "printable") $link = "<a href='"._BASEDIR."browse.php?type=categories&amp;catid=$thiscat'>".$catlist[$thiscat]['name']."</a>".$link;
      				else $link = $catlist[$thiscat]['name'].$link;
      				if($catlist[$thiscat]['pid'] == -1) unset($thiscat);
      				else $thiscat = $catlist[$thiscat]['pid'];
      			}
      			$categorylinks[] = $link;
      		}
      		else $categorylinks[] = "<a href='"._BASEDIR."browse.php?type=categories&amp;catid=$cat'>".$catlist[$cat]['name']."</a>";
      	}
      	return implode(", ", $categorylinks);
      }

        
    }
    new efiction_categories();
}
