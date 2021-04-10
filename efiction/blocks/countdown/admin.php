<?php

$blocks = eFiction::blocks();
e107::includeLan(e_PLUGIN.'efiction/blocks/countdown/'.e_LANGUAGE.'.php');

include(e_PLUGIN."efiction/blocks/".$blocks['countdown']['file']); 
 
$output .= "
<div class='panel panel-primary'>
	<div class='panel-heading text-center bg-primary'>".LAN_EFICTION_CURRENT.':</div>
	<div class="panel-body tblborder text-left">'.$content.'</div>
</div>';

$output .= "
<div class='panel panel-primary'> 
	<div class='panel-body text-left'>
	 	<div class='row form-group'> 
		 	<label class='control-label col-md-2' for=\"target\">"._TARGETDATE.':</label>
			<div class="col-sm-10">
				<input type="text" class="form-controlinput-block-level  textbox" name="block_variables[\'target\']" id="target" value="'.(!empty($blocks['countdown']['target']) ? $blocks['countdown']['target'] : date('m/d/Y G:H')).'">
			</div>
		</div>
		<div  class="row form-group">
			<label  class="control-label col-md-2" for="CDformat">'._FORMATCOUNT.':</label>
			<div class="col-sm-10">
				<input type="text" class="form-control input-block-level textbox" name="block_variables[\'CDformat\']" id="CDformat" size="40" value="'.(empty($blocks['countdown']['CDformat']) ? _COUNTDOWNFORMAT : $blocks['countdown']['CDformat']).'">
			</div>
		</div>
		<div class="row form-group">
			<label class="control-label col-md-2"  for="finish">'._FINISHMESSAGE.':</label>
			<div class="col-sm-10">
				<input type="text" class="form-control input-block-level textbox" name="block_variables[\'finish\']" id="finish" size="40" value="'.(empty($blocks['countdown']['finish']) ? _COUNTDOWNOVER : $blocks['countdown']['finish'])."\"> 
			</div>
		</div>
	</div>
</div>
<div class='well'>"._DATENOTE."</div>";

 