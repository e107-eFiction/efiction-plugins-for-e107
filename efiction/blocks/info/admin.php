<?php
$blocks = eFiction::blocks(); 
 
e107::includeLan(e_PLUGIN.'efiction/blocks/info/'.e_LANGUAGE.'.php');

 require e_PLUGIN."efiction/blocks/".$blocks['info']['file'] ;

 
		$style = isset($blocks['info']['style']) ? $blocks['info']['style'] : 0;
        
		if(empty($blocks['info']['template']) && $style == 1) $template = _NARTEXT;
		else if($style == 1) $template = $blocks['info']['template'];
		else $template = "";
		
        $output .= "<div style='margin: 1em auto; width: 80%;'><b>".LAN_EFICTION_CURRENT.":</b><br /><div class=\"tblborder\" style=\"text-align: left; padding: 4px; margin: 0 auto;\">$content</div><br />";
		$output .= " 
			<label for='template'>".LAN_EFICTION_TEMPLATE.":</label><br /><textarea name=block_variables[\"template\"] rows='5' cols='50' style='width: 100%;'>$template</textarea>";
		 
		$output .= "<label for='style'>"._DISPLAY.": </label><select name='block_variables[\"CDformat\"]' class='textbox' >
		<option value='0'".(!$style ? " selected" : "").">"._CHART."</option>
				<option value='1'".($style == 1 ? " selected" : "").">"._NARRATIVE."</option>
				<option value='2'".($style == 2 ? " selected" : "").">"._VARIABLES."</option></select><br />
			 </div>";
  