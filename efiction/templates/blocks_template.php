<?php

if (!defined('e107_INIT')) { exit; }
 
/* global look of blocks is in efiction_template and global shortcode {EFICTION_BLOCK_CONTENT=info} */


$BLOCKS_TEMPLATE['default']['recent'] = "<div class='recentstory'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME}{STORY_SUMMARY}</div>"; 
$BLOCKS_TEMPLATE['default']['random'] = "<div class='randomstory'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME}{STORY_SUMMARY}</div>";
$BLOCKS_TEMPLATE['default']['featured'] = "<div class='featuredstory'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME}{STORY_SUMMARY}</div>";
 
/* template for stylink content of info block */
$BLOCKS_TEMPLATE['info']['start'] = "<div id='infoblock'>";
$BLOCKS_TEMPLATE['info']['end'] = "</div>";
$BLOCKS_TEMPLATE['info']['tablerender'] = 'menu';
$BLOCKS_TEMPLATE['info']['content'] = 
" 
<div><span class='label'>{LAN=_MEMBERS}: </span>{TOTALMEMBERS}</div>
<div><span class='label'>{LAN=_SERIES}: </span>{TOTALSERIES}</div>
<div><span class='label'>{LAN=_STORIES}: </span>{TOTALSTORIES}</div>
<div><span class='label'>{LAN=_CHAPTERS}: </span>{TOTALCHAPTERS}</div>
<div><span class='label'>{LAN=_WORDCOUNT}: </span>{TOTALWORDS}</div>
<div><span class='label'>{LAN=_AUTHORS}: </span>{TOTALAUTHORS}</div>
<div><span class='label'>{LAN=_REVIEWS}: </span>{TOTALREVIEWS}</div>
<div><span class='label'>{LAN=_REVIEWERS}: </span>{TOTALREVIEWERS}</div>
<div><span class='label'>{LAN=_NEWESTMEMBER}: </span>{NEWESTMEMBER}</div>
{BLOCKINFO_CODEBLOCK}
{LOGGEDINAS}
<div>{SUBMISSIONS}</div><div class='cleaner'>&nbsp;</div> 
</div>"
;
    

/* Epiphany: <h3>{recent_title}</h3>{recent_content}   */
$BLOCKS_TEMPLATE['recent']['caption'] = '<h3>{BLOCK_CAPTION}</h3>'; 
$BLOCKS_TEMPLATE['recent']['start'] = "";
$BLOCKS_TEMPLATE['recent']['item'] = 
  "<div class='recentstory mb-2'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME} <br> 
  {STORY_SUMMARY}</div>";
$BLOCKS_TEMPLATE['recent']['end'] = ''; 

$BLOCKS_TEMPLATE['random'] = $BLOCKS_TEMPLATE['recent'];
$BLOCKS_TEMPLATE['featured'] = $BLOCKS_TEMPLATE['recent'];

    
    
 