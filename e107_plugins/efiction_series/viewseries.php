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
e107::lan('efiction_series');

require_once (e_PLUGIN."efiction/includes/queries.php");
 
if(isset($_GET['seriesid']))
{
	$seriesid = (int)$_GET['seriesid']; 
	$tmp = efiction_series::get_series_by_serieid($seriesid);
	$title = $tmp['title'];
}
 
$series_id 	 = (int)$_GET['seriesid']; // Filter user input 
 

// Individual recipe
if(isset($series_id ))
{
 
	$data = efiction_series::serie($series_id);
	 
	if($data) { 
		/* render only caption */
		$caption = e107::getSingleton('efiction_series')->getCaption($series_id);

		define('e_PAGETITLE', $caption); 
		require_once(HEADERF);

		e107::getRender()->tablerender($caption, '', "efiction-caption");

		/* render series detail */
	 	$SeriesDetail = e107::getSingleton('efiction_series')->renderSeriesDetail($data); 
	 	e107::getRender()->tablerender('', $SeriesDetail , "viewseries");

		/* render series in series */
	 	$SeriesChildren  = e107::getSingleton('efiction_series')->renderSeriesChildren($series_id);
	
	 	if(!empty($SeriesChildren)) {   
	 		e107::getRender()->tablerender(LAN_ES_SERIES_IN_SERIES, $SeriesChildren , "viewseries");	
	 	}

		/* render stories in series */
	 	$SeriesStories  = e107::getSingleton('efiction_series')->renderSeriesStories($series_id);
	  	if(!empty($SeriesStories)) {
			e107::getRender()->tablerender(LAN_ES_SERIES_STORIES, '' , "section-caption");  
	 		e107::getRender()->tablerender('' ,  $SeriesStories , "none");	
	 	}

		/* render comments for serie */
	 	$SeriesComments  = e107::getSingleton('efiction_series')->renderSeriesComments($data);
	 	if(!empty($SeriesComments)) {
            e107::getRender()->tablerender(LAN_ES_SERIES_COMMENTS, $SeriesComments , "section-caption");  
	 	 //	e107::getRender()->tablerender('', $SeriesComments, "nocaption");	
	 	}
	}

 
}

 
 
 
require_once(FOOTERF);	