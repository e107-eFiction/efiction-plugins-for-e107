<?php

e107::lan('efiction');
e107::lan('efiction', true);

include e_PLUGIN.'efiction/inc/queries.php';
include e_PLUGIN.'efiction/inc/corefunctions.php';

e107::getSingleton('efiction_settings', e_PLUGIN.'efiction/classes/settings.class.php');
e107::getSingleton('efiction_authors', e_PLUGIN.'efiction/classes/authors.class.php');
e107::getSingleton('efiction_panels', e_PLUGIN.'efiction/classes/panels.class.php');
e107::getSingleton('efiction_ratings', e_PLUGIN.'efiction/classes/ratings.class.php');
e107::getSingleton('efiction_blocks', e_PLUGIN.'efiction/classes/blocks.class.php');

$efiction = e107::getSingleton('efiction', e_PLUGIN.'efiction/classes/efiction.class.php');
$efiction->init();

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
    define('_ADMINBASEDIR', e_PLUGIN.'efiction/admin/');
}
