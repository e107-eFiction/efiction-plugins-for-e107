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

class eAuthors
{
    public function __construct()
    {
    }

    public function init()
    {
    }

    /* used for author select in storyform */
    public function get_authors_list()
    {
        $authors = array();
        $authorquery = 'SELECT author.penname as penname, author.uid as uid FROM #fanfiction_authors as author ORDER BY author.penname';
        $authorsarray = e107::getDb()->retrieve($authorquery, true);
        foreach ($authorsarray as $authorresult) {
            $authors[$authorresult['uid']] = $authorresult['penname'];
        }
        return $authors;
    }

    /* full author data related to efiction user ID */
    public function get_author_data($uid = null)
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
        FROM #fanfiction_authors as author LEFT JOIN #fanfiction_authorprefs as ap ON ap.uid = author.uid WHERE author.uid = '".$uid."'"  ;

        $authordata = e107::getDb()->retrieve($authorquery);

        $var = array();

        if ($authordata) {
            $var = $authordata;
        }

        return $var;
    }

    /* full author data related to e107 user ID */
    public function get_author_data_by_user_id($user_id = null)
    {
        $user_id = intval($user_id);

        if (empty($user_id)) {
            return false;
        }

        $where = ' user_id = '.$user_id;

        $authorquery = 'SELECT *, ap.* 
        FROM #fanfiction_authors as author LEFT JOIN #fanfiction_authorprefs as ap ON ap.uid = author.uid WHERE '.$where.' LIMIT 1' ;

        $authordata = e107::getDb()->retrieve($authorquery);

        $var = array();

        if ($authordata) {
            $var = $authordata;
        }

        return $var;
    }

    /* just author ID by e107 user ID */
    public function get_author_id_by_user_id($user_id = null)
    {
        $user_id = intval($user_id);

        if (empty($user_id)) {
            return false;
        }

        $where = ' user_id = '.$user_id;

        $authorquery = 'SELECT uid 
        FROM #fanfiction_authors as author WHERE '.$where.' LIMIT 1' ;

        $authorid = e107::getDb()->retrieve($authorquery);

        $var = 0;

        if ($authorid) {
            $var = $authorid;
        }

        return $var;
    }

    /* just e107 user ID  by author ID */
    public function get_user_id_by_author_id($uid = null)
    {
        $uid = intval($uid);

        if (empty($uid)) {
            return false;
        }

        $where = ' uid = '.$uid;

        $authorquery = 'SELECT user_id 
        FROM #fanfiction_authors as author WHERE '.$where.' LIMIT 1' ;

        $userid = e107::getDb()->retrieve($authorquery);

        $var = false;

        if ($userid) {
            $var = $userid;
        }

        return $var;
    }
}
