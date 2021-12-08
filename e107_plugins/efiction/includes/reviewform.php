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

if(!defined("e107_INIT")) exit( );

if(!isset($item)) $item = "";
if(!isset($action)) $action == "add";


$form_action = "reviews.php?action=".($action == "edit" ? "edit&amp;reviewid=".$review['reviewid'] : "add&amp;type=$type&amp;item=$item").(!empty($nextchapter) ? "&amp;next=$nextchapter" : "");
 
//$form  = e107::getForm()->open("reviewform", "POST", $form_action, " ");
$form = "<form method=\"POST\" id=\"reviewform\" enctype=\"multipart/form-data\" action=\"reviews.php?action=".($action == "edit" ? "edit&amp;reviewid=".$review['reviewid'] : "add&amp;type=$type&amp;item=$item").(!empty($nextchapter) ? "&amp;next=$nextchapter" : "")."\">";

$ratings = e107::getSingleton('efiction_settings')->getPref('ratings'); 
 
if($action != "edit") {

        $review = array('reviewid' => '', 'reviewer' => '', 'review' => '', 'rating' => '-1');
        
        if(isMEMBER) {
 
          
          $field_key = "reviewer";
          $form .= '<div class="row mb-3">';
              $form .= "<label class=\"col-sm-2 col-form-label\" for=\'".$field_key."\'>"._PENNAME.":</label>";       
              $form .= '<div class="col-sm-10">';
                      $form .= e107::getForm()->text($field_key, USERPENNAME, 30, array('class'=>'form-control-plaintext-not-supported', 'readonly'=> true));  
  		    $form .= '</div>';
          $form .= '</div>';            
         $form .= e107::getForm()->hidden("uid", USERUID);
        }
        else {
          $field_key = "reviewer";
          $form .= '<div class="row mb-3">';
              $form .= "<label class=\"col-sm-2 col-form-label\" for=\'".$field_key."\'>"._PENNAME.":</label>";       
              $form .= '<div class="col-sm-10">';
                      $form .= e107::getForm()->text($field_key, "", 30,   );  
  		    $form .= '</div>';
          $form .= '</div>';  
        }
	
/*	if(isMEMBER)
		$form .= USERPENNAME." <INPUT type=\"hidden\" name=\"reviewer\" value=\"".USERPENNAME."\"><INPUT type=\"hidden\" name=\"uid\" value=\"".USERUID."\">";
	else
		$form .= "<INPUT name=\"reviewer\" id=\"reviewer\" size=\"30\" maxlength=\"200\">";*/
}
else { 
  $form .= $review['reviewer']."<INPUT type=\"hidden\" name=\"reviewid\" value=\"".$review['reviewid']."\">";

}

          $field_key = "review";
          $form .= '<div class="row mb-3">';
              $form .= "<label class=\"col-sm-2 col-form-label\" for=\'".$field_key."\'>"._REVIEW.":</label>";       
              $form .= '<div class="col-sm-10">';
                      $form .= e107::getForm()->bbarea($field_key, $review['review'], 'signature', '' , 'tiny',  array('wysiwyg'=>'bbcode')   );  
  		    $form .= '</div>';
          $form .= '</div>';  
     
 
if($ratings == "2"){
	$form .= "<div><label for=\"rating\">"._OPINION."</label> <select id=\"rating\" name=\"rating\" class=\"textbox\">
		<option value=\"1\"".($review['rating'] == 1 ? " selected" : "").">"._LIKED."</option><option value=\"0\"".($review['reviewid'] && !$review['rating'] ? " selected" : "").">"._DISLIKED."</option><option value=\"-1\"".($review['rating'] == -1 || $action == "add" ? " selected" : "").">"._NONE."</option></select></div>";
}
if($ratings == "1") {
	$form .= "<div><label for=\"rating\">"._REVIEWRATING.":</label> <select name=\"rating\">";
	for($x=10; $x > 0; $x--) {
		$form .= "<option value=\"$x\"".($review['rating'] == $x ? " selected" : "").">$x</option>";
	}
	$form .= "<option value=\"-1\"".($review['rating'] == -1 || $action != "edit" ? " selected" : "").">"._NONE."</option></select></div>";
}

/* captcha */
if(!USERUID && !empty($captcha)) 
{
$form .= "<div><span class=\"label\">"._CAPTCHANOTE."</span><input MAXLENGTH=5 SIZE=5 name=\"userdigit\" type=\"text\" value=\"\"><br /><img width=120 height=30 src=\""._BASEDIR."includes/button.php\" style=\"border: 1px solid #111;\"></div>";
}


$form .= "<INPUT type=\"hidden\" name=\"chapid\" value=\"".(isset($chapid) ? $chapid : "")."\"><div style=\"text-align: center; margin: 1ex;\">
<INPUT type=\"submit\" class=\"button btn btn-success btn-submit\" name=\"submit\" value=\""._SUBMIT."\"></div>";
if(!empty($rateonly)) $form .= "<div>"._REVIEWNOTE."</div>";
$form .= "</div></form>";
 
?>