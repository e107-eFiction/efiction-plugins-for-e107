<?php
if (!defined('e107_INIT')) { exit; }

global $language, $pagelinks;

$block_key = 'menu';

//$linkquery = dbquery("SELECT * from ".TABLEPREFIX."fanfiction_pagelinks ORDER BY link_access ASC");
if(!isset($current)) $current = "";
$pagelinks  = efiction_pagelinks::get_pagelinks($current);
 
include _BASEDIR.'blocks/'.$blocks[$block_key]['file'];
 
if(isset($_GET['up'])) {
	$pos = array_search($_GET['up'], $blocks[$block_key]['content']);
	if($pos >= 1) {
		$blocks[$block_key]['content'][$pos] = $blocks[$block_key]['content'][$pos - 1];
		$blocks[$block_key]['content'][$pos - 1] = $_GET['up'];
		$blocks[$block_key]['content'] = $blocks[$block_key]['content'];
		efiction_blocks::save_blocks( $blocks );
	}
}
if(isset($_GET['down'])) {
	$pos = array_search($_GET['down'], $blocks[$block_key]['content']);
	if($pos <= count($blocks[$block_key]['content'])) {
		$blocks[$block_key]['content'][$pos] = $blocks[$block_key]['content'][$pos + 1];
		$blocks[$block_key]['content'][$pos + 1] = $_GET['down'];
		$blocks[$block_key]['content'] = $blocks[$block_key]['content'];
		efiction_blocks::save_blocks( $blocks );
	}
}		
if(isset($_POST['submit'])) {
	$newcontent = array( );
	for($x = 0; $x <= count($pagelinks); $x++) {
		if(isset($_POST["content_$x"])) $newcontent[] = $_POST["content_$x"];
	}
	$blocks[$block_key]['content'] = $newcontent;
	$blocks[$block_key]['style'] = isset($_POST['style']) && !empty($_POST['style']) ? 1 : 0;
	efiction_blocks::save_blocks( $blocks );
}
if($block_key){
		
	
	$output .= "<div style='text-align: center;'><span class='h4 text-primary'>"._CURRENT.' '.LAN_PREVIEW.':</span><br /><hr class="preview" > '.$content.'<hr class="preview" ></div>';

    $text = '';
	$content = isset($blocks[$block_key]['content']) ? $blocks[$block_key]['content'] : array();
    $output .= '
<form method="POST" enctype="multipart/form-data" action="'.e_SELF.'?action=blocks&amp;admin='.$block_key.'"> 
<table class="tblborder table table-bordered">';

	$output .= "<table class=\"tblborder table table-bordered\" width=\"100%\"><tr><th>"._TITLE."</th><th colspan=\"2\">"._MOVE."</th></tr>";
	$count = 1;
	if(is_array($content)) {
		foreach($content as $link) {
			$output .= "<tr><td class='tblborder'><input type=\"checkbox\" class=\"checkbox\" checked name=\"content_$count\" value=\"$link\">".$pagelinks["$link"]['link']."</td>
				<td class='tblborder' width=\"15\">".($count > 1 ? "<a href=\"admin.php?action=blocks&admin=$block_key&up=$link\"><img src=\""._BASEDIR."images/arrowup.gif\" width=\"13\" height=\"18\" alt=\""._UP."\" title=\""._UP."\" border=\"0\"></a>" : "")."</td>
				<td class='tblborder' width=\"15\">".($count < sizeof($blocks[$block_key]['content']) ? "<a href=\"admin.php?action=blocks&admin=$block_key&down=$link\"><img src=\""._BASEDIR."images/arrowdown.gif\" width=\"13\" height=\"18\" alt=\""._DOWN."\" title=\""._DOWN."\" border=\"0\"></a>" : "")."</td></tr>";
			$count++;
		}
	}
	foreach($pagelinks as $page => $link) {
		if(!is_array($content) || !in_array($page, $content)) {
			$output .= "<tr><td class='tblborder'><input type=\"checkbox\" class=\"checkbox\" name=\"content_$count\" value=\"$page\">".$link['link']."</td>
				<td class='tblborder' colspan=\"2\">&nbsp;</td></tr>";
			$count++;
		}
	}
	$output .= "</table><br />
	   <div style=\"text-align: center;\">
		<label for=\"style\">"._STYLE.":</label> <select class=\"form-control\" name=\"style\" id=\"style\">
		<option value=\"1\"".(!empty($blocks["menu"]['style']) ? " selected" : "").">"._NOLIST."</option>
		<option value=\"0\"".(empty($blocks['menu']['style']) ? " selected" : "").">"._LISTFORMAT."</option>
		</select><br /><br />
		<input type=\"submit\" class=\"button btn btn-submit btn-primary\" id=\"submit\" name=\"submit\" value=\""._SUBMIT."\">
		</div></form>  ";
}
 