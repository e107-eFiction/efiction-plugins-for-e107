<?php 

$dbhost = "localhost";
$dbname = "efiction";
$dbuser= "root";
$dbpass = "12345678";
$sitekey = "cUg2qzQFKf";
$settingsprefix = "e107_";

include_once("includes/dbfunctions.php");
if(!empty($sitekey)) $dbconnect = dbconnect($dbhost, $dbuser,$dbpass, $dbname);
 

?>