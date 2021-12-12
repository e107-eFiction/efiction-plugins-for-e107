<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 * XXX HIGHLY EXPERIMENTAL AND SUBJECT TO CHANGE WITHOUT NOTICE. 
*/

if (!defined('e107_INIT')) { exit; }

 

class efiction_comments_event // plugin-folder + '_event'
{

	function config()
	{

		$event = array();

		$event[] = array(
			'name'	=> "efiction_comment_posted", 
			'function'	=> "commentCountUp", // ..run this function (see below).
		);
        
		$event[] = array(
			'name'	=> "efiction_comment_deleted", 
			'function'	=> "commentCountDown", // ..run this function (see below).
		);        
 
        
       	return $event;
        
    }    
    
    
    
    
	function commentCountDown($data) // the method to run.
	{
	 
	   if(empty($data['comment_type'])) {
             return false;
        } 
        
        if(empty($data['comment_item_id'])) {
             return false;
        } 
        
        
        if($data['comment_type'] == 'ST' )
		{
 
            $id = intval($data['comment_item_id']);
			e107::getDb()->update("fanfiction_stories", "reviews=reviews-1 WHERE sid =".$id);
		}
        
        if($data['comment_type'] == 'CH')
		{
 
            $id = intval($data['comment_item_id']);
			e107::getDb()->update("fanfiction_chapters", "reviews=reviews-1 WHERE chapid=".$id);
			//e107::getCache()->clear('news_php_extend_'.$id.'_');
            
		}

        if($data['comment_type'] == 'SE')
		{
			$id = intval($data['comment_item_id']);
			e107::getDb()->update("fanfiction_series", "reviews=reviews+1 WHERE seriesid=".$id);
		}


	}   
    
    
    
	function commentCountUp($data) // the method to run.
	{
	 
	   if(empty($data['comment_type'])) {
             return false;
        } 
        
        if(empty($data['comment_item_id'])) {
             return false;
        } 
        
        
        if($data['comment_type'] == 'ST' )
		{
			//dbquery("UPDATE ".TABLEPREFIX."fanfiction_stories SET reviews = (reviews + 1) WHERE sid = '$item'");
            $id = intval($data['comment_item_id']);
			e107::getDb()->update("fanfiction_stories", "reviews=reviews+1 WHERE sid =".$id);
		}
        
        if($data['comment_type'] == 'CH')
		{
		    //dbquery("UPDATE ".TABLEPREFIX."fanfiction_chapters SET reviews = (reviews + 1) WHERE chapid = '$chapid'");
            $id = intval($data['comment_item_id']);
			e107::getDb()->update("fanfiction_chapters", "reviews=reviews+1 WHERE chapid=".$id);
			//e107::getCache()->clear('news_php_extend_'.$id.'_');
            
		}

        if($data['comment_type'] == 'SE')
		{
			$id = intval($data['comment_item_id']);
			e107::getDb()->update("fanfiction_series", "reviews=reviews+1 WHERE seriesid=".$id);
		}
 
	}
 

}


 