<?php
 

global $tinyMCE, $allowed_tags;

$blocks = eFiction::blocks();

include("blocks/".$blocks['poll']['file']);
	if(isset($_GET['delete']) && isNumber($_GET['delete'])) {
		$delete = dbquery("DELETE FROM ".TABLEPREFIX."fanfiction_poll WHERE poll_id = '$_GET[delete]' LIMIT 1");
		if($delete) $output .= write_message(_ACTIONSUCCESSFUL);
	}	
	if(isset($_POST['close_current'])) {
		$final = "";
		foreach($pollopts as $num => $opt) {
			if(strlen($final) > 0) $final .= "#";
			$n = $num + 1;
			$final .= (isset($results[$n]) ? $results[$n] : "0");
		}
		$closepoll =dbquery("UPDATE ".TABLEPREFIX."fanfiction_poll SET poll_results = '$final', poll_end = NOW( ) WHERE poll_id = '".$currentpoll['poll_id']."'");
		if($closepoll) $emptyvotes = dbquery("TRUNCATE TABLE `".TABLEPREFIX."fanfiction_poll_votes`");
		$output .= write_message(_ACTIONSUCCESSFUL);
	}
 
	if($currentpoll && !isset($_POST['close_current'])) {
		include("blocks/".$blocks['poll']['file']);
		$output .= "<div style='text-align: center;'><b>"._CURRENT.":</b><br /><div class=\"tblborder\" style=\"width: 200px; margin: 0 auto; text-align: left;\">$content</div><br /></div>";
		$output .= "<form method=\"POST\" enctype=\"multipart/form-data\" action=\"admin.php?action=blocks&amp;admin=poll\" style='text-align: center;'><INPUT type=\"submit\" class=\"button\" name=\"close_current\" value=\""._CLOSEPOLL."\"></form>";
	}
	else  {
		$output .= "<div style='width: 400px; margin: 1em auto; text-align: center;'><form method=\"POST\" enctype=\"multipart/form-data\" action=\"admin.php?action=blocks&admin=poll\">
			<label for=\"poll_question\">"._POLLQUESTION."</label><textarea name='poll_question' cols='40' id='poll_question' rows='5'></textarea><br />";
		if($tinyMCE) 
			$output .= "<div class='tinytoggle'><input type='checkbox' name='toggle' onclick=\"toogleEditorMode('poll_question');\" checked><label for='toggle'>"._TINYMCETOGGLE."</label></div>";
		$output .= "<label for=\"poll_opts\">"._POLLOPTS."</label><textarea name='poll_opts' id='poll_opts' class='mceNoEditor' cols='40' rows='5'></textarea><br />";
		$output .= "<INPUT type=\"submit\" class=\"button\" name=\"submit\" value=\""._SUBMIT."\"></form></div>";
	}
	$oldpolls = dbquery("SELECT * FROM ".TABLEPREFIX."fanfiction_poll WHERE poll_end != '0000-00-00 00:00:00' ORDER BY poll_id DESC");
	if(dbnumrows($oldpolls)) {
		$output .= "<table class='tblborder' style='width: 400px; margin: 1em auto; text-align: center;'><tr><th>"._POLLQUESTION."</th><th>"._OPTIONS."</th></tr>";
		while($poll = dbassoc($oldpolls)) {
			$output .= "<tr><td class='tblborder'>".stripslashes($poll['poll_question'])."</td><td class='tblborder'><a href='admin.php?action=blocks&amp;admin=poll&amp;delete=".$poll['poll_id']."'>"._DELETE."</a></td></tr>";
		}
		$output .= "</table><br />";
	}
 