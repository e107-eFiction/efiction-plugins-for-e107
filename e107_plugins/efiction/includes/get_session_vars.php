<?php
// ----------------------------------------------------------------------
// eFiction 3.2
// Copyright (c) 2007 by Tammy Keefer
// Valid HTML 4.01 Transitional
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

if (!defined('e107_INIT')) {
    exit;
}
 
 
if (USERID) {

         /* options:
         - normal e107 user, single author access, author user_id is used, EUA are not needed
         - normal e107 user with different author access  =  normal e107 user with author admin rights admin = 1 , EUA are not needed ?  Could it be so simply?
         - e107 admin with efiction plugin rights  = uLevel = 1 + isAdmin = true
         */
 
    $authordata = efiction_authors::get_single_author_by_user(USERID);
    
    if (getperms('0'))  //e107 superadmin
    {
		define('uLEVEL', "1");
		define('isADMIN', true);
	}
    
    if (getperms('P'))  //full plugin admin
    {
		define('uLEVEL', "2");
		define('isADMIN', true);
	}
     
    if ($authordata) {
        define('USERUID', $authordata['uid']);
        define('USERPENNAME', $authordata['penname']);
        define('isMEMBER', true);
                
        if (!defined('uLEVEL')) {
            define('uLEVEL', $authordata['level']);
        }
        
        if (!defined('isADMIN')) { 
           define("isADMIN", uLEVEL > 0 ? true : false);
        }
            
        if (e107::getSession()->is(SITEKEY.'_ageconsent')) {
            $ageconsent = e107::getSession()->get(SITEKEY.'_ageconsent');
        } else {
            $ageconsent = $authordata['ageconsent'];
        }
    }
} else {
    if (!defined('USERUID')) {
        define('USERUID', 0);
    }
    if (!defined('USERPENNAME')) {
        define('USERPENNAME', false);
    }
    if (!defined('uLEVEL')) {
        define('uLEVEL', 0);
    }
    if (!defined('isMEMBER')) {
        define('isMEMBER', false);
    }
    if (!defined('isADMIN')) {
        define('isADMIN', false);
    }
}

if (!defined('USERUID')) {
    define('USERUID', 0);
}
if (!defined('USERPENNAME')) {
    define('USERPENNAME', false);
}
if (!defined('uLEVEL')) {
    define('uLEVEL', 0);
}
if (!defined('isMEMBER')) {
    define('isMEMBER', false);
}
if (!defined('isADMIN')) {
    define('isADMIN', false);
}

if (empty($siteskin)) {
    $siteskin = $defaultskin;
}
