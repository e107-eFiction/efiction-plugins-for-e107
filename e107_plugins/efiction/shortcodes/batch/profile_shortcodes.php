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

/*
{PROFILE_USERPENNAME}
{PROFILE_REALNAME}
{PROFILE_MEMBERSINCE}
{PROFILE_USERLEVEL}
{PROFILE_IMAGE}
{PROFILE_BIO}
{PROFILE_AUTHORFIELDS}
{PROFILE_ADMINOPTIONS}
{PROFILE_REPORTTHIS}
*/

class plugin_efiction_profile_shortcodes extends e_shortcode
{
 
    public function __construct()
	{
 

	}

    /* {PROFILE_ADMINOPTIONS} */
	public function sc_profile_adminoptions($parm = null)
	{
        $uid = $this->var['uid'];  
        $userinfo = $this->var; 
        $adminopts = "";
        if(isADMIN && uLEVEL < 3) {
        	$adminopts .= "<span class='label'>"._ADMINOPTIONS.":</span> ".(isset($userinfo['validated']) && $userinfo['validated'] ? "[<a  href=\"admin.php?action=members&amp;revoke=$uid\" class=\"btn btn-sm btn-outline--danger vuadmin\">"._REVOKEVAL."</a>] " : "[<a href=\"admin.php?action=members&amp;validate=$uid\" class=\"btn btn-sm btn-outline-success vuadmin\">"._VALIDATE."</a>] ")."[<a href=\"member.php?action=editbio&amp;uid=$uid\" class=\"btn btn-sm  btn-outline-success vuadmin\">"._EDIT."</a>] [<a href=\"admin.php?action=members&amp;delete=$uid\" class=\"btn btn-sm btn-outline-danger vuadmin\">"._DELETE."</a>]";
        	$adminopts .= " [<a href=\"admin.php?action=members&amp;".($userinfo['level'] < 0 ? "unlock=".$userinfo['uid']."\" class=\"btn btn-sm btn-outline-info vuadmin\">"._UNLOCKMEM : "lock=".$userinfo['uid']."\" class=\"btn btn-sm btn-outline-secondary vuadmin\">"._LOCKMEM)."</a>]";
        	$adminopts .= " [<a href=\"admin.php?action=admins&amp;".(isset($userinfo['level']) && $userinfo['level'] > 0 ? "revoke=$uid\" class=\"btn btn-sm btn-outline-danger vuadmin\">"._REVOKEADMIN."</a>] [<a href=\"admin.php?action=admins&amp;do=edit&amp;uid=$uid\" class=\"btn btn-sm btn-outline-info vuadmin\">"._EDITADMIN : "do=new&amp;uid=$uid\" class=\"btn btn-sm btn-outline-warning vuadmin\">"._MAKEADMIN)."</a>]";
        	 
            return $adminopts;
        }

    }
    /* {PROFILE_AUTHORFIELDS} */
	public function sc_profile_authorfields($parm = null)
	{  
        /* way how to get just efiction custom fields:
        $dynamicfields = array();
          foreach ($user_data as $key => $value) {
              if (strpos($key, 'user_plugin_efiction_') === 0) {
                  $dynamicfields[$key] = $value;
              }
          }
        */
        
        $authorfields = '';
 
        $user = $this->var['user'];
      //  if(empty($user)) return '';
        
        $user_shortcodes = e107::getScBatch('user');
        $user_shortcodes->wrapper('user/view');
        
        $user_shortcodes->setVars($user);
        $user_shortcodes->setScVar('userProfile', $user);
        
        e107::setRegistry('core/user/profile', $user);
        $text = "{USER_EXTENDED_ALL}";
        $dynamicfields = e107::getParser()->parseTemplate( $text, TRUE, $user_shortcodes); 
        
        if(!empty($dynamicfields)) $authorfields = $dynamicfields ;
        return $authorfields;
        
    }
    /* {PROFILE_BIO} */
	public function sc_profile_bio($parm = null)
	{
        if($this->var['bio']) {
    	   $bio = nl2br($this->varo['bio']);	
    	   return stripslashes($bio) ;
        }
    }
    
    /* {PROFILE_CODEBLOCK} */
    public function sc_profile_codeblock($parm = null)
    {
        if ($parm == 'userprofile') {
            
            $codequery = "SELECT * FROM #fanfiction_codeblocks WHERE code_type = 'userprofile'";
            $codes = e107::getDb()->retrieve($codequery, true);
   
            foreach ($codes as $code) {
                 
                eval($code['code_text']);
            }
            $text = $output;
            print_a($output);
            return $text;
       } 
    }
    
    /* {PROFILE_IMAGE} */
	public function sc_profile_image($parm = null)
	{
    if($this->var['image'])
	return "<img src=\"".$this->var['image']."\">" ;
    
    }
    /* {PROFILE_MEMBERSINCE} */
	public function sc_profile_membersince($parm = null)
	{
        //$tpl->assign("membersince", date("$dateformat", $userinfo['date']));
        //
        return e107::getDate()->convert_date($this->var['date'], "forum");
 
    }
    /* {PROFILE_REALNAME} */
	public function sc_profile_realname($parm = null)
	{
        if($this->var['realname'])
    	return $this->var['realname'];
    }
    /* {PROFILE_REPORTTHIS} */
	public function sc_profile_reportthis($parm = null)
	{
	  $start = '[';
      $end = ']';
      $class = '';
      if(!empty($parm['class'])) {
        $class = ' class ="'.$parm['class'].'"' ;
        $start = '';
        $end = '';
      }
      
      $text=
      $start."<a ".$class." href=\""._BASEDIR."report.php?action=report&amp;url=viewuser.php?uid=".$this->var['uid']."\">"._REPORTTHIS."</a>".$end;
      return $text;
	}
    /* {PROFILE_USERLEVEL} */
	public function sc_profile_userlevel($parm = null)
	{
       $level = isset($this->var['level']) && $this->var['level'] > 0 && $this->var['level'] < 4 ? _ADMINISTRATOR.(isADMIN ? " - ".$this->var['level'] : "") : _MEMBER;
       return $level;
    }
    /* {PROFILE_USERPENNAME} */
	public function sc_profile_userpenname($parm = null)
	{
 
      return $this->var['penname'];
    }
    
    /* {PROFILE_NAMEINFO} */
	public function sc_profile_nameinfo($parm = null)
	{
        $userinfo = $this->var;
        /*
        $nameinfo = "";
        if($userinfo['email'])
        	$nameinfo .= " [<a href=\"viewuser.php?action=contact&amp;uid=".$userinfo['uid']."\">"._CONTACT."</a>]";
        if(!empty($favorites) && isMEMBER && $userinfo['uid'] != USERUID) {
        	$fav = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_favorites WHERE uid = '".USERUID."' AND type = 'AU' AND item = '".$userinfo['uid']."'");
        	if(dbnumrows($fav) == 0) $nameinfo .= " [<a href=\"member.php?action=favau&amp;uid=".USERUID."&amp;add=".$userinfo['uid']."\">"._ADDAUTHOR2FAVES."</a>]";
        }
        */
        $nameinfo = "";
        if($userinfo['email'])
        	$nameinfo .= " [<a href=\"viewuser.php?action=contact&amp;uid=".$userinfo['uid']."\">"._CONTACT."</a>]";
        if(!empty($favorites) && isMEMBER && $userinfo['uid'] != USERUID) {
            $fav = e107::getDb()->retrieve("SELECT * FROM ".TABLEPREFIX."fanfiction_favorites WHERE uid = '".USERUID."' AND type = 'AU' AND item = '".$userinfo['uid']."'");
            if(!$fav)  {
                $nameinfo .= " [<a href=\"member.php?action=favau&amp;uid=".USERUID."&amp;add=".$userinfo['uid']."\">"._ADDAUTHOR2FAVES."</a>]";
            }
        }
    }    
 

}
