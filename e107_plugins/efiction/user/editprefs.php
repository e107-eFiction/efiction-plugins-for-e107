<?php
// ----------------------------------------------------------------------
// eFiction 3.2
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

if(!defined("e107_INIT")) exit( );
 
	$output = "<div id='pagetitle'>".($action == "register" ? _SETPREFS : _EDITPREFS)."</div>";
	if(isset($_POST['submit'])) {
 
        $update = array(
    		'alertson'    =>  intval(varset($_POST['useralertson'], 0)),
            'newreviews'    =>  intval(varset($_POST['newreviews'], 0)),
            'newrespond'    =>  intval(varset($_POST['newrespond'], 0)),
            'ageconsent'    =>  intval(varset($_POST['ageconsent'], 0)),
            'tinyMCE'    => intval(varset($_POST['tinyMCE'], 0)),
            'contact'    =>  intval(varset($_POST['contact'], 0)),
            'storyindex'    =>  intval(varset($_POST['storyindex'], 0)),        
            'sortby'    =>  intval(varset($_POST['sortby'], 0)),     
            "WHERE"  =>  "uid = ".USERUID 
     	);
      
        $result = e107::getDB()->update('fanfiction_authorprefs', $update, true);
 
        if($result == 0 ) {
            e107::getMessage()->addInfo(LAN_SETTINGS_NOT_SAVED_NO_CHANGES_MADE);
            
            
        }
        elseif($result == 1 ) {
           e107::getMessage()->addSuccess(LAN_SETSAVED);
        }
 
        $output .= e107::getMessage()->render();
	}

        if(!e107::getDb()->retrieve("SELECT * FROM ".TABLEPREFIX."fanfiction_authorprefs WHERE uid = '".USERUID."' LIMIT 1")) {
                    $insert = array(
  						'uid'    =>  USERUID,
  						'_DUPLICATE_KEY_UPDATE' => 1
  					);
  					e107::getDB()->insert("fanfiction_authorprefs", $insert);
        }
		$user = e107::getDb()->retrieve("SELECT * FROM ".TABLEPREFIX."fanfiction_authorprefs WHERE uid = '".USERUID."' LIMIT 1");
 
 
        $output .= e107::getForm()->open("editprefs", "POST", "member.php?action=editprefs", "class=form-horizontal col-md-6 offset-md-3"); 
 
        $field_key = "contact";
        $output .= '<div class="row mb-3">';
            $output .= "<label class=\"col-sm-8 col-form-label\" for=\'".$field_key."\'>"._CONTACTME.": ";
            $output .= "<a href='#' data-bs-toggle=\"tooltip\" data-bs-html=\"true\" data-bs-placement=\"bottom\" title=\""._HELP_CONTACTME."\">[?]</a></label>";
            $output .= '<div class="col-sm-4">'; 
		              $output .= e107::getForm()->renderElement($field_key, $user[$field_key], array( 'type' => 'checkbox', 'data' => 'int' ));
		    $output .= '</div>';
        $output .= '</div>';
        
        $field_key = "newreviews";
        $output .= '<div class="row mb-3">';
            $output .= "<label class=\"col-sm-8 col-form-label\" for=\'".$field_key."\'>"._CONTACTREVIEWS.": ";
            $output .= "<a href='#' data-bs-toggle=\"tooltip\" data-bs-html=\"true\" data-bs-placement=\"bottom\" title=\""._HELP_NEWREV."\">[?]</a></label>";
            $output .= '<div class="col-sm-4">'; 
		              $output .= e107::getForm()->renderElement($field_key, $user[$field_key], array( 'type' => 'checkbox', 'data' => 'int'  ));
		    $output .= '</div>';
        $output .= '</div>';
        
        $field_key = "newrespond";
        $output .= '<div class="row mb-3">';
            $output .= "<label class=\"col-sm-8 col-form-label\" for=\'".$field_key."\'>"._CONTACTRESPOND.": ";
            $output .= "<a href='#' data-bs-toggle=\"tooltip\" data-bs-html=\"true\" data-bs-placement=\"bottom\" title=\""._HELP_NEWRESP."\">[?]</a></label>";
            $output .= '<div class="col-sm-4">'; 
		              $output .= e107::getForm()->renderElement($field_key, $user[$field_key], array( 'type' => 'checkbox', 'data' => 'int' ));
		    $output .= '</div>';
        $output .= '</div>';
   
		if($alertson)   
        {
              $field_key = "alertson";
              $output .= '<div class="row mb-3">';
                  $output .= "<label class=\"col-sm-8 col-form-label\" for=\'".$field_key."\'>"._ALERTSON2.": ";
                  $output .= "<a href='#' data-bs-toggle=\"tooltip\" data-bs-html=\"true\" data-bs-placement=\"bottom\" title=\""._HELP_FAVALERT."\">[?]</a></label>";
                  $output .= '<div class="col-sm-4">'; 
      		              $output .= e107::getForm()->renderElement($field_key, $user[$field_key], array( 'type' => 'checkbox', 'data' => 'int' ));
      		    $output .= '</div>';
              $output .= '</div>';     
        }
        
        $field_key = "storyindex";
        $output .= '<div class="row mb-3">';
            $output .= "<label class=\"col-sm-8 col-form-label\" for=\'".$field_key."\'>"._DISPLAYINDEX.": ";
            $output .= "<a href='#' data-bs-toggle=\"tooltip\" data-bs-html=\"true\" data-bs-placement=\"bottom\" title=\""._HELP_TOC."\">[?]</a></label>";
            $output .= '<div class="col-sm-4">'; 
		              $output .= e107::getForm()->renderElement($field_key, $user[$field_key], array( 'type' => 'checkbox', 'data' => 'int' ));
		    $output .= '</div>';
        $output .= '</div>';
  
/*
        $field_key = "tinyMCE";
        $output .= '<div class="row mb-3">';
            $output .= "<label class=\"col-sm-8 col-form-label\" for=\'".$field_key."\'>"._USETINYMCE.": ";
            $output .= "<a href=\"#\" class=\"pophelp\">[?]<span>"._HELP_TINYMCE."</span></a></label>";
            $output .= '<div class="col-sm-4">'; 
		              $output .= e107::getForm()->renderElement($field_key, $user[$field_key], array( 'type' => 'checkbox', 'data' => 'int' ));
		    $output .= '</div>';
        $output .= '</div>';
*/ 
 
 		if($agestatement) {
           $output .= '<div class="row mb-3">';
		   $output .= "<div style=\"margin: 1ex 0;\">"._AGECONSENT." <span style='white-space: nowrap;'>";
           $output .= e107::getForm()->renderElement('ageconsent', $user['ageconsent'], 
           array( 'type' => 'boolean', 'data' => 'int', 'writeParms' => array("label"=> "yesno" )));   
            $output .= "<a href='#' data-bs-toggle=\"tooltip\" data-bs-html=\"true\" data-bs-placement=\"bottom\" title=\""._HELP_AGE."\">[?]</a></div>";      
            $output .= '</div>';
		}
        
        $field_key = "sortby";
        $output .= '<div class="row mb-3">';
            $output .= "<label class=\"col-sm-6 col-form-label\" for=\'".$field_key."\'>"._DEFAULTSORT.": ";
            $output .= "<a href='#' data-bs-toggle=\"tooltip\" data-bs-html=\"true\" data-bs-placement=\"bottom\" title=\""._HELP_DEFAULTSORT."\">[?]</a></label>";
            $output .= '<div class="col-sm-6">'; 

    		    $output .= e107::getForm()->renderElement('sortby', $user[$field_key], 
                array( 'type' => 'dropdown', 'data' => 'int', 'title'=> _DEFAULTSORT, 'writeParms' => array( 
                "optArray"=> array('1' => _MOSTRECENT, '0' => _ALPHA   ))));        
    		    
	       	$output .= '</div>';
        $output .= '</div>';   
        
        $output .= e107::getForm()->button("submit", _SUBMIT);
	 
        
        $output .= e107::getForm()->close();


?>