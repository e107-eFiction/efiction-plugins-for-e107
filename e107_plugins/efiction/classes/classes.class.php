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

if (!class_exists('efiction_classes')) {
    class efiction_classes
    {
  
      public static function classtypelist()
      {
          $classtypelist = array();
          $classlistquery = 'SELECT * FROM #fanfiction_classtypes ORDER BY classtype_name';
          $result = e107::getDb()->retrieve($classlistquery, true);
          foreach ($result as $type) {
              $classtypelist[$type['classtype_id']] = array('name' => $type['classtype_name'], 'title' => stripslashes($type['classtype_title']));
          }
          return $classtypelist;
      }
        
        public static function classlist()
        {
            $classlist = array();
            $classquery = 'SELECT * FROM #fanfiction_classes ORDER BY class_name';
            $result = e107::getDb()->retrieve($classquery, true);
            foreach ($result as $class) {
                $classlist[$class['class_id']] = array('type' => $class['class_type'], 'name' => stripslashes($class['class_name']));
            }
            return $classlist;
        }
    
    }
    
    
    
    new efiction_classes();
}
