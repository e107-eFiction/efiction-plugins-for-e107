<?php
 error_reporting(0);


if (!defined('e107_INIT'))
{
	require_once(__DIR__.'/../../../class2.php');
}
 
e107::lan('efiction');

header("Content-Type: text/javascript; charset=utf-8",true);
include("../includes/queries.php");
 
$userstr = isset($_GET['str']) ? e107::getParser()->toDB($_GET['str']) : "";
$element = isset($_GET['element']) ? e107::getParser()->toDB($_GET['element']) : "";

$usersquery = "SELECT "._UIDFIELD." as uid, "._PENNAMEFIELD." as username FROM "._AUTHORTABLE." WHERE LOWER(".
	_PENNAMEFIELD.") LIKE \"".$userstr."%\" ORDER BY username ASC limit 10";
   
echo "var element = '".$element."';\n";
$x = 0;
$records = e107::getDb()->retrieve($usersquery, true);

foreach($records AS $u) {
    $userlist[$u['uid']] = $u['username'];
}
foreach($userlist AS $k => $v)  {
        echo "userList[$x] =  new Array('$k','$v');\n";
		$x++;
}
 
 