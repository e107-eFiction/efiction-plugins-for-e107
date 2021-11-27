<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2009 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 *
 *
 * $Source: /cvs_backup/e107_0.8/e107_themes/templates/comment_template.php,v $
 * $Revision$
 * $Date$
 * $Author$
 */

if (!defined('e107_INIT')) { exit; }


// Shortcode wrappers.
$COMMENT_WRAPPER['item']['COMENT_TIMEDATE']     = '<small>{---}</small>';
$COMMENT_WRAPPER['item']['COMMENT_EDIT']        = '<span class="comment-edit">{---}</span>';
$COMMENT_WRAPPER['item']['COMENT_REPLY']		= '<span class="comment-reply">{---}</span>';
$COMMENT_WRAPPER['item']['COMMENT_AVATAR']  	= '<div class="comment-avatar center">{---}</div>';
$COMMENT_WRAPPER['item']['COMMENT_MODERATE']	= '<span class="comment-moderate">{---}</span>';

$COMMENT_WRAPPER['form'] = $COMMENT_WRAPPER['item']; // use the above wrappers for the 'form' as well.

// Templates

$COMMENT_TEMPLATE['form']			= "
	{SETIMAGE: w=90&h=90&crop=1}
	<div class='media comment-box comment-box-form d-flex clearfix'>
		<div class='comment-box-left media-object pull-left me-3' >
		{COMMENT_AVATAR: shape=circle}
		</div>
		<div class='media-body comment-box-right text-left' >
			<div class='P10'>
				{AUTHOR_INPUT}
				{COMMENT_INPUT: inputclass=form-control&class=form-group} 
			<div id='commentformbutton'>
				{COMMENT_BUTTON}
				{COMMENT_SHARE}
			</div>
			</div>
		</div>
	</div>
	<div class='clear_b'><!-- --></div>
	<hr>"; 

 

$COMMENT_TEMPLATE['item'] = '
<div class="card comment-card w-100 mb-2">
        {SETIMAGE: w=30&h=30&crop=1}
		<div class="card-header  d-flex justify-content-between" style="float: left;">
			<div class="d-flex align-items-center ">{COMMENT_AVATAR: shape=circle} {USERNAME}</div><div>{COMMENT_TIMEDATE=relative}</div>
		</div>	
		<div class="card-body ">
			<div class="row-fluid">
				<div class="span12 col-xs-12 comment-text" id="{COMMENT_ITEMID}-edit" contentEditable="false" >
					<p>
						{COMMENT}
					</p>
				</div>
			</div>	
			<div class="row ">
				<div class="comment-status span2 col-sm-12 col-md-6">{COMMENT_STATUS}</div>
					<div class="comment-moderate span6 col-sm-12 col-md-6 text-right text-end">{COMMENT_RATE} {COMMENT_REPLY} {COMMENT_EDIT} {COMMENT_MODERATE}</div>
			</div>
		</div>           
</div>';
	

$COMMENT_TEMPLATE['layout']['default'] 		= '
<div class="container mt-5">
{COMMENTFORM}
{COMMENTS} 
  <div style="padding:10px 0px">{MODERATE}</div>
</div>
';
										
$COMMENT_TEMPLATE['layout']['fanfiction_stories'] 		= '
<div class="container mt-5">
{COMMENTFORM}
{COMMENTS} 
  <div style="padding:10px 0px">{MODERATE}</div>
</div>
';

$COMMENT_TEMPLATE['layout'] 		= '
<div class="container mt-5">
{COMMENTFORM}
{COMMENTS} 
  <div style="padding:10px 0px">{MODERATE}</div>
</div>
';