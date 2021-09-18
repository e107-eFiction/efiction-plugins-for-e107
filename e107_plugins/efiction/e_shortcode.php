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

if (!defined('e107_INIT')) {
    exit;
}

class efiction_shortcodes extends e_shortcode
{

    /*
     Not needed with e107 menus and tablerender 
     {EFICTION_BLOCK_CONTENT: key=info}
     {EFICTION_BLOCK_CONTENT: key=news}
     {EFICTION_BLOCK_CONTENT: key=categories}
     {EFICTION_BLOCK_CONTENT: key=recent}
     {EFICTION_BLOCK_CONTENT: key=random}
	 {EFICTION_BLOCK_CONTENT: key=featured}
     {EFICTION_BLOCK_CONTENT: key=menu}
    */
    
    public function sc_efiction_block_content($parm = NULL)
    {    
        global $current;
        
        if ($parm == '') {
            return '';
        }
        $pagelinks = efiction_pagelinks::get_pagelinks();
        $blocks = efiction_blocks::get_blocks();  //all blocks have to be used, because blocks/... 
        
        $block = $parm['key'];
        $value = $blocks[$block];

        if(empty($value['status']) || ($value['status'] == 2 && $current != "home")) return '';
        if(empty($value['file'])) return '';
 
        if($value['status'] && file_exists(_BASEDIR."blocks/".$value['file'])) {
            $content = "";
            if(file_exists(_BASEDIR."blocks/".$value['file'])) include(_BASEDIR."blocks/".$value['file']);
            $block_content =  $content;
            return $block_content;  
        }
           
        return $block_content;    
    }
    
    
    /*  {EFICTION_LINK} */
    /*  {EFICTION_LINK=rss} - doesn't work on live site, on local it works. Data issue? */
    /*  example for login menu 
    {EFICTION_LINK: key=adminarea&class=list-group-item} 
    {EFICTION_LINK: key=login&class=list-group-item}   
    {EFICTION_LINK=adminarea} 
    {EFICTION_LINK=login} 
    {EFICTION_LINK=logout}
    */
    public function sc_efiction_link($parm = '')
    { 
		if($parm == "") { return ''; }
    
        $key = (!empty($parm['key'])) ? $parm['key'] : $parm;
        
	     
	    $link = efiction_pagelinks::get_single_link($key);
        /* why don't use this: $url = e107::url('efiction', $key, $data);
          key for e107::url() is admin.php not adminarea
          use still need link name
        */ 
 
		$class = (!empty($parm['class'])) ? $parm['class']. ' ' .$key  : $key;
        
		if($link) {    
			return $link;
		}
		else return "";
		 
    }
    
}