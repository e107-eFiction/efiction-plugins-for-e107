<!-- START BLOCK : listings -->
{seriesheader}
<!-- START BLOCK : seriesblock -->
 
<div class="card mt-4 listbox {oddeven}">
{seriesimage} 
<div class="card-header text-dark bg-info mb-3 text-center"><div class="title">{title} [Admin: {author}] {score} [{reviews} - {numreviews}]</div>

</div>

<div class="card-body content"><span class="label">Summary: </span>{summary}<br />
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
<div class="card mt-4 listbox {oddeven}">
<div class="card-header text-dark mb-3 text-center"><div class="title">{title} by {author} <span class="label">Rated:</span> {rating} {roundrobin} {score} [{reviews} - {numreviews}] {new} </div></div>
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