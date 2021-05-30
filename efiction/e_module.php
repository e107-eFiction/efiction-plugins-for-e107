<?php

e107::lan('efiction');
e107::lan('efiction', true);

$efiction = e107::getSingleton('efiction', e_PLUGIN.'efiction/classes/efiction.class.php');
$efiction->init();
$eAuthors = e107::getSingleton('eauthors', e_PLUGIN.'efiction/classes/authors.class.php');
$eAuthors->init(); 
   
$sitekey = e107::getInstance()->getSitePath();
 
if (!defined('SITEKEY') && $sitekey) {
    define('SITEKEY', $sitekey);
}

/* temp */
if (!defined('TABLEPREFIX')) {
    define('TABLEPREFIX', MPREFIX);
} 

/* temp */
if (!defined('_BASEDIR')) {
    define('_BASEDIR', e_PLUGIN.'efiction/');
}

/* temp */
if (!defined('_ADMINBASEDIR')) {
    define('_ADMINBASEDIR', e_PLUGIN."efiction/admin/");
}
 
