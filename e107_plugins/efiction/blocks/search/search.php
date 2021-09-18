<?php
if (!defined('e107_INIT')) {  
    exit();
}
    $content = '<form method="POST" id="searchblock" enctype="multipart/form-data" action="'._BASEDIR.'searching.php?action=advanced">
			<INPUT type="text" class="textbox" name="searchterm" id="searchterm" size="15"> 
			<INPUT type="hidden" name="searchtype" value="advanced">
			<INPUT type="submit" class="button" name="submit" value="'.LAN_SEARCH.'"></form>';
