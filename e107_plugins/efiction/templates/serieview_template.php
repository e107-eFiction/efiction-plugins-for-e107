<?php

if (!defined('e107_INIT')) { exit; }

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
*/ 


$SERIEVIEW_TEMPLATE['listing']['caption'] = '{SERIES_HEADER}'; 
$SERIEVIEW_TEMPLATE['listing']['start'] = '';
$SERIEVIEW_TEMPLATE['listing']['item'] = 
'
<div class="listbox {SERIE_VIEW_ODDEVEN}">
<div class="title"><span class="h3">{SERIE_VIEW_TITLE}</span> by {SERIE_VIEW_AUTHOR}{SERIE_VIEW_SCORE} [{SERIE_VIEW_REVIEWS}  - {SERIE_VIEW_NUMREVIEWS}]</div>
<div class="content"><span class="label">Summary: </span>{SERIE_VIEW_SUMMARY: limit=400}<br />
<span class="label">Parent Series:</span> {SERIE_VIEW_PARENTSERIES}<br />
<span class="label">Categories:</span> {SERIE_VIEW_CATEGORY}<br />
 <span class="label">Characters: </span>{SERIE_VIEW_CHARACTERS}<br />
{SERIE_VIEW_CLASSIFICATIONS}
<span class="label">Stories:</span> {SERIE_VIEW_NUMSTORIES}<br />
<span class="label">Open:</span>{SERIE_VIEW_OPEN} {SERIE_VIEW_ADDTOFAVES} {SERIE_VIEW_REPORTTHIS}
{SERIE_VIEW_ADMINOPTIONS}</div>
</div>
{SERIE_VIEW_COMMENT}
';  
$SERIEVIEW_TEMPLATE['listing']['end'] = ''; 
