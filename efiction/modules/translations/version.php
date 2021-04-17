<?php
/*
This file will be called by admin/modules.php and update.php to determine if 
the module version in the database is the current version of the module.  
The version number in this file will be the current version.
*/

if (!defined('e107_INIT')) { exit; }

$moduleVersion = "1.2";
$moduleName = "Translations";

$moduleDescription = "Module to extend efiction for site with translations only ";
$moduleAuthor = "Jimako";
$moduleAuthorEmail = "jimako@e107sk.com";
$moduleWebsite = "https://www.e107sk.com";