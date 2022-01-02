
<?php

$EFICTION_SERIES_TEMPLATE['default']['item'] = '
<div class="row mb-4">  
    <article class=" post col-md-12">    
        <div class="card">                  
            <div class="card-header">            
                <h3 class="post-title"><a href="{SERIE_LINK}" class="transicion">{TITLE}</a></h3>                      
                <p class="storysubinfo">{LAN=_SERIE_MANAGER}: {AUTHOR} | {RATING} | {REVIEWS} - {NUMREVIEWS}</p>          
            </div>          
            <div class="card-body ">            
                <div class="row">                
                    <div class="col-sm-6">{IMAGE}</div>                
                    <div class="col-sm-6 post-content">            
                        <span class="label">{LAN=_SUMMARY}:
                        </span> {SUMMARY}<br />            
                        <hr>  			
                        <span class="label">{LAN=_CATEGORIES}:
                        </span> {CATEGORY}<br />			
                        <span class="label">{LAN=_CHARACTERS}:
                        </span> {CHARACTERS}<br />			{CLASSIFICATIONS} 			
                        <span class="label">{LAN=_STORIESNUMBER}:
                        </span> {NUMSTORIES}<br />			
                        <span class="label">{LAN=_SERIES_TYPE}:
                        </span> {OPEN}<br />                            
                    </div>            
                </div>            
            </div>
            <div class="card-footer">{ADMINOPTIONS}{ADDTOFAVES}{ADDCOMMENT}</div>    
        </div>
    </article> 
</div>
';
$EFICTION_SERIES_TEMPLATE['default']['end'] = "{PAGINATIONS}";

$EFICTION_SERIES_TEMPLATE['default_item'] = $EFICTION_SERIES_TEMPLATE['default']['item']; 

$EFICTION_SERIES_WRAPPER['default_item']['PARENTSERIES'] = '<span class="label">{LAN=_PARENT_SERIES}:</span> {---}<br />';

$EFICTION_SERIES_TEMPLATE['default_item'] = $EFICTION_SERIES_TEMPLATE['default_item'];
 
$EFICTION_SERIES_TEMPLATE['story']['item'] = 
'
<div class="row mb-4"> 
<article class=" post col-md-12">
    <div class="card">       
          <div class="card-header">
		  		<h3 class="post-title card-title fs-3">{LAN=_STORY} : {STORY_FEATUREDSTORY} {STORY_TITLE_LINK}{STORY_NEW} </h3>  
                <p class="storysubinfo">
            	{LAN=_AUTHOR}: {STORY_AUTHOR_LINK} | {LAN=_PUBLISHED}: {STORY_PUBLISHED}  | {LAN=_UPDATED}: {STORY_UPDATED} |  {LAN=_COMPLETED}: {STORY_COMPLETED} | {LAN=_WORDCOUNT}: {STORY_WORDCOUNT} 
          </p>
          </div>
          <div class="card-body ">
            <div class="row">
                <div class="col-sm-6">
                    <img src="{STORY_IMAGE}" class="img-post img-fluid img-responsive" alt="{STORY_TITLE}">
                </div>
                <div class="col-sm-6 post-content">
					{STORY_SUMMARY}
                    <hr>        
					<dl class="row">          
					<dt class="col-5">{LAN=_CATEGORIES}     
					</dt>       
					<dd class="col-7">{STORY_CATEGORY}      
					</dd>       
					<dt class="col-5">{LAN=_NUMCHAPTERS}     
					</dt>       
					<dd class="col-7"><strong>{STORY_NUMCHAPTERS}</strong>[{STORY_TOC}]     
					</dd>       
					<dt class="col-5">{LAN=_RATING}     
					</dt>       
					<dd class="col-7">{STORY_RATING_NAME}     
					</dd>       
					<dt class="col-5">{LAN=_HITS}      
					</dt>       
					<dd class="col-7">{STORY_COUNT}    
					</dd>               
				</dl>                
                </div>
            </div>
            </div>

    </div>
</article>
 </div>
 
';

