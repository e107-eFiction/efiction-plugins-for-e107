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

if (!defined('e107_INIT')) { exit; }
$text = '';

if(is_string($parm))
{
	parse_str($parm, $parms);
}
else
{
	$parms = $parm;
}

if(isset($parms['block_caption'][e_LANGUAGE]))
{
	$caption = $parms['block_caption'][e_LANGUAGE];
}
else $caption = $parms['block_caption']; 

 
 
//don't use it, it is part of content already  
/* {EFICTION_BLOCK_CAPTION=info} 
if($caption == '') {
    $code = "{EFICTION_BLOCK_CAPTION: key={$parms['block_name']}}"; 
    $caption =  e107::getParser()->parseTemplate($code);   
}
 */
/* {EFICTION_BLOCK_CONTENT=info} */
if($parm['block_name'] ) {
 $code = "{EFICTION_BLOCK_CONTENT: key={$parms['block_name']}}";  
 $text =  e107::getParser()->parseTemplate($code);
}
 
echo $text;
/* 
tablerender is used already in {EFICTION_BLOCK_CAPTION} 
$style =  e107::getParser()->parseTemplate($parms['shortcode_menuTableStyle']);    
 
e107::getRender()->tablerender($caption, $text, $style );
*/