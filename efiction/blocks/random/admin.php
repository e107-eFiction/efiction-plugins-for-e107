 
<?php
 
$blocks = eFiction::blocks();
 
include(e_PLUGIN."efiction/blocks/".$blocks['random']['file']);

$output .= "
<div class='panel panel-primary'>
	<div class='panel-heading text-center bg-primary'>".LAN_EFICTION_CURRENT.':</div>
	<div class="panel-body tblborder text-left">'.(!empty($blocks['recent']['tpl']) ? LAN_EFICTION_NATPL : $content).'</div>
</div>';
 
 