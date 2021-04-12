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

 
if (!defined('e107_INIT'))
{
	require_once(__DIR__.'/../../class2.php');
}
 

// Defines the character set for your language/location
define ("_CHARSET", "utf-8");
define ("_BASEDIR", e_PLUGIN."efiction/"); ;
 
define("_ADMINBASEDIR", e_PLUGIN."efiction/admin/");

require_once(_BASEDIR."config.php");

$settings = efiction::settings();
 
 
if(isset($skin)) $globalskin = $skin; 
 
$settings = efiction::settings();
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
 
if(isset($_GET['debug'])) $debug = 1;
if(!$displaycolumns) $displaycolumns = 1; // shouldn't happen, but just in case.
if($words) $words = explode(", ", $words);
else $words = array( );
// Fix for sites with 2.0 or 1.1 running as well as 3.0 with register_globals on.
$defaultskin = 'e107';

if(isset($globalskin)) $skin = $globalskin;

if(isset($_GET['action'])) $action = strip_tags($_GET['action']);
else $action = false;

e107::lan('efiction');

//because alphabet
if(file_exists(_BASEDIR."languages/{$language}.php")) include (_BASEDIR."languages/{$language}.php");
else include (_BASEDIR."languages/en.php");

require_once(_BASEDIR."includes/queries.php");
require_once(_BASEDIR."includes/corefunctions.php");


// Check and/or set some variables used at various points throughout the script
if(isset($_GET['offset'])) $offset = $_GET['offset'];
if(!isset($offset) || !isNumber($offset)) $offset = 0;
if(isset($_REQUEST["sid"])) $sid = $_REQUEST["sid"];
if(isset($sid) && !isNumber($sid)) unset($sid);
if(isset($_REQUEST['seriesid'])) $seriesid = $_REQUEST["seriesid"];
if(isset($seriesid) && !isNumber($seriesid)) unset($seriesid);
if(isset($_REQUEST['uid'])) $uid = $_REQUEST["uid"];
if(isset($uid) && !isNumber($uid)) unset($uid);
if(isset($_REQUEST['chapid'])) $chapid = $_REQUEST["chapid"];
if(isset($chapid) && !isNumber($chapid)) unset($chapid);
$let = false;
if(isset($_GET['let'])) $let = $_GET['let'];
if(isset($let) && !in_array($let, $alphabet)) $let = false;
$output = "";

// Cleans these two variables of possible XSS attacks.
if(isset($_SERVER['PHP_SELF'])) $_SERVER['PHP_SELF'] = htmlspecialchars(descript($_SERVER['PHP_SELF']), ENT_QUOTES);
if(isset($PHP_SELF)) $PHP_SELF = htmlspecialchars(descript($PHP_SELF), ENT_QUOTES);

// Set these variables to start.
$agecontsent = false; $viewed = false; 

require_once("includes/get_session_vars.php");
 
if(isset($_GET['skin'])) {
	$siteskin = $_GET['skin'];
    e107::getSession()->set(SITEKEY."_skin", $siteskin); 
}

$v = explode(".", $version);
include("version.php");
$newV = explode(".", $version);
//if($v[0] == $newV[0] && ($v[1] < $newV[1] || (isset($newV[2]) && $v[2] < $newV[2]))) {
foreach($newV AS $k => $l) {
	if($newV[$k] > $v[$k] || (!empty($newV[$k]) && empty($v[$k]))) {
		if(isADMIN && e_PAGE != "update.php") {
			header("Location: update.php");
			exit( );
		}
		else if(!isADMIN && e_PAGE != "maintenance.php" && !(isset($_GET['action']) && $_GET['action'] == "login")) {
			header("Location: maintenance.php");
			exit( );
		}
	}
}

if(e107::getSession()->is(SITEKEY."_skin")) $siteskin = e107::getSession()->get(SITEKEY."_skin");
if($maintenance && !isADMIN && e_PAGE != "maintenance.php" && !(isset($_GET['action']) && $_GET['action'] == "login")) {
	header("Location: maintenance.php");
	exit( );
}

$blocks = efiction::blocks();

if(e107::getSession()->is(SITEKEY."_viewed")) $viewed = e107::getSession()->get(SITEKEY."_viewed"); 
if(isset($_GET['ageconsent'])) e107::getSession()->set(SITEKEY."_ageconsent", 1);
if(isset($_GET['warning'])) e107::getSession()->set(SITEKEY."_warned_{$_GET['warning']}", 1);

 
if(is_dir(_BASEDIR."skins/$siteskin")) $skindir = _BASEDIR."skins/$siteskin";
else if(is_dir(_BASEDIR."skins/".$settings['skin'])) $skindir = _BASEDIR."skins/".$defaultskin;
else $skindir = _BASEDIR."default_tpls";


if(USERUID) {
	$prefs = dbquery("SELECT sortby, storyindex, tinyMCE FROM ".TABLEPREFIX."fanfiction_authorprefs WHERE uid = '".USERUID."'");
	if(dbnumrows($prefs)) list($defaultsort, $displayindex, $tinyMCE) = dbrow($prefs);
}
if(isset($_REQUEST['sort'])) $defaultsort = $_REQUEST['sort'] == "update" ? 1 : 0;
define("_ORDERBY", " ORDER BY ".($defaultsort == 1 ? "updated DESC" : "stories.title ASC"));
if($current == "viewstory"){
	if(isset($chapid)) {
		$squery = dbquery("SELECT sid, inorder FROM ".TABLEPREFIX."fanfiction_chapters WHERE chapid = ".$chapid." LIMIT 1");
		list($sid, $chapter) = dbrow($squery);
	}
	$titlequery = dbquery("SELECT story.title, story.coauthors, "._PENNAMEFIELD." as penname, story.summary FROM ".TABLEPREFIX."fanfiction_stories as story, "._AUTHORTABLE." WHERE sid = '$sid' AND "._UIDFIELD." = story.uid LIMIT 1");
	if($story = dbassoc($titlequery)) { 
			$authlink[] = $story['penname'];
		if($story['coauthors']) {
			$coquery = dbquery("SELECT "._PENNAMEFIELD." as penname FROM "._AUTHORTABLE." LEFT JOIN ".TABLEPREFIX."fanfiction_coauthors as ca ON "._UIDFIELD." = ca.uid WHERE ca.sid = '$sid'");
			while($co = dbassoc($coquery)) {
				$authlink[] = $co['penname'];
			}
		}
		$titleinfo = stripslashes($story['title'])." "._BY." ".implode(", ", $authlink);
		$metaDesc = htmlspecialchars(stripslashes($story['summary']));
		$filename = basename($titleinfo.".html");
		$ie = strpos("msie", strtolower($_SERVER['HTTP_USER_AGENT'])) !== false ? true : false;
		if ($ie) $filename = rawurlencode($filename);
		//header("Content-Disposition: inline; filename=\"".$titleinfo."\"");
 	}
}
if($current == "viewuser" && isNumber($uid)) {
	$author = dbquery("SELECT "._PENNAMEFIELD." as penname FROM "._AUTHORTABLE." WHERE "._UIDFIELD." = '".$uid."'");
	list($penname) = dbrow($author);
	$titleinfo = "$sitename :: $penname";
}
 
 
if(!isset($_GET['action']) || $_GET['action'] != "printable") {
  e107::js('url',  _BASEDIR."includes/javascript.js" , 'jquery' );
  if(!empty($tinyMCE)) {
      //e107::js('url', _BASEDIR."tinymce/js/tinymce/tinymce.min.js" , 'jquery' );
   
  }
}

if(isset($displayform) && $displayform == 1) {

e107::js('url',  _BASEDIR."includes/xmlhttp.js" , 'jquery' );
  $inlinecode = "
    lang = new Array( );

lang['Back2Cats'] = '"._BACK2CATS."';
lang['ChooseCat'] = '"._CHOOSECAT."';
lang['Categories'] = '"._CATEGORIES."';
lang['Characters'] = '"._CHARACTERS."';
lang['MoveTop'] = '"._MOVETOP."';
lang['TopLevel'] = '"._TOPLEVEL."';
lang['CatLocked'] = '"._CATLOCKED."';
basedir = '"._BASEDIR."';

categories = new Array( );
characters = new Array( );
\n";
      
   e107::js('inline', $inlinecode); 
}
 

if(!$displaycolumns) $displaycolumns = 1;
$colwidth = floor(100/$displaycolumns);


if(!empty($_GET['action']) && $_GET['action'] == "printable") {
	if(file_exists("$skindir/printable.css")) echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"$skindir/printable.css\">";
	else echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"default_tpls/printable.css\">";
    
    e107::css('url', _BASEDIR.'default_tpls/printable.css');
    
    $inlinescript = "
    if (window.print) {
        window.print() ;  
      } else {
          var WebBrowser = '<OBJECT ID=\"WebBrowser1\" WIDTH=0 HEIGHT=0 CLASSID=\"CLSID:8856F961-340A-11D0-A96B-00C04FD705A2\"></OBJECT>';
      document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
          WebBrowser1.ExecWB(6, 2);//Use a 1 vs. a 2 for a prompting dialog box    WebBrowser1.outerHTML = \"\";  
      }";
      
   e107::js('footer-inline', $inlinescript);  
}
else { 

$inlinestyle = '
    #columncontainer { margin: 1em auto; width: auto; padding: 5%;}
    #browseblock, #memberblock { width: 100%; padding: 0; margin: 0; float: left; border: 0px solid transparent; }
    .column { float: left; width: '.($colwidth - 1).'%; }
    html>body .column { width: '.$colwidth.'%; }
    .cleaner { clear: both; height: 1px; font-size: 1px; margin: 0; padding: 0; background: transparent; }
    #settingsform { margin: 0; padding: 0; border: none; }
    #settingsform FORM { width: 100%; margin: 0 10%; }
    #settingsform LABEL { float: left; display: block; width: 30%; text-align: right; padding-right: 10px; clear: left; }
    #settingsform DIV { clear: both;}
    #settingsform .fieldset SPAN { float: left; display: block; width: 30%; text-align: right; padding-right: 10px; clear: left;}
    #settingsform .fieldset LABEL { float: none; width: auto; display: inline; text-align: left; clear: none; }
    #settingsform { float: left; margin: 1ex 10%; }
    #settingsform .tinytoggle { text-align: center; }
    #settingsform .tinytoggle LABEL { float: none; display: inline; width: auto; text-align: center; padding: 0; clear: none; }
    #settingsform #submitdiv { text-align: center; width: 100%;clear: both; height: 3em; }
    #settingsform #submitdiv #submit { position: absolute; z-index: 10001; margin: 1em; }
    a.pophelp{
        position: relative; /* this is the key*/
        vertical-align: super;
    }
    
    a.pophelp:hover{z-index:100; border: none; text-decoration: none;}
    
    a.pophelp span{display: none; position: absolute; top: -25em; left: 20em; }
    
    a.pophelp:hover span{ /*the span will display just on :hover state*/
        display:block;
        position: absolute;
        top: -3em; left: 8em; width: 225px;
        border:1px solid #000;
        background-color:#CCC; color:#000;
        text-decoration: none;
        text-align: left;
        padding: 5px;
        font-weight: normal;
        visibility: visible;
    }
    .required { color: red; }
    .shim {
    	position: absolute;
    	display: none;
    	height: 0;
    	width:0;
    	margin: 0;
    	padding: 0;
    	z-index: 100;
    }
    
    .ajaxOptList {
    	background: #CCC;
    	border: 1px solid #000;
    	margin: 0;
    	position: absolute;
    	padding: 0;
    	z-index: 1000;
    	text-align: left;
    }
    .ajaxListOptOver {
    	padding: 4px;
    	background: #CCC;
    	margin: 0;
    }
    .ajaxListOpt {
    	background: #EEE;
    	padding: 4px;
    	margin: 0;
    }
    .multiSelect {
    	width: 300px;
    };
';

e107::css('inline', $inlinestyle);
 
e107::css('url',  $skindir."/style.css");
 
}

 
include (_BASEDIR."includes/class.TemplatePower.inc.php");
 
 