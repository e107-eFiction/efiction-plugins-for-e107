<?php

// TODO: FIX, temp solution

if (!defined('TABLEPREFIX')) {
    define('TABLEPREFIX', MPREFIX);
}
require_once e_PLUGIN."efiction/includes/queries.php";

$newcaptcha = efiction::settings('captcha');

if($newcaptcha && extension_loaded('gd'))
{
	define('USE_IMAGECODE', TRUE);
}
else
{
	define('USE_IMAGECODE', FALSE);
}

 