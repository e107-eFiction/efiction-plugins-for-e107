<?php
 
$blocks = eFiction::blocks();
e107::includeLan(e_PLUGIN.'efiction/blocks/shoutbox/'.e_LANGUAGE.'.php');

 
	if(isset($_GET['delete']) && isNumber($_GET['delete'])) {
		$delete = dbquery("DELETE FROM ".TABLEPREFIX."fanfiction_shoutbox WHERE shout_id = '$_GET[delete]' LIMIT 1");
		if($delete) $output .= write_message(_ACTIONSUCCESSFUL);
	}	
	if(isset($_GET['shout_id'])) {
		$output .= "<div class='sectionheader'>"._EDITSHOUT."</div>";
 
		$shoutquery = dbquery("SELECT shout_message FROM ".TABLEPREFIX."fanfiction_shoutbox WHERE shout_id = '".$_GET['shout_id']."' LIMIT 1");
		$shout = dbassoc($shoutquery);
		if($shout) {
			$output .= "<div style='text-align: center;'>
<form method=\"POST\"  enctype=\"multipart/form-data\" action=\"admin.php?action=blocks&admin=shoutbox&amp;shout_id=".$_GET['shout_id']."\">
<div style='text=align: center; margin: 0 auto;'><textarea name='shout_message' id='shout_message' rows='4' class='mceNoEditor' cols='30'>".$shout['shout_message']."</textarea></div>
<input type='submit' class='button' name='submit' id='submit' value='"._SUBMIT."'>
</form></div>";
		}
		else {
			$output .= write_error(_NORESULTS);
		}
	}
 
	$defaults = array("m/d/y h:i a", "d/m/y G:i:s", "m-d-y h:i a", "d-m-y G:i:s", "m.d.y h:i a", "d.m.y G:i:s", "M j, Y h:i a", "M j, Y G:i:s", "d M, Y h:i a", "d M, Y G:i:s");
	$output .= "<form name='shoutopts' method='POST' id='settingsform' action='admin.php?action=blocks&amp;admin=shoutbox'>\n
<div><label for='shoutdate'>"._SHOUTDATE.":</label><select name='shoutdate' id='shoutdate'><option value=\"\">"._SELECTONE."</option>";
		foreach($defaults as $d) {
			$output .= "<option value='$d'".($blocks['shoutbox']['shoutdate'] == $d ? " selected" : "").">".date("$d")."</option>";
		}
		$output .= "</select> "._OR." <input type='text' name='customshoutdate' class='textbox' value='".(isset($blocks['shoutbox']['shoutdate']) && !in_array($blocks['shoutbox']['shoutdate'], $defaults) ? $blocks['shoutbox']['shoutdate'] : "")."'> <A HREF='#' class='pophelp'>[?]<span>"._HELP_SHOUTDATEFORMAT."</span></A></div>
<div><label for='shoutlimit'>"._SHOUTLIMIT.":</label><input type='text' name='shoutlimit' size='1' value='".(isset($blocks['shoutbox']['shoutlimit']) ? $blocks['shoutbox']['shoutlimit'] : "")."'></div>
<div class='fieldset'><span class='label'>"._GUESTSHOUTS.":</span>\n
<input type='radio' name='guestshouts' id='guestshouts"._YES."' value='"._YES."'".(!empty($blocks['shoutbox']['guestshouts'])  ? " checked='checked'" : "")."> <label for='guestshouts"._YES."'>"._YES."</label>\n
<input type='radio' name='guestshouts' id='guestshouts"._YES."' value='"._NO."'".(empty($blocks['shoutbox']['guestshouts'])  ? " checked='checked'" : "")."> <label for='guestshouts"._NO."'>"._NO."</label>\n</div>\n
<input type='submit' class='button' name='submitopts' id='submit' value='"._SUBMIT."'></form>";
$shouts = dbquery("SELECT shouts.*, "._PENNAMEFIELD." as penname FROM ".TABLEPREFIX."fanfiction_shoutbox as shouts LEFT JOIN "._AUTHORTABLE." ON "._UIDFIELD." = shouts.shout_name ORDER BY shout_datestamp DESC");
$totalshouts = dbnumrows($shouts);
$shouts = dbquery("SELECT shouts.*, "._PENNAMEFIELD." as penname FROM ".TABLEPREFIX."fanfiction_shoutbox as shouts LEFT JOIN "._AUTHORTABLE." ON "._UIDFIELD." = shouts.shout_name ORDER BY shout_datestamp DESC LIMIT $offset, $itemsperpage");
if($totalshouts > 0) {
	$output .= "<form name='deleteform' method='POST'action='admin.php?action=blocks&amp;admin=shoutbox'>\n
<div style='text-align: center;'>"._DELETESHOUTS."<select name='del_range' class='textbox'>\n
<option value='90'>90</option>\n
<option value='60'>60</option>\n
<option value='30'>30</option>\n
<option value='20'>20</option>\n
<option value='10'>10</option>\n
</select>"._DAYS."<br />
<input type='submit' name='deleteshouts' class='button' value='"._DELETE."'></div></form>";
	$output .= "<div class='sectionheader'>"._SHOUTARCHIVE."</div><div style='width: 80%;margin: 0 auto;'>";
	if(!empty($blocks['shoutbox']['shoutdate'])) $shoutdate = $blocks['shoutbox']['shoutdate'];
	else $shoutdate = $dateformat." ".$timeformat;
	while($shout = dbassoc($shouts)) {
		if(isNumber($shout['shout_name']) && isset($shout['penname'])) $shoutname = "<a href='viewuser.php?uid=".$shout['shout_name']."'>".$shout['penname']."</a>";
		else if(isset($shout['shout_name'])) $shoutname = $shout['shout_name'];
		else $shout = _GUEST; // Just in case.
		$output .= "
<div class='tblborder'><span class='sbname'>$shoutname</span><br />\n
<span class='sbshout'>".stripslashes($shout['shout_message'])."</span><br />\n
<span class='sbdatetime'>".date("$shoutdate", $shout['shout_datestamp'])." [<a href='admin.php?action=blocks&amp;admin=shoutbox&amp;delete=".$shout['shout_id']."' class='sbadmin'>"._DELETE."</a>] [<a href='admin.php?action=blocks&amp;admin=shoutbox&amp;shout_id=".$shout['shout_id']."' class='sbadmin'>"._EDIT."</a>]</span></div>\n<br />";
	}
	$output .= "</div>";
	if($totalshouts > $itemsperpage) $output .= build_pagelinks("admin.php?action=blocks&amp;admin=shoutbox&amp;", $totalshouts, $offset);
}
else $output .= write_message(_NOSHOUTS);

 