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

if (!class_exists('efiction_core')) {
	class efiction_core
	{
		protected $pref = array();



		public function __construct()
		{
			$this->pref = e107::pref('efiction');
		}

		public function init()
		{
		}
	
	
		// replace for e107::getParser()->truncate($text, $limit); see issue https://github.com/e107inc/e107/issues/4480
		public static function truncate_text($str, $n = 75, $delim = '...')
		{
			$len = strlen($str);
			if ($len > $n) {
				$pos = strpos($str, ' ', $n);
				if ($pos) {
					$str = trim(substr($str, 0, $pos), "\n\t\.,").$delim;
				}
			}
			return self::closetags($str);
		}
		
		
		// A helper function for the truncate_text function.  This will close all open tags
		public function closetags($html)
		{
			$donotclose = array('br', 'img', 'input', 'hr');
			preg_match_all('#<([a-z]+)( .*)?(?!/)>#iU', $html, $result);
			$openedtags = $result[1];

			preg_match_all('#</([a-z]+)>#iU', $html, $result);
			$closedtags = $result[1];
			$len_opened = count($openedtags);
			if (count($closedtags) == $len_opened) {
				return $html;
			}

			$openedtags = array_reverse($openedtags);

			for ($i = 0;$i < $len_opened;$i++) {
				if (!in_array($openedtags[$i], $closedtags) && !in_array($openedtags[$i], $donotclose)) {
					$html .= '</'.$openedtags[$i].'>';
				} else {
					unset($closedtags[array_search($openedtags[$i], $closedtags)]);
				}
			}
			return $html;
		}

		public function sendemail
		 ($to_name, $to_email, $from_name, $from_email, $subject,$message,$type="plain",$cc="",$bcc="", $template ="") {
                 
			$eml = array();
			$eml['email_subject']		= $subject;
			$eml['send_html']			= true;
			$eml['email_body']			= $message;
			$eml['template']			= 'default';
			// $eml['sender_email']        = $from_email;  always $pref['replyto_email']
			// $eml['sender_name']         = $from_name;   always $pref['replyto_name']
		 
			$eml['cc']			= $cc;
			$eml['bcc']			= $bcc;
			
			if($type == 'plain')   { 
			   $eml['template'] =  'textonly'; 
			   $eml['send_html'] =  false;  
			}  //texthtml
		
			 if(e107::getEmail()->sendEmail($to_email, $to_name, $eml))
			{
				return true;
			}
			else
			{
				return false;
			}
		   
		}
        
    }
}
