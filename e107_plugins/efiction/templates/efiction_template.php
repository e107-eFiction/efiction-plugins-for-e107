<?php

if (!defined('e107_INIT')) { exit; }

//like  defaults/index.tpl
$EFICTION_TEMPLATE['index']['caption'] = ''; 
$EFICTION_TEMPLATE['index']['start'] = '';
$EFICTION_TEMPLATE['index']['body'] = 
'
<div id="leftindex">
      <div class="block">
       <div class="title">{BLOCK_CAPTION=info}</div>
       <div class="content">{EFICTION_MESSAGES: key=welcome}{EFICTION_BLOCK_CONTENT: key=info}<br>{EFICTION_BLOCK_CONTENT: key=login}</div>
     </div>
     <div class="block">
       <div class="title">{EFICTION_BLOCK_CAPTION: key=random}</div>
       <div class="content">{EFICTION_BLOCK_CONTENT: key=random}</div>
     </div>
</div>
<div id="rightindex">
     <div class="block">
       <div class="title">{EFICTION_BLOCK_CAPTION: key=categories}</div>
       <div class="content">{EFICTION_BLOCK_CONTENT: key=categories}</div>
     </div>
     <div class="block">
       <div class="title">{EFICTION_BLOCK_CAPTION: key=recent}</div>
       <div class="content">{EFICTION_BLOCK_CONTENT: key=recent}</div>
     </div>
     <div class="block">
       <div class="title">{EFICTION_BLOCK_CAPTION: key=news}</div>
       <div class="content">{EFICTION_BLOCK_CONTENT: key=news}</div>
    </div>
</div>
';  
$EFICTION_TEMPLATE['index']['end'] = '';



$EFICTION_TEMPLATE['toplists']['start']  = "<div class='tblborder' id='top10list' style='margin: 0 25%;'>";
$EFICTION_TEMPLATE['toplists']['item']  = "<a href='toplists.php?list={panel_name}'>{panel_title}</a><br />";
$EFICTION_TEMPLATE['toplists']['end']  = '</div>';


$EFICTION_TEMPLATE['favcomment']['favst']  = 
'<div class="comment{oddeven}">
	<div class="comments"><span class="label">'._COMMENTS.': </span></div> 
			{comment}
			{commentoptions}
</div>';
 
$EFICTION_TEMPLATE['favcomment']['favse']  = 
'<div class="card">
	<div class="card-body">
		<div class="comment{oddeven}">
			{comment}
			{commentoptions}
		</div>
	</div>
</div>'; 
 
 
$EFICTION_TEMPLATE['favcomment']['favau']  = 
'<div class="card">
	<div class="card-body">
		<span class="label">{number}</span> <a href="viewuser.php?uid="{uid}">{penname}</a><br />
		<div class="comment{oddeven}">
			{comment}
			{commentoptions}
		</div>
	</div>
</div>';

$EFICTION_TEMPLATE['favcomment']['favst']  = 
'<div class="comment{oddeven}">
	<div class="comments"><span class="label">'._COMMENTS.': </span></div> 
			{comment}
			{commentoptions}
</div>';
 
$EFICTION_TEMPLATE['favcomment']['favse']  = 
'<div class="card">
	<div class="card-body">
		<div class="comment{oddeven}">
			{comment}
			{commentoptions}
		</div>
	</div>
</div>'; 