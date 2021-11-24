<?php

if (!defined('e107_INIT')) { exit; }

e107::lan('forum', "front", true);

class efiction_frontpage // include plugin-folder in the name.
{
	function config()
	{
		$sql 	= e107::getDb();
		$config = array();

		$config['title'] = "Latest chapters";

		// Always show the 'forum index' option
		$config['page'][] = array('page' => e107::url('efiction', 'index'), 'title' => "Latest chapters"); 
 
 
		return $config;
	}
}