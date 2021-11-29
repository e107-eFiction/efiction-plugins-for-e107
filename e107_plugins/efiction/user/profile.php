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

if(!defined("_CHARSET")) exit( );

// Build the user's profile information
 
$profile_template =  e107::getSingleton("efiction_core")->getTpl("user_profile.tpl");

$profile_vars = array();  //all key have to be listed ? fixed with array_change_key_case() 
 
$userinfo = efiction_authors::get_single_author($uid);
 
if($userinfo['email'] && $userinfo['admincreated'] == 0 )
	$nameinfo .= " [<a href=\"viewuser.php?action=contact&amp;uid=".$userinfo['uid']."\">"._CONTACT."</a>]";
    
if(!empty($favorites) && isMEMBER && $userinfo['uid'] != USERUID) {
	$fav = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_favorites WHERE uid = '".USERUID."' AND type = 'AU' AND item = '".$userinfo['uid']."'");
	if(dbnumrows($fav) == 0) $nameinfo .= " [<a href=\"member.php?action=favau&amp;uid=".USERUID."&amp;add=".$userinfo['uid']."\">"._ADDAUTHOR2FAVES."</a>]";
}
$profile_vars["userpenname"] =  $userinfo['penname']." ".$nameinfo;
 
$profile_vars["membersince"] =  e107::getDate()->convert_date($userinfo['date'], "forum");  
if($userinfo['realname'])
	$profile_vars["realname"] =  $userinfo['realname'];
 
if($userinfo['user_signature']) {
//	$bio = e107::getParser()->toHTML($this->var['bio'];	 + stripslashes($bio);
	$profile_vars["USER_SIGNATURE"] =  e107::getParser()->toHTML($userinfo['user_signature'], TRUE);
}
    
if($userinfo['bio']) {
//	$bio = e107::getParser()->toHTML($this->var['bio'];	 + stripslashes($bio);
	$profile_vars["BIO"] =  e107::getParser()->toHTML($userinfo['bio'], TRUE);
}

if($userinfo['image'])
	$profile_vars["image"] =  "<img src=\"".$userinfo['image']."\">";
        
$profile_vars["userlevel"] =  isset($userinfo['level']) && $userinfo['level'] > 0 && $userinfo['level'] < 4 ? _ADMINISTRATOR.(isADMIN ? " - ".$userinfo['level'] : "") : _MEMBER;


/* Dynamic authorinfo fields */
$authorfields = '';
 
$user_shortcodes = e107::getScBatch('user');
$user_shortcodes->wrapper('user/view');

$user_shortcodes->setVars($userinfo);
$user_shortcodes->setScVar('userProfile', $userinfo);

e107::setRegistry('core/user/profile', $userinfo);
$text = "{USER_EXTENDED_ALL}";

$dynamicfields = e107::getParser()->parseTemplate( $text, TRUE, $user_shortcodes); 
if(!empty($dynamicfields)) $profile_vars["authorfields"] = $authorfields;
/* End dynamic fields */

/* Custom code */
$codequery = "SELECT * FROM #fanfiction_codeblocks WHERE code_type = 'userprofile'";
$codes = e107::getDb()->retrieve($codequery, true);
foreach ($codes as $code) {         
        eval($code['code_text']);
}
/* End of custom code */         
 
$profile_vars["reportthis"] =  "[<a class='btn btn-reporthis' href=\"".e_PLUGIN_ABS."efiction/report.php?action=report&amp;url=viewuser.php?uid=".$uid."\">"._REPORTTHIS."</a>]";

$adminopts = "";
if(isADMIN && uLEVEL < 3) {
	$adminopts .= "<div class=\"adminoptions\"><span class='label'>"._ADMINOPTIONS.":</span> ".(isset($userinfo['validated']) && $userinfo['validated'] ? "[<a href=\"admin.php?action=members&amp;revoke=$uid\" class=\"vuadmin\">"._REVOKEVAL."</a>] " : "[<a href=\"admin.php?action=members&amp;validate=$uid\" class=\"vuadmin\">"._VALIDATE."</a>] ")."[<a href=\"member.php?action=editbio&amp;uid=$uid\" class=\"vuadmin\">"._EDIT."</a>] [<a href=\"admin.php?action=members&amp;delete=$uid\" class=\"vuadmin\">"._DELETE."</a>]";
	$adminopts .= " [<a href=\"admin.php?action=members&amp;".($userinfo['level'] < 0 ? "unlock=".$userinfo['uid']."\" class=\"vuadmin\">"._UNLOCKMEM : "lock=".$userinfo['uid']."\" class=\"vuadmin\">"._LOCKMEM)."</a>]";
	$adminopts .= " [<a href=\"admin.php?action=admins&amp;".(isset($userinfo['level']) && $userinfo['level'] > 0 ? "revoke=$uid\" class=\"vuadmin\">"._REVOKEADMIN."</a>] [<a href=\"admin.php?action=admins&amp;do=edit&amp;uid=$uid\" class=\"vuadmin\">"._EDITADMIN : "do=new&amp;uid=$uid\" class=\"vuadmin\">"._MAKEADMIN)."</a>]</div>";
	$profile_vars["adminoptions"] =  $adminopts;
}
 
$profile_vars = array_change_key_case($profile_vars,CASE_UPPER);
$profile_text = e107::getParser()->simpleParse($profile_template,$profile_vars, false);
$profile_text = e107::getParser()->parseTemplate($profile_text, true); //to fix LANs. remove empty shortcodes

 