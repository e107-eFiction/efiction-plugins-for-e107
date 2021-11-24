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

if (!class_exists('efiction_characters')) {

	/*query = 'SELECT charname, catid, charid FROM #fanfiction_characters ORDER BY charname';*/ 
    class efiction_characters
    {    
        /* $charlist id => array(name, catid) */
        public static function charlist()
        {
            $charlist = array( );
            $query = "SELECT charname, catid, charid FROM ".TABLEPREFIX."fanfiction_characters ORDER BY charname";
         
            $result = e107::getDb()->retrieve($query, true);
            foreach ($result as $char) {
                $charlist[$char['charid']] = array("name" => stripslashes($char['charname']), "catid" => $char['catid']);
			}
            return $charlist;
        }


		/* characters by category, id => name */

        public static function characters($catid = -1) {

			$characters = array( );
            $query = "SELECT charname, catid, charid FROM ".TABLEPREFIX."fanfiction_characters ORDER BY charname";

			$result = e107::getDb()->retrieve($query, true);   
            foreach ($result as $charresults) {
				if ((is_array($catid) && in_array($charresults['catid'], $catid)) || $charresults['catid'] == -1) {
					$characters[$charresults['charid']] = stripslashes($charresults['charname']);
				}
            }

			return $characters;

		}
       

    }
    new efiction_characters();
}
