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
 * 	{
 * 		require_once(__DIR__.'/../../class2.php');
 * 	}
 * 
 */
 
if (!defined('e107_INIT')) { exit; }

// v2.x Standard  - Simple mod-rewrite module. 

class efiction_url // plugin-folder + '_url'
{
	
     public $alias = 'efiction';
     
    function config() 
	{
		$config = array();

		$config['adminarea'] = array(
			'alias'         => 'admin.php',
			'regex'			=> '^{alias}\/?([\?].*)?\/?$', 
			'sef'			=> '{alias}', 
			'redirect'		=> '{e_PLUGIN}efiction/admin.php$1', 	
			'sef'			=> 'admin.php',   
		);


		$config['reviews'] = array(
            'alias'         => 'reviews.php',
			'regex'			=> '^{alias}\/?([\?].*)?\/?$', 
			'sef'			=> '{alias}', 
			'redirect'		=> '{e_PLUGIN}efiction/reviews.php$1', 	 		// file-path of what to load when the regex returns true.
		);

		$config['report'] = array(
            'alias'         => 'report.php',
			'regex'			=> '^{alias}\/?([\?].*)?\/?$', 
			'sef'			=> '{alias}', 
			'redirect'		=> '{e_PLUGIN}efiction/report.php$1', 	 		// file-path of what to load when the regex returns true.
		);


		$config['browse'] = array(
            'alias'         => 'browse.php',
			'regex'			=> '^{alias}\/?([\?].*)?\/?$', 
			'sef'			=> '{alias}', 
			'redirect'		=> '{e_PLUGIN}efiction/browse.php$1', 	 		// file-path of what to load when the regex returns true.
		);

		$config['authors'] = array(
            'alias'         => 'authors.php',
			'regex'			=> '^{alias}\/?([\?].*)?\/?$', 
			'sef'			=> '{alias}', 
			'redirect'		=> '{e_PLUGIN}efiction/authors.php$1', 	 		// file-path of what to load when the regex returns true.
		);

		$config['rss'] = array(
            'alias'         => 'rss.php',
			'regex'			=> '^{alias}\/?([\?].*)?\/?$', 
			'sef'			=> '{alias}', 
			'redirect'		=> '{e_PLUGIN}efiction/rss.php$1', 	 		// file-path of what to load when the regex returns true.
		);


		$config['searching'] = array(
            'alias'         => 'searching.php',
			'regex'			=> '^{alias}\/?([\?].*)?\/?$', 
			'sef'			=> '{alias}', 
			'redirect'		=> '{e_PLUGIN}efiction/searching.php$1', 	 		// file-path of what to load when the regex returns true.
		);

		$config['series'] = array(
            'alias'         => 'series.php',
			'regex'			=> '^{alias}\/?([\?].*)?\/?$', 
			'sef'			=> '{alias}', 
			'redirect'		=> '{e_PLUGIN}efiction/series.php$1', 	 		// file-path of what to load when the regex returns true.
		);

		$config['stories'] = array(
            'alias'         => 'stories.php',
			'regex'			=> '^{alias}\/?([\?].*)?\/?$', 
			'sef'			=> '{alias}', 
			'redirect'		=> '{e_PLUGIN}efiction/stories.php$1', 	 		// file-path of what to load when the regex returns true.
		);  

		$config['toplists'] = array(
            'alias'         => 'toplists.php',
			'regex'			=> '^{alias}\/?([\?].*)?\/?$', 
			'sef'			=> '{alias}', 
			'redirect'		=> '{e_PLUGIN}efiction/toplists.php$1', 	 		// file-path of what to load when the regex returns true.
		);   


		$config['viewuser'] = array(
            'alias'         => 'viewuser.php',
			'regex'			=> '^{alias}\/?([\?].*)?\/?$', 
			'sef'			=> '{alias}', 
			'redirect'		=> '{e_PLUGIN}efiction/viewuser.php$1', 	 		// file-path of what to load when the regex returns true.
		);   

		
		$config['viewpage'] = array(
            'alias'         => 'viewpage.php',
			'regex'			=> '^{alias}\/?([\?].*)?\/?$', 
			'sef'			=> '{alias}', 
			'redirect'		=> '{e_PLUGIN}efiction/viewpage.php$1', 	 		// file-path of what to load when the regex returns true.
		);   

		$config['viewserie'] = array(
            'alias'         => 'viewserie.php',
			'regex'			=> '^{alias}\/?([\?].*)?\/?$', 
			'sef'			=> '{alias}', 
			'redirect'		=> '{e_PLUGIN}efiction/viewserie.php$1', 	 		// file-path of what to load when the regex returns true.
		);   
 
		$config['viewstory'] = array(
            'alias'         => 'viewstory.php',
			'regex'			=> '^{alias}\/?([\?].*)?\/?$', 
			'sef'			=> '{alias}', 
			'redirect'		=> '{e_PLUGIN}efiction/viewstory.php$1', 	 		// file-path of what to load when the regex returns true.
		);   
 
		$config['member'] = array(
            'alias'         => 'member.php',
			'regex'			=> '^{alias}\/?([\?].*)?\/?$', 
			'sef'			=> '{alias}', 
			'redirect'		=> '{e_PLUGIN}efiction/member.php$1', 	 		// file-path of what to load when the regex returns true.
		);      
        
        $config['index'] = array(
            'alias'         => 'efiction',
			'regex'			=> '^{alias}\/?$', 						// matched against url, and if true, redirected to 'redirect' below.
			'sef'			=> '{alias}', 							// used by e107::url(); to create a url from the db table.
			'redirect'		=> '{e_PLUGIN}efiction/index.php', 		// file-path of what to load when the regex returns true.
		);
        
		return $config;
	}
	

	
}