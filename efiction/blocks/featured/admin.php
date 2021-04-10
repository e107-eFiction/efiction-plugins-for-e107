<?php
$blocks = eFiction::blocks();
e107::includeLan(e_PLUGIN.'efiction/blocks/featured/'.e_LANGUAGE.'.php');

include(e_PLUGIN."efiction/blocks/".$blocks['featured']['file']);

$output .= "
<div class='panel panel-primary'>
	<div class='panel-heading text-center bg-primary'>".LAN_EFICTION_CURRENT.':</div>
	<div class="panel-body tblborder text-left">'.($use_tpl ? LAN_EFICTION_NATPL : $content).'</div>
</div>';
 
	 
