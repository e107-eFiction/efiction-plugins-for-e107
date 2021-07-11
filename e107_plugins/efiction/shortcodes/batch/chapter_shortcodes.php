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

class plugin_efiction_chapter_shortcodes extends e_shortcode
{
	public function __construct()
	{
	}

	/* {CHAPTER_VIEW_LINK} */
	public function sc_chapter_view_link($parm)
	{
		$chapter = $this->var;
		$url = 'viewstory.php?sid='.$chapter['sid'].'&amp;chapter='.$chapter['inorder'];
		return $url;
	}

	/* {CHAPTER_VIEW_TITLE} */
	public function sc_chapter_view_title($parm)
	{
		$chapter = $this->var;
		$text = e107::getParser()->toHTML($this->var['title'], true, 'TITLE');
		return $text;
	}

	/* {CHAPTER_REORDER} */
	public function sc_chapter_reorder($parm)
	{
		global  $up, $down;
		$chapter = $this->var;
 
		$chapters = $this->var['chapters'];
		if ($chapters > 1) {
			$text = ($chapter['inorder'] == 1 ? '' :
			"<a href=\"stories.php?action=viewstories&amp;go=up&amp;sid=".$chapter['sid']."&amp;chapid=".$chapter['chapid']."&amp;inorder=".$chapter['inorder']."\">$up</a>").
			($chapter['inorder'] == $chapters ? '' :
			"<a href=\"stories.php?action=viewstories&amp;go=down&amp;sid=".$chapter['sid']."&amp;chapid=".$chapter['chapid']."&amp;inorder=".$chapter['inorder']."\">$down</a>");
		}
		return $text;
	}

	/* {CHAPTER_EDIT_BUTTON} */
	public function sc_chapter_edit_button($parm)
	{
		$chapter = $this->var;
		$text = "<a class='btn btn-success' href=\"stories.php?action=editchapter&amp;chapid=".$chapter['chapid'].($this->admin ? '&amp;admin=1&amp;uid='.$chapter['uid'] : '')."\">"._EDIT.'</a>';
		return $text;
	}

	/* {CHAPTER_DELETE_BUTTON} */
	public function sc_chapter_delete_button($parm)
	{
		$chapter = $this->var;
		$text = "<a class='btn btn-danger'  href=\"stories.php?action=delete&amp;chapid=".$chapter['chapid'].($this->admin ? '&amp;admin=1&amp;uid='.$chapter['uid'] : '')."\">"._DELETE.'</a>';
		return $text;
	}
}
