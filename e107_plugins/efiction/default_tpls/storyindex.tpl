<section class="scroll-section" id="title">
	<div class="page-title-container">
	<h1 class="mb-0 pb-0 display-4">{title} by {author}</h1>	
	</div>
</section>
 <div class="card shadow-lg mb-5 storyinfo"><div class="card-body">
<div id="sort">  {reviews} - {numreviews}  {score}{printicon} - {featuredstory} {addtofaves}{adminlinks}</div>
</div></div>

<div id="output">
	<div class="jumpmenu">{jumpmenu}</div>
	<div class="listbox">
		<div class="card shadow-lg mb-5 storyinfo"><div class="card-body">
			<span class="label">Summary: </span>{summary}
		</div></div>
		<div class="card shadow-lg mb-5 storyinfo"><div class="card-body">
			<span class="label">Rated:</span> {rating}<br />
			<span class="label">Categories:</span> {category} <span class="label">Characters: </span> {characters}<br />
			{classifications}
			<span class="label">Challenges:</span> {challengelinks}<br /> <span class="label">Series:</span> {serieslinks}<br />
			<span class="label">Chapters: </span> {numchapters} <span class="label">Completed:</span> {completed} <br /> 
			<span class="label">Word count:</span> {wordcount} <span class="label">Read:</span> {count}<br />
			<span class="label"> Published: </span>{published} <span class="label">Updated:</span> {updated} </div>
		</div></div>
 
		<!-- START BLOCK : storynotes -->
		<div class="card shadow-lg mb-5 storyinfo"><div class="card-body">
            <span class='label'>Story Notes:</span> <div class='noteinfo'>{storynotes}</div>
		     
		</div></div>
		<!-- END BLOCK : storynotes -->

		<!-- START BLOCK : storyindexblock -->
		<div class="card shadow-lg mb-5 storyinfo"><div class="card-body">
			<p><b>{chapternumber}. {title} </b>by {author} [{reviews} - {numreviews}] {ratingpics} ({wordcount} words)<br />
			{chapternotes}{adminoptions}</p>
			</div></div>
		<!-- END BLOCK : storyindexblock -->
		<div class="card shadow-lg mb-5 storyinfo"><div class="card-body">
		{storyend}{last_read}
		</div></div>
		<div id="pagelinks"><div class="jumpmenu">{jumpmenu2}</div>
	</div>
	<div class="respond">{roundrobin}</div>
	{reviewform}
</div>
<!-- INCLUDE BLOCK : footer -->
