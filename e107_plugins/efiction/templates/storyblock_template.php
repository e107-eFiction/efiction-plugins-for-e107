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
 
 
$STORYBLOCK_TEMPLATE['listing']['caption'] = '<h3>{BLOCK_CAPTION}</h3>'; 
$STORYBLOCK_TEMPLATE['listing']['start'] = ' <div class="filter-list row"> ';
$STORYBLOCK_TEMPLATE['listing']['item'] = 
'
            <div class="property-block-two all mix villa appartment col-lg-6 col-md-12 col-sm-12">
                        <div class="inner-box">
                            <div class="image-box">
                                <figure class="image"><a href="property-detail.html">
                                 <img src="{STORY_IMAGE}" alt=""> </a></figure>
                                <span class="for">FOR SALE</span>
                            </div>
                            <div class="lower-content">
                                <ul class="property-info clearfix">
                                    <li><span class="icon fa fa-expand"></span> Sq Ft 12,000</li>
                                    <li><span class="icon fa fa-bed"></span> Bedroom 3</li>
                                    <li><span class="icon fa fa-bath"></span> Bathroom 2</li>
                                </ul>
                                <h3>{STORY_TITLE_LINK} {LAN=LAN_EFICTION_BY} {STORY_AUTHORS_LINK} {STORY_RATING_NAME} </h3> 
                                <div class="text">{STORY_SUMMARY}</div>
                            </div>
                            <div class="property-price clearfix">
                                <div class="location"><span class="icon fa fa-map-marker-alt"></span> 568 E 1st Ave, Ney Jersey</div>
                                <div class="price">$ 765,300</div>
                            </div>
                        </div>{comment}
                    </div> ';  
$STORYBLOCK_TEMPLATE['listing']['end'] = '</div> '; 
