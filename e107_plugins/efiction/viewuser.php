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

// Identify the current page for the pagelinks etc.
$current = "viewuser";

// Include some files for page setup and core functions
require_once(HEADERF);
include ("header.php");
include(_BASEDIR."includes/pagesetup.php");	

// FIX THIS !!!
// If uid isn't a number kill the script with an error message.  The only way this happens is a hacker.
if(empty($uid)) {
	if(!isMEMBER) accessDenied( );
	else $uid = USERUID;
}

$userinfo = e107::getDb()->retrieve("SELECT *, UNIX_TIMESTAMP(date) as date FROM "._AUTHORTABLE." LEFT JOIN ".TABLEPREFIX."fanfiction_authorprefs as ap ON ap.uid = "._UIDFIELD." WHERE "._UIDFIELD." = '$uid' LIMIT 1");

if($userinfo) {
	$userinfo['user_id'] = fiction_authors::get_single_user_by_author($uid);  //used for e107 stuff
	$userinfo['action'] = $action;  //used for tabs
	$userinfo['current'] = $viewuser; //default for tablerender
	$viewuser_template = e107::getTemplate('efiction', 'user', 'user');
	
	$sc_viewuser = e107::getScBatch('user', 'efiction');
	$sc_viewuser->setVars($userinfo);

	$viewuser_title = e107::getParser()->parseTemplate($viewuser_template['title'], true, $sc_viewuser);
	$viewuser_content = e107::getParser()->parseTemplate($viewuser_template['content'], true, $sc_viewuser);
	
	$viewuser_tablerender = varset($viewuser_template['tablerender'], 'user');
	
//	e107::getRender()->tablerender($viewuser_title, $viewuser_content, $viewuser_tablerender );
} 
else {
	accessDenied();
}
require_once(FOOTERF);  
exit( );