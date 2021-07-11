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

require_once("../inc/get_session_vars.php");
$sql = e107::getDb();

require_once(e_ADMIN."auth.php");
 

e107::lan('efiction');
e107::lan('efiction', true);
 

if(isset($_GET['action']))
{
	$action = e107::getParser()->filter($_GET['action'], 'str');
}
/*
if(isset($_GET['init']))
{
	$par = e107::getParser()->filter($_GET['init'], 'str'); 
}
*/ 

if(isset($_GET['message']))
{
	$par = e107::getParser()->filter($_GET['message'], 'str'); 
}
 
if(function_exists($action))
{
	$result = call_user_func($action, $par);
}



require(e_ADMIN . 'footer.php');


function blocks($init) {
 
 
	if($warning = efiction_blocks::get_removed_blocks()) {
		echo $warning;
	}
        
	$output = '';
    $blocks = efiction_blocks::get_blocks(); 
	include(e_PLUGIN."efiction/admin/blocks.php");
	
	e107::getRender()->tablerender($caption,   $output); 

}
 

function admin_blocks_adminmenu()
{
 
	$panellist = efiction_panels::get_adminmenu_panels(); 
 
		foreach($panellist as $accesslevel => $panels) {
			$var['header'.$accesslevel ] = array(
				'header' => _LEVEL . ": ". $accesslevel 
			);

			foreach($panels as $mode => $value)
			{
	
				$var[$mode]['text'] = $value['text'];
				$var[$mode]['perm'] = $value['perm'];
				$var[$mode]['link'] = $value['link'];
			
			}
		}	
  
	show_admin_menu(LAN_EFICTION_ADMIN_PANELS, $mode, $var);
}
