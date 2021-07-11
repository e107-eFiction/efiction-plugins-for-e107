<?php
/*
<!-- START BLOCK : listings -->
{seriesheader}
<!-- START BLOCK : seriesblock -->
<div class="listbox {oddeven}">
<div class="title">{title} by {author}{score} [{reviews} - {numreviews}]</div>
<div class="content"><span class="label">Summary: </span>{summary}<br />
<span class="label">Parent Series:</span> {parentseries}<br />
<span class="label">Categories:</span> {category}<br />
 <span class="label">Characters: </span>{characters}<br />
{classifications}
<span class="label">Stories:</span> {numstories}<br />
<span class="label">Open:</span> {open} {addtofaves} {reportthis}
{adminoptions}</div>
</div>
{comment}
<!-- END BLOCK : seriesblock -->
{stories}
<!-- START BLOCK : storyblock -->
<div class="listbox {oddeven}">
<div class="title">{title} by {author} <span class="label">Rated:</span> {rating} {roundrobin} {score} [{reviews} - {numreviews}] {new} </div>
<div class="content"><span class="label">Summary: </span>{featuredstory}{summary}<br />
<span class="label">Categories:</span> {category} <br />
<span class="label">Characters: </span> {characters}<br />
{classifications}
<span class="label">Series:</span> {serieslinks}<br />
<span class="label">Chapters: </span> {numchapters} {toc}<br />
<span class="label">Completed:</span> {completed}  
<span class="label">Word count:</span> {wordcount} <span class="label">Read Count:</span> {count}
{adminlinks}</div>
<div class="tail"><span class="label">{addtofaves} {reportthis} Published: </span>{published} <span class="label">Updated:</span> {updated}</div>
</div>
{comment}
<!-- END BLOCK : storyblock -->
{pagelinks}
<!-- END BLOCK : listings -->
*/

/*
$LISTINGS_TEMPLATE['seriesblock']['item'] = 
'<div class="listbox {SERIES_ODDEVEN}">
<div class="title">{SERIES_PAGETITLE} by {SERIES_AUTHOR}{SERIES_SCORE} [{SERIES_REVIEWS} - {SERIES_NUMREVIEWS}]</div>
<div class="content"><span class="label">{LAN=_SUMMARY}: </span>{SERIES_SUMMARY: limit=100}<br />
<span class="label">{LAN=LAN_EFICTION_PARENTSERIES}:</span> {SERIES_PARENTSERIES}<br />
<span class="label">Categories:</span> {SERIES_CATEGORY}<br />
 <span class="label">Characters: </span>{SERIES_CHARACTERS}<br />
{SERIES_CLASSIFICATIONS}
<span class="label">{LAN=_STORIES}:</span> {SERIES_NUMSTORIES}<br />
<span class="label">{LAN=_SERIESTYPE}:</span> {SERIES_OPEN} {SERIES_ADDTOFAVES} {SERIES_REPORTTHIS}
{SERIES_ADMINOPTIONS}</div>
</div>';
*/

$LISTINGS_TEMPLATE['seriesblock']['start'] = '
{SERIESBY_SORT}
<div class="row"><div class="col-12"><div class="card-columns">';
$LISTINGS_TEMPLATE['seriesblock']['end'] = '</div></div></div>
<div class="row"><div class="col-12">{SERIESBY_PAGELINKS}</div></div>';

$LISTINGS_TEMPLATE['seriesblock']['item'] = 
'
<div class="card {SERIES_ODDEVEN}">
    {SETIMAGE: w=0&h=0}
	{SERIES_IMAGE: class=card-img-top&placeholder=true}
	<div class="card-body">
		<h4 class="card-title">{SERIES_TITLE_LINK} {LAN=_BY} {SERIES_AUTHOR}
		<small><span class="label">{LAN=LAN_EFICTION_RATED}:</span>  {SERIES_SCORE} [{SERIES_REVIEWS} - {SERIES_NUMREVIEWS}]</small></h4>
		<p class="card-text"><span class="label">{LAN=_SUMMARY}: </span>{SERIES_SUMMARY: limit=100}</p>
		<span class="label">{LAN=LAN_EFICTION_PARENTSERIES}:</span> {SERIES_PARENTSERIES}<br />
		<span class="label">Categories:</span> {SERIES_CATEGORY}<br />
		<span class="label">{LAN=_CHARACTERS}: </span> {SERIES_CHARACTERS}<br>
		<span class="label">{LAN=_STORIES}:</span> {SERIES_NUMSTORIES}<br />
		<span class="label">{LAN=_SERIESTYPE}:</span> {SERIES_OPEN}<br />
		<span class="label">{LAN=_WORDCOUNT}:</span> {STORY_WORDCOUNT}<br> 
		<span class="label">Read Count:</span> {STORY_COUNT}<br>
		{SERIES_CLASSIFICATIONS} 
	</div>
	<div class="card-footer"> 
		<span class="label">{SERIES_ADDTOFAVES} {SERIES_REPORTTHIS}  <br>{STORY_ADMINLINKS}
	</div>
</div>';

/*
{oddeven} - {STORY_ODDEVEN}
{title} - {STORY_TITLE}
{author} - {STORY_AUTHOR}
{rating} - {STORY_RATING}
{roundrobin} - {STORY_ROUNDROBIN}
{score} - {STORY_SCORE}
{reviews} - {STORY_REVIEWS}
{numreviews} - {STORY_NUMREVIEWS}
{new} - {STORY_NEW} 
{featuredstory} - {STORY_FEATUREDSTORY}
{summary} - {STORY_SUMMARY}
{category} - {STORY_CATEGORY}
{characters} - {STORY_CHARACTERS}
{classifications} - {STORY_CLASSIFICATIONS}
{serieslinks} - {STORY_SERIESLINKS}
{numchapters} -{STORY_NUMCHAPTERS}
{toc} - {STORY_TOC}
{completed}- {STORY_COMPLETED} 
{wordcount} - {STORY_WORDCOUNT}
{count} - {STORY_COUNT}
{adminlinks} - {STORY_ADMINLINKS}
{addtofaves} - {STORY_ADDTOFAVES}
{reportthis} - {STORY_REPORTTHIS}
{published} - {STORY_PUBLISHED} 
{updated} - {STORY_UPDATED}
{comment} - {STORY_COMMENT}
*/
/*
$LISTINGS_TEMPLATE['storyblock']['item'] = 
'<div class="listbox {STORY_ODDEVEN}">
<div class="title">{STORY_TITLE} {LAN=_BY} {STORY_AUTHOR} <span class="label">Rated:</span> {STORY_RATING} {STORY_ROUNDROBIN} {STORY_SCORE} [{STORY_REVIEWS} - {STORY_NUMREVIEWS}] {STORY_NEW} </div>
<div class="content"><span class="label">Summary: </span>{STORY_FEATUREDSTORY}{STORY_SUMMARY}<br />
<span class="label">Categories:</span> {STORY_CATEGORY} <br />
<span class="label">{LAN=_CHARACTERS}: </span> {STORY_CHARACTERS}<br />
{STORY_CLASSIFICATIONS}
<span class="label">Series:</span> {STORY_SERIESLINKS}<br />
<span class="label">Chapters: </span> {STORY_NUMCHAPTERS} {STORY_TOC}<br />
<span class="label">{LAN=_COMPLETE}:</span> {STORY_COMPLETED}  
<span class="label">{LAN=_WORDCOUNT}:</span> {STORY_WORDCOUNT} <span class="label">Read Count:</span> {STORY_COUNT}
{STORY_ADMINLINKS}</div>
<div class="tail"><span class="label">{STORY_ADDTOFAVES} {STORY_REPORTTHIS} Published: </span>{STORY_PUBLISHED} <span class="label">Updated:</span> {STORY_UPDATED}</div>
</div>
{STORY_PAGELINKS}
';*/

$LISTINGS_TEMPLATE['storyblock']['start'] = '
{STORIESBY_SORT}
<div class="row"><div class="col-12"><div class="card-columns">';
$LISTINGS_TEMPLATE['storyblock']['end'] = '</div></div></div>
<div class="row"><div class="col-12">{STORIESBY_PAGELINKS}</div></div>
';
$LISTINGS_TEMPLATE['storyblock']['item'] = 
'
<div class="card {STORY_ODDEVEN}">
	<img class="card-img-top" src="{STORY_IMAGE}" alt="{STORY_TITLE}">
	<div class="card-body">
		<h4 class="card-title">{STORY_TITLE_LINK} {LAN=_BY} {STORY_AUTHOR}
		<small><span class="label">{LAN=LAN_EFICTION_RATED}:</span> {STORY_RATING} {STORY_ROUNDROBIN} {STORY_SCORE} [{STORY_REVIEWS} - {STORY_NUMREVIEWS}] {STORY_NEW}</small></h4>
		<p class="card-text"><span class="label">Summary: </span>{STORY_FEATUREDSTORY}{STORY_SUMMARY}</p>

	 
		<span class="label">Categories:</span> {STORY_CATEGORY}<br>
		<span class="label">{LAN=_CHARACTERS}: </span> {STORY_CHARACTERS}<br>
		<span class="label">{LAN=_SERIES}:</span> {STORY_SERIESLINKS}<br>
		<span class="label">Chapters: </span> {STORY_NUMCHAPTERS} {STORY_TOC}<br>
		<span class="label">{LAN=_COMPLETE}:</span> {STORY_COMPLETED}<br>
		<span class="label">{LAN=_WORDCOUNT}:</span> {STORY_WORDCOUNT}<br> 
		<span class="label">Read Count:</span> {STORY_COUNT}<br>
		{STORY_CLASSIFICATIONS} 
	</div>
	<div class="card-footer"> 
	{STORY_ADMINLINKS} <br>
		<span class="label">{STORY_ADDTOFAVES} {STORY_REPORTTHIS}
		<br> Published: </span>{STORY_PUBLISHED} <span class="label">Updated:</span> {STORY_UPDATED} 
	</div>
</div>
';
 
 