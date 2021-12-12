<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * e107 Blank Plugin
 *
*/
if (!defined('e107_INIT'))
{
	require_once(__DIR__.'/../../class2.php');
}


e107::canonical('efiction_series');
e107::route('efiction_series/viewserie'); 
e107::lan('efiction');

require_once (e_PLUGIN."efiction/includes/queries.php");


if(isset($_GET['seriesid']))
{
	$seriesid = (int)$_GET['seriesid']; 
	$tmp = efiction_series::get_series_by_serieid($seriesid);
	$title = $tmp['title'];
}

$caption = empty($title) ? _SERIE : $title; 

define('e_PAGETITLE', $caption); 

require_once(HEADERF);
 
// Individual recipe
if(isset($_GET['seriesid']))
{
	$rid 	= (int)$_GET['seriesid']; // Filter user input 
	$text 	= e107::getSingleton('efiction_series')->renderSeries($seriesid); 
	$caption = e107::getSingleton('efiction_series')->caption;

	e107::getRender()->tablerender($caption, $text, "viewseries");
}


 
class viewserie_front
{

	protected $get = array();
	protected $post = array();
	protected $pref = array();

	function __construct()
	{

		$this->get = varset($_GET);
		$this->post = varset($_POST);
		$this->pref = e107::pref('efiction_series');
 
	}

	public function run()
	{
	
		
	}


}	

 


require_once(HEADERF);

new viewserie_front;
 
require_once(FOOTERF);	