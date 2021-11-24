<?php

if (!defined('e107_INIT')) {
    exit;
}

/* original viewstory.tpl
<!-- INCLUDE BLOCK : header -->
<div id="pagetitle">{title} by {author}</div>
<div class="storyinfo"> [{reviews} - {numreviews}]<br />
{toc} {reportthis}<br />
{printicon} <br />
{adminlinks} </div>
<div class="jumpmenu">{textsizer}{jumpmenu}</div>
<!-- START BLOCK : storynotes -->
<div class='notes'>
	<div class='title'><span class='label'>Story Notes:</span></div>
	<div class='noteinfo'>{storynotes}</div>
</div>
<!-- END BLOCK : storynotes -->
<!-- START BLOCK : notes -->
<div class='notes'><div class='title'><span class='label'>Author's Chapter Notes:</span></div><div class='noteinfo'>{notes}</div></div>
<!-- END BLOCK : notes -->
<div id="story">{story}</div>
<!-- START BLOCK : endnotes -->
<div class='notes'><div class='title'><span class='label'>Chapter End Notes:</span></div><div class='noteinfo'>{endnotes}</div></div>
<!-- END BLOCK : endnotes -->
<div id="prev">{prev}</div><div id="next">{next}</div>
<div class="jumpmenu2">{jumpmenu2}</div>
<div class="respond">{addtofaves} {roundrobin}</div>
{reviewform}
<!-- INCLUDE BLOCK : footer -->
*/

$VIEWSTORY_TEMPLATE['default']['caption'] = 
$VIEWSTORY_TEMPLATE['default']['start'] = '<div class="storyinfo"> [{STORY_REVIEWS} - {STORY_NUMREVIEWS}]<br />{STORY_TOC} {STORY_REPORTTHIS}<br />{printicon} <br />{STORY_ADMINLINKS} </div>
<div class="jumpmenu">{textsizer}{jumpmenu}</div>';
$VIEWSTORY_TEMPLATE['default']['item'] = '
<div class="notes">
	<div class="title"><span class="label">Story Notes:</span></div>
	<div class="noteinfo">{STORY_STORYNOTES}</div>
</div>

<div class="notes"><div class="title"><span class="label">Author\'s Chapter Notes:</span></div><div class="noteinfo">{STORY_NOTES}</div></div>

<div id="story">{STORY_STORYTEXT}</div>

<div class="notes"><div class="title"><span class="label">Chapter End Notes:</span></div><div class="noteinfo">{STORY_ENDNOTES}</div></div>
';

$VIEWSTORY_TEMPLATE['default']['end'] = '
<div id="prev">{prev}</div><div id="next">{next}</div>
<div class="jumpmenu2">{jumpmenu2}</div>
<div class="respond">{STORY_ADDTOFAVES} {STORY_ROUNDROBIN}</div>
{reviewform}
';


$VIEWSTORY_TEMPLATE['preview_story']['caption']  = '<div id="pagetitle"> {STORY_TITLE_LINK} by {STORY_AUTHOR}</div>';

$VIEWSTORY_TEMPLATE['preview_story']['start'] = '<div class="storyinfo">  {STORY_ADMINLINKS_VALIDATE} </div>';

$VIEWSTORY_TEMPLATE['preview_story']['item'] =   $VIEWSTORY_TEMPLATE['default']['item'] ; 

$VIEWSTORY_TEMPLATE['preview_story']['end'] = '<div class="storyinfo">  {STORY_ADMINLINKS_VALIDATE} </div>';