<!-- START BLOCK : series -->
<div class="card mb-3 serie_title">
    <div class="card-header text-white bg-info text-center">
		<div id="pagetitle">{pagetitle} {rating} </div>
		<div id="titleinfo"> [{reviews} - {numreviews}]</div>
	</div>
	<div class="card-body">
		<div id="titleblock">
			<span class="label">Summary:</span> {summary}<br />
			<span class="label">Categories:</span> {category}<br />
			<span class="label">Characters:</span> {characters}<br />
			{classifications}
			<span class="label">Parent Series:</span> {parentseries}<br />
			<span class="label">Stories:</span> {numstories}<br />
			<span class="label">Series Type:</span> {open}<br />
		</div>
	</div>
	<div class="card-footer">
		<span class="label">{adminoptions}{addtofaves}{addtoseries}<br />
		<div class="jumpmenu">{jumpmenu}</div>
	</div>
</div>
<!-- END BLOCK : series -->