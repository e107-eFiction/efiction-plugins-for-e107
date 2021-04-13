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

    

    /*  {EFICTION_LINK} */
    /* {EFICTION_LINK=rss} - doesn't work on live site, on local it works. Data issue? */
    public function sc_efiction_link($parm = '')
    { 
		if($parm == "") { return ''; }

	    $efiction = e107::getSingleton('efiction', e_PLUGIN.'efiction/efiction.class.php');
		 
		$link = $efiction->get_userlink($parm);
		
        
		if($link) {    
			return "<li class=".$parm.">".$link."</li>";
		}
		else return "";
		 
    }


	/* {EFICTION_MENU_CONTENT} */
    public function sc_efiction_menu_content()
    {
 
		//$block = $efiction->get_block('menu'); 
		$blocks = efiction::blocks();
        $pagelinks = efiction::pagelinks();

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
  
		//require_once(__DIR__ . '/../../includes/pagesetup.php');
		$catlist = efiction::catlist(); 
		$charlist = efiction::charlist();
		$classlist = efiction::classlist();
		$classtypelist = efiction::classtypelist();
		$ratingslist = $ratlist = efiction::ratingslist();

		//temp
		$template2 = 
		'<section class="property-search-section style-two">
        	<div class="auto-container">
				<div class="property-search-form-two wow fadeInUp">
					<div class="title"><h5>Search For Stories</h5></div>
                		<div class="form-inner">
								<div id="sortform">
                                   {sortbegin} 
									<div class="row">
											{categorymenu}
											{charactermenu1} {charactermenu2} {pairingsmenu} {ratingmenu} {classmenu} {sortmenu} {completemenu} 
									</div>
									</div>
									{sortend}
								</div> 
							 
						</div>
					</div>
				</div>
			</div>
		</section>';
        
        $template = 
		'<section class="property-search-section">
		      <div class="auto-container">
			     <div class="property-search-tabs tabs-box">
                    <div class="property-search-form">
						<div id="sortform">
                             {sortbegin} 
									<div class="row">
									   {categorymenu} {classmenu} {ratingmenu}    {sortmenu}  
									</div>
                             {sortend}
						</div>			
					</div>		 
			 	</div>
			</div>
		</div>
	</section>';

		$var['sortbegin'] = 
		"<form style=\"margin:0\" method=\"POST\" id=\"form\" enctype=\"multipart/form-data\" action=\"browse.php?type=recent\">";

		/* CATEGORIES */
		if($catlist && !in_array("categories", $disablesorts)) {
			if(count($catid) > 0) $thiscat = $catid[0];
			else $thiscat = -1;
			$catmenu = "<div class='form-group col-lg-4 col-md-6 col-sm-12 '><select class=\"textbox custom-select-box\"  name=\"catid\" id=\"catid\"
			onChange='browseCategories(\"catid\")'><option value=\"-1\">".($thiscat > 0 ? _BACK2CATS : _CATEGORIES)."</option>\n";
			foreach($catlist as $cat => $info) {
				if($info['pid'] == $thiscat || $cat == $thiscat) $catmenu .= "<option value=\"$cat\"".($thiscat == $cat ? " selected" : "").">".$info['name']."</option>\n";
			}
			$catmenu .= "</select></div>";

			$var['categorymenu'] = $catmenu;
		}
 
         //todo fix
         $disablesorts = array('cw_lang','cw_warning','cw_words', 'pairing', 'ratings' ); 
		if(count($charlist) > 0 && !in_array("characters", $disablesorts)) {
			$charactermenu1 = "<div class='form-group col-lg-4 col-md-6 col-sm-12 hidden-sm-down '><select class=\"textbox custom-select-box\"  name=\"charlist1\" id=\"charlist1\">\n";
			$charactermenu1 .= "<option value=\"0\">"._CHARACTERS."</option>\n";
			$charactermenu2 = "<div class='form-group col-lg-4 col-md-6 col-sm-12 hidden-sm-down '><select class=\"textbox custom-select-box\"  name=\"charlist2\" id=\"charlist2\">\n";
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
			$charactermenu1 .= "</select></div>";
			$charactermenu2 .= "</select></div>";
			if($type != "characters") $var['charactermenu1']  = $charactermenu1 ;
			$var['charactermenu2']  = $charactermenu2 ;
		}

			// To avoid throwing warnings we need to define $classopts and tell it how many elements it should have.
			if(!in_array("classes", $disablesorts)) {
				$classopts = array();  
				foreach($classlist as $id => $vars) {
                    
					if(empty($classopts[$vars['type']])) $classopts[$vars['type']] = "";
					$classopts[$vars['type']] = $classopts[$vars['type']]."<option value=\"$id\"".(isset($classin) && is_array($classin) && in_array($id, $classin) ? " selected" : "").">".$vars['name']."</option>\n";
				}
				$allclasses = "";  
				foreach($classopts as $type => $opts) {
					if(empty($type) || in_array($classtypelist[$type]['name'], $disablesorts)) continue; // Because of the way we defined $classopts we need to skip the empty first element.
					$opts = "<option value=\"\">".$classtypelist[$type]['title']."</option>$opts";
					$tmp = $classtypelist[$type]['name']."menu"; 
					$var[$tmp] = "<div class='form-group col-lg-4 col-md-6 col-sm-12'><select name=\"".$classtypelist["$type"]['name']."\">\n$opts</select></div>";
					$allclasses .= "<div class='form-group col-lg-4 col-md-6 col-sm-12'><select class=\"textbox custom-select-box\"  name=\"".$classtypelist["$type"]['name']."\">\n$opts</select></div>";
				}
				$var['classmenu'] = $allclasses;
			}

			if(!in_array("ratings", $disablesorts)) {
				$ratingmenu = "<div class='form-group col-lg-4 col-md-6 col-sm-12'><select class=\"textbox custom-select-box\"  name=\"rating\">\n";
				$ratingmenu .= "<option value=\"0\">"._RATINGS."</option>\n";
				if(!isset($ratingslist)) $ratingslist = array( );
				foreach($ratingslist as $r => $rinfo) {
					$ratingmenu .= "<option value=\"".$r."\"";
					if(isset($rid) && in_array($r, $rid))
						$ratingmenu .= " selected";
					$ratingmenu .= ">".$rinfo['name']."</option>\n";
				}
				$ratingmenu .= "</select></div>";
				$var['ratingmenu'] = $ratingmenu;
			}
			if(!in_array("sorts", $disablesorts)) 
			$var['sortmenu']  = "<div class='form-group col-lg-4 col-md-6 col-sm-12'><select class=\"textbox custom-select-box\"  name=\"sort\">\n<option value=''>"._SORT."</option><option value=\"alpha\"".(!$defaultsort ? " selected" : "").">"._ALPHA."</option>\n<option value=\"update\"".($defaultsort == 1 ? " selected" : "").">"._MOSTRECENT."</option>\n</select></div>";

			if(!in_array("complete", $disablesorts)) 
			$var['completemenu'] = "<div class='form-group col-lg-4 col-md-6 col-sm-12'><select class=\"textbox custom-select-box\"  name=\"complete\">\n<option value=\"all\"".($complete == "all" ? " selected" : "").">"._ALLSTORIES."</option>\n<option value=\"1\"".($complete == 1 ? " selected" : "").">"._COMPLETEONLY."</option>\n<option value=\"0\"".($complete && $complete != "all" && $complete != 1 ? " selected" : "").">"._WIP."</option>\n</select></div" ;
	

            $var['sortend'] = "<div class=\"form-group col-lg-12 col-md-6 col-sm-12 text-center\">
                                <button type=\"submit\" class=\"theme-btn btn-style-one col-md-3\"><span class=\"btn-title\">"._GO."</span></button>
                            </div>
                            </form>";
 

		$text .= e107::getParser()->simpleParse($template, $var);
     return $text;
    
    }
 
}
