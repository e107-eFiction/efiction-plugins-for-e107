<?php
 
$blocks = eFiction::blocks();

global $numupdated;
include("blocks/".$blocks['news']['file']);
 
		if(!isset($blocks['news']['sumlength'])) $blocks['news']['sumlength'] = "";
		$output .= "
		<div class='panel panel-primary'>
			<div class='panel-heading text-center bg-primary'>".LAN_EFICTION_CURRENT.':</div>
			<div class="panel-body tblborder text-left">'.$content.'</div>
		</div>';
 
        
		$output .= "<div><div id='settingsform'><form method=\"POST\" enctype=\"multipart/form-data\" action=\"admin.php?action=blocks&admin=news\">
			<div><label for=\"num\">"._NUMNEWS.":</label><input type=\"text\" class=\"textbox\" name=\"num\" id=\"num\" size=\"4\" value=\"".$blocks['news']['num']."\"></div>
		<div><label for=\"num\">"._SUMLENGTH.":</label><input type=\"text\" class=\"textbox\" name=\"sumlength\" id=\"sumlength\" size=\"6\" value=\"".$blocks['news']['sumlength']."\"></div>
			<INPUT type=\"submit\" name=\"submit\" class=\"button\" id=\"submit\" value=\""._SUBMIT."\"></form></div><div style='clear: both;'></div></div>";
 