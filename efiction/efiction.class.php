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

class eFiction
{
    private $text = null;
    private $caption = null;

    /**
     * @var array Array with
     */
    protected static $customerFields = array();

    public function __construct()
    {
        $sql = e107::getDb();

        /** @var efiction_shortcodes sc */
        $this->sc = e107::getScParser()->getScObject('efiction_shortcodes', 'efiction', false);

        $this->get = varset($_GET);
        $this->post = varset($_POST);

        $this->pref = e107::pref('efiction');

        $this->initPrefs();
    }

    public static function blocks()
    {
        $blockquery = 'SELECT * FROM #fanfiction_blocks';
        $result = e107::getDb()->retrieve($blockquery, true);

        foreach ($result as $block) {
            $blocks[$block['block_name']] = e107::unserialize($block['block_variables']);
            $blocks[$block['block_name']]['title'] = $block['block_title'];
            $blocks[$block['block_name']]['file'] = $block['block_file'];
            $blocks[$block['block_name']]['status'] = $block['block_status'];
        }

        return $blocks;
    }

    public static function ratingslist()
    {
        $ratingslist = array();
        $ratlist = 'SELECT * FROM #fanfiction_ratings';
        $result = e107::getDb()->retrieve($ratlist, true);

        foreach ($result as $rate) {
            $ratingslist[$rate['rid']] = array('name' => $rate['rating'], 'ratingwarning' => $rate['ratingwarning'], 'warningtext' => $rate['warningtext']);
        }

        return $ratingslist;
    }

    /**
     * Compiles the prefs for usage within the class.
     */
    public function initPrefs()
    {
    }

    public function init()
    {
    }

    /**
     * Handle & process all non-ajax requests.
     *
     * @return void
     */
    private function process()
    {
    }

    /**
     * Render the efiction pages.
     *
     * @return string
     */
    public function render()
    {
        $ns = e107::getRender();

        $ns->tablerender('caption', 'this is text', 'vstore-category-list');
    }
}
