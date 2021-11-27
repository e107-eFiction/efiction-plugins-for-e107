<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2010 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Comment handling generic interface
 *
 * $URL$
 * $Id$
 */


/**
 *	@package    e107
 *	@subpackage	user
 *	@version 	$Id$;
 *
 *	Display comments
 */

if (!defined('e107_INIT'))
{
	require_once(__DIR__.'/../../class2.php');
}


e107::includeLan(e_LANGUAGEDIR.e_LANGUAGE.'/lan_comment.php');

if (!empty(e107::getPref('comments_disabled')))
{
	exit;
}


if(e_AJAX_REQUEST) // TODO improve security
{

	if(!ANON && !USER)
	{
		exit;
	}
	
	$ret = array();
	 
	// Comment Pagination 
	if(varset($_GET['mode']) == 'list' && vartrue($_GET['id']) && vartrue($_GET['type']))
	{
		$clean_type = preg_replace("/[^\w\d]/","",$_GET['type']);
		
		$tmp = e107::getSingleton('efiction_comments')->getComments($clean_type,intval($_GET['id']),intval($_GET['from']));
		echo $tmp['comments'];
		exit;
	}
	

	if(varset($_GET['mode']) == 'reply' && vartrue($_POST['itemid']))
	{	
		$status 		= e107::getSingleton('efiction_comments')->replyComment($_POST['itemid']);	
		$ret['msg'] 	= COMLAN_332; 
		$ret['error'] 	= ($status) ? false : true;
		$ret['html']	= $status;
		echo json_encode($ret);
		exit; 	
	}
	
	
	if(varset($_GET['mode']) == 'delete' && !empty($_POST['id']) && ADMIN)
	{
		$status 		= e107::getSingleton('efiction_comments')->deleteComment($_POST['id'],$_POST['table'],$_POST['itemid']);
		$ret['msg'] 	= ($status) ? 'Ok' : COMLAN_332; 
		$ret['error'] 	= ($status) ? false : true;
		echo json_encode($ret);
		exit; 	
	}
	
	if(varset($_GET['mode']) == 'approve' && vartrue($_POST['itemid']) && ADMIN)
	{
		$status 		= e107::getSingleton('efiction_comments')->approveComment($_POST['itemid']);		
		$ret['msg'] 	= ($status) ? COMLAN_333 : COMLAN_334; 
		$ret['error'] 	= ($status) ? false : true;
		$ret['html']	= COMLAN_335;
		echo json_encode($ret);
		exit; 	
	}
	
		
	if(!vartrue($_POST['comment']) && varset($_GET['mode']) == 'submit')
	{
		$ret['error'] 	= true;
		$ret['msg'] 	= COMLAN_336." - ".implode(" ",$_GET);
		echo json_encode($ret);
		exit; 	
	}

	// Update Comment 
	if(e107::getPref('allowCommentEdit') && varset($_GET['mode']) == 'edit' && vartrue($_POST['comment']) && vartrue($_POST['itemid']))
	{			
		$error = e107::getSingleton('efiction_comments')->updateComment($_POST['itemid'],$_POST['comment']);
		
		$ret['error'] 	= ($error) ? true : false;
		$ret['msg'] 	= ($error) ? $error : COMLAN_337;
		
		echo json_encode($ret);
		exit;	
	}
	
	// Insert Comment and return rendered html. 
	if(!empty($_POST['comment'])) // ajax render comment
	{
		$pid 				= intval(varset($_POST['pid'], 0)); // ID of the specific comment being edited (nested comments - replies)
		$row 				= array();
		$authName           = e107::getParser()->filter($_POST['author_name'], 'str');
		$clean_authorname 	= vartrue($authName,USERNAME);
		$clean_comment 		= e107::getParser()->toText($_POST['comment']);
		$clean_subject 		= e107::getParser()->filter($_POST['subject'],'str');
		$clean_table        = e107::getParser()->filter($_POST['table'],'str');
		
		$_SESSION['comment_author_name'] = $clean_authorname;
		
		$row['comment_pid'] 		= $pid;
		$row['comment_item_id']		= intval($_POST['itemid']);
		$row['comment_type']		= e107::getSingleton('efiction_comments')->getCommentType($tp->toDB($clean_table,true));
		$row['comment_subject'] 	= $tp->toDB($clean_subject);
		$row['comment_comment'] 	= $tp->toDB($clean_comment);
		$row['user_image'] 			= USERIMAGE;
		$row['user_id']				= (USERID) ? USERID : 0;
		$row['user_name'] 			= USERNAME;
		$row['comment_author_name'] = $tp->toDB($clean_authorname);
		$row['comment_author_id'] 	= (USERID) ? USERID : 0;
		$row['comment_datestamp'] 	= time();
		$row['comment_blocked']		= (check_class($pref['comments_moderate']) ? 2 : 0);
		$row['comment_share']		= ($_POST['comment_share']);
		
		$newid =e107::getSingleton('efiction_comments')->enter_comment($row);
	
		
	//	$newid =e107::getSingleton('efiction_comments')->enter_comment($clean_authorname, $clean_comment, $_POST['table'], intval($_POST['itemid']), $pid, $clean_subject);
	
		if(is_numeric($newid) && ($_GET['mode'] == 'submit'))
		{
			
			$row['comment_id']			= $newid; 		
			$width = ($pid) ? 1 : 0;
			
			$ret['html'] = "\n<!-- Appended -->\n<li>";

			/**
			 * Fix for issue e107inc/e107#3154 (Comments not refreshing on submission)
			 * Missing 6th argument ($subject) caused an exception
			 */
			$ret['html'] .= e107::getSingleton('efiction_comments')->render_comment($row,'comments','comment', (int) $_POST['itemid'], $width, $tp->toDB($clean_subject));
			$ret['html'] .= "</li>\n<!-- end Appended -->\n";
			
			$ret['error'] = false;	
			
		}
		else
		{
			$ret['error'] = true;
			$ret['msg'] = $newid;			
		}
		
		echo json_encode($ret);
	}
	exit;
}
 

require_once(FOOTERF);
exit;
