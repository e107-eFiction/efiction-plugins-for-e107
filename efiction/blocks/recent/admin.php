<?php
 
global $numupdated;

$blocks = eFiction::blocks();

e107::includeLan(e_PLUGIN.'efiction/blocks/recent/'.e_LANGUAGE.'.php');

include(e_PLUGIN."efiction/blocks/".$blocks['recent']['file']);

$output .= "
<div class='panel panel-primary'>
	<div class='panel-heading text-center bg-primary'>".LAN_EFICTION_CURRENT.':</div>
	<div class="panel-body tblborder text-left">'.(!empty($blocks['recent']['tpl']) ? _NATPL : $content).'</div>
</div>';
 
   