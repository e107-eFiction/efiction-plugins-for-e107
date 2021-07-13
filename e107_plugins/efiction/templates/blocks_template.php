<?php

if (!defined('e107_INIT')) { exit; }
 
/* global look of blocks is in efiction_template and global shortcode {EFICTION_BLOCK_CONTENT=info} */


$BLOCKS_TEMPLATE['default']['recent'] = "<div class='recentstory'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME}{STORY_SUMMARY}</div>"; 
$BLOCKS_TEMPLATE['default']['random'] = "<div class='randomstory'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME}{STORY_SUMMARY}</div>";
$BLOCKS_TEMPLATE['default']['featured'] = "<div class='featuredstory'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME}{STORY_SUMMARY}</div>";
 
/* template for stylink content of info block */
$BLOCKS_TEMPLATE['info']['caption'] = '{BLOCK_CAPTION}'; 
$BLOCKS_TEMPLATE['info']['start'] = "<div id='infoblock'>";
$BLOCKS_TEMPLATE['info']['end'] = "</div>";
$BLOCKS_TEMPLATE['info']['tablerender'] = 'menu';
$BLOCKS_TEMPLATE['info']['content'] = 
" 
<div><span class='elabel'>{LAN=_MEMBERS}: </span>{TOTALMEMBERS}</div>
<div><span class='elabel'>{LAN=_SERIES}: </span>{TOTALSERIES}</div>
<div><span class='elabel'>{LAN=_STORIES}: </span>{TOTALSTORIES}</div>
<div><span class='elabel'>{LAN=_CHAPTERS}: </span>{TOTALCHAPTERS}</div>
<div><span class='elabel'>{LAN=_WORDCOUNT}: </span>{TOTALWORDS}</div>
<div><span class='elabel'>{LAN=_AUTHORS}: </span>{TOTALAUTHORS}</div>
<div><span class='elabel'>{LAN=_REVIEWS}: </span>{TOTALREVIEWS}</div>
<div><span class='elabel'>{LAN=_REVIEWERS}: </span>{TOTALREVIEWERS}</div>
<div><span class='elabel'>{LAN=_NEWESTMEMBER}: </span>{NEWESTMEMBER}</div>
{BLOCKINFO_CODEBLOCK}
{LOGGEDINAS}
<div>{SUBMISSIONS}</div><div class='cleaner'>&nbsp;</div> 
</div>"
;
    

/* Epiphany: <h3>{recent_title}</h3>{recent_content}  - put in tablestyle() */
$BLOCKS_TEMPLATE['recent']['caption'] = '{BLOCK_CAPTION}'; 
$BLOCKS_TEMPLATE['recent']['start'] = "";
$BLOCKS_TEMPLATE['recent']['item'] = 
  "<div class='recentstory'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME} <br> 
  {STORY_SUMMARY}</div>";
$BLOCKS_TEMPLATE['recent']['end'] = ''; 

$BLOCKS_TEMPLATE['random']['caption'] = '{BLOCK_CAPTION}'; 
$BLOCKS_TEMPLATE['random']['start'] = "";
$BLOCKS_TEMPLATE['random']['item'] = 
  "<div class='randomstory'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME} <br> 
  {STORY_SUMMARY}</div>";
$BLOCKS_TEMPLATE['random']['end'] = ''; 
 
$BLOCKS_TEMPLATE['featured']['caption'] = '{BLOCK_CAPTION}'; 
$BLOCKS_TEMPLATE['featured']['start'] = "";
$BLOCKS_TEMPLATE['featured']['item'] = 
  "<div class='featuredstory'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME} <br> 
  {STORY_SUMMARY}</div>";
$BLOCKS_TEMPLATE['featured']['end'] = ''; 
    
    
 