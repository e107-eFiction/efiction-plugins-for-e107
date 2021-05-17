<?php

if (!defined('e107_INIT')) {
    exit;
}

/* Original 
<!-- START BLOCK : reviewsblock -->
<div class="listbox">
<div class="content{oddeven}">
<span class="label">Reviewer: </span>{reviewer} <span class="label">{member}</span> {rating} {reportthis}<br />
<span class="label">Date: </span>{reviewdate}
<span class="label">Title: </span>{chapter}
<p>{review}</p>
{adminoptions}
</div>
</div>
<!-- END BLOCK : reviewsblock -->
*/
/*
{REVIEW_ODDEVEN}
{REVIEW_REVIEWER}
{REVIEW_MEMBER}
{REVIEW_RATING}
{REVIEW_REPORTTHIS}
{REVIEW_REVIEWDATE}
{REVIEW_CHAPTER}
{REVIEW_C}
{REVIEW_ADMINOPTIONS}
*/
/* example of custom template 
 
$REVIEW_TEMPLATE['review']['item'] = 
'
{REVIEW_LISTING}
<div class="listbox">
<div class="content {REVIEW_ODDEVEN}">
<span class="label">Reviewer: </span>{REVIEW_REVIEWER} <span class="label">{REVIEW_MEMBER}</span> {REVIEW_RATING} {REVIEW_REPORTTHIS}<br />
<span class="label">Date: </span>{REVIEW_REVIEWDATE}
<span class="label">Title: </span>{REVIEW_CHAPTER}
<p>{REVIEW_REVIEW}</p>
{REVIEW_ADMINOPTIONS}
</div>
</div>';
 */

$REVIEW_TEMPLATE['reviewblock']['start'] = '
 
<div class="row"><div class="col-12"><div class="card-columns">';
$REVIEW_TEMPLATE['reviewblock']['end'] = '</div></div></div>';
 
$REVIEW_TEMPLATE['reviewblock']['item'] = 
'
<div class="card {REVIEW_ODDEVEN}">
    {SETIMAGE: w=0&h=0}
	{SERIES_IMAGE: class=card-img-top&placeholder=true}
	<div class="card-body">
		<h4 class="card-title">{LAN=_TITLE}: {REVIEW_CHAPTER} </h4> 
 
		<span class="label">Reviewer: </span>{REVIEW_REVIEWER} <span class="label">{REVIEW_MEMBER}</span> {REVIEW_RATING} {REVIEW_REPORTTHIS}<br />
		<span class="label">Date: </span>{REVIEW_REVIEWDATE}
		<p class="card-text">{REVIEW_REVIEW}</p>
		{REVIEW_ADMINOPTIONS}
	</div>
</div>';

 
$REVIEW_TEMPLATE['seriesblock']['item'] = 
'{SETIMAGE: w=700&h=250&crop=1}
<div class="row mb-4 mr-3">
	<div class="col-md-12 mb-4">
		<div class="card  mb-3 text-center hoverable">
			<div class="card-body">
				<div class="row">
					<div class="col-md-5 mx-3 my-3">
						<!-- Featured image -->
						<div class="view overlay rgba-white-slight">
							{SERIES_IMAGE}
							<a>
							<div class="mask waves-effect waves-light"></div>
							</a>
						</div>
					</div>
					<div class="col-md-6 text-left ml-xl-3 ml-lg-0 ml-md-3 mt-3">
						<h4 class="mb-4">
							<strong>{SERIES_TITLE}</strong>
						</h4>
						<p> {SERIES_SUMMARY: limit=200}</p>
						<a href="{SERIES_LINK}" class="btn btn-indigo btn-sm waves-effect waves-light">{LAN=LAN_MORE}</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>';
 
$REVIEW_TEMPLATE['storyblock']['item'] = 
'{SETIMAGE: w=700&h=250&crop=1}
<div class="row mb-4 mr-3">
<div class="col-md-12 mb-4">
	<div class="card  mb-3 text-center hoverable">
		<div class="card-body">
			<div class="row">
				<div class="col-md-5 mx-3 my-3">
					<!-- Featured image -->
					<div class="view overlay rgba-white-slight">
						{STORY_IMAGE}
						<a>
						<div class="mask waves-effect waves-light"></div>
						</a>
					</div>
				</div>
				<div class="col-md-6 text-left ml-xl-3 ml-lg-0 ml-md-3 mt-3">
					<h4 class="mb-4">
						<strong>{STORY_TITLE}</strong>
					</h4>
					<p>{STORY_SUMMARY: limit=200}</p>
					<a href="{STORY_LINK}" class="btn btn-indigo btn-sm waves-effect waves-light">{LAN=LAN_MORE}</a>
				</div>
			</div>
		</div>
	</div>
<!-- News card -->
</div>
</div>';