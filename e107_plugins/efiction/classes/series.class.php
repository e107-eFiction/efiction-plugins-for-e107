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

if (!class_exists('efiction_series')) {
    class efiction_series
    {
  
       public static function get_series_by_uid($series_uid = NULL) { 
       
         $query = "SELECT * from ".TABLEPREFIX."fanfiction_series WHERE uid = '".$series_uid."' ORDER BY title";
         $series = e107::getDb()->retrieve($query,true);
         return $series;
      }
      
      
       public static function serie($series_id = NULL) { 
       
         $query = "SELECT * from ".TABLEPREFIX."fanfiction_series WHERE seriesid = '".$series_id."' ORDER BY title LIMIT 1 ";
         $series = e107::getDb()->retrieve($query);
         return $series;
      }     
      
      public static function series_list() {
      
        //"SELECT series.*, "._PENNAMEFIELD." as penname FROM "._AUTHORTABLE.", ".TABLEPREFIX."fanfiction_series as series WHERE "._UIDFIELD." = series.uid ");
        $seriesquery =  _SERIESQUERY." AND seriesid = '$seriesid'  " ;
 
        $series  = e107::getDb()->retrieve($query, true);
 
        return $series;
        
        
      }
      /* $series = efiction_series::get_series_by_serieid($seriesid); */ 
      public static function get_series_by_serieid($seriesid = NULL) 
      {

         $query = "SELECT title, uid, isopen FROM ".TABLEPREFIX."fanfiction_series WHERE seriesid = '$seriesid' LIMIT 1";
         
         $series = e107::getDb()->retrieve($query);
         
          return $series;
      }
      
               
               
      
      /* $seriesstories = efiction_series:: get_stories_ids_in_series($seriesid); */
      
      public static function get_stories_ids_in_series($serieid = NULL) {
        
          $query = "SELECT sid FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid'";
      
          $seriesstories  = e107::getDb()->retrieve($query, true);
         
          return $seriesstories ;
      }
      
      
      public function member_serie_listing($uid, $current = 'efiction') {
      
        $allowseries = efiction_settings::get_single_setting('allowseries');
            if($allowseries) {
            $caption  = "<div id=\"pagetitle\">"._MANAGESERIES."</div>";
            
            $result = efiction_series::get_series_by_uid($uid);
    		$output .= "<div class='table-responsive'>";
    		$output .= "<table style=\"margin: 0 auto;\" cellpadding=\"0\" cellspacing=\"0\" class=\"tblborder\">
    			 <tr><th class=\"tblborder\">"._TITLE."</th><th class=\"tblborder\">"._OPTIONS."</th></tr>";
    
    		foreach($result AS $series) 
    		 {
    			$output .= "<tr>
                 <td class=\"tblborder\"><a href=\"viewseries.php?seriesid=".$series['seriesid']."\">".stripslashes($series['title'])."</a></td>";
    			$output .= "<td class=\"tblborder\"><div class='d-grid gap-2 d-md-flex justify-content-md-end'>
    			 <a class='btn btn-outline-primary me-md-2' href=\"series.php?action=add&amp;add=stories&amp;seriesid=".$series['seriesid']."\">"._ADD2SERIES."</a> 
    			 <a class='btn btn-outline-success me-md-2' href=\"series.php?action=edit&amp;seriesid=$series[seriesid]\">"._EDIT."</a>  
    			 <a class='btn btn-outline-danger me-md-2' href=\"series.php?action=delete&amp;seriesid=$series[seriesid]\">"._DELETE."</a></td></tr>";
    		}
    		$output .= "</table>";
    		$output .= "</div>";
    		$output .= "<div class='text-center m-2'>";
    		$output .= "<a class='btn btn-outline-success' href='series.php?action=add'>"._ADDSERIES."</a>";
    		$output .= "</div>";
            
            e107::getRender()->tablerender($caption, $output , $current);
        }    
      }
      
      
 
    
    }
    
    
    
    new efiction_series();
}
