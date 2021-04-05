<?php

if (!defined('e107_INIT')) { exit; }

/* Default: <div class="block">
       <div class="title">{recent_title}</div>
       <div class="content">{recent_content}</div>
     </div> 
$STORYBLOCK_TEMPLATE['recent']['caption'] = '<div class="title">{RECENT_MENU_CAPTION}</div>'; 
$STORYBLOCK_TEMPLATE['recent']['start'] = "<div class='content'>";
$STORYBLOCK_TEMPLATE['recent']['item'] = 
  ""<div class='recentstory'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME} <br> 
  {STORY_SUMMARY: limit=100}</div>";
$STORYBLOCK_TEMPLATE['recent']['end'] = '</div>';    */


/*
  $content .= "<div class='recentstory'>".title_link($stories)." "._BY." ".author_link($stories)." ".$ratingslist[$stories['rid']]['name']."<br />".stripslashes($stories['summary'])."</div>";
  */

/* Epiphany: <h3>{recent_title}</h3>{recent_content}   */
$STORYBLOCK_TEMPLATE['recent']['caption'] = '<h3>{RECENT_MENU_CAPTION}</h3>'; 
$STORYBLOCK_TEMPLATE['recent']['start'] = "";
$STORYBLOCK_TEMPLATE['recent']['item'] = 
  "<div class='recentstory mb-2'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME} <br> 
  {STORY_SUMMARY: limit=100}</div>";
$STORYBLOCK_TEMPLATE['recent']['end'] = ''; 


 