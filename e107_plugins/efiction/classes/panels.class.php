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

if (!class_exists('efiction_panels')) {
    class efiction_panels
    {
        public static function get_panel_types() 
        {
        
          $panelquery =  "SELECT panel_type FROM ".MPREFIX."fanfiction_panels GROUP BY panel_type";
          $records = e107::getDb()->retrieve($panelquery, true);

		  return $records;
        
        }
            

        public static function favorites_panel()  
        {
           $panelquery =  "SELECT * FROM ".MPREFIX."fanfiction_panels WHERE panel_type = 'F' AND panel_name != 'favlist' ORDER BY panel_title ASC";
           $records = e107::getDb()->retrieve($panelquery, true);
    
    	   return $records;
        }
        
        public static function member_panel()  
        {
           $submissionsoff = efiction_settings::get_single_setting('submissionsoff');
           $favorites =   efiction_settings::get_single_setting('favorites');
           if(USERID && isMEMBER) {
 
               $panelquery =  "SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_hidden != '1' AND panel_level = '1' AND (panel_type = 'U' ".(!$submissionsoff || isADMIN ? " OR panel_type = 'S'" : "").($favorites ? " OR panel_type = 'F'" : "").") ORDER BY panel_type, panel_order, panel_title ASC";
               $records = e107::getDb()->retrieve($panelquery, true);
               
               foreach ($records AS $panel)  {
               		if(!$panel['panel_url']) $panel['panel_url'] = "member.php?action=".$panel['panel_name']; 
                    $panels[] = $panel;
               }
        	   return  $panels;
           }
        }
        
        
        public static function member_panels_byaction($action = NULL) 
        {
            $submissionsoff = efiction_settings::get_single_setting('submissionsoff');
            $favorites =   efiction_settings::get_single_setting('favorites');
            
            if(empty($action)) return array();
            
            $panelquery =  "SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_name = '$action' AND (panel_type='U' ".(!$submissionsoff || isADMIN ? " OR panel_type = 'S'" : "").($favorites ? " OR panel_type = 'F'" : "").") LIMIT 1";
        
            $panel = e107::getDb()->retrieve($panelquery);
 
            return $panel;
   
        }
 
 
        public static function favorite_panels()  
        {
 
               $panelquery =  "SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_type = 'F' AND panel_name != 'favlist' ORDER BY panel_title ASC";
               $records = e107::getDb()->retrieve($panelquery, true);
               
               foreach ($records AS $panel)  {
               		if(!$panel['panel_url']) $panel['panel_url'] = "member.php?action=".$panel['panel_name']; 
                    $panels[] = $panel;
               }
        	   return  $panels;
            
        }     
        
        
         public static function admin_panels()  
        {
 
               $panelquery =  "SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_hidden != '1' AND panel_type = 'A' AND panel_level >= ".uLEVEL." ORDER BY panel_level DESC, panel_order ASC, panel_title ASC";
               $records = e107::getDb()->retrieve($panelquery, true);
               
               foreach ($records AS $panel)  {
               
                   		if(!$panel['panel_url']) $panellist[$panel['panel_level']][]= "<a href=\"admin.php?action=".$panel['panel_name']."\">".$panel['panel_title']."</a>";
    		            else $panellist[$panel['panel_level']][] = "<a href=\"".$panel['panel_url']."\">".$panel['panel_title']."</a>";
 
               }
        	   return  $panellist;
            
        }    
        
          
     }
    new efiction_panels();
}
