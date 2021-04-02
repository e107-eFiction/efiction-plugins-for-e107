<?php
/*
* Copyright (c) e107 Inc e107.org, Licensed under GNU GPL (http://www.gnu.org/licenses/gpl.txt)
 
*/

if(!defined('e107_INIT'))
{
	exit;
}

class efiction_shortcodes extends e_shortcode
{
	public $override = false; // when set to true, existing core/plugin shortcodes matching methods below will be overridden. 
  	public $settings  = false;
  
  	function __construct()
	{
  		  
	}
  
  
    /* 
      {FANFICTION_MESSAGES=welcome} replaced with {WMESSAGE}
      {FANFICTION_MESSAGES=rules}  used in pages
      {FANFICTION_MESSAGES=maintenance}  
      {FANFICTION_MESSAGES=printercopyright} in viewstory
      {FANFICTION_MESSAGES=copyright}
      {FANFICTION_MESSAGES=thankyou}  in yesletter.php
      {FANFICTION_MESSAGES=nothankyou} in noletter.php
      
      custom pages - SELECT * FROM ".TABLEPREFIX."fanfiction_messages WHERE message_id = $edit LIMIT 1");
    */
     
    function sc_fanfiction_messages($parm = '') {
      if($parm == '') {
        return '';
      } 
      $query =  "SELECT message_text FROM #fanfiction_messages WHERE message_name = '{$parm}'" ;
      
      $text = e107::getDB()->retrieve($query);
 
      return $text;
    
    }
}
