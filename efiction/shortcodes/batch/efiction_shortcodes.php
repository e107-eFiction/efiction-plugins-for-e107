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

        /* {STORY_AUTHORS_LINK} TODO: TEMPLATE */

        public function sc_story_authors_link($parm)
        {
            $stories = $this->var;

            if ($stories['coauthors'] > 0) {
                $authlink[] = '<a href="'.e_BASE.'viewuser.php?uid='.$stories['uid'].'">'.$stories['penname'].'</a>';
                $coauth_query = 'SELECT '._PENNAMEFIELD.' as penname, co.uid FROM #fanfiction_coauthors AS co LEFT JOIN '._AUTHORTABLE.' ON co.uid = '._UIDFIELD." WHERE co.sid = '".$stories['sid']."'" ;

                $records = e107::getDb()->retrieve($coauth_query, true);

                foreach ($records as $coauth) {
                    $v = $coauth['penname'];
                    $k = $coauth['uid'];
                    $authlink[] = '<a href="'.e_BASE.'viewuser.php?uid='.$k.'">'.$v.'</a>';
                }
            }
            if (isset($authlink)) {
                return implode(', ', $authlink);
            } else {
                return '<a href="'.e_BASE.'viewuser.php?uid='.$stories['uid'].'">'.$stories['penname'].'</a>';
            }
        }

        /* {STORY_SUMMARY}
        {STORY_SUMMARY: limit=100}
        {STORY_SUMMARY: limit=full}
        */
        public function sc_story_summary($parm)
        {
            $stories = $this->var;
            $text = e107::getParser()->toHTML($this->var['summary'], true, 'TITLE');
			 
            $limit = ($stories['sumlength'] > 0 ? $stories['sumlength'] : 75);  
            if (!empty($parm['limit'])) {
                $limit = $parm['limit'];
            }
            if ($limit == 'full') {
                return $text;
            } else {
                $text = e107::getParser()->truncate($stories['summary'], $limit);
                return $text;
            }
        }

        /* {STORY_TITLE_LINK} */
        /* TODO: sessions */
        public function sc_story_title_link($parm)
        {
            global $ageconsent, $disablepopups;
            
            $tp = e107::getParser();
            $stories = $this->var;
 
            $ratingslist = efiction::ratingslist();
		 
            $rating = $stories['rid'];
			$row['story_sef'] = eHelper::title2sef($stories['title'],'dashl');

        	$warningtext = !empty($ratingslist[$rating]['warningtext']) ? addslashes(strip_tags($ratingslist[$rating]['warningtext'])) : "";
			
			if(empty($ratingslist[$rating]['ratingwarning'])) {
			    $row['story_query'] = "sid=".$stories['sid'];
				$url = e107::url("efiction", "viewstory", $row, "full");  
      			$title = "<a href='{$url}'>".$stories['title']."</a>";
			}	  
      		else {
      	 
      			$warninglevel = sprintf("%03b", $ratingslist[$rating]['ratingwarning']);
				 
      			if($warninglevel[2] && !e107::getSession()->is(SITEKEY."_warned_{$rating}")) {
					$row['story_query'] = "sid=".$stories['sid']."&warning=$rating"; 
      				$location = e107::url("efiction", "viewstory", $row, "full"); 
      				$warning = $warningtext;
      			}
      			elseif($warninglevel[1] && !$ageconsent && !e107::getSession()->is(SITEKEY."_ageconsent")) {
					$row['story_query'] = "sid=".$stories['sid']."&ageconsent=ok&warning=$rating";
      				$location = e107::url("efiction", "viewstory", $row, "full"); 
      				$warning = _AGECHECK." - "._AGECONSENT." ".$warningtext." -- 1";
      			}
      			elseif($warninglevel[0] && !isMEMBER) {
      				$location = "member.php?action=login&amp;sid=".$stories['sid'];
      				$warning = _RUSERSONLY." - $warningtext";		
      			}
      			
				if(!empty($warning)) {
      				$warning = preg_replace("@'@", "\'", $warning);

      				$title = "<a href=\"javascript:if(confirm('".$warning."')) location = '$location'\">".$stories['title']."</a>";
      			}
      			else {
					  $row['story_query'] = "sid=".$stories['sid'];
					  $url = e107::url("efiction", "viewstory", $row, "full");  
					  $title = "<a href='{$url}'>".$stories['title']."</a>";
				}
      		}
            return $title;
        }

        /* {STORY_RATING_NAME} */
        public function sc_story_rating_name($parm)
        {
            $stories = $this->var;
            if (class_exists('efiction')) {
                $ratingslist = efiction::ratingslist();
                $rating_name = $ratingslist[$stories['rid']]['name'];
                return $rating_name;
            }
            return '';
        }
    }
