<?php

if (!defined('e107_INIT')) { exit; }


/*
  $content .= "<div class='recentstory'>".title_link($stories)." "._BY." ".author_link($stories)." ".$ratingslist[$stories['rid']]['name']."<br />".stripslashes($stories['summary'])."</div>";
  */
$STORYBLOCK_TEMPLATE['recent']['caption'] = 'caption';

 
$STORYBLOCK_TEMPLATE['recent']['start'] = "";
$STORYBLOCK_TEMPLATE['recent']['item'] = 
  "<div class='recentstory mb-2'>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK}  {STORY_RATING_NAME} <br> 
  {STORY_SUMMARY: limit=100}</div>";
$STORYBLOCK_TEMPLATE['recent']['end'] = '';


 