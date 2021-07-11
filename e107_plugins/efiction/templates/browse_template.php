<?php

if (!defined('e107_INIT')) { exit; }


$BROWSE_TEMPLATE['index']['caption'] = '{BROWSE_CAPTION}'; 
$BROWSE_TEMPLATE['index']['start'] = '';
$BROWSE_TEMPLATE['index']['body'] = 
'
<div class="row my-3">   
    <div class="col-md-12">	 
		{BROWSE_OUTPUT} 
    </div>
</div>
';  
$BROWSE_TEMPLATE['index']['end'] = '';
$BROWSE_TEMPLATE['index']['tablerender'] = 'browse'; 
 
$BROWSE_TEMPLATE['categories'] = $BROWSE_TEMPLATE['index'];  
$BROWSE_TEMPLATE['ratings'] = $BROWSE_TEMPLATE['index']; 
$BROWSE_TEMPLATE['original_authors'] = $BROWSE_TEMPLATE['index'];
$BROWSE_TEMPLATE['original_titles'] = $BROWSE_TEMPLATE['index'];
$BROWSE_TEMPLATE['titles'] = $BROWSE_TEMPLATE['index'];
$BROWSE_TEMPLATE['recent'] = $BROWSE_TEMPLATE['index'];
$BROWSE_TEMPLATE['home'] = $BROWSE_TEMPLATE['index'];
 
// search in sidebar 
// $BROWSE_WRAPPER['series']['BROWSE_SEARCHFORM'] = '<div class="col-md-4">{---}</div>';
 
$BROWSE_TEMPLATE['series']['caption'] = ''; 
$BROWSE_TEMPLATE['series']['start'] = '';
$BROWSE_TEMPLATE['series']['body'] = 
'
<div class="row my-3">      
    <div class="col-md-12">
        {BROWSE_SEARCHFORM} 
		{BROWSE_ALPHALINKS}
		{BROWSE_OUTPUT}
        {BROWSE_OTHERRESULTS}
		{BROWSE_SERIESBLOCK}
        {BROWSE_PAGELINKS}
    </div>
</div>
';  
$BROWSE_TEMPLATE['series']['end'] = ''; 
  
$BROWSE_TEMPLATE['characters'] = $BROWSE_TEMPLATE['series']; 