<?php

if (!defined('e107_INIT')) { exit; }

 
$SEARCHFORM_TEMPLATE['default']['form']  =' 

<section class="uix-spacing--s">
  <div class="container">
    {SEARCHFORM_SORTBEGIN}
    <div class="row">
  
        {SEARCHFORM_CATEGORYMENU}
        {SEARCHFORM_CHARACTERMENU1} {SEARCHFORM_CHARACTERMENU2} {SEARCHFORM_PAIRINGSMENU} {SEARCHFORM_RATINGMENU} 
        {SEARCHFORM_CLASSMENU} 
        {SEARCHFORM_SORTMENU} 
        {SEARCHFORM_COMPLETEMENU} 
        {SEARCHFORM_SORTEND}
    																
    </div>
  </div>
</section>'; 
 

$SEARCHFORM_TEMPLATE['default']['wrap_start'] = '<div class="col-md-4">
<div class="uix-controls uix-controls--line uix-controls__select is-fullwidth">
 <label>';
$SEARCHFORM_TEMPLATE['default']['wrap_end'] = '</label></div></div>'; 

$SEARCHFORM_WRAPPER['default']['SEARCHFORM_CATEGORYMENU'] =  '<div class="col-md-3">{---}</div>'; 

$SEARCHFORM_WRAPPER['default']['SEARCHFORM_CHARACTERMENU1'] =  '<div class="col-md-3">{---}</div>'; 
 
$SEARCHFORM_WRAPPER['default']['SEARCHFORM_CHARACTERMENU2'] =  '<div class="col-md-3">{---}</div>'; 
 
$SEARCHFORM_WRAPPER['default']['SEARCHFORM_PAIRINGSMENU'] =  '<div class="col-md-3">{---}</div>'; 
 
$SEARCHFORM_WRAPPER['default']['SEARCHFORM_RATINGMENU'] =  '<div class="col-md-3">{---}</div>'; 
 
$SEARCHFORM_WRAPPER['default']['SEARCHFORM_SORTMENU'] =  '<div class="col-md-3">{---}</div>'; 
 
$SEARCHFORM_WRAPPER['default']['SEARCHFORM_COMPLETEMENU'] =  '<div class="col-md-3">{---}</div>'; 
 
 
 