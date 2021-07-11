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

/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * e107 efiction Plugin
 *
 * #######################################
 * #     e107 website system plugin      #
 * #     by Jimako                    	 #
 * #     https://www.e107sk.com          #
 * #######################################
 */

if (!defined('e107_INIT')) { exit; }

if (class_exists('efiction')) {
 
    $template = e107::getTemplate('efiction', 'blocks', 'info', true, true);
    $start = $template['start']; 
	$end = $template['end'];
    $tablerender= varset($template['tablerender'], '');
    
    $members =  e107::getDb()->retrieve("SELECT COUNT(uid) as members FROM #fanfiction_authors");
    /* newest author */
    $newest =   e107::getDb()->retrieve("SELECT uid as newest FROM #fanfiction_authors ORDER BY uid DESC LIMIT 1");
 
    /* update stats */
    $update = array(
		'members'    =>  $members,
		'newestmember'  => $newest,
		'WHERE' => "sitekey = '".SITEKEY."'"
	);
	e107::getDB()->update("fanfiction_stats", $update); 
    
    /* stats data */
    $stats = e107::getDb()->retrieve("fanfiction_stats", "*" , "sitekey = '".SITEKEY."'" );
  
    /* newestmember data */
    $newmember = e107::getDb()->retrieve( "SELECT penname FROM #fanfiction_authors WHERE uid = '".$stats['newestmember']."' LIMIT 1" );
 
	$var['TOTALSTORIES'] = $stats['stories'];
	$var['TOTALAUTHORS'] = $stats['authors'];
	$var['TOTALMEMBERS'] = $stats['members'];
	$var['TOTALREVIEWS'] = $stats['reviews'];
	$var['TOTALREVIEWERS'] = $stats['reviewers'];	
	$var['TOTALWORDS'] = $stats['wordcount'];
	$var['TOTALCHAPTERS'] = $stats['chapters'];
	$var['TOTALSERIES'] = $stats['series'];
	$var['NEWESTMEMBER'] = "<a href=\"viewuser.php?uid=".$stats['newestmember']."\">$newmember</a>";
    
    $var['LOGGEDINAS'] = '';
    $var['SUBMISSIONS'] = '';
    $var['BLOCKINFO_CODEBLOCK'] = '';
    
  	if(isMEMBER) {
      $var['LOGGEDINAS'] =  _LOGGEDINAS." ".USERPENNAME.". ".($noskin ? " "._NOSKIN : "");
    }
    $adminnotices = "";
    if(isADMIN) {
      $count = e107::getDb()->retrieve("SELECT COUNT(DISTINCT chapid) AS count FROM #fanfiction_chapters WHERE validated = '0'");
      $count = 5;
      if($count) $adminnotices = sprintf(_QUEUECOUNT, $count);
      
      $codequery = "SELECT * FROM #fanfiction_codeblocks WHERE code_type = 'adminnotices'";
      $codes = e107::getDb()->retrieve($codequery, true);
      foreach ($codes as $code) {
          //example:   
          eval($code['code_text']);
      }
      $var['SUBMISSIONS'] = $adminnotices; 
      
    } 
    
    $codequery = "SELECT * FROM #fanfiction_codeblocks WHERE code_type = 'sitestats'";
      $codes = e107::getDb()->retrieve($codequery, true);
      foreach ($codes as $code) {
          //example:   
          eval($code['code_text']);
      }
    $var['BLOCKINFO_CODEBLOCK'] = $sitestats; 
      
    $text .= e107::getParser()->parseTemplate($template['content'], true, $var);
 
    // $content = e107::getRender()->tablerender($caption, $start.$text.$end, $tablerender, true);
}

e107::getRender()->tablerender($caption, $start.$text.$end, $tablerender);
