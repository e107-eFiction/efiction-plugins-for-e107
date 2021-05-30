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
    protected $pref = array();

    private static $admin_panel_icons = array(
        'maintenance' => '<i class="S32 e-configure-32"></i>',
        'modules' => '<i class="S32 e-plugins-32"></i>',
        'newstory' => '<i class="S32 e-add-32"></i>',
        'addseries' => '<i class="S32 e-articles-32"></i>',
        'news' => '<i class="S32 e-news-32"></i>',
        'mailusers' => '<i class="S32 e-mail-32"></i>',
        'blocks' => '<i class="S32 e-welcome-32"></i>',
        'admins' => '<i class="S32 e-cat_users-32"></i>',
        'submitted' => '<i class="S32 e-notify-32"></i>',
        'skins' => '<i class="S32 e-themes-32"></i>',
        //find better icons later
        'featured' => '<i class="S32 e-frontpage-32"></i>',
        'manual' => '<i class="S32 e-forums-32"></i>',

        'versioncheck' => '<i class="S32 e-cat_users-32"></i>',
        'characters' => '<i class="S32 e-content-32"></i>',
        'ratings' => '<i class="S32 e-reviews-32"></i>',
        'members' => '<i class="S32 e-users-32"></i>',
        'classifications' => '<i class="S32 e-rename-32"></i>',
        'categories' => '<i class="S32 e-prefs-32"></i>',
        'settings' => '<i class="S32 e-configure-32"></i>',
        'panels' => '<i class="S32 e-rename-32"></i>',
        'custpages' => '<i class="S32 e-prefs-32"></i>',
        'viewlog' => '<i class="S32 e-warning-32"></i>',
        'authorfields' => '<i class="S32 e-userclass-32"></i>',
        'phpinfo' => '<i class="S32 e-userclass-32"></i>',
        'links' => '<i class="S32 e-userclass-32"></i>',
    );

    public function __construct()
    {
        $this->pref = e107::pref('efiction');
    }

    public function init()
    {
    }

    /* in admin.php */
    public static function admin_panels($parm = null)
    {
        $panelquery = "SELECT * FROM #fanfiction_panels WHERE panel_hidden != '1' AND panel_type = 'A' AND panel_level >= ".uLEVEL.' ORDER BY panel_level DESC, panel_order ASC, panel_title ASC';

        $records = e107::getDb()->retrieve($panelquery, true);

        foreach ($records as $panel) {
            if (!$panel['panel_url']) {
                $panellist[$panel['panel_level']][] = '<a href="admin.php?action='.$panel['panel_name'].'">'.$panel['panel_title'].'</a>';
            } else {
                $panellist[$panel['panel_level']][] = '<a href="'.$panel['panel_url'].'">'.$panel['panel_title'].'</a>';
            }
        }

        return $panellist;
    }

    public function get_perms_from_level($level)
    {
        if (e107::getDb()->select('plugin', 'plugin_id', "plugin_path = 'efiction' LIMIT 1 ")) {
            $row = e107::getDb()->fetch();
            $arg = 'P'.$row['plugin_id'];
        }

        switch ($level) {
            case 1: $perms = '0'; break;  //main admin, see everything
            case 2: $perms = 'P'.$row['plugin_id']; break;
            case 3: $perms = 'P'.$row['plugin_id']; break;
       default:
           $perms = '';
        }
        return $perms;
    }

    /* in adminarea.php */
    public static function adminarea_panels($parm = null)
    {
        $panelquery = "SELECT * FROM #fanfiction_panels WHERE panel_hidden != '1' AND panel_type = 'A' AND panel_level >= ".uLEVEL.' ORDER BY panel_level DESC, panel_order ASC, panel_title ASC';

        $records = e107::getDb()->retrieve($panelquery, true);

        foreach ($records as $panel) {
            $key = $panel['panel_name'];
            if (!$panel['panel_url']) {
                $link = e_HTTP.'admin.php?action='.$panel['panel_name'];
            } else {
                $link = e_HTTP.$panel['panel_url'];
            }

            $vals[$key]['link'] = $link;
            $vals[$key]['title'] = $panel['panel_title'];
            $vals[$key]['caption'] = $panel['panel_title'];
            $vals[$key]['perms'] = 0;
            $vals[$key]['icon_32'] = self::$admin_panel_icons[$key];

            /*	if(!$panel['panel_url']) $panellist[$panel['panel_level']][]= "<a href=\"admin.php?action=".$panel['panel_name']."\">".$panel['panel_title']."</a>";
               else $panellist[$panel['panel_level']][] = "<a href=\"".$panel['panel_url']."\">".$panel['panel_title']."</a>";
            */
        }

        return $vals;
    }

    public static function catlist()
    {
        $catlist = array();
        $catquery = 'SELECT * FROM #fanfiction_categories ORDER BY leveldown, displayorder';
        $result = e107::getDb()->retrieve($catquery, true);
        foreach ($result as $cat) {
            $catlist[$cat['catid']] = array('name' => stripslashes($cat['category']), 'pid' => $cat['parentcatid'], 'order' => $cat['displayorder'], 'locked' => $cat['locked'], 'leveldown' => $cat['leveldown']);
        }
        return $catlist;
    }

    public static function charlist()
    {
        $charlist = array();
        $charquery = 'SELECT charname, catid, charid FROM #fanfiction_characters ORDER BY charname';
        $result = e107::getDb()->retrieve($charquery, true);
        foreach ($result as $char) {
            $charlist[$char['charid']] = array('name' => stripslashes($char['charname']), 'catid' => $char['catid']);
        }
        return $charlist;
    }

    public static function classlist()
    {
        $classlist = array();
        $classquery = 'SELECT * FROM #fanfiction_classes ORDER BY class_name';
        $result = e107::getDb()->retrieve($classquery, true);
        foreach ($result as $class) {
            $classlist[$class['class_id']] = array('type' => $class['class_type'], 'name' => stripslashes($class['class_name']));
        }
        return $classlist;
    }

    public static function classtypelist()
    {
        $classtypelist = array();
        $classlistquery = 'SELECT * FROM #fanfiction_classtypes ORDER BY classtype_name';
        $result = e107::getDb()->retrieve($classlistquery, true);
        foreach ($result as $type) {
            $classtypelist[$type['classtype_id']] = array('name' => $type['classtype_name'], 'title' => stripslashes($type['classtype_title']));
        }
        return $classtypelist;
    }

    /* use get_block($key) if you need one block */
    public static function blocks()
    {
        $blocks = array();
        $blockquery = 'SELECT * FROM #fanfiction_blocks';
        $result = e107::getDb()->retrieve($blockquery, true);

        foreach ($result as $block) {
            $blocks[$block['block_name']] = e107::unserialize($block['block_variables']);
            $blocks[$block['block_name']]['block_variables'] = e107::unserialize($block['block_variables'], 'json');  //use both way to be able to edit blocks e107
            $blocks[$block['block_name']]['title'] = $block['block_title'];
            $blocks[$block['block_name']]['file'] = $block['block_file'];
            $blocks[$block['block_name']]['status'] = $block['block_status'];
        }

        return $blocks;
    }

    /* all data, id => array() */
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

    /* used for ratings select in storyform */
    /* ID => NAME */
    // used in story_shortcodes.php, series_shortcodes.php
    public function get_ratings_list()
    {
        $authors = array();
        $ratingquery = 'SELECT rid, rating FROM #fanfiction_ratings';
        $ratingsarray = e107::getDb()->retrieve($ratingquery, true);

        foreach ($ratingsarray as $ratingresult) {
            $ratings[$ratingresult['rid']] = $ratingresult['rating'];
        }

        return $ratings;
    }

    public static function userlinks()
    {
        $linkquery = 'SELECT * from #fanfiction_pagelinks ORDER BY link_access ASC' ;
        $records = e107::getDb()->retrieve($linkquery, true);

        $userlinks = array();
        foreach ($records as $link) {
            if ($link['link_access'] && !isMEMBER) {
                continue;
            }
            if ($link['link_access'] == 2 && uLEVEL < 1) {
                continue;
            }
            if ($link['link_name'] == 'register' && isMEMBER) {
                continue;
            }
            if (strpos($link['link_url'], 'http://') === false && strpos($link['link_url'], 'https://') === false) {
                $link['link_url'] = e_HTTP.$link['link_url'];
            }

            $linkname = $link['link_name'];
            $link_start = '<a href="'.$link['link_url'].'" title="'.$link['link_text'].'"'.($link['link_target'] ? ' target="_blank"' : '').(!empty($link['link_key']) ? " accesskey='".$link['link_key']."'" : '').($current == $link['link_name'] ? ' id="current"' : '').'>';

            $userlinks[$link['link_name']] = $link_start.$link['link_text'].'</a>';
        }

        return $userlinks;
    }

    public static function userpanels()
    {
        $settings = self::settings();
        $submissionsoff = $settings['submissionsoff'];
        $favorites = $settings['favorites'];

        $userpanels = array();
        $panelquery = "SELECT * FROM #fanfiction_panels WHERE panel_hidden != '1' 
        AND panel_level = '1' AND 
        (panel_type = 'U' ".(!$submissionsoff || isADMIN ? " OR panel_type = 'S'" : '').($favorites ? " OR panel_type = 'F'" : '').') 
        ORDER BY panel_type, panel_order, panel_title ASC';
        $records = e107::getDb()->retrieve($panelquery, true);

        foreach ($records as $panel) {
            if (!$panel['panel_url']) {
                $base = e107::url('efiction', 'member');
                $link = '<a href="'.$base.'?action='.$panel['panel_name'].'">'.$panel['panel_title']."</a><br />\n";
            } else {
                $link = '<a href="'.$panel['panel_url'].'">'.$panel['panel_title']."</a><br />\n";
            }
            $userpanels[$panel['panel_name']] = $link;
        }

        return $userpanels;
    }

    public static function favourite_panels($uid = null)
    {
        $settings = self::settings();
        $submissionsoff = $settings['submissionsoff'];
        $favorites = $settings['favorites'];

        $userpanels = array();
        $panelquery = "SELECT * FROM #fanfiction_panels WHERE panel_type = 'F' AND panel_name != 'favlist' ORDER BY panel_title ASC";
        $records = e107::getDb()->retrieve($panelquery, true);

        foreach ($records as $panel) {
            if (substr($panel['panel_name'], 0, 3) == 'fav' && $type = substr($panel['panel_name'], 3)) {
                if ($panel['panel_name'] == 'favlist') {
                    continue;
                }

                $itemcount = 0;
                $countquery = "SELECT COUNT(item) AS itemcount FROM #fanfiction_favorites WHERE uid = '$uid' AND type = '$type'";
                $itemcount = e107::getDb()->retrieve($countquery);

                if (!$panel['panel_url']) {
                    $base = e107::url('efiction', 'member');
                    $link = '<a href="'.$base.'?action='.$panel['panel_name'].'">'.$panel['panel_title'].'['.$itemcount."]</a><br />\n";
                } else {
                    $link = '<a href="'.$panel['panel_url'].'">'.$panel['panel_title'].'['.$itemcount."]</a><br />\n";
                }

                $favpanels[$panel['panel_name']] = $link;
            }
        }
        return $favpanels;
    }

    /* action is used too with:  ($action ? "panel_name = '$action' AND (panel_type = 'P' OR panel_type = 'F') in viewuser */
    /* action is used in admin.php too */
    public static function panel_byaction($action = '')
    {
        /*
        $settings = self::settings();
        $submissionsoff = $settings['submissionsoff'];
        $favorites = $settings['favorites'];

        $panelquery = "SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_name = '$action'
        AND (panel_type='U' ".(!$submissionsoff || isADMIN ? " OR panel_type = 'S'" : "").($favorites ? " OR panel_type = 'F'" : "").") LIMIT 1";

        $panel  = e107::getDb()->retrieve($panelquery);
        if($panel['panel_level'] > 0 && !isMEMBER) accessDenied( );

        if($panel['panel_url'] && file_exists(_BASEDIR.$panel['panel_url'])) {
            $panel['use_panel'] =  _BASEDIR.$panel['panel_url'];
        }
        else if(file_exists(e_PLUGIN."efiction/user/{$action}.php")) {
            $panel['use_panel'] =  "user/{$action}.php";
        }

        return $panel;*/
    }

    /* only for browse */
    public static function panel_bytype($type = '')
    {
        $panelquery = 'SELECT * FROM '.TABLEPREFIX."fanfiction_panels WHERE panel_name = '$type' AND panel_type = 'B' LIMIT 1";

        $panel = e107::getDb()->retrieve($panelquery);

        if ($panel['panel_level'] > 0 && !isMEMBER) {
            accessDenied();
        }

        if ($panel['panel_url'] && file_exists(_BASEDIR.$panel['panel_url'])) {
            $panel['use_panel'] = _BASEDIR.$panel['panel_url'];
        } elseif (file_exists(_BASEDIR."/browse/{$type}.php")) {
            $panel['use_panel'] = _BASEDIR."/browse/{$type}.php";
        }

        return $panel;
    }

    public function get_userlink($key = null)
    {
        if (null === $key) {
            $ret = self::userlinks();
            return $ret;
        }

        $links = self::userlinks();
        $ret = isset($links[$key]) ? $links[$key] : null;
        return $ret;
    }

    public function get_block($key = null)
    {
        if (null === $key) {
            $ret = self::blocks();
            return $ret;
        }

        $blocks = self::blocks();
        $ret[$key] = isset($blocks[$key]) ? $blocks[$key] : null;
        return $ret;
    }

    /*
    $settingsresults = dbquery("SELECT * FROM ".$settingsprefix."fanfiction_settings WHERE sitekey = '".$sitekey."'");
$settings = dbassoc($settingsresults);
if(!defined("SITEKEY")) define("SITEKEY", $settings['sitekey']);
unset($settings['sitekey']);
if(!defined("TABLEPREFIX")) define("TABLEPREFIX", $settings['tableprefix']);
unset($settings['tableprefix']);
define("STORIESPATH", $settings['storiespath']);
unset($settings['storiespath']);
foreach($settings as $var => $val) {
    $$var = stripslashes($val);
    $settings[$var] = htmlspecialchars($val);
}
*/

    public static function settings($setting_name = null)
    {
        $settingslist = array();
        $settingsquery = "SELECT * FROM #fanfiction_settings WHERE sitekey = '".SITEKEY."'"  ;
        $settings = e107::getDb()->retrieve($settingsquery);

        if ($setting_name) {
            return $settings[$setting_name];
        }

        return $settings;
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

    // replace for e107 pagination system, see issue https://github.com/e107inc/e107/issues/4024
    public function build_pagelinks($url, $total, $offset = 0, $columns = 1, $type = 'default')
    {
        global  $linkstyle, $linkrange;

        $itemsperpage = efiction::settings('itemsperpage');

        $pages = '';
        $itemsperpage = $itemsperpage * $columns;

        if ($itemsperpage >= $total) {
            return;
        }

        if (empty($linkrange)) {
            $linkrange = 4;
        }

        $totpages = floor($total / $itemsperpage) + ($total % $itemsperpage ? 1 : 0);
        $curpage = floor($offset / $itemsperpage) + 1;
        if (!$linkstyle) {
            $startrange = $curpage;
        } else {
            if ($totpages <= $linkrange || $curpage == 1) {
                $startrange = 1;
            } elseif ($curpage >= $totpages - floor($linkrange / 2) + 1) {
                $startrange = $totpages - $linkrange;
            } else {
                $startrange = $curpage - floor($linkrange / 2) > 0 ? $curpage - floor($linkrange / 2) : 1;
            }
        }
        if ($startrange >= $totpages - $linkrange) {
            $startrange = $totpages - $linkrange > 0 ? $totpages - $linkrange : 1;
        }
        $stoprange = $totpages > $startrange + $linkrange ? $startrange + $linkrange : $totpages + 1;

        if ($type == 'bootstrap4') {
            if ($curpage > 1 && $linkstyle != 1) {
                $pages .= "<li class=\"page-item\"><a class=\"page-link\" href='".$url.'offset='.($offset - $itemsperpage)."' id='plprev'>"._PREVIOUS.'</a></li>';
            }
            if ($startrange > 1 && $linkstyle > 0) {
                $pages .= "<li class=\"page-item\"><a class=\"page-link\" href='".$url."offset=0'>1</a></li><li class=\"page-item\"><span class='ellipses'>...</span></li>";
            }

            for ($x = $startrange; $x < $stoprange; $x++) {
                $pages .= '<li class="page-item'.($x == $curpage ? ' active' : '')."\"><a class=\"page-link\"  href='".$url.'offset='.(($x - 1) * $itemsperpage)."'".($x == $curpage ? "id='currentpage'" : '').'>'.$x."</a></li>\n";
            }

            if ($stoprange < $totpages && $linkstyle > 0) {
                $pages .= "<li class=\"page-item\"><span class='ellipses'>...</span></li><li class=\"page-item\"> <a class=\"page-link\" href='".$url.'offset='.(($totpages - 1) * $itemsperpage)."'>$totpages</a>\n";
            }
            if ($curpage < $totpages && $linkstyle != 1) {
                $pages .= "<li class=\"page-item\"><a class=\"page-link\" href='".$url.'offset='.($offset + $itemsperpage)."' id='plnext'>"._NEXT.'</a>';
            }

            return "<nav aria-label=\"pagination\" class=\"\" \"><ul class=\"pagination justify-content-center\">$pages</div></div>";
        } else {
            if ($curpage > 1 && $linkstyle != 1) {
                $pages .= "<a href='".$url.'offset='.($offset - $itemsperpage)."' id='plprev'>["._PREVIOUS.']</a> ';
            }
            if ($startrange > 1 && $linkstyle > 0) {
                $pages .= "<a href='".$url."offset=0'>1</a><span class='ellipses'>...</span>";
            }

            for ($x = $startrange; $x < $stoprange; $x++) {
                $pages .= "<a href='".$url.'offset='.(($x - 1) * $itemsperpage)."'".($x == $curpage ? "id='currentpage'" : '').'>'.$x."</a> \n";
            }
            if ($stoprange < $totpages && $linkstyle > 0) {
                $pages .= "<span class='ellipses'>...</span> <a href='".$url.'offset='.(($totpages - 1) * $itemsperpage)."'>$totpages</a>\n";
            }
            if ($curpage < $totpages && $linkstyle != 1) {
                $pages .= " <a href='".$url.'offset='.($offset + $itemsperpage)."' id='plnext'>["._NEXT.']</a>';
            }

            return "<div id=\"pagelinks\">$pages</div>";
        }
    }
}
