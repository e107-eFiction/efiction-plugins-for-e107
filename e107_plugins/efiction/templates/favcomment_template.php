<?php

if (!defined('e107_INIT')) {
    exit;
}

/* original 
<!-- START BLOCK : comment -->
<div class="comment{oddeven}">
{comment}
{commentoptions}
</div>
<!-- END BLOCK : comment -->
*/

$FAVCOMMENT_TEMPLATE['default']['start'] = '';
$FAVCOMMENT_TEMPLATE['default']['item'] = '
<span class="label">{x}</span> {autorlink}<br />
<div class="comment{oddeven}">
{comment}
{commentoptions}
</div>';
$FAVCOMMENT_TEMPLATE['default']['end'] = '';
 
 							 
$FAVCOMMENT_TEMPLATE['favau']   =   $FAVCOMMENT_TEMPLATE['default'];   

$FAVCOMMENT_TEMPLATE['favau']['item'] = '

<div class="border-bottom border-separator-light mb-2 pb-2">
                            <div class="row g-0 sh-6">
                              <div class="col-auto">
                                <img src="{avatar}" class="card-img rounded-xl sh-6 sw-6" alt="{author}" />
                              </div>
                              <div class="col">
                                <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                                  <div class="d-flex flex-column">
                                    <div>{authorlink}</div>
                                    <div class="text-small text-muted">{comment}</div>
                                  </div>
                                  <div class="d-flex">
                                   
                                       {commentoptions_alt}
                                    
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
 ';
 
/*


*/ 
                 
$FAVCOMMENT_TEMPLATE['favst']['item'] = '

<div class="border-bottom border-separator-light mb-2 pb-2">
                            <div class="row g-0 sh-6">
                              <div class="col-auto">
                                <img src="{avatar}" class="card-img rounded-xl sh-6 sw-6" alt="{author}" />
                              </div>
                              <div class="col">
                                <div class="card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between">
                                  <div class="d-flex flex-column">
                                    <div>{authorlink}</div>
                                    <div class="text-small text-muted">{comment}</div>
                                  </div>
                                  <div class="d-flex">
                                   
                                       {commentoptions_alt}
                                    
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
 ';                             