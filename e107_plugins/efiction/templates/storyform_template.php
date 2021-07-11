<?php

if (!defined('e107_INIT')) { exit; }
 
$STORYFORM_WRAPPER['layout']['STORY_EDIT_CATEGORY'] = '<div class="row"><div class="col-md-12">{---}</div></div>';

$STORYFORM_WRAPPER['layout']['STORY_EDIT_AUTHOR'] = '
<div class="form-group"><label for="uid" class="col-form-label">{LAN=_AUTHOR}:</label>{---}</div>';

$STORYFORM_WRAPPER['layout']['STORY_EDIT_COAUTHORS'] = '
<div class="form-group"><label for="uid" class="col-form-label">{LAN=_COAUTHORS}:</label>{---}</div>';

$STORYFORM_TEMPLATE['story']  = '
<div class="card-columns preview mb-4">
    <div class="card"><div class="card-body">
      <div class="title"><h3>{LAN=LAN_REQUIRED_INFORMATION}</h3></div> 
      {STORY_EDIT_CATEGORY}
      <input type="hidden" name="formname" value="stories"> 
      {STORY_EDIT_AUTHOR}
      {STORY_EDIT_COAUTHORS}
      <div class="form-group"><label for="title" class="col-form-label">{LAN=_TITLE}</label>
      {STORY_EDIT_TITLE}
        </div>
      <div class="form-group"><label for="summary" class="col-form-label">{LAN=_SUMMARY}</label>
      {STORY_EDIT_SUMMARY}
      
      </div></div>
 
    </div> 
    <div class="card">
      <div class="card-body">
        <div class="form-group">{STORY_EDIT_RATING}</div>
        <div class="form-group">{STORY_EDIT_COMPLETE}</div>
        <div class="form-group">{STORY_EDIT_FEATURED}</div>
        <div class="form-group">{STORY_EDIT_VALIDATED}</div>
      {STORY_EDIT_CODEBLOCK=storyform_start}
      </div>
    </div>  
</div>
  
 
<div class="card"><div class="card-body">
  <div class="title"><h3>More information:</h3></div>
  <div class="form-group"><label for="title" class="col-form-label">{LAN=_CHARACTERS}</label>
  {STORY_EDIT_CHARACTERS}
  </div></div>
</div>
<div class="card"><div class="card-body">
    {STORY_EDIT_CLASSES}
</div></div>
 

<div class="card"><div class="card-body">
 
		<div class="form-group"><label for="title" class="col-form-label">{LAN=_STORYNOTES}</label>
			{STORY_EDIT_STORYNOTES}
		</div>    
   </div> 
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12">
	{STORY_EDIT_CODEBLOCK=storyform}
	</div>
</div>
 {STORY_BUTTON_PREVIEW}  {STORY_BUTTON_SAVE}  {STORY_BUTTON_ADD_CHAPTER} 
 {STORY_EDIT_CHAPTERS_LIST} 

'; 

$STORYFORM_TEMPLATE['chapter']  = '

 
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12">
    <div class="form-group"><label for="title" class="col-form-label">{LAN=_CHAPTERTITLE}</label>   
            {STORY_EDIT_CHAPTERTITLE}
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 bg-danger">
    <div class="form-group"><label for="storytext" class="col-form-label text-white">{LAN=_STORYTEXTTEXT}</label>   
            {STORY_EDIT_STORYTEXT}
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12">
    <div class="form-group"><label for="endnotes" class="col-form-label">{LAN=_CHAPTERNOTES}</label>   
            {STORY_EDIT_CHAPTERNOTES}
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12">
 {STORY_BUTTON_PREVIEW}  {STORY_BUTTON_SAVE}    
  </div>
</div> 
';



$STORYFORM_TEMPLATE['chapter_list']['start']  = '<table class="table table table-bordered table-striped">
    <thead>
        <tr>
            <th>{LAN=_CHAPTER}</th>
            <th>{LAN=_MOVE}</th>
            <th>{LAN=_OPTIONS}</th>
        </tr>
    </thead>
    <tbody>';
$STORYFORM_TEMPLATE['chapter_list']['item']  = 
'<tr>
    <td><a href="{CHAPTER_VIEW_LINK}">{CHAPTER_VIEW_TITLE}</a></td><td>{CHAPTER_REORDER}</td><td>{CHAPTER_EDIT_BUTTON} {CHAPTER_DELETE_BUTTON}</td></tr>';

$STORYFORM_TEMPLATE['chapter_list']['end']  = '</tbody></table>';