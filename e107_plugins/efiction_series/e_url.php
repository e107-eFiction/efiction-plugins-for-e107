<?php
/*
 * e107 Bootstrap CMS
 *
 * Copyright (C) 2008-2015 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 * 
 * IMPORTANT: Make sure the redirect script uses the following code to load class2.php: 
 * 
 * 	if (!defined('e107_INIT'))
 * 		require_once(__DIR__.'/../../class2.php');
 * 	}
 * 
 */
 
if (!defined('e107_INIT')) { exit; }

// v2.x Standard  - Simple mod-rewrite module. 

class efiction_series_url // plugin-folder + '_url'
{
	public $alias = 'efiction_series';
     
    function config() 
	{
		$config = array();
 
      	$config['viewseries'] = array(
            'alias'         => 'viewseries',
		//	'regex'			=> '^{alias}\/?([\?].*)?\/?$', 
            'regex'			=> '^{alias}\/(.*)\?(.*)',
			'sef'			=> '{alias}/{seriessef}?seriesid={seriesid}', 
			'redirect'		=> '{e_PLUGIN}efiction_series/viewseries.php?$2', 	 		 
		); 
 
		$config['browseseries'] = array(
            'alias'         => 'browseseries.php',
			'regex'			=> '^{alias}\/?([\?].*)?\/?$', 
			'sef'			=> '{alias}', 
			'redirect'		=> '{e_PLUGIN}efiction_series/browseseries.php$1', 	  
		);
       
    return $config;      
    }
    
    

}
        