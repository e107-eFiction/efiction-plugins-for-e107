<?php

if (!defined('e107_INIT')) {
    exit;
}


/* original 
<!-- START BLOCK : storyblock -->
<div class="listbox {oddeven} clearfix">
<h2>{title} {new} by {author}</h2>
<b>Rated:</b> {rating} &bull; {numreviews} {reviews} {score} {featuredstory} {roundrobin}<br />
<b>Summary:</b> {summary}<br />
<div class="storyinfo">
<b>Categories:</b> {category}<br />
<b>Characters:</b> {characters}<br />
{classifications}
<b>Series:</b> {serieslinks}<br />
<b>Chapters:</b> {numchapters} | <b>Completed:</b> {completed} | <b>Words:</b> {wordcount} | <b>Hits</b>: {count} | <b>Published:</b> </b>{published} | <b>Updated:</b> {updated}
<br />{addtofaves} {reportthis} {comment}<br />{adminlinks}<br />
</div></div>
<!-- END BLOCK : storyblock -->
*/


$LISTINGS_TEMPLATE['favst']['start'] = '';
$LISTINGS_TEMPLATE['favst']['end'] = '';
/*
$LISTINGS_TEMPLATE['favst']['item'] = '
<div class="listbox {STORY_ODDEVEN} clearfix">
<h2>{STORY_TITLE_LINK} {STORY_NEW} {LAN=LAN_EFICTION_BY} {STORY_AUTHOR_LINK}</h2>
<b>Rated:</b> {STORY_RATING_NAME} &bull; {STORY_NUMREVIEWS} {STORY_REVIEWS} {STORY_SCORE} {STORY_FEATUREDSTORY} {STORY_ROUNDROBIN}<br />
<b>Summary:</b> {STORY_SUMMARY}<br />
<div class="storyinfo">
<b>Categories:</b> {STORY_CATEGORY}<br />
<b>Characters:</b> {STORY_CHARACTERS}<br />
{STORY_CLASSIFICATIONS}
<b>Series:</b> {STORY_SERIESLINKS}<br />
<b>Chapters:</b> {STORY_NUMCHAPTERS} | <b>Completed:</b> {STORY_COMPLETED} | <b>Words:</b> {STORY_WORDCOUNT} | <b>Hits</b>: {STORY_COUNT} | <b>Published:</b> </b>{STORY_PUBLISHED} | <b>Updated:</b> {STORY_UPDATED}
<br />{STORY_ADDTOFAVES} {reportthis} {STORY_COMMENT}<br />{STORY_ADMINLINKS}<br />
</div></div>';
*/

$LISTINGS_TEMPLATE['favst']['item'] = '
<div class="listbox {STORY_ODDEVEN} border-bottom border-separator-light mb-2 pb-2">
<h2>{STORY_TITLE_LINK} {STORY_NEW} {LAN=LAN_EFICTION_BY} {STORY_AUTHOR_LINK}</h2>
<b>Rated:</b> {STORY_RATING_NAME} &bull; {STORY_NUMREVIEWS} {STORY_REVIEWS} {STORY_SCORE} {STORY_FEATUREDSTORY} {STORY_ROUNDROBIN}<br />
<b>Summary:</b> {STORY_SUMMARY}<br />
<div class="storyinfo">
<b>Categories:</b> {STORY_CATEGORY}<br />
<b>Characters:</b> {STORY_CHARACTERS}<br />
{STORY_CLASSIFICATIONS}
<b>Series:</b> {STORY_SERIESLINKS}<br />
<b>Chapters:</b> {STORY_NUMCHAPTERS} | <b>Completed:</b> {STORY_COMPLETED} | <b>Words:</b> {STORY_WORDCOUNT} | <b>Hits</b>: {STORY_COUNT} | <b>Published:</b> </b>{STORY_PUBLISHED} | <b>Updated:</b> {STORY_UPDATED}
<br />{STORY_ADDTOFAVES} {STORY_REPORTTHIS} {STORY_COMMENT}<br />{STORY_ADMINLINKS}<br />
</div>


';
$LISTINGS_TEMPLATE['favst']['end'] = '
<div class="comment{oddeven}">
{comment}
{commentoptions_alt}
</div>

</div>';


$LISTINGS_TEMPLATE['home'] =  $LISTINGS_TEMPLATE['favst'];