<!-- START BLOCK : listings -->
{seriesheader}
<!-- START BLOCK : seriesblock -->
<div class="block-center card-center border rounded p-3 mb-3 mt-6 card border-primary listbox {oddeven}"> 
	<div class="card-header-center rounded text-center">
		<h2 class="card-header-title text-white py-3">{title} by {author}</h2>	 
	</div> 
	<div class="card-body">
		<div class="title">{title} by {author}{score} [{reviews} - {numreviews}]</div>
		<div class="content"><span class="label">Summary: </span>{summary}<br />
			<span class="label">Parent Series:</span> {parentseries}<br />
			<span class="label">Categories:</span> {category}<br />
			<span class="label">Characters: </span>{characters}<br />
			{classifications}
			<span class="label">Stories:</span> {numstories}<br />
			<span class="label">Open:</span> {open} {addtofaves} {reportthis}
			{adminoptions}
		</div>
	</div>
	{comment}
</div>
<!-- END BLOCK : seriesblock -->
 
<!-- START BLOCK : storyblock -->
<div class="block-center card-center border rounded p-3 mb-3 mt-6 card border-primary listbox {oddeven}"> 
	<div class="card-header-center rounded text-center">
		<h2 class="card-header-title text-white py-3">{title} by {author}</h2>	 
	</div> 
    <div class="card-body">
    	<div class="title">{title} by {author} <span class="label">Rated:</span> {rating} {roundrobin} {score} [{reviews} - {numreviews}] {new} </div>
    	<div class="content"><span class="label">Summary: </span>{featuredstory}{summary}<br />
    		<span class="label">Categories:</span> {category} <br />
    		<span class="label">Characters: </span> {characters}<br />
    		{classifications}
    		<span class="label">Series:</span> {serieslinks}<br />
    		<span class="label">Chapters: </span> {numchapters} {toc}<br />
    		<span class="label">Completed:</span> {completed}  
    		<span class="label">Word count:</span> {wordcount} <span class="label">Read Count:</span> {count}
    		{adminlinks}
    	</div>
  	     <div class="tail"><span class="label">{addtofaves} {reportthis} Published: </span>{published} <span class="label">Updated:</span> {updated}</div>
        {comment}
    </div>
</div>
<!-- END BLOCK : storyblock -->
{pagelinks}
<!-- END BLOCK : listings -->