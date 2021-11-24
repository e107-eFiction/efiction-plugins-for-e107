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

if (!class_exists('efiction_authors')) {
    class efiction_authors
    {
        public function __construct()
        {
        }

        /* indenpendent on e107 users */
        public static function get_single_author($uid = null)
        {
            $uid = intval($uid);
            if (empty($uid)) {
                return false;
            }
            
            /* double check if fanfiction_authorprefs exists - otherwise there is uid = null */
            if(!e107::getDb()->retrieve("SELECT * FROM ".TABLEPREFIX."fanfiction_authorprefs WHERE uid = '".$uid."' LIMIT 1")) {
                $insert = array(
    			'uid'    =>  $uid,
    			'_DUPLICATE_KEY_UPDATE' => 1
          		);
          		e107::getDB()->insert("fanfiction_authorprefs", $insert);
            }
        
            $authorquery = "SELECT author.*, ap.*,  u.*, 
			author.user_id AS user_id, 
            author.uid  AS uid
			FROM ".MPREFIX."fanfiction_authors as author  
			LEFT JOIN ".MPREFIX."fanfiction_authorprefs as ap ON ap.uid = author.uid  
            LEFT JOIN ".MPREFIX."user as u ON u.user_id = author.user_id WHERE author.uid =  ".$uid;

            $authordata = e107::getDb()->retrieve($authorquery);
 
            $var = array();

            if ($authordata) {
                unset($authordata['user_prefs']);
                $var = $authordata;
                
            }
 
            return $var;
        }
        
        /* get author information on e107 profile page */
        public static function get_single_author_by_user($user_id = null)
        {
            $user_id = intval($user_id);

            if (empty($user_id)) {
                return false;
            }
            
            $authorquery = "SELECT author.*, ap.*,  
			user_id AS e107_user_id 
			FROM ".MPREFIX."fanfiction_authors as author  
			LEFT JOIN ".MPREFIX."fanfiction_authorprefs as ap ON ap.uid = author.uid WHERE author.user_id =  ".$user_id ;
            
            $authordata = e107::getDb()->retrieve($authorquery);

            return $authordata;
        }
        
        public static function get_penname_by_uid($uid = NULL) 
        {
             $uid = intval($uid);

            if (empty($uid)) {
                return false;
            }
            
           
           $authorquery = "SELECT "._PENNAMEFIELD." FROM "._AUTHORTABLE." WHERE "._UIDFIELD." = '$uid' LIMIT 1 ";
           
           $penname = e107::getDb()->retrieve($authorquery);
           
           return $penname;
        }
 
        /*
        public static function get_user_id_by_author_uid($uid = null)
        {
            $uid = intval($uid);

            if (empty($uid)) {
                return false;
            }

            $where = ' user_plugin_efiction_author_uid = '.$uid;

            $user_id = e107::getDb()->retrieve('user_extended', 'user_extended_id', $where);
 
            return $user_id;
        }
        
*/
        public function get_author_avatar($uid = null, $parm = NULL) {
          $avatar = '';
          $author = self::get_single_author($uid);
          
          if( isset($author['user_id'])) {
          
            $parm['type'] = 'url';
            $avatar =  e107::getParser()->toAvatar($author, $parm);
          }
           
          return $avatar;
        }
 
        
    }

    new efiction_authors();
}
