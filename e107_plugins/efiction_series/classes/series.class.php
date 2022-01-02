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
       
 
        public function getCaption($series_id = '')
        {
            if ($data = self::serie($series_id)) {
                $this->caption = ucfirst(_SERIES1).": ".$data['title'];
            }

            return $this->caption;
        }
    
        public function renderSeriesDetail($data = NULL, $template_key = 'default_item')
        {
            $text = '';
            if ($data) {
                $sc = e107::getScBatch('efiction_series', true);
                $sc->setVars($data);
                $sc->wrapper('efiction_series/series_title');
                $SeriesDetail = e107::getTemplate('efiction_series', 'efiction_series', $template_key);
                $text = e107::getParser()->parseTemplate($SeriesDetail, true, $sc);
            }

            return $text;
        }

 
        public function renderSeriesChildren($series_id = null)
        {
            /* a bit complicated because mix listing of series and stories */
            /* original solution over complicated, maybe because template system, pagination  - mixing both together
            let it simplify */
 
            $cquery = "SELECT ins.subseriesid AS subseriesid, subserie.*  FROM ".MPREFIX."fanfiction_inseries AS ins 
			LEFT JOIN ".MPREFIX."fanfiction_series AS subserie ON subserie.seriesid = ins.subseriesid 
			WHERE ins.subseriesid > 0 AND ins.seriesid = '$series_id' AND ins.confirmed = 1
			ORDER BY ins.inorder ";

            $inserieslist = e107::getDb()->retrieve($cquery, true);
            $text = '';
            if ($inserieslist) {
                //for now
                foreach ($inserieslist as $inserie) {
                    $text .= $this->loadSeriesTitle($inserie, 'subseries_title');
                }
            }
            return $text;
        }

        public function renderSeriesStories($series_id = null)
        {
 
            //$cquery = "SELECT ins.sid AS sid, external, storylink FROM ".MPREFIX."fanfiction_inseries AS ins
            $cquery = "SELECT ins.sid AS sid FROM ".MPREFIX."fanfiction_inseries AS ins 
			WHERE ins.sid > 0 AND ins.seriesid = '$series_id' AND ins.confirmed = 1
			ORDER BY ins.inorder ";

            $instorieslist = e107::getDb()->retrieve($cquery, true);
 
            $text = '';
            if ($instorieslist) {
                //for now
 
				$sc = e107::getScParser()->getScObject('story_shortcodes', 'efiction', false);
				$text = '';
 
				$template = e107::getTemplate('efiction_series', 'efiction_series', 'story');

                foreach ($instorieslist as $story) {
                  
                    $squery = _STORYQUERY. " AND sid = ". $story['sid'] . " LIMIT 1";
                    $stories = e107::getDb()->retrieve($squery);
                     
                    $storyblock_vars = array();
					$sc->setVars($stories);
                    
					$text .=  e107::getParser()->parseTemplate($template['item'], true, $sc);   
					
					$storytext .= e107::getRender()->tablerender('', $text , "none", true);	
  
                }
            }
 
            return $storytext ;
        }

        public function renderSeriesComments($data = NUL)
        {
            $item = $data['seriesid'];
            $series_title = $data['title'];
            $type = "SE";
            $rate = true;
 
            $prevStyle = e107::getRender()->getStyle();
            e107::getRender()->setStyle('nocaption');
            $form =  e107::getSingleton('efiction_comments')->render($type, $item, $series_title, $rate);
            // //   $form  = e107::getComment()->render($type, $item, $series_title, $rate);
            e107::getRender()->setStyle($prevStyle);
            $text  = $form;


            return $text;
        }
 
       
        public static function get_series_by_uid($series_uid = null)
        {
            $query = "SELECT * from ".TABLEPREFIX."fanfiction_series WHERE uid = '".$series_uid."' ORDER BY title";
            $series = e107::getDb()->retrieve($query, true);
            return $series;
        }
      
      
        public static function serie($series_id = null)
        {
            $query = "SELECT series.*, author.penname as penname FROM 
		 #fanfiction_authors as author, 
		 #fanfiction_series as series 
		 WHERE author.uid = series.uid AND seriesid = '".$series_id."' ORDER BY title LIMIT 1 ";
 
            $series = e107::getDb()->retrieve($query);
            return $series;
        }
      
        public static function series_list()
        {
      
        //"SELECT series.*, "._PENNAMEFIELD." as penname FROM "._AUTHORTABLE.", ".TABLEPREFIX."fanfiction_series as series WHERE "._UIDFIELD." = series.uid ");
            $seriesquery =  _SERIESQUERY." AND seriesid = '$seriesid'  " ;
 
            $series  = e107::getDb()->retrieve($query, true);
 
            return $series;
        }


        /* $series = efiction_series::get_series_by_serieid($seriesid); */
        public static function get_series_by_serieid($seriesid = null)
        {
            $query = "SELECT title, uid, isopen FROM ".TABLEPREFIX."fanfiction_series WHERE seriesid = '$seriesid' LIMIT 1";
         
            $series = e107::getDb()->retrieve($query);
         
            return $series;
        }
 
        /* $seriesstories = efiction_series:: get_stories_ids_in_series($seriesid); */
      
        public static function get_stories_ids_in_series($serieid = null)
        {
            $query = "SELECT sid FROM ".TABLEPREFIX."fanfiction_inseries WHERE seriesid = '$seriesid'";
      
            $seriesstories  = e107::getDb()->retrieve($query, true);
         
            return $seriesstories ;
        }
      
      
        public function member_serie_listing($uid, $current = 'efiction')
        {
            $allowseries = efiction_settings::get_single_setting('allowseries');
            if ($allowseries) {
                $caption  = "<div id=\"pagetitle\">"._MANAGESERIES."</div>";
            
                $result = efiction_series::get_series_by_uid($uid);
                $output .= "<div class='table-responsive'>";
                $output .= "<table style=\"margin: 0 auto;\" cellpadding=\"0\" cellspacing=\"0\" class=\"tblborder\">
    			 <tr><th class=\"tblborder\">"._TITLE."</th><th class=\"tblborder\">"._OPTIONS."</th></tr>";
    
                foreach ($result as $series) {
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
            
                e107::getRender()->tablerender($caption, $output, $current);
            }
        }
      
        /* used in admin_config.php for OptArray*/
        public function get_series_list()
        {
            $values = array();
            $result = e107::getDb()->retrieve("SELECT seriesid, title  FROM #fanfiction_series ORDER BY title", true);
 
            $values[0] = "No serie";
            foreach ($result as $row) {
                $values[$row['seriesid']] = $row['title']. " [" . $row['sid'] . "]";
                ;
            }
 
            return $values;
        }
    }
    
    
    
    new efiction_series();
}
