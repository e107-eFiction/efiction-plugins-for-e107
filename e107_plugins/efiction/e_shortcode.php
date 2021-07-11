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
    public $override = false; // when set to true, existing core/plugin shortcodes matching methods below will be overridden.
    public $settings = false;

    public function __construct()
    {
    }

    /*
      {EFICTION_MESSAGES: key=welcome&strip=1} replaced with {WMESSAGE} removed div and p tags
      {EFICTION_MESSAGES: key=rules}  used in pages
      {EFICTION_MESSAGES: key=maintenance}
      {EFICTION_MESSAGES: key=printercopyright} in viewstory
      {EFICTION_MESSAGES: key=copyright}
      {EFICTION_MESSAGES: key=thankyou}  in yesletter.php
      {EFICTION_MESSAGES: key=nothankyou} in noletter.php
      {EFICTION_MESSAGES: key=tos} in e107 signup template 
    */

    public function sc_efiction_messages($parm = NULL)
    {
     
        if ($parm == '') {
            return '';
        }
        
        if(varset($parm['key'])) { 
            $key = $parm['key'];  
            $query = "SELECT message_text FROM #fanfiction_messages WHERE message_name = '{$key}'  LIMIT 1 " ;
        }
        else return '';
        
        $text = e107::getDB()->retrieve($query);
        
        if(varset($parm['strip']) === 'blocks')
		{
			$text = e107::getParser()->stripBlockTags($text);
		}
        
 
       return $text ? e107::getParser()->toHTML($text, true, 'BODY') : '';
    }
    
    /*
     Not needed with e107 menus and tablerender 
     {EFICTION_BLOCK_CAPTION: key=info}
     {EFICTION_BLOCK_CAPTION: key=random}
     {EFICTION_BLOCK_CAPTION: key=categories}
     {EFICTION_BLOCK_CAPTION: key=recent}
     {EFICTION_BLOCK_CAPTION: key=news}
    */
    
    public function sc_efiction_block_caption($parm = NULL)
    {    
        global $current;
        if ($parm == '') {
            return '';
        }
 
        $block = $parm['key'];
        $value = efiction_blocks::get_single_block($block);  
 
        if(empty($value['status']) || ($value['status'] == 2 && $current != "home")) return '';
        if(empty($value['file'])) return '';
        
        if($value['status'] /* && file_exists(_BASEDIR."blocks/".$value['file'])  */ ) {
            $content = "";
            $title = !empty($value['title']) ? stripslashes($value['title']) : "";   
            
        }
        
        return $title;
    }

    
    /*
     Not needed with e107 menus and tablerender 
     {EFICTION_BLOCK_CONTENT: key=info}
     {EFICTION_BLOCK_CONTENT: key=login}
     {EFICTION_BLOCK_CONTENT: key=news}
     {EFICTION_BLOCK_CONTENT: key=categories}
     {EFICTION_BLOCK_CONTENT: key=recent}
     {EFICTION_BLOCK_CONTENT: key=random}
	 {EFICTION_BLOCK_CONTENT: key=featured}
    */
    
    public function sc_efiction_block_content($parm = NULL)
    {    
        global $current;
        
        if ($parm == '') {
            return '';
        }
        
        $blocks = efiction::blocks();
        
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
    */
    public function sc_efiction_link($parm = '')
    { 
		if($parm == "") { return ''; }
        
        $key = (!empty($parm['key'])) ? $parm['key'] : $parm;
	    $efiction = e107::getSingleton('efiction', e_PLUGIN.'efiction/classes/efiction.class.php');
		$link = $efiction->get_userlink($key);
         
		$class = (!empty($parm['class'])) ? $parm['class']. ' ' .$key  : $key;
        
		if($link) {    
			return "<li class='".$class."'>".$link."</li>";
		}
		else return "";
		 
    }

	/* {EFICTION_MENU_CONTENT} */
	public function sc_efiction_menu_content()
	{
		//$block = $efiction->get_block('menu'); 
		$blocks = efiction::blocks();
		$pagelinks = efiction::userlinks();

		foreach ($blocks['menu']['content'] as $page) {
			if (isset($pagelinks[$page]['link'])) {
				if (empty($blocks[$block]['style'])) {
					$content .= '<li '.($current == $page ? 'id="menu_current"' : '').'>'.$pagelinks[$page]['link'].'</li>';
				} else {
					$content .= $pagelinks[$page]['link'];
				}
			}
		}

		return $content;
	}

 

     /* {EFICTION_SORTFORM} */
    public function sc_efiction_sortform() {
    
    global $disablesorts, $terms, $type;
     
     $browse_template = e107::getTemplate('efiction', 'browse', 'searchform');
     $sc_browse = e107::getScParser()->getScObject('efiction_shortcodes', 'efiction', false);
     $search_vars = array();
     $sc_browse->wrapper('browse/searchform');
     
     $search_vars['sortbegin'] = 
		"<form style=\"margin:0\" method=\"POST\" id=\"form\" enctype=\"multipart/form-data\" action=\"browse.php?type=home\">";
 
        $disablesorts = array('cw_lang','cw_warning','cw_words', 'pairing'  ); 

		//require_once(__DIR__ . '/../../includes/pagesetup.php');
		$catlist = efiction::catlist(); 
		$charlist = efiction::charlist();
		$classlist = efiction::classlist();
		$classtypelist = efiction::classtypelist();
		$ratingslist = $ratlist = efiction::ratingslist();
        
    	/* CATEGORIES */
    	if($catlist && !in_array("categories", $disablesorts)) {
    		if(count($catid) > 0) $thiscat = $catid[0];
    		else $thiscat = -1;
    		$catmenu = "<select name=\"catid\" id=\"catid\"
    		onChange='browseCategories(\"catid\")'><option value=\"-1\">".($thiscat > 0 ? _BACK2CATS : _CATEGORIES)."</option>\n";
    		foreach($catlist as $cat => $info) {
    			if($info['pid'] == $thiscat || $cat == $thiscat) $catmenu .= "<option value=\"$cat\"".($thiscat == $cat ? " selected" : "").">".$info['name']."</option>\n";
    		}
    		$catmenu .= "</select>";
    
    		$search_vars['categorymenu'] = $catmenu;
    	}
    
         //todo fix
     
		 if(count($charlist) > 0 && !in_array("characters", $disablesorts)) {
			$charactermenu1 = "<select name=\"charlist1\" id=\"charlist1\">\n";
			$charactermenu1 .= "<option value=\"0\">"._CHARACTERS."</option>\n";
			$charactermenu2 = "<select name=\"charlist2\" id=\"charlist2\">\n";
			$charactermenu2 .= "<option value=\"0\">"._CHARACTERS."</option>\n";
			$categories[] = -1;
			//$categories = array_merge($categories, $catid);
			foreach($charlist as $char => $info) {
				if(is_array($categories) && in_array($info['catid'], $categories)) {
					$charactermenu1 .= "<option value=\"$char\"";
					if(isset($charid[0]) && $charid[0] == $char)
						$charactermenu1 .= " selected";
					$charactermenu1 .= ">".$info['name']."</option>\n";
					$charactermenu2 .= "<option value=\"$char\"";
					if(isset($charid[1]) && $charid[1] == $char)
						$charactermenu2 .= " selected";
					$charactermenu2 .= ">".$info['name']."</option>\n";
				}
			}
			$charactermenu1 .= "</select>";
			$charactermenu2 .= "</select>";
			if($type != "characters") $search_vars['charactermenu1']  = $charactermenu1 ;
			$search_vars['charactermenu2']  = $charactermenu2 ;
		}
        
        if(!in_array("ratings", $disablesorts)) {
				$ratingmenu = " <select class=\"textbox custom-select-box\"  name=\"rating\">\n";
				$ratingmenu .= "<option value=\"0\">"._RATINGS."</option>\n";
				if(!isset($ratingslist)) $ratingslist = array( );
				foreach($ratingslist as $r => $rinfo) {
					$ratingmenu .= "<option value=\"".$r."\"";
					if(isset($rid) && in_array($r, $rid))
						$ratingmenu .= " selected";
					$ratingmenu .= ">".$rinfo['name']."</option>\n";
				}
				$ratingmenu .= "</select> ";
				$search_vars['ratingmenu'] = $ratingmenu;
	    }
            
        
        
       $search_vars['sortend'] = "<div class=\"form-group col-lg-12 col-md-6 col-sm-12 text-center\">
                                        <button type=\"submit\" class=\"uix-btn uix-btn__border--thin uix-btn__margin--b uix-btn__size--s uix-btn__bg--primary\">"._GO."</button>
                                </div>
                            </form>";
                            
 			// To avoid throwing warnings we need to define $classopts and tell it how many elements it should have.
			if(!in_array("classes", $disablesorts)) {
				$classopts = array();  
				foreach($classlist as $id => $vars) {
                    
					if(empty($classopts[$vars['type']])) $classopts[$vars['type']] = "";
					$classopts[$vars['type']] = $classopts[$vars['type']]."<option value=\"$id\"".(isset($classin) && is_array($classin) && in_array($id, $classin) ? " selected" : "").">".$vars['name']."</option>\n";
				}
				$allclasses = "";  
 
                $wrap_start = $browse_template['wrap_start'];
                $wrap_end = $browse_template['wrap_end'];
				foreach($classopts as $type => $opts) { 
					if(empty($type) || in_array($classtypelist[$type]['name'], $disablesorts)) continue; // Because of the way we defined $classopts we need to skip the empty first element.
					$opts = "<option value=\"\">".$classtypelist[$type]['title']."</option>$opts";
					$tmp = $classtypelist[$type]['name']."menu"; 
					$search_vars[$tmp] = " <select name=\"".$classtypelist["$type"]['name']."\">\n$opts</select> ";
                    
					$allclasses .= $wrap_start." <select name=\"".$classtypelist["$type"]['name']."\">\n$opts</select> ".$wrap_end;  
				}
      
				$search_vars['classmenu'] = $allclasses;
			}


			if(!in_array("sorts", $disablesorts)) 
			$search_vars['sortmenu']  = "<select class=\"textbox custom-select-box\"  name=\"sort\">\n<option value=''>"._SORT."</option><option value=\"alpha\"".(!$defaultsort ? " selected" : "").">"._ALPHA."</option>\n<option value=\"update\"".($defaultsort == 1 ? " selected" : "").">"._MOSTRECENT."</option>\n</select>";

			if(!in_array("complete", $disablesorts)) 
			$search_vars['completemenu'] = "<select class=\"textbox custom-select-box\"  name=\"complete\">\n<option value=\"all\"".($complete == "all" ? " selected" : "").">"._ALLSTORIES."</option>\n<option value=\"1\"".($complete == 1 ? " selected" : "").">"._COMPLETEONLY."</option>\n<option value=\"0\"".($complete && $complete != "all" && $complete != 1 ? " selected" : "").">"._WIP."</option>\n</select>" ;
	

       
     $sc_browse->setVars($search_vars);
     $text = e107::getParser()->parseTemplate($browse_template['index'], true, $sc_browse);
 
     return $text;
   
    
    }

	 
 
}
