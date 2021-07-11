<?php

if (!defined('e107_INIT')) {
    exit;
}

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

/* full replacement
<div class="listbox {SERIE_VIEW_ODDEVEN}">
<div class="title"><span class="h3">{SERIE_TITLE_LINK}</span> by {SERIE_AUTHOR}{SERIE_SCORE} [{SERIE_REVIEWS}  - {SERIE_NUMREVIEWS}]</div>
<div class="content"><span class="label">Summary: </span>{SERIE_SUMMARY: limit=400}<br />
<span class="label">Parent Series:</span> {SERIE_PARENTSERIES}<br />
<span class="label">Categories:</span> {SERIE_CATEGORY}<br />
 <span class="label">Characters: </span>{SERIE_CHARACTERS}<br />
{SERIE_CLASSIFICATIONS} 
<span class="label">Stories:</span> {SERIE_NUMSTORIES}<br />
<span class="label">Open:</span>{SERIE_OPEN} {SERIE_ADDTOFAVES} {SERIE_VIEW_REPORTTHIS}
{SERIE_ADMINOPTIONS}</div>
</div>
{SERIE_COMMENT}

*/

$SERIES_TEMPLATE['listing']['caption'] = '';
$SERIES_TEMPLATE['listing']['start'] = '{SERIE_SERIESHEADER}';  //like subtitle
$SERIES_TEMPLATE['listing']['item'] =
'{SETIMAGE: w=700&h=250&crop=1}
<div class="row mb-4 mr-3">
<div class="col-md-12 mb-4">
	<div class="card  mb-3 text-center hoverable">
		<div class="card-body">
			<div class="row">
				<div class="col-md-5 mx-3 my-3">
					<!-- Featured image -->
					<div class="view overlay rgba-white-slight">
						{SERIE_IMAGE}
						<a>
						<div class="mask waves-effect waves-light"></div>
						</a>
					</div>
				</div>
				<div class="col-md-6 text-left ml-xl-3 ml-lg-0 ml-md-3 mt-3">
					<h4 class="mb-4">
						<strong>{SERIE_TITLE}</strong>
					</h4>
					<p> {SERIE_SUMMARY: limit=200}</p>
					<a href="{SERIE_LINK}" class="btn btn-indigo btn-sm waves-effect waves-light">{LAN=LAN_MORE}</a>
				</div>
			</div>
		</div>
	</div>
<!-- News card -->
</div>
</div>
';
$SERIES_TEMPLATE['listing']['end'] = '';


/* series_title.tpl
<!-- START BLOCK : series -->
<div id="pagetitle">{pagetitle} {rating}</div>
<div id="titleinfo"> [{reviews} - {numreviews}]</div>
<div id="titleblock">
<span class="label">Summary:</span> {summary}<br />
<span class="label">Categories:</span> {category}<br />
<span class="label">Characters:</span> {characters}<br />
{classifications}
<span class="label">Parent Series:</span> {parentseries}<br />
<span class="label">Stories:</span> {numstories}<br />
<span class="label">Series Type:</span> {open}<br />
<span class="label">{adminoptions}{addtofaves}{addtoseries}<br />
</div>
<div class="jumpmenu">{jumpmenu}</div>
<!-- END BLOCK : series -->


$SERIES_TEMPLATE['titleblock']['caption'] = '';
$SERIES_TEMPLATE['titleblock']['content'] = ' 
<div id="pagetitle">{SERIE_PAGETITLE} {SERIE_RATING}</div>
<div id="titleinfo"> [{SERIE_REVIEWS} - {SERIE_NUMREVIEWS}]</div>
<div id="titleblock">
<span class="label">{LAN=_SUMMARY}:</span> {SERIE_SUMMARY: limit=full}<br />
<span class="label">{LAN=_CATEGORY}:</span> {SERIE_CATEGORY}<br />
<span class="label">{LAN=_CHARACTERS}:</span> {SERIE_CHARACTERS}<br />
{SERIE_CLASSIFICATIONS} 
<span class="label">{LAN=LAN_EFICTION_PARENTSERIES}:</span> {SERIE_PARENTSERIES}<br />
<span class="label">{LAN=_STORIES}:</span> {SERIE_NUMSTORIES}<br />
<span class="label">{LAN=_SERIESTYPE}:</span> {SERIE_OPEN}<br />
<span class="label">{SERIE_ADMINOPTIONS}{SERIE_ADDTOFAVES}{SERIE_ADDTOSERIES}{SERIE_SUBMITREVIEWS}<br />
</div>
<div class="jumpmenu">{SERIE_JUMPMENU}</div>
';
*/

$SERIES_TEMPLATE['titleblock']['caption'] = '<div id="pagetitle">{SERIE_PAGETITLE} {SERIE_RATING}</div><div id="titleinfo"> [{SERIE_REVIEWS} - {SERIE_NUMREVIEWS}]</div>';

$SERIES_TEMPLATE['titleblock']['content'] = 
'<div class="card">
<img class="card-img-top" src="{SERIE_IMAGE_SRC}" alt="Card image cap">
<div class="card-body">
<dl class="row">
  <dt class="col-sm-3"><span class="label">{LAN=_SUMMARY}:</span></dt>
  <dd class="col-sm-9">{SERIE_SUMMARY: limit=full}</dd>
  <dt class="col-sm-3"><span class="label">{LAN=_CATEGORY}:</span></dt>
  <dd class="col-sm-9">{SERIE_CATEGORY}</dd>
  <dt class="col-sm-3"><span class="label">{LAN=_CHARACTERS}:</span></dt>
  <dd class="col-sm-9">{SERIE_CHARACTERS}</dd>
  {SERIE_CLASSIFICATIONS: type=dl} 
  <dt class="col-sm-3"><span class="label">{LAN=LAN_EFICTION_PARENTSERIES}:</span></dt>
  <dd class="col-sm-9">{SERIE_PARENTSERIES}</dd>
  <dt class="col-sm-3"><span class="label">{LAN=_STORIES}:</span></dt>
  <dd class="col-sm-9">{SERIE_NUMSTORIES}</dd>
  <dt class="col-sm-3"><span class="label">{LAN=_SERIESTYPE}:</span></dt>
  <dd class="col-sm-9">{SERIE_OPEN}</dd>
</dl>
<div id="titleblock">
 
 
<span class="label">{SERIE_ADMINOPTIONS}{SERIE_ADDTOFAVES}{SERIE_ADDTOSERIES}{SERIE_SUBMITREVIEWS}<br />
</div>
<div class="jumpmenu">{SERIE_JUMPMENU}</div></div></div>';