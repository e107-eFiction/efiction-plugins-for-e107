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

class eFiction
{
    protected $pref = array();
   
   
     
    public function __construct()
    {
        $sql = e107::getDb();

        /** @var efiction_shortcodes sc */
        // $this->sc = e107::getScParser()->getScObject('efiction_shortcodes', 'efiction', false);

        $this->get = varset($_GET);
        $this->post = varset($_POST);

        $this->pref = e107::pref('efiction');
 
        $this->settings = self::settings();

	
    }
    
    public function init()
    {
    }
 
    
    public static function catlist()
    {
        $catlist = array();
        $catquery = "SELECT * FROM #fanfiction_categories ORDER BY leveldown, displayorder";
        $result = e107::getDb()->retrieve($catquery, true);
        foreach ($result as $cat) {
            $catlist[$cat['catid']] = array('name' => stripslashes($cat['category']), 'pid' => $cat['parentcatid'], 'order' => $cat['displayorder'], 'locked' => $cat['locked'], 'leveldown' => $cat['leveldown']);
        }
        return $catlist;
    }

    public static function charlist()
    {
        $charlist = array();
        $charquery = "SELECT charname, catid, charid FROM #fanfiction_characters ORDER BY charname";
        $result = e107::getDb()->retrieve($charquery, true);
        foreach ($result as $char) {
            $charlist[$char['charid']] = array('name' => stripslashes($char['charname']), 'catid' => $char['catid']);
        }
        return $charlist;
    }

    public static function classlist()
    {
        $classlist = array();
        $classquery = "SELECT * FROM #fanfiction_classes ORDER BY class_name";
        $result = e107::getDb()->retrieve($classquery, true);
        foreach ($result as $class) {
            $classlist[$class['class_id']] = array("type" => $class['class_type'], "name" => stripslashes($class['class_name']));
        }
        return $classlist;
    }

    public static function classtypelist()
    {
        $classtypelist = array();
        $classlistquery = "SELECT * FROM #fanfiction_classtypes ORDER BY classtype_name";
        $result = e107::getDb()->retrieve($classlistquery, true);
        foreach ($result as $type) {
            $classtypelist[$type['classtype_id']] = array("name" => $type['classtype_name'], "title" => stripslashes($type['classtype_title']));
        }
        return $classtypelist;
    }

    public static function blocks()
    {
        $blocks = array();
        $blockquery = 'SELECT * FROM #fanfiction_blocks';
        $result = e107::getDb()->retrieve($blockquery, true);

        foreach ($result as $block) {
            $blocks[$block['block_name']] = e107::unserialize($block['block_variables']);
            $blocks[$block['block_name']]['title'] = $block['block_title'];
            $blocks[$block['block_name']]['file'] = $block['block_file'];
            $blocks[$block['block_name']]['status'] = $block['block_status'];
        }

        return $blocks;
    }
    
 

    public static function ratingslist()
    {
        $ratingslist = array();
        $ratlist = 'SELECT * FROM #fanfiction_ratings';
        $result = e107::getDb()->retrieve($ratlist, true);

        foreach ($result as $rate) {
            $ratingslist[$rate['rid']] = array('name' => $rate['rating'], 'ratingwarning' => $rate['ratingwarning'], 'warningtext' => $rate['warningtext']);
        }

        return $ratingslist;
    }

    public static function pagelinks()
    {
        $linkquery = 'SELECT * from #fanfiction_pagelinks ORDER BY link_access ASC' ;
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

            $linkname = $link['link_name'];
            $link_start = '<a href="'.$link['link_url'].'" title="'.$link['link_text'].'"'.($link['link_target'] ? ' target="_blank"' : '').(!empty($link['link_key']) ? " accesskey='".$link['link_key']."'" : '').($current == $link['link_name'] ? ' id="current"' : '').'>';
 
            $pagelinks[$link['link_name']] = array(
                'id' => $link['link_id'],
                'text' => $link['link_text'],
                'url' => $link['link_url'],
                'key' => $link['link_key'],
                'link' => $link_start.$link['link_text'].'</a>');
        }

        return $pagelinks;
    }


    public static function userlinks()
    {
        $linkquery = 'SELECT * from #fanfiction_pagelinks ORDER BY link_access ASC' ;
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

            $linkname = $link['link_name'];
            $link_start = '<a href="'.$link['link_url'].'" title="'.$link['link_text'].'"'.($link['link_target'] ? ' target="_blank"' : '').(!empty($link['link_key']) ? " accesskey='".$link['link_key']."'" : '').($current == $link['link_name'] ? ' id="current"' : '').'>';

            $userlinks[$link['link_name']] = $link_start.$link['link_text'].'</a>';
        }
 
        return $userlinks;
    }

    public static function userpanels()
    { 
		$settings = self::settings();
		$submissionsoff = $settings['submissionsoff'];
        $favorites = $settings['favorites'];
        
        $userpanels = array();
        $panelquery = "SELECT * FROM #fanfiction_panels WHERE panel_hidden != '1' 
        AND panel_level = '1' AND 
        (panel_type = 'U' ".(!$submissionsoff || isADMIN ? " OR panel_type = 'S'" : "").($favorites ? " OR panel_type = 'F'" : "").") 
        ORDER BY panel_type, panel_order, panel_title ASC";
        $records = e107::getDb()->retrieve($panelquery, true);

        foreach ($records as $panel) {
            if (!$panel['panel_url']) {
				$base = e107::url('efiction', 'member');
                $link =  "<a href=\"".$base."?action=".$panel['panel_name']."\">".$panel['panel_title']."</a><br />\n";
            } else {
                $link = "<a href=\"".$panel['panel_url']."\">".$panel['panel_title']."</a><br />\n";
            }
            $userpanels[$panel['panel_name']] =  $link;
        }

        return $userpanels;
    }

	public static function favourite_panels($uid = NULL)
    { 
		$settings = self::settings();
		$submissionsoff = $settings['submissionsoff'];
        $favorites = $settings['favorites'];
        
        $userpanels = array();
        $panelquery = "SELECT * FROM #fanfiction_panels WHERE panel_type = 'F' AND panel_name != 'favlist' ORDER BY panel_title ASC";
        $records = e107::getDb()->retrieve($panelquery, true);

		foreach ($records as $panel) {
			if(substr($panel['panel_name'], 0, 3) == "fav" && $type = substr($panel['panel_name'], 3)) {
			if($panel['panel_name'] == "favlist") continue;
            
			$itemcount = 0;
			$countquery = "SELECT COUNT(item) AS itemcount FROM #fanfiction_favorites WHERE uid = '$uid' AND type = '$type'";
			$itemcount =e107::getDb()->retrieve($countquery );
		 
			if (!$panel['panel_url']) {
				$base = e107::url('efiction', 'member');
                $link =  "<a href=\"".$base."?action=".$panel['panel_name']."\">".$panel['panel_title']."[".$itemcount."]</a><br />\n";
            } else {
                $link = "<a href=\"".$panel['panel_url']."\">".$panel['panel_title']."[".$itemcount."]</a><br />\n";
            }
 
			$favpanels[$panel['panel_name']] =  $link;
		    }
        }  
        return $favpanels;
    }
    
    public static function panel_byaction($action = '' )
    {
        
		$settings = self::settings();
		$submissionsoff = $settings['submissionsoff'];
        $favorites = $settings['favorites'];
  
        $panelquery = "SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_name = '$action' 
        AND (panel_type='U' ".(!$submissionsoff || isADMIN ? " OR panel_type = 'S'" : "").($favorites ? " OR panel_type = 'F'" : "").") LIMIT 1";
        
        $panel  = e107::getDb()->retrieve($panelquery);
        if($panel['panel_level'] > 0 && !isMEMBER) accessDenied( );

		if($panel['panel_url'] && file_exists(_BASEDIR.$panel['panel_url'])) { 
			$panel['use_panel'] =  _BASEDIR.$panel['panel_url'];
		}
		else if(file_exists(e_PLUGIN."efiction/panels/user/{$action}.php")) {
			$panel['use_panel'] =  "panels/user/{$action}.php";  		 
		}
 
        return $panel;
    } 
    
    public static function panel_bytype($type = '' )
    {
 
        $panelquery = "SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_name = '$type' AND panel_type = 'B' LIMIT 1";
        
        $panel  = e107::getDb()->retrieve($panelquery);
        
        if($panel['panel_level'] > 0 && !isMEMBER) accessDenied( );

		if($panel['panel_url'] && file_exists(_BASEDIR.$panel['panel_url'])) { 
			$panel['use_panel'] =  _BASEDIR.$panel['panel_url'];
		}
		else if(file_exists(_BASEDIR."/browse/{$type}.php")) {
			$panel['use_panel'] =  _BASEDIR."/browse/{$type}.php";  		 
		}
 
        return $panel;
    }   
    
    
    public function get_userlink($key = null)
    {
        if (null === $key) {
            $ret = self::userlinks();
            return $ret;
        }

        $links = self::userlinks();
        $ret = isset($links[$key]) ? $links[$key] : null;
        return $ret;
    }

    public function get_block($key = null)
    {
        if (null === $key) {
            $ret = self::blocks();
            return $ret;
        }

        $blocks = self::blocks();
        $ret = isset($blocks[$key]) ? $blocks[$key] : null;
        return $ret;
    }
    
  

    /*
    $settingsresults = dbquery("SELECT * FROM ".$settingsprefix."fanfiction_settings WHERE sitekey = '".$sitekey."'");
$settings = dbassoc($settingsresults);
if(!defined("SITEKEY")) define("SITEKEY", $settings['sitekey']);
unset($settings['sitekey']);
if(!defined("TABLEPREFIX")) define("TABLEPREFIX", $settings['tableprefix']);
unset($settings['tableprefix']);
define("STORIESPATH", $settings['storiespath']);
unset($settings['storiespath']);
foreach($settings as $var => $val) {
    $$var = stripslashes($val);
    $settings[$var] = htmlspecialchars($val);
}
*/

    public static function settings($setting_name = null)
    {
        $settingslist = array();
        // $settingsquery = 'SELECT * FROM #fanfiction_settings WHERE sitekey = '".$sitekey."'  ;
        $settingsquery = 'SELECT * FROM #fanfiction_settings '  ;
        $settings = e107::getDb()->retrieve($settingsquery);
        
        if($setting_name) {
           return $settings[$setting_name]; 
        }
 
        return $settings;
    }
  
}
