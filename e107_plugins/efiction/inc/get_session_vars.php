<?php
// ----------------------------------------------------------------------
// eFiction 3.5.5.
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
 
if (USERID) {  //fully managed by e107, user is logged in
    $userData = e107::user(USERID);
 
    $author_uid = $userData['user_plugin_efiction_author'];
    $author_level = $userData['user_plugin_efiction_level'];

	if ($author_level != -1) {   //it can be admin without author, uLevel is too important to relay on author ID
		define('uLEVEL', $author_level);
		define('isADMIN', uLEVEL > 0 ? true : false);
	}

    if ($author_uid > 0) { //user is author
        $authordata = efiction_authors::get_single_author($author_uid);
		define('USERUID', $authordata['uid']);
		define('USERPENNAME', $authordata['penname']);
		define('isMEMBER', true);
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
