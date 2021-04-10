<?php
// ----------------------------------------------------------------------
// Copyright (c) 2007 by Tammy Keefer
// Based on eFiction 1.1
// Copyright (C) 2003 by Rebecca Smallwood.
// http://efiction.sourceforge.net/
// ----------------------------------------------------------------------
// LICENSE
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License (GPL)
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// To read the license please visit http://www.gnu.org/copyleft/gpl.html
// ----------------------------------------------------------------------

$current = "home";

require_once(__DIR__ . '/../../header.php'); //inside is class2.php TODO
 
$tpl = new TemplatePower(__DIR__ . "/../../default_tpls/index.tpl");
 
if(file_exists(__DIR__ . "/../../".$skindir."/index.tpl")) $tpl = new TemplatePower(__DIR__ . "/../../".$skindir."/index.tpl");
else $tpl = new TemplatePower(__DIR__ . "/../../default_tpls/index.tpl");

include(__DIR__ . "/../../includes/pagesetup.php");

$welcome = e107::getDb()->retrieve("SELECT message_text FROM ".TABLEPREFIX."fanfiction_messages WHERE message_name = 'welcome'");
 
$tpl->assign("welcome", stripslashes($welcome));

$output = $tpl->getOutputContent( );  
$output = e107::getParser()->parseTemplate($output, true); 
echo $output;
require_once(FOOTERF);					// render the footer (everything after the main content area)
exit; 


dbclose( );
?>