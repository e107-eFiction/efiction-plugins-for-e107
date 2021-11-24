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

// Force the argument separator to be standards compliant

if (!defined('e107_INIT'))
{
	require_once(__DIR__.'/../../class2.php');
}


 //e_ROUTE is available
 /*
if(e_CURRENT_PLUGIN == "efiction") {
 define("THEME_LAYOUT", "efiction");
}
 */
// Defines the character set for your language/location
define("_CHARSET", CHARSET); 
e107::lan("efiction");



//THEME_LAYOUT is available
include_once(_BASEDIR."includes/queries.php");
require_once(_BASEDIR."includes/get_session_vars.php");

$settings = efiction_settings::get_settings();
//print_xa($settings);
foreach($settings as $var => $val) {
  	$$var = stripslashes($val);
}
 

 

@ ini_set('arg_separator.output','&amp;'); 
if(isset($_GET['debug'])) @ error_reporting(E_ALL);
if(isset($_GET['benchmark'])) {
	list($usec, $sec) = explode(" ", microtime());
	$start = ((float)$usec + (float)$sec);
}
$headerSent = false;

if(get_magic_quotes_gpc()){
	foreach($_POST as $var => $val) {
		$_POST[$var] = is_array( $val ) ? array_map( 'stripslashes', $val ) : stripslashes( $val );
	}
	foreach($_GET as $var => $val) {
		$_GET[$var] = is_array( $val ) ? array_map( 'stripslashes', $val ) : stripslashes( $val );
	}
}



// Prevent possible XSS attacks via $_GET.
foreach ($_GET as $v) {
	if(preg_match('@<script[^>]*?>.*?</script>@si', $v) ||
		preg_match("'@<iframe[^>]*?>.*?</script>@si'", $v) ||
		preg_match("'@<applet[^>]*?>.*?</script>@si'", $v) ||
		preg_match("'@<meta[^>]*?>.*?</script>@si'", $v) ||
		preg_match('@<[\/\!]*?[^<>]*?>@si', $v) ||
		preg_match('@<style[^>]*?>.*?</style>@siU', $v) ||
		preg_match('@<![\s\S]*?--[ \t\n\r]*>@', $v)) {
 	
		die (_POSSIBLEHACK);
	}
} 
unset($v);
 
// clear the global variables if register globals is on.

if(ini_get('register_globals')) {
	$arrayList = array_merge($_GET, $_POST, $_COOKIE);
	foreach($arrayList as $k => $v) {
		unset($GLOBALS[$k]);
	}
}                   
 

if(isset($_GET['debug'])) $debug = 1;
if(!$displaycolumns) $displaycolumns = 1; // shouldn't happen, but just in case.
if($words) $words = explode(", ", $words);
else $words = array( );
 
if(isset($_GET['action'])) $action = strip_tags($_GET['action']);
else $action = false;

 
require_once(HEADERF);
 
$alphabet = efiction_settings::get_alphabet(); 

include_once(_BASEDIR."includes/corefunctions_old.php");
include_once(_BASEDIR."includes/corefunctions.php");

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
 
/*
if($maintenance && !isADMIN && basename($_SERVER['PHP_SELF']) != "maintenance.php" && !(isset($_GET['action']) && $_GET['action'] == "login")) {
	header("Location: maintenance.php");
	exit( );
}
*/
$blockquery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_blocks");
while($block = dbassoc($blockquery)) {
	$blocks[$block['block_name']] = unserialize($block['block_variables']);
	$blocks[$block['block_name']]['title'] = $block['block_title'];
	$blocks[$block['block_name']]['file'] = $block['block_file'];
	$blocks[$block['block_name']]['status'] = $block['block_status'];
}

// This session variable is used to track the story views
if(e107::getSession()->is(SITEKEY."_viewed")) $viewed = e107::getSession()->get(SITEKEY."_viewed"); 

if(isset($_GET['ageconsent'])) e107::getSession()->set(SITEKEY."_ageconsent", 1);
if(isset($_GET['warning'])) e107::getSession()->set(SITEKEY."_warned_{$_GET['warning']}", 1);
 

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
 
//echo _DOCTYPE."<html><head>";
 /*
if(!isset($titleinfo)) $titleinfo = "$sitename :: $slogan";
if(isset($metaDesc)) echo "<meta name='description' content='$metaDesc'>";
echo "<title>$titleinfo</title>";
*/
 
/*

if(!isset($_GET['action']) || $_GET['action'] != "printable") {
 
if(!empty($tinyMCE)) {
	echo "<script language=\"javascript\" type=\"text/javascript\" src=\""._BASEDIR."tinymce/js/tinymce/tinymce.min.js\"></script>
	<script language=\"javascript\" type=\"text/javascript\"><!--";
	$tinymessage = dbquery("SELECT message_text FROM ".TABLEPREFIX."fanfiction_messages WHERE message_name = 'tinyMCE' LIMIT 1");
	list($tinysettings) = dbrow($tinymessage);
	if(!empty($tinysettings) && $current != "adminarea") {
		echo $tinysettings;
	}
	else {
		echo "
	tinymce.init({
  		selector: 'textarea:not(.mceNoEditor)',
  		menubar: false,
		language: '$language',
  		theme: 'modern',
		skin: 'lightgray',
		min_height: 200,
		plugins: [
		    'autolink lists link image charmap paste preview hr anchor pagebreak',
		    'searchreplace wordcount visualblocks visualchars code fullscreen',
		    'insertdatetime media nonbreaking save table contextmenu directionality',
		    'emoticons template textcolor colorpicker textpattern imagetools toc textcolor table'
		],
		paste_word_valid_elements: 'b,strong,i,em,h1,h2,u,p,ol,ul,li,a[href],span,color,font-size,font-color,font-family,mark,table,tr,td',
		  		paste_retain_style_properties : 'all',
		paste_strip_class_attributes: 'none',
		toolbar1: 'undo redo | insert styleselect | bold italic underline strikethrough | link image | alignleft aligncenter alignright alignjustify',
		toolbar2: 'preview | bullist numlist | forecolor backcolor emoticons | fontselect |  fontsizeselect wordcount',
		image_advtab: true,
		templates: [
		    { title: 'Test template 1', content: 'Test 1' },
		    { title: 'Test template 2', content: 'Test 2' }
		],
		content_css: [
		    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
		    '//www.tinymce.com/css/codepen.min.css'
		],";
		if(USERUID) 
			echo "		external_image_list_url : '".STORIESPATH."/".USERUID."/images/imagelist.js',";
		echo "
		theme_modern_resizing: true,".($current == "adminarea" ? "\n\t\tentity_encoding: 'raw'" : "\n\t\tinvalid_elements: 'script,object,applet,iframe'")."
   });
	
";
	}
	echo "
var tinyMCEmode = true;
	function toogleEditorMode(id) {
		var elm = document.getElementById(id);

		if (tinyMCE.getInstanceById(id) == null)
			tinyMCE.execCommand('mceAddControl', false, id);
		else
			tinyMCE.execCommand('mceRemoveControl', false, id);
	}
";
 
echo " --></script>";
}
}
 
*/
if(file_exists("extra_header.php")) include_once("extra_header.php");
if(file_exists("$skindir/extra_header.php")) include_once("$skindir/extra_header.php");
 
 
/*
if(!empty($_GET['action']) && $_GET['action'] == "printable") {
	 
	echo "<script type='text/javascript'>
<!--
if (window.print) {
    window.print() ;  
} else {
    var WebBrowser = '<OBJECT ID=\"WebBrowser1\" WIDTH=0 HEIGHT=0 CLASSID=\"CLSID:8856F961-340A-11D0-A96B-00C04FD705A2\"></OBJECT>';
document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
    WebBrowser1.ExecWB(6, 2);//Use a 1 vs. a 2 for a prompting dialog box    WebBrowser1.outerHTML = \"\";  
}
-->
</script>";
}
else {
 
<meta name='viewport' content='width=device-width, initial-scale=1.0' />
";
}
echo "</head>";
*/
$headerSent = true;
include (_BASEDIR."includes/class.TemplatePower.inc.php");
 
 
 

