
<?php
$EFICTION_SERIES_WRAPPER['series_title']['PARENTSERIES'] = '<span class="label">{LAN=_PARENT_SERIES}:</span> {---}<br />';

$EFICTION_SERIES_TEMPLATE['series_title'] = '
<!-- START BLOCK : series -->
<div class="card mb-3 serie_title">
    {IMAGE}
    <div class="card-header text-white bg-info text-center">
		<div id="pagetitle">{TITLE} [{LAN=_SERIE_MANAGER}: {AUTHOR}] {RATING} </div>
		<div id="titleinfo"> [{REVIEWS} - {NUMREVIEWS}]</div>
	</div>
	<div class="card-body">
		<div id="titleblock">
			<span class="label">{LAN=_SUMMARY}:</span> {SUMMARY}<br />
			<span class="label">{LAN=_CATEGORIES}:</span> {CATEGORY}<br />
			<span class="label">{LAN=_CHARACTERS}:</span> {CHARACTERS}<br />
			{CLASSIFICATIONS}
			<span class="label">{LAN=_STORIESNUMBER}:</span> {NUMSTORIES}<br />
			<span class="label">{LAN=_SERIES_TYPE}:</span> {OPEN}<br />
		</div>
	</div>
	<div class="card-footer">
		<span class="label">{ADMINOPTIONS}{ADDTOFAVES}<br />
		<div class="jumpmenu">{JUMPMENU}</div>
	</div>
</div>
<!-- END BLOCK : series -->
';


$EFICTION_SERIES_TEMPLATE['subseries_title'] = '
<!-- START BLOCK : series -->
<div class="card mb-3 serie_title">
    {SERIESIMAGE}
    <div class="card-header text-white bg-secondary text-center">
		<div id="pagetitle">{TITLE} [{LAN=_SERIE_MANAGER}: {AUTHOR}] {RATING} </div>
		<div id="titleinfo"> [{REVIEWS} - {NUMREVIEWS}]</div>
	</div>
	<div class="card-body">
		<div id="titleblock">
			<span class="label">{LAN=_SUMMARY}:</span> {SUMMARY}<br />
			<span class="label">{LAN=_CATEGORIES}:</span> {CATEGORY}<br />
			<span class="label">{LAN=_CHARACTERS}:</span> {CHARACTERS}<br />
			{CLASSIFICATIONS}
			{PARENTSERIES}
			<span class="label">{LAN=_STORIESNUMBER}:</span> {NUMSTORIES}<br />
			<span class="label">{LAN=_SERIES_TYPE}:</span> {OPEN}<br />
		</div>
	</div>
	<div class="card-footer">
		<span class="label">{ADMINOPTIONS}{ADDTOFAVES}<br />
		<div class="jumpmenu">{JUMPMENU}</div>
	</div>
</div>
<!-- END BLOCK : series -->
';


// INDVIDUAL RECIPE LAYOUT 
$EFICTION_SERIES_TEMPLATE['viewseries_layout'] = '
<div class="row">
	<div class="col-md-12">
		{---SERIE-HEADER---}

	</div> <!-- col-md-12 -->
</div> <!-- row -->
<div class="row">
    <div class="col-md-12">
		{---SUBSERIES---}
		{---STORIES-IN-SERIE---}

        {SETSTYLE=cookbook_comments}
         
        {SETSTYLE=default}
    </div>
</div>
<div class="row">
    <div class="col-md-12">  
   
        {COOKBOOK_RELATED}
        {SETSTYLE=default}
    </div>
</div>
';