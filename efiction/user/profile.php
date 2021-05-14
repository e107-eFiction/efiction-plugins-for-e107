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

if (!defined('e107_INIT')) { exit; }
 
//$result2 = dbxquery("SELECT *, UNIX_TIMESTAMP(date) as date FROM "._AUTHORTABLE." LEFT JOIN ".TABLEPREFIX."fanfiction_authorprefs as ap ON ap.uid = "._UIDFIELD." WHERE "._UIDFIELD." = '$uid' LIMIT 1");
$userinfo = e107::getDb()->retrieve("SELECT *, UNIX_TIMESTAMP(date) as date FROM "._AUTHORTABLE." LEFT JOIN ".TABLEPREFIX."fanfiction_authorprefs as ap ON ap.uid = "._UIDFIELD." WHERE "._UIDFIELD." = '$uid' LIMIT 1");
 
$user_id = eauthors::get_user_id_by_author_id($uid);   
$userinfo['user'] = e107::user($user_id);  

$template = e107::getTemplate('efiction', 'profile', 'profile');  
$sc_profile = e107::getScParser()->getScObject('profile_shortcodes', 'efiction', false);
$sc_profile->wrapper('profile/profile');  //not working
$sc_profile->setVars($userinfo);
$profile_title = e107::getParser()->parseTemplate($template['title'], true, $sc_profile);
$profile_content = e107::getParser()->parseTemplate($template['content'], true, $sc_profile);
$profile_tablerender = $template['tablerender'];   
$profiler_tablerender = varset($profile_tablerender, 'profile');
 
e107::getRender()->tablerender($profile_title, $profile_content, $profile_tablerender );
 
 
 