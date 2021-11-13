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

if (!class_exists('efiction_settings')) {
    class efiction_settings
    {
        public function __construct()
        {
        }
        
        
        public static function get_alphabet() {
            include_once(e_PLUGIN."efiction/languages/".e_LANGUAGE."_alphabet.php");
            return $alphabet; 
        }

        public static function get_settings()
        {
            $table_name = MPREFIX.'fanfiction_settings';

            $sitekey = e107::getInstance()->getSitePath();

            $query = 'SELECT * FROM '.$table_name." WHERE sitekey = '".$sitekey."' LIMIT 1 "  ;

            $settings = e107::getDb()->retrieve($query);

            /* replace not used settings */
            $settings['sitekey'] = $sitekey;
            $settings['sitename'] = SITENAME;
            $settings['slogan'] = SITETAG;
            $settings['url'] = SITEURL;
            $settings['tableprefix'] = e107::getDB()->mySQLPrefix;
            $settings['siteemail'] = ADMINEMAIL;
            $settings['language'] = e_LANGUAGE;
            
            /* defalt values */
            $settings['recentdays'] = varset($settings['recentdays'], 7);
            if(defined("USERUID") AND USERID) {
            	
                $user_prefs = e107::getDb()->retrieve("SELECT sortby, storyindex, tinyMCE FROM ".MPREFIX."fanfiction_authorprefs WHERE uid = '".USERUID."'");
               
            	if(dbnumrows($prefs)) list($defaultsort, $displayindex, $tinyMCE) = dbrow($prefs);
            }

      

            unset($settings['smtp_host'], $settings['smtp_username'], $settings['smtp_password']);
 
            return $settings;
        }

        public static function get_single_setting($setting_name)
        {
            $settings = self::get_settings();
 
            if ($setting_name) {
                return $settings[$setting_name];
            }

            return null;
        }
        
        /*instead tinymce yes/no */
        public static function get_available_editors()
        {
                $editor['default'] = EFICTION_EDITOR_217; 
        		$editor['bbcode'] = 'BBCode';
        
        		$editors = e107::getPlug()->getInstalledWysiwygEditors();
        		if (!empty($editors))
        		{
        			$editor = array_merge($editor, $editors);
        		}
                
                return $editor;
        }       
        
        
        
    }

    new efiction_settings();
}
