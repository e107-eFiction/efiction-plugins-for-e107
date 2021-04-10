<?php

if (!defined('e107_INIT')) { exit; }

/* Default: <div class="block">
       <div class="title">{recent_title}</div>
       <div class="content">{recent_content}</div>
     </div> 
$STORYBLOCK_TEMPLATE['recent']['caption'] = '<div class="title">{BLOCK_CAPTION}</div>'; 
$STORYBLOCK_TEMPLATE['recent']['start'] = "<div class='content'>";
$STORYBLOCK_TEMPLATE['recent']['item'] = 
  ""<div class='recentstory'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME} <br> 
  {STORY_SUMMARY: limit=100}</div>";
$STORYBLOCK_TEMPLATE['recent']['end'] = '</div>';    */
 

$STORYBLOCK_TEMPLATE['default']['recent'] = "<div class='recentstory'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME}{STORY_SUMMARY}</div>"; 
$STORYBLOCK_TEMPLATE['default']['random'] = "<div class='randomstory'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME}{STORY_SUMMARY}</div>";
$STORYBLOCK_TEMPLATE['default']['featured'] = "<div class='featuredstory'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME}{STORY_SUMMARY}</div>";

/* Epiphany: <h3>{recent_title}</h3>{recent_content}   */
$STORYBLOCK_TEMPLATE['recent']['caption'] = '<h3>{BLOCK_CAPTION}</h3>'; 
$STORYBLOCK_TEMPLATE['recent']['start'] = "";
$STORYBLOCK_TEMPLATE['recent']['item'] = 
  "<div class='recentstory mb-2'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME} <br> 
  {STORY_SUMMARY}</div>";
$STORYBLOCK_TEMPLATE['recent']['end'] = ''; 

$STORYBLOCK_TEMPLATE['random'] = $STORYBLOCK_TEMPLATE['recent'];
$STORYBLOCK_TEMPLATE['featured'] = $STORYBLOCK_TEMPLATE['recent'];