<?php
// ----------------------------------------------------------------------
// Copyright (c) 2007 by Tammy Keefer
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
 
 
	global $language;
    
    
 if(isset($_POST['submit'])) {      
			$stories['writer'] = stripslashes($_POST['writer']);
			$stories['original_title'] = stripslashes($_POST['original_title']);
			$stories['original_url'] = stripslashes($_POST['original_url']);
			$stories['preklad_url'] = stripslashes($_POST['preklad_url']);
			$stories['multichapter'] = stripslashes($_POST['multichapter']);
			$stories['source'] =  stripslashes($_POST['source']);
}    
 
    if(!empty($stories['writer'])) {  
    
    	$writer_id = $stories['writer'];
      
    	$writer_result = e107::getDb()->retrieve("fanfiction_writers", "cw_author_name, cw_author_rs, cw_author_id", "cw_author_id =".$writer_id." LIMIT 1 ");
         
        $rsekcia = '';
        if($writer_result['cw_author_rs'])   {
           $rsekcia = ' <span class="label rs label-danger">RS  </span> ';  
        }   
    	$writer_name =  (!empty($writer_result ) ? $writer_result['cw_author_name']  : _NONE);
    }
    else $tpl->assign("writer", _NONE); 
 
        $tpl->assign("original_title", stripslashes($stories['original_title']) );
    	$tpl->assign("original_link"   , stripslashes(original_link($stories)) );    
        $tpl->assign("translation_link"   , stripslashes(preklad_link($stories)) );   
     
        $tpl->assign("storyimage", stripslashes(storyimage($stories)) );
        $tpl->assign("storyimage_alt", stripslashes($stories['title']) );
    
        $tpl->assign("writer", "<a  href=\"browse.php?type=original_authors&amp;wrid=".$writer_result['cw_author_id']."\"> ".stripslashes($writer_name)."</a>".$rsekcia);
    
    /*	$writer_withlabel = "<span class='label'>"._ORIGINAL_WRITER.": </span> ".$writer_name['cw_author_name'] ."<br />";
    	$tpl->assign("writer_label", $writer_withlabel );
    	$allclasslist .= "<span class='label'>"._ORIGINAL_WRITER.": </span> ".$writer_name['cw_author_name'] ."<br />";
    */

    
     
    


?>