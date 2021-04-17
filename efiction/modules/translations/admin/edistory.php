<?php
// ----------------------------------------------------------------------
// Copyright (c) 2010 by Kirstyn Amanda Fox
// Based on DisplayWorld for eFiction 3.0
// Copyright (c) 2005 by Tammy Keefer
// Valid HTML 4.01 Transitional
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

 
    //double work in the name of saving original code
    // End change author of story
 
    $writer = isset($_POST['writer']) && isNumber($_POST['writer']) ? $_POST['writer'] : 0;
    $updatequery = dbquery("UPDATE ".TABLEPREFIX."fanfiction_stories SET writer = '$writer' WHERE sid = '$sid'");
    
    $original_title = isset($_POST['original_title']) ? descript(strip_tags($_POST['original_title'], $allowed_tags)) : "";       
    $original_url = isset($_POST['original_url']) ? descript(strip_tags($_POST['original_url'], $allowed_tags)) : "";
    $preklad_url = addslashes($_POST['preklad_url']);   
    $multichapter = isset($_POST['multichapter']) && isNumber($_POST['multichapter']) ? $_POST['multichapter'] : 0; 
    $source = isset($_POST['source']) ? descript(strip_tags($_POST['source'], $allowed_tags)) : "";
 
    $updatequery = dbquery("UPDATE ".TABLEPREFIX."fanfiction_stories 
    SET writer = '$writer' 
    , original_title =  '".addslashes($original_title)."'
    , original_url  =  '".addslashes($original_url)."'
    , preklad_url  =  '".addslashes($preklad_url)."'
    , multichapter  =  '$multichapter'    
    , source  =  '".addslashes($source)."' 
 
    WHERE sid = '$sid'");  
    
    
    
 
 