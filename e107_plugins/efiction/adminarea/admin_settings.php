<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Forum upgrade routines
 *
 */

if(!defined('e_ADMIN_AREA'))
{
	define('e_ADMIN_AREA', true);
}
require_once(__DIR__ . '/../../../class2.php');

if(!getperms('P'))
{
	e107::redirect();
	exit;
}

  
$sql = e107::getDb();

require_once(e_ADMIN."auth.php");
 

e107::lan('efiction');
e107::lan('efiction', true);
 

if(isset($_GET['action']))
{
	$action = e107::getParser()->filter($_GET['action'], 'str');
}
if(isset($_GET['sect']))
{
	$par = e107::getParser()->filter($_GET['sect'], 'str'); 
}
 

if(isset($_GET['message']))
{
	$par = e107::getParser()->filter($_GET['message'], 'str'); 
}
 
if(function_exists($action))
{
	$result = call_user_func($action, $par);
}



require(e_ADMIN . 'footer.php');


function settings($sect) {
 
	$output = '';
 
	include(e_PLUGIN."efiction/admin/settings.php");

	e107::getRender()->tablerender($caption,   $output); 

}

function censor($sect) {
 
	$output = '';
	include(e_PLUGIN."efiction/admin/censor.php");

	e107::getRender()->tablerender($caption,   $output); 

}

function messages($message) {
 
	$output = '';
	include(e_PLUGIN."efiction/admin/messages.php");

	e107::getRender()->tablerender($caption,   $output); 

}

function admin_settings_adminmenu()
{
/*
	$output .= "<h1>"._SETTINGS."</h1><div style='text-align: center;'>
 
	 
	$settingsquery = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_panels WHERE panel_type = 'AS' ORDER BY panel_title");
	while($os = dbassoc($settingsquery)) {
		if($os['panel_url']) $othersettings[] = "<a href='".$os['panel_url']."'>".$os['panel_title']."</a>";
	}
	if(isset($othersettings)) $output .= implode(" | ", $othersettings);
$output .= "</div> ";
*/
	$sect = 'main';

	$var['main']['text'] = _MAINSETTINGS;
	$var['main']['link'] = e_SELF . "?action=settings&sect=main";

	$var['submissions']['text'] = _SUBMISSIONSETTINGS;
	$var['submissions']['link'] = e_SELF . "?action=settings&sect=submissions";

	$var['sitesettings']['text'] = _SITESETTINGS;
	$var['sitesettings']['link'] =  e_SELF . "?action=settings&sect=sitesettings";

	$var['display']['text'] = _DISPLAYSETTINGS;
	$var['display']['link'] = e_SELF . "?action=settings&sect=display";

	$var['reviews']['text'] = _REVIEWSETTINGS;
	$var['reviews']['link'] = e_SELF . "?action=settings&sect=reviews";

	$var['useropts']['text'] = _USERSETTINGS;
	$var['useropts']['link'] = e_SELF . "?action=settings&sect=useropts";

	$var['email']['text'] = _EMAILSETTINGS;
	$var['email']['link'] = e_SELF . "?action=settings&sect=email";
 
	$var['censor']['text'] = _CENSOR;
	$var['censor']['link'] = e_SELF . "?action=censor";

	$var['welcome']['text'] = _WELCOME;
	$var['welcome']['link'] = e_SELF . "?action=messages&message=welcome";

	$var['copyright']['text'] = _COPYRIGHT;
	$var['copyright']['link'] = e_SELF . "?action=messages&message=copyright";

	$var['printercopyright']['text'] = _PRINTERCOPYRIGHT;
	$var['printercopyright']['link'] = e_SELF . "?action=messages&message=printercopyright";

	$var['tinyMCE']['text'] = _TINYMCE;
	$var['tinyMCE']['link'] = e_SELF . "?action=messages&message=tinyMCE";

	$var['nothankyou']['text'] = _NOTHANKYOU;
	$var['nothankyou']['link'] = e_SELF . "?action=messages&message=nothankyou";

	$var['thankyou']['text'] = _THANKYOU;
	$var['thankyou']['link'] = e_SELF . "?action=messages&message=thankyou";

	$var['back']['text'] = LAN_BACK;
	$var['back']['link'] =  e_PLUGIN."efiction/admin_config.php";	

 
	if(isset($_GET['action']) && $_GET['action'] == "censor") {
		$active = "censor";
	} 
	if(isset($_GET['message'])) {
		$active = "message";
	}
	if(isset($_GET['sect']))
	{
		$active =  e107::getParser()->toDb($_GET['sect']);  
	}

	show_admin_menu(_SETTINGS, $active, $var);
}
