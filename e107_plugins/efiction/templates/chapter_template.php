<?php

$CHAPTER_TEMPLATE['default']['item'] = 
' 
<div class="row mb-4"> 
<article class=" post col-md-12">
    <div class="card">
        
          <div class="card-header">
            <h3 class="post-title"><a href="{CHAPTER_LINK}" class="transicion">{CHAPTER_NUMBER}. {CHAPTER_TITLE}</a></h3>
                      <p class="storysubinfo">
            <a href="{AUTHOR_URL}">{AUTHOR_NAME}</a> | {CHAPTER_TIME} | {CHAPTER_PRINTICON}
 
              | {STORY_TITLE}
 
          </p>
          </div>
          <div class="card-body ">
            <div class="row">
                <div class="col-sm-6">
                    <img src="{STORY_IMAGE}" class="img-post img-fluid img-responsive" alt="{STORY_TITLE}">
                </div>
                <div class="col-sm-6 post-content">
                    {CHAPTER_NOTES} 
                    <hr>
                    {STORY_SUMMARY}
                    <hr>
                    {STORY_STORYNOTES}              
                </div>
            </div>
            </div>
       
         
    </div>
</article>
 </div>
';



?>