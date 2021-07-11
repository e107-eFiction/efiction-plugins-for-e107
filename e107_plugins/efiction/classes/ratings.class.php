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

if (!class_exists('efiction_ratings')) {
    class efiction_ratings
    {
        public function __construct()
        {
        }
 

		/* all data, id => array() */
		public static function get_ratings()
		{
			$ratingslist = array();

			$table_name = MPREFIX.'fanfiction_ratings';
			$$query = 'SELECT * FROM '.$table_name  ;

			$result = e107::getDb()->retrieve($ratlist, true);

			foreach ($result as $rate) {
				$ratingslist[$rate['rid']] = array('name' => $rate['rating'], 'ratingwarning' => $rate['ratingwarning'], 'warningtext' => $rate['warningtext']);
			}

			return $ratingslist;
		}


		/* used for ratings select in storyform */
		/* ID => NAME */
		// used in story_shortcodes.php, series_shortcodes.php
		public function get_ratings_list()
		{
			$authors = array();
			$ratingquery = 'SELECT rid, rating FROM #fanfiction_ratings';
			$ratingsarray = e107::getDb()->retrieve($ratingquery, true);

			foreach ($ratingsarray as $ratingresult) {
				$ratings[$ratingresult['rid']] = $ratingresult['rating'];
			}

			return $ratings;
		}

        public static function get_single_rating($rating_name)
        {
            $ratings = self::get_ratings();

            if ($rating_name) {
                return $ratings[$rating_name];
            }

            return null;
        }
    }

    new efiction_ratings();
}
