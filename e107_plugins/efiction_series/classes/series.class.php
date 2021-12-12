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
  
	   public $caption; 
       
       
       // Renders an individual viewseries page
       public function renderSeries($series_id = '', $child = true)
       {
       
            $text = '';
			
			if($data = self::serie($series_id)) 
			{
				$this->caption = ucfirst(_SERIES1).": ".$data['title'];
				$sc = e107::getScBatch('efiction_series', true);

				$sc->setVars($data);
 
				$LAYOUT = e107::getTemplate('efiction_series', 'efiction_series', 'viewseries_layout');

				// Render series title
				$series_header = $this->loadSeriesTitle($data);

				if($child) {
					$subseries  = $this->loadSeriesChildren($series_id);
					$substories = $this->loadSeriesStories($series_id);
					
				}	

				// Render stories
			//	$stories_inseries = $this->loadRecipeInfo($data);
				
				$LAYOUT = str_replace(
				['{---SERIE-HEADER---}', '{---SUBSERIES---}', '{---STORIES-IN-SERIE---}'],
				[$series_header, $subseries, $substories],
				$LAYOUT);
 
				$text .= e107::getParser()->parseTemplate($LAYOUT, true, $sc);


				return $text; 
		   }
            
    
       }

	   private function loadSeriesChildren($series_id = NULL) 
	   {
			/* a bit complicated because mix listing of series and stories */
			/* original solution over complicated, maybe because template system, pagination  - mixing both together
			let it simplify */
			/* display subseries first */
 
			$cquery = "SELECT ins.subseriesid AS subseriesid, subserie.*  FROM ".MPREFIX."fanfiction_inseries AS ins 
			LEFT JOIN ".MPREFIX."fanfiction_series AS subserie ON subserie.seriesid = ins.subseriesid 
			WHERE ins.subseriesid > 0 AND ins.seriesid = '$series_id' AND ins.confirmed = 1
			ORDER BY ins.inorder ";  

			$inserieslist = e107::getDb()->retrieve($cquery, true);
			$text = '';
			if($inserieslist) {
				//for now
				foreach($inserieslist AS $inserie) {     
					$text .= $this->loadSeriesTitle($inserie, 'subseries_title');
				}
				
			}
			return $text;    
	   }

	   private function loadSeriesStories($series_id = NULL) {


			/* temp solution for stories */
			require_once (e_PLUGIN."efiction/includes/class.TemplatePower.inc.php");
			$tpl = new TemplatePower(e_PLUGIN."efiction/default_tpls/default.tpl");
			$tpl->assignInclude( "storyblock", e_PLUGIN."efiction/default_tpls/story_block.tpl" );
 

			require_once (e_PLUGIN."efiction/includes/corefunctions.php");
 
			$cquery = "SELECT ins.sid AS sid, external, storylink FROM ".MPREFIX."fanfiction_inseries AS ins 
			WHERE ins.sid > 0 AND ins.seriesid = '$series_id' AND ins.confirmed = 1
			ORDER BY ins.inorder ";  

			$instorieslist = e107::getDb()->retrieve($cquery, true);
			
			$text = '';
			if($instorieslist) {
				//for now
				$tpl->prepare( );
				 
				$storyblock_template =  e107::getSingleton("efiction_core")->getTpl("listings_stories.tpl");

				foreach($instorieslist AS $story) {
 
					$tpl->newBlock("storyblock");
					$squery = _STORYQUERY. " AND sid = ". $story['sid'] . " LIMIT 1"; 
					$stories = e107::getDb()->retrieve($squery);
					 
					$storyblock_vars = array();
		 
				 	include(e_PLUGIN."efiction/includes/storyblock.php");
					/*  if($story['external']) {
						$title = e107::getParser()->toHTML($stories['title']);
						if($story['storylink'])  {
							$title = "<a target='_blank'  href=\"".$story['storylink']."\">".$title."</a>";

					}

					}
					$tpl->assign("title", $title); */
					$storyblock_vars = array_change_key_case($storyblock_vars,CASE_UPPER);
					$storyblock_text = e107::getParser()->simpleParse($storyblock_template,$storyblock_vars, false);
 
					$text .= $storyblock_text;
				}
 
			 
			}
 
			return $text ;    

	   }

	   private function loadSeriesTitle($data = NULL, $template_key = "series_title" )
	   {
		   // Load shortcodes
		   $sc = e107::getScBatch('efiction_series', true);
   
		   // Pass data
		   $sc->setVars($data);
   
		   // Set wrapper
		   $sc->wrapper('efiction_series/series_title');
   
		   $SERIES_TITLE = e107::getTemplate('efiction_series', 'efiction_series', $template_key);
   
		   return e107::getParser()->parseTemplate($SERIES_TITLE, true, $sc);
	   }


       
       public static function get_series_by_uid($series_uid = NULL) { 
       
         $query = "SELECT * from ".TABLEPREFIX."fanfiction_series WHERE uid = '".$series_uid."' ORDER BY title";
         $series = e107::getDb()->retrieve($query,true);
         return $series;
      }
      
      
       public static function serie($series_id = NULL) { 
       
         $query = "SELECT series.*, author.penname as penname FROM 
		 #fanfiction_authors as author, 
		 #fanfiction_series as series 
		 WHERE author.uid = series.uid AND seriesid = '".$series_id."' ORDER BY title LIMIT 1 ";
 
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
      
       /* used in admin_config.php for OptArray*/
       public function get_series_list() {
 
		$values = array();
		$result = e107::getDb()->retrieve("SELECT seriesid, title  FROM #fanfiction_series ORDER BY title", true);
 
		$values[0] = "No serie";
		foreach ($result AS $row)
		{
			$values[$row['seriesid']] = $row['title']. " [" . $row['sid'] . "]";;
		}
 
		return $values;    
  
      }
    
    }
    
    
    
    new efiction_series();
}
