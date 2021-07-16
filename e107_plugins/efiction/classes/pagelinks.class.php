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

if (!class_exists('efiction_pagelinks')) {
    class efiction_pagelinks
    {
        public function __construct()
        {
        }
 
        /* list of available efiction links for user - access checked */
    	public static function sitelinks()
        {
            $linkquery = 'SELECT * from '.MPREFIX.'fanfiction_pagelinks ORDER BY link_access ASC' ;
            $records = e107::getDb()->retrieve($linkquery, true);
    		 
            $userlinks = array();
            foreach ($records as $link) { 
                if ($link['link_access'] && !isMEMBER) {
                    continue;
                }
                if ($link['link_access'] == 2 && uLEVEL < 1) {
                    continue;
                }
                if ($link['link_name'] == 'register' && isMEMBER) {
                    continue;
                }
                if (strpos($link['link_url'], 'http://') === false && strpos($link['link_url'], 'https://') === false) {
                    $link['link_url'] = e_HTTP.$link['link_url'];
                }
     
    			$userlinks[$link['link_name']]  = $link;
                
            }
    
            return $userlinks;
        }
        
    	public static function get_sitelinks()
        {
            $userlinks = self::sitelinks();
    
            return $userlinks;
        }
        
        /* list of available efiction links for user - access checked - with different keys and final link tag */
    	public static function get_pagelinks($current = '') 
        {
            $links = self::get_sitelinks();
            $pagelinks = array();
            foreach($links AS $link) {
 
	           $pagelinks[$link['link_name']] = array(
                "id" => $link['link_id'], 
                "text" => $link['link_text'], 
                "url" => $link['link_url'], 
                "link" => "<a class='efiction_links' href=\"".$link['link_url']."\" title=\"".$link['link_text']."\"".($link['link_target'] ? " target=\"_blank\"" : "").(!empty($link['link_key']) ? " accesskey='".$link['link_key']."'" : "").($current == $link['link_name'] ? " id=\"current\"" : "").">".$link['link_text']."</a>");
            }
          
            return $pagelinks;
        } 
        
     
      /* for link shortcode - return single link tag */  
      public function get_userlink($key = null)
      {
          if (null === $key) {
              return  null;
          }
  
          $links = self::get_pagelinks();  
          $ret = isset($links[$key]['link']) ? $links[$key]['link'] : null;
          return $ret;
      }       
    }

    new efiction_pagelinks();
}
