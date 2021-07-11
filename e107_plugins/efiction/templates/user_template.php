<?php

if (!defined('e107_INIT')) {
    exit;
}

/*
<!-- INCLUDE BLOCK : header -->
<!-- INCLUDE BLOCK : profile -->
<div align="center">{sort}</div>
<br><br>
<!-- START BLOCK : paneltabs -->
<div {class}>{link} {count}</div>
<!-- END BLOCK : paneltabs -->

{output}
<!-- INCLUDE BLOCK : listings -->
<!-- INCLUDE BLOCK : footer -->
*/

/* 
block  {BLOCK_USER_PROFILE} 
{sort} {USER_SORT}
{class} {link} {count} {USER_PANELTABS}
{output} {USER_OUTPUT}  - output for selected tab detected by action
block  {USER_LISTINGS}
*/

$USER_TEMPLATE['user']['title'] = '';
$USER_TEMPLATE['user']['content'] = '
{BLOCK_USER_PROFILE}
{USER_PANELTABS}
{USER_OUTPUT}
 	 
';

$USER_TEMPLATE['paneltabs']['title'] = '
<div class="row">
	<div class="col-12">
		<div class="mb-3 text-center mt-2">
			<h2>{LAN=LAN_EFICTION_ACTIVITYBY}: {USER_PENNAME}</h2>
		</div>
	</div>
</div>'; 
$USER_TEMPLATE['paneltabs']['tablerender'] = 'section';  

$USER_TEMPLATE['paneltabs']['start'] = 
'<section><div class="row">';
			 
$USER_TEMPLATE['paneltabs']['item'] = '
<div class="col-xl-3 col-md-6 mb-4">   
	<a {CLASS} class="card" data-href="{LINK}" href="{LINK}">
		<div class="card-body text-center">
			<p class="card-text mb-0">{NAME}</p>
			<p class="lead text-center">{COUNT}</p>
		</div>
	</a>
</div>                            
'; 
$USER_TEMPLATE['paneltabs']['end'] = 
'</div></section>';


 
$USER_TEMPLATE['storiesby']['title'] = '
<div class="row">
	<div class="col-12">
		<div class="mb-3 text-center">
			<h2>{LAN=_STORIESBY}: {USER_PENNAME}</h2>
		</div>
	</div>
</div>'; 
$USER_TEMPLATE['storiesby']['end'] = '
<div class="row">	
  <div class="col-12">
		<div class="mb-3 text-center">
  			{STORIESBY_PAGELINKS}
		</div>
	</div>
</div>'; 
$USER_TEMPLATE['storiesby']['tablerender'] = 'section';  


$USER_TEMPLATE['seriesby']['title'] = '
<div class="row">
	<div class="col-12">
		<div class="mb-3 text-center">
			<h2>{LAN=_SERIESBY}: {USER_PENNAME}</h2>
		</div>
	</div>
</div>'; 
$USER_TEMPLATE['seriesby']['end'] = '
<div class="row">	
  <div class="col-12">
		<div class="mb-3 text-center">
  			{SERIESBY_PAGELINKS}
		</div>
	</div>
</div>'; 
$USER_TEMPLATE['seriesby']['tablerender'] = 'section'; 


$USER_TEMPLATE['reviewsby']['usertitle'] = '
<div class="row">
	<div class="col-12">
		<div class="mb-3 text-center">
			<h2>{LAN=_YOURREVIEWS}</h2>
		</div>
	</div>
</div>'; 
$USER_TEMPLATE['reviewsby']['title'] = '
<div class="row">
	<div class="col-12">
		<div class="mb-3 text-center">
			<h2>{LAN=_REVIEWSBY}: {USER_PENNAME}</h2>
		</div>
	</div>
</div>'; 
$USER_TEMPLATE['reviewsby']['start'] = '<div class="card-deck">';
$USER_TEMPLATE['reviewsby']['firstitem'] = '';
$USER_TEMPLATE['reviewsby']['end'] = '</div>';

$USER_TEMPLATE['reviewsby']['tablerender'] = 'section'; 


