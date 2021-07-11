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

        public static function get_single_author($uid = null)
        {
            $uid = intval($uid);
            if (empty($uid)) {
                return false;
            }
            $authorquery = "SELECT ap.*, 
			author.uid as author_uid, 
			author.penname as penname, 
			author.email as email, 
			author.password as password,
			user_id AS e107_user_id 
			FROM #fanfiction_authors as author 
			LEFT JOIN #fanfiction_authorprefs as ap ON ap.uid = author.uid WHERE author.uid = '".$uid."'"  ;

            $authordata = e107::getDb()->retrieve($authorquery);

            $var = array();

            if ($authordata) {
                $var = $authordata;
            }

            return $var;
        }

        public static function get_single_author_by_user($user_id = null)
        {
            $user_id = intval($user_id);

            if (empty($user_id)) {
                return false;
            }

            $userData = e107::user($user_id);

            $author_uid = $userData['user_plugin_efiction_author'];

            return efiction_authors::get_single_author($author_uid);
        }

        public static function get_user_id_by_author($uid = null)
        {
            $uid = intval($uid);

            if (empty($uid)) {
                return false;
            }

            $where = ' user_plugin_efiction_author = '.$uid;

            $user_id = e107::getDb()->retrieve('user_extended', '	user_extended_id', $where);

            return $user_id;
        }

        /* used for author select in storyform */
        public static function get_authors_list()
        {
            $authors = array();
            $authorquery = 'SELECT author.penname as penname, author.uid as uid FROM #fanfiction_authors as author ORDER BY author.penname';
            $authorsarray = e107::getDb()->retrieve($authorquery, true);
            foreach ($authorsarray as $authorresult) {
                $authors[$authorresult['uid']] = $authorresult['penname'];
            }
            return $authors;
        }
    }

    new efiction_authors();
}
