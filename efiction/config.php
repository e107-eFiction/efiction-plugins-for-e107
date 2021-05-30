<?php 

$dbhost = "localhost";
$dbname = "efiction";
$dbuser= "root";
$dbpass = "12345678";
$sitekey = SITEKEY;
$settingsprefix = "e107_";

include_once("includes/dbfunctions.php");
if(!empty($sitekey)) $dbconnect = dbconnect($dbhost, $dbuser,$dbpass, $dbname);
 

?>